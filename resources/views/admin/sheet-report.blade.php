@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b>Salary calculated to hourly based</b></center>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group col-md-3">
                    <label class="required" for="employee">Employee</label>
                    <select class="form-control" name="employee" id="employee">
                        <option hidden>Select an employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request()->input('employee') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-sm" id="printTable">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Attendance Date</th>
                        <th>Total Working hours</th>
                        <th>Total pay</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($attendancesall as $attendance)
                        <tr>
                            <td>{{ $attendance->name }}</td>
                            {{--<td>{{ $attendance->status }}</td>--}}
                            {{--<td>{{ $attendance->attendance_time }}</td>--}}
                            <td>{{ $attendance->attendance_date }}</td>
                            <td>{{ $attendance->time_difference }}</td>
                            <td><b>$</b>{{ $attendance->time_difference*$attendance->hourrate }}</td>
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
    </script>
@endsection

