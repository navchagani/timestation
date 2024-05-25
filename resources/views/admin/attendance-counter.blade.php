@extends('layouts.master')
@section('content')
    <form method="POST" action="{{ route('filters') }}">
        @csrf
        <div class="form-group row">
            <div class="col-md-2">
                <label class="required" for="employee">Select Reports</label>
                <select class="form-control" name="employeereport" id="employeereport">
                    <option hidden>Please Select</option>
                    <option value="/administrator-list">Administrator list</option>
                    <option value="/attendance-counter">Attendance Counter</option>
                    <option value="/attendance-list">Attendance list</option>
                    <option value="/sheet-report">Employee Report</option>
                    <option value="/current-employee">Current Employee Report</option>
                    <option value="/employee-daily">Employee Daily Summary</option>
                    <option value="/daily-absence">Employee Daily & Absence Report</option>
                    <option value="/summary-reporttwo">Multiple Employee Summary Report</option>
                </select>
            </div>

            <div class="col-md-2">

                <label class="required" for="employee">Select Employee:</label>
                <select class="form-control" name="employee">
                    <option hidden>Select an employee</option>
                    @foreach($employeesa as $employee)
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
            </div>
            </form>
        </div>

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b> Attendance Counter</b></center>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-hover dt-responsive display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Departments</th>
                        <th>Days In</th>
                        <th>Check-Ins</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($employees as $employee)

                        <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                            @php

                                    $check_attd = \App\Models\Attendance::query()
                                                    ->where('emp_id', $employee->id)
                                                    ->where('attendance_date', '>=', $start) // Filter records with attendance_date greater than or equal to $start
                                                    ->where('attendance_date', '<=', $end)
                                                    ->selectRaw('count(emp_id) as count')
                                                    ->first();
                            @endphp
                            <td> {{ $check_attd->count }}</td>
                            <td> {{ $check_attd->count }}</td>
                        </tr>
                    @endforeach
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

