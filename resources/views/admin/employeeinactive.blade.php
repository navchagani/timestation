@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b>Inactive Employees</b></center>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('employeeinactivefilters') }}">
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
                                <option value="/employee-permission">Employee Permission</option>
                                <option value="/current-employee">Current Employee Report</option>
                                <option value="/employee-daily">Employee Daily Summary</option>
                                <option value="/employee-daily-one-week">Employee Daily Summary - One Week</option>
                                <option value="/employee-daily-two-week">Employee Daily Summary - Two Week</option>
                                <option value="/daily-absence">Daily Attendance & Absence</option>
                                <option value="/sheet-report">Payroll Export - Crystal Payroll</option>
                                <option value="/summary-reporttwo">Multiple Employee Summary Report</option>
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
                        </div>
                    </div>
                </form>
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-hover dt-responsive display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>
                            Name</th>
                        <th>	Primary Department	</th>
                        <th>	Title</th>
                        <th>Status</th>
                        <th>Date Created</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if (sizeof($employees))
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->position }}</td>
                                <td>{{ $employee->title }}</td>
                                <td>{{ $employee->status == 1 ? 'Active' : 'Inactive'  }}</td>
                                <td>{{ $employee->created_at }}</td>
                            </tr>
                        @endforeach

                    @else
                        <tr>
                            <td colspan="6"><center>No Administrator List records found</center></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
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

