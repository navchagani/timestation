@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b> Employee Daily Summary </b> </center>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm" id="printTable">
                    <thead>
                        <tr>

                            <th>Employee Name</th>
                            <th>	Department	</th>

                            @php
                                $today = today();
                                $dates = [];

                                for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                    $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('m/d');
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
                                    $totalValue = 0;
                                @endphp
                                @for ($i = 1; $i < $today->daysInMonth + 1; ++$i)


                                    @php

                                        $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');

                                        $check_attd = \App\Models\Attendance::query()
                                            ->where('emp_id', $employee->id)
                                            ->where('attendance_date', $date_picker)
                                            ->get();

                                        $check_leave = \App\Models\Leave::query()
                                            ->where('emp_id', $employee->id)
                                            ->where('leave_date', $date_picker)
                                            ->first();

                                    @endphp
                                    <td>
                                        <table>
                                            <tr>
                                           {{-- {{dd($check_attd)}}--}}

                                            @foreach ($check_attd as $check_attds)
                                                @if ($check_attds->status=='IN')

                                                @endif
                                                @if ($check_attds->status=='OUT')
                                                        @php
                                                            $checkattd = \App\Models\Attendance::query()
                                                                ->where('emp_id', $employee->id)
                                                                ->where('attendance_date', $date_picker)
                                                                ->where('status', 'IN')
                                                                ->first();
                           $existingAttendanceTime = DateTime::createFromFormat('H:i:s', $check_attds->attendance_time);
                           $existingAttendanceend = DateTime::createFromFormat('H:i:s', $checkattd->attendance_time);
                            $difference = $existingAttendanceTime->diff($existingAttendanceend);
                            $totalSecondsDifference = $difference->s + $difference->i + $difference->h;
                                $totalValue += $totalSecondsDifference;
                                                        @endphp
                                                        <td style="color: blue">{{$totalSecondsDifference}}</td>

                                                @endif
                                            @endforeach
                                            </tr>

                                        </table>
                                    </td>

                                @endfor

                                <td>{{$employee->hourrate}}</td>
                                <td>${{$totalValue*$employee->hourrate}}</td>
                            </tr>
                        @endforeach





                    </tbody>


                </table>
            </div>
        </div>
    </div>


@endsection
