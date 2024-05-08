@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b>Salary calculated to hourly based</b></center>
        </div>
        <div class="card-body">
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
                            <td>{{ $attendance->time_difference*$attendance->fsalary }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
