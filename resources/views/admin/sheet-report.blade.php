@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b>Payroll Export - Crystal Payroll</b></center>
        </div>
        <form method="POST" action="{{ route('employeesummaryfilters') }}">
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

                    <label class="required" for="employee">Select Employee:</label>
                    <select class="form-control" name="employee">
                        <option hidden>Select an employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ $empid == $employee->id  ? 'selected' : '' }}>{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="time_in" class="col-sm-6 control-label">Start Date</label>
                    <div class="bootstrap-timepicker">
                        <input type="date" class="form-control timepicker" id="start" name="start" value="{{$start}}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="time_out" class="col-sm-6 control-label">End Date</label>
                    <div class="bootstrap-timepicker">
                        <input type="date" class="form-control timepicker" id="end" name="end" value="{{$end}}" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="time_out" class="col-sm-6 control-label"><br></label>
                    <button type="submit" class="btn btn-primary form-control">
                        Run Report
                    </button>

           </form>>
            </div>
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-hover dt-responsive display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>
                            EmployeeLink</th>
                        <th>ActionDate	</th>
                        <th>ActionType	</th>
                        <th>	ActionTask</th>
                        <th>Action Hours</th>
                        <th>PayTimes	</th>
                        <th>Pay Rate</th>
                        <th>MiscType</th>
                        <th>MiscUnits</th>
                        <th>MiscPayRate</th>
                        <th>Department</th>
                    </tr>
                    </thead>
                    <tbody>

                    @if (sizeof($attendancesall))
                        @php
                             $totalHourRate = 0;
                        @endphp
                    @foreach($attendancesall as $attendance)
                       {{-- {{! $hourRate = $attendance->time_difference*$attendance->hourrate  }}
                        {{! $totalHourRate += $hourRate }}--}}
                        <tr>
                            <td>{{ $attendance->name }}</td>
                            <td>{{ $attendance->attendance_date }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ $attendance->time_difference }}</td>
                            <td>1</td>
                            <td>{{ $attendance->hourrate }}</td>
                             <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $attendance->position }}</td>
                        </tr>
                    @endforeach
                   {{-- <tr>
                        <td colspan="4"><b>Total payment</b></td>
                        <td><b>$</b>{{ $totalHourRate }}</td>
                        <td></td>
                    </tr>--}}
                    @else
                    <tr>
                        <td colspan="6"><center>No attendance records found</center></td>
                    </tr>
                    @endif
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

