@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b>Department Members</b></center>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group row">
                <div class="form-group col-md-3">
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
                        <option value="/employee-details">Employee Details</option>
                        <option value="/daily-absence">Daily Attendance & Absence</option>
                        <option value="/sheet-report">Payroll Export - Crystal Payroll</option>
                        <option value="/payrollexport">Payroll Export - Ctuit</option>
                        <option value="/payrollheartland">Payroll Export - SurePayroll</option>
                        {{-- <option value="/payrollpaychex">Payroll Export - Paychex</option>
                         <option value="/payrollsure">Payroll Export - SurePayroll</option>--}}
                        <option value="/summary-reporttwo">Multiple Employee Summary Report</option>
                    </select>
                </div>
            </form>
                <div class="col-md-2">
                    <form method="POST" action="{{ route('departmentfilters') }}">
                        @csrf
                    <label class="required" for="employee">Select Department:</label>
                    <select class="form-control" name="department">
                        <option hidden>Select an Department</option>
                        @foreach($departments as $department)
                            <option value="{{$department->name}}">{{$department->name}}</option>
                        @endforeach
                    </select>
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
                            Department Name</th>
                        <th>Employees	</th>
                        <th>	Hourly Rate</th>
                        <th>Primary </th>

                    </tr>
                    </thead>
                    <tbody>
                    @if (sizeof($departmentlist))
                        @foreach($departmentlist as $departmentlists)
                            <tr>
                                <td>{{ $departmentlists->dename }}</td>
                                <td>{{ $departmentlists->empname  }}</td>
                                <td>{{ $departmentlists->hourrate  }}$</td>
                                <td>Yes</td>
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

