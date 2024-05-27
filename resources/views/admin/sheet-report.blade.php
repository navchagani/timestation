@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b>Salary calculated to hourly based</b></center>
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
                        <option value="/department-list">Department list</option>
                        <option value="/department-member">Department Members</option>
                        <option value="/department-summary">Department Summary</option>
                        <option value="/sheet-report">Employee Report</option>
                        <option value="/current-employee">Current Employee Report</option>
                        <option value="/employee-daily">Employee Daily Summary</option>
                        <option value="/daily-absence">Employee Daily & Absence Report</option>
                        <option value="/summary-reporttwo">Multiple Employee Summary Report</option>
                    </select>
                </div>
            </form>
            <form>
                <div class="col-md-12">
                    <label class="required" for="employee">Employee</label>
                    <select class="form-control" name="employee" id="employee">
                        <option hidden>Select an employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request()->input('employee') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            </div>
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-hover dt-responsive display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Attendance Date</th>
                        <th>Action Hours</th>
                        <th>Pay Rate</th>
                        <th>Total pay</th>
                        <th>Department</th>
                    </tr>
                    </thead>
                    <tbody>

                    @if (sizeof($attendancesall))
                        @php
                             $totalHourRate = 0;
                        @endphp
                    @foreach($attendancesall as $attendance)
                        {{! $hourRate = $attendance->time_difference*$attendance->hourrate  }}
                        {{! $totalHourRate += $hourRate }}
                        <tr>
                            <td>{{ $attendance->name }}</td>
                            {{--<td>{{ $attendance->status }}</td>--}}
                            {{--<td>{{ $attendance->attendance_time }}</td>--}}
                            <td>{{ $attendance->attendance_date }}</td>
                            <td>{{ $attendance->time_difference }}</td>
                            <td>{{ $attendance->hourrate }}</td>
                             <td><b>$</b>{{ $hourRate }}</td>
                            <td>{{ $attendance->position }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4"><b>Total payment</b></td>
                        <td><b>$</b>{{ $totalHourRate }}</td>
                        <td></td>
                    </tr>
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

