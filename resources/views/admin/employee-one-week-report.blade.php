@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b> Employee Daily Summary - One Week </b> </center>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('filterempattendanceone') }}">
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
            <div class="table-responsive">
                <table class="table table-sm" id="printTable">
                    <thead>
                        <tr>

                            <th>Employee Name</th>
                            <th>	Department	</th>

                            @php
                                use Carbon\Carbon;
                                    $ps= $start;
                                    $pe= $end;
                                    $start = Carbon::create($start);
                                    $end = Carbon::create($end); // Adjust the end date as needed
                                    $dates = [];

                                    for ($date = $start; $date->lte($end); $date->addDay()) {
                                        $dates[] = $date->format('m/d');
                                    }

                            @endphp
                            @foreach ($dates as $date)
                            <th style="">


                                    {{ $date }}

                        </th>


                            @endforeach
                            <th>	Hourly Rate	</th>
                            <th>	Total Pay	</th>
                        </tr>
                    </thead>

                    <tbody>





                        @foreach ($employees as $employee)

                            <input type="hidden" name="emp_id" value="{{ $employee->id }}">

                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->position }}</td>
                               {{-- <td>{{ $employee->id }}</td>--}}


                                @php
                                    // Define the start and end dates
                                     $start = Carbon::create($ps);
                                    $end = Carbon::create($pe); // Adjust the end date as needed
                                    $totalValue = 0;
                                @endphp

                                @for ($date = $start->copy(); $date->lte($end); $date->addDay())
                                    @php
                                        $date_picker = $date->format('Y-m-d');

                                        // Query attendance for the current date
                                        $check_attd = \App\Models\Attendance::query()
                                            ->where('emp_id', $employee->id)
                                            ->where('attendance_date', $date_picker)
                                            ->get();

                                        // Query leave for the current date
                                        $check_leave = \App\Models\Leave::query()
                                            ->where('emp_id', $employee->id)
                                            ->where('leave_date', $date_picker)
                                            ->first();
                                    @endphp
                                    @if ($check_attd->isNotEmpty())
                                    <td>
                                        <table>
                                            <tr>
                                                {{$totalSecondsDifference=''}}
                                                @foreach ($check_attd as $check_attds)

                                                    @if ($check_attds->status == 'OUT')
                                                        @php
                                                            $checkattd = \App\Models\Attendance::query()
                                                                ->where('emp_id', $employee->id)
                                                                ->where('attendance_date', $date_picker)
                                                                ->where('status', 'IN')
                                                                ->first();
                                                            if ($checkattd) {
                                                                $existingAttendanceTime = DateTime::createFromFormat('H:i:s', $check_attds->attendance_time);
                                                                $existingAttendanceEnd = DateTime::createFromFormat('H:i:s', $checkattd->attendance_time);
                                                                $difference = $existingAttendanceTime->diff($existingAttendanceEnd);
                                                                //$totalSecondsDifference = $difference->h + ($difference->i / 60) + ($difference->s / 3600);
                                                                $totalSecondsDifference = $difference->h;
                                                                $totalValue += $totalSecondsDifference;
                                                            }
                                                        @endphp
                                                        <td>{{$totalSecondsDifference }}:00</td>
                                                    @endif

                                                @endforeach
                                            </tr>
                                        </table>
                                    </td>
                                    @else
                                        <td>00:00</td>
                                    @endif
                                @endfor

                                <td>{{ $employee->hourrate }}</td>
                                <td>${{ number_format($totalValue * $employee->hourrate) }}</td>
                            </tr>
                        @endforeach





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
