@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b> Monthly Employee Summary</b></center>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-hover dt-responsive display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th> Name</th>
                        <th>Department</th>
                        <th>	Total Hours</th>
                        <th>Hourly Rate</th>
                        <th>	Total Pay</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($employees as $employee)

                        <tr>
                            <td>{{! $d = date('Y-m-d') }}{{date('Y-M') }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                            @php
                                $dailyabsence = DB::table('attendances AS t1')
                                           ->join('employees AS t2', 't1.emp_id', '=', 't2.id')
                                           ->select(
                                               't1.status',
                                               't1.attendance_time',
                                               't1.attendance_date',
                                               't2.name',
                                               't2.position',
                                                't2.hourrate',
                                                DB::raw('TIMESTAMPDIFF(HOUR,
            (SELECT t3.attendance_time FROM attendances AS t3 WHERE t3.emp_id = t1.emp_id AND t3.attendance_date = t1.attendance_date AND t3.status = "IN" ORDER BY t3.attendance_time LIMIT 1),
            t1.attendance_time
        ) AS time_difference')
                                           )
                                           ->where('t1.status', 'OUT')
                                           ->where('t1.emp_id', $employee->id)
                                           ->where('t1.attendance_date', $d)
                                           ->orderBy('t1.attendance_date', 'asc')
                                           ->orderBy('t1.attendance_time', 'asc')
                                           ->first();
                                @endphp
                            <td>{{ $dailyabsence->time_difference ?? '' }}</td>
                            <td>${{ $employee->hourrate ?? '' }}</td>
                            <td>@php if (!empty($dailyabsence->time_difference)) {
                                      echo '$'.$dailyabsence->time_difference * $employee->hourrate;
                                }
                                @endphp</td>
                        </tr>
                    @endforeach
                   {{-- @if (sizeof($dailyabsence))

                        --}}{{--@foreach($dailyabsence as $dailyabsences)
                            <tr>
                                <td>{{ $dailyabsences->attendance_date }}</td>
                                <td>{{ $dailyabsences->name }}</td>
                                <td>{{ $dailyabsences->position }}</td>
                                <td>{{$dailyabsences->status }}</td>
                                <td>{{$dailyabsences->attendance_time }}</td>
                            </tr>
                        @endforeach--}}{{--

                    @else
                        <tr>
                            <td colspan="4"><center>No attendance records found</center></td>
                        </tr>
                    @endif--}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#employee').change(function () {
                $(this).parents('form').submit();
            });
        });
    </script>
@endsection

