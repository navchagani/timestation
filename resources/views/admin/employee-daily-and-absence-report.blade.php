@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b> Employee Daily & Absence</b></center>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-hover dt-responsive display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th> Name</th>
                        <th>Department</th>
                        <th>Present</th>
                        <th>Arrival Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($employees as $employee)

                        <tr>
                            <td>{{ $d = date('Y-m-d') }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                            @php
                                $dailyabsence = DB::table('opaltimecard_ts.attendances AS t1')
                                           ->join('opaltimecard_ts.employees AS t2', 't1.emp_id', '=', 't2.id')
                                           ->select(
                                               't1.status',
                                               't1.attendance_time',
                                               't1.attendance_date',
                                               't2.name',
                                               't2.position'
                                           )
                                           ->where('t1.status', "IN")
                                           ->where('t1.emp_id', $employee->id)
                                           ->where('t1.attendance_date', $d)
                                           ->orderBy('t1.attendance_date', 'asc')
                                           ->orderBy('t1.attendance_time', 'asc')
                                           ->groupBy('t1.emp_id')
                                           ->first();
                                @endphp
                            <td> {{ $dailyabsence->status ?? ''}}</td>
                            <td> {{ $dailyabsence->attendance_time ?? ''}}</td>
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

