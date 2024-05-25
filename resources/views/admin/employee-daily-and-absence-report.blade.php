@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b> Employee Daily & Absence</b></center>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <form>
                    <div class="col-md-12">
                        <label class="required" for="employee">Select Reports</label>
                        <select class="form-control" name="employeereport" id="employeereport">
                            <option hidden>Please Select</option>
                            <option value="/administrator-list">Administrator list</option>
                            <option value="/attendance-counter">Attendance Counter</option>
                            <option value="/attendance-list">Attendance Only</option>
                            <option value="/sheet-report">Employee Report</option>
                            <option value="/current-employee">Current Employee Report</option>
                            <option value="/employee-daily">Employee Daily Summary</option>
                            <option value="/daily-absence">Employee Daily & Absence Report</option>
                            <option value="/summary-reporttwo">Multiple Employee Summary Report</option>
                        </select>
                    </div>
                </form>
            </div>
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
                                $dailyabsence = DB::table('attendances AS t1')
                                           ->join('employees AS t2', 't1.emp_id', '=', 't2.id')
                                           ->select(
                                               't1.status',
                                               't1.attendance_time',
                                               't1.attendance_date',
                                               't2.name',
                                               't2.position'
                                           )
                                           ->where('t1.status', 'IN')
                                           ->where('t1.emp_id', $employee->id)
                                           ->where('t1.attendance_date', $d)
                                           ->orderBy('t1.attendance_date', 'asc')
                                           ->orderBy('t1.attendance_time', 'asc')
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
        $(function () {
            $('#employeereport').change(function () {
                var selectedOption = $(this).val();
                if (selectedOption) {
                    window.location.href = selectedOption;
                }
            });
        });
    </script>
@endsection

