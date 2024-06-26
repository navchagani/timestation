@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b> Daily Attendance & Absence</b></center>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dailyfilters') }}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-2">
                        <label class="required" for="employee">Select Reports</label>
                        <select class="form-control" name="employeereport" id="employeereport">
                            <option hidden>Please Select</option>
                            <option value="/administrator-list">Administrator list</option>
                            <option value="/attendance-counter">Attendance Counter</option>
                            <option value="/attendance-list">Attendance Only</option>
                            <option value="/current-device">Current Device Status</option>
                            <option value="/department-list">Department list</option>
                            <option value="/department-member">Department Members</option>
                            <option value="/department-summary">Department Summary</option>
                            <option value="/employee-summary">Employee Summary</option>
                            <option value="/inactive-employee">Inactive Employee </option>
                            <option value="/manual-time">Manual Time Adjustments</option>
                            <option value="/employee-permission">Employee Permission</option>
                            <option value="/current-employee">Current Employee Report</option>
                            <option value="/employee-daily">Employee Daily Summary</option>
                            <option value="/employee-daily-one-week">Employee Daily Summary - One Week</option>
                            <option value="/employee-daily-two-week">Employee Daily Summary - Two Week</option>
                            <option value="/employee-details">Employee Details</option>
                            <option value="/daily-absence">Daily Attendance & Absence</option>
                            <option value="/sheet-report">Payroll Export - Crystal Payroll</option>
                            <option value="/payrollexport">Payroll Export - Ctuit</option>
                            <option value="/payrollheartland">Payroll Export - SurePayroll</option>
                            {{-- <option value="/payrollpaychex">Payroll Export - Paychex</option>
                             <option value="/payrollsure">Payroll Export - SurePayroll</option>
                            <option value="/summary-reporttwo">Multiple Employee Summary Report</option>--}}
                        </select>
                    </div>
                    <div class="col-md-2">

                        <label class="required" for="employee">Select Department:</label>
                        <select class="form-control" name="department">
                            <option hidden>Select an Department</option>
                            @foreach($department as $departments)
                                <option value="{{ $departments->name }}" {{ $empid == $departments->name  ? 'selected' : '' }}>{{ $departments->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="time_in" class="col-sm-6 control-label">Day:</label>
                        <div class="bootstrap-timepicker">
                            <input type="date" class="form-control timepicker" id="start" name="start" value="{{$start}}" required>
                        </div>
                    </div>
                    <div class="col-md-2">

                        <label class="required" for="employee">Attendance Status:</label>
                        <select class="form-control" name="department">
                            <option value="all">{All}</option>
                            <option value="Present">{Present}</option>
                            <option value="Absent">{Absent}</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="time_out" class="col-sm-6 control-label"><br></label>
                        <button type="submit" class="btn btn-primary form-control">
                            Run Report
                        </button>
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
                            <td>{{ $start }}</td>
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
                                           ->where('t1.attendance_date', $start)
                                           ->orderBy('t1.attendance_date', 'asc')
                                           ->orderBy('t1.attendance_time', 'asc')
                                           ->first();
                                @endphp
                            <td>
                                @php
                                    $status = $dailyabsence->status ?? '';
                                @endphp
                                @if ($status == 'IN')
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
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

