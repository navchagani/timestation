@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            TimeTable
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm" id="printTable">
                    <thead>
                        <tr >

                            <th>Employee Name</th>
                            <th>Employee Position</th>
                            <th>Employee ID</th>
                            @php
                                $today = today();
                                $dates = [];

                                for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                    $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                }

                            @endphp
                            @foreach ($dates as $date)
                            <th style="">


                                    {{ $date }}

                        </th>


                            @endforeach

                        </tr>
                    </thead>

                    <tbody>





                        @foreach ($employees as $employee)

                            <input type="hidden" name="emp_id" value="{{ $employee->id }}">

                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->position }}</td>
                                <td>{{ $employee->id }}</td>






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
                                            <td style="color: green">{{--IN {{$check_attds->attendance_time}}--}}</td>
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
                            $totalValue = $totalSecondsDifference * 10;

                                                        @endphp
                                                        <td style="color: red">{{-- Out {{$check_attds->attendance_time}}--}}</td> <td style="color: blue">Pay today {{$totalValue}}</td>

                                                @endif
                                            @endforeach
                                            </tr>
                                        </table>
                                            {{--{{die}}

                                            @if (isset($check_attd))
                                                 @if ($check_attd->status==1)
                                                IN
                                                @endif
                                                 @if ($check_attd->status==0)
                                               Out
                                                 @endif

                                            @else
                                            <i class="fas fa-times text-danger"></i>
                                            @endif--}}

                                        {{--<div class="form-check form-check-inline">

                                            @if (isset($check_leave))
                                            @if ($check_leave->status==0)
                                            <i class="fa fa-check text-success"></i>
                                            @else
                                            <i class="fa fa-check text-danger"></i>
                                            @endif

                                       @else
                                       <i class="fas fa-times text-danger"></i>
                                       @endif


                                        </div>--}}

                                    </td>

                                @endfor
                            </tr>
                        @endforeach





                    </tbody>


                </table>
            </div>
        </div>
    </div>


@endsection
