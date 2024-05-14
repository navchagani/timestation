@extends('layouts.master')
@section('content')
    @if (!empty($success))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong> Success! </strong>{{ $success }}
        </div>
    @endif
    <form method="POST" action="{{ route('filter') }}">
        @csrf
    <div class="form-group row">
            <div class="col-md-3">
                <label class="required" for="employee">Employee</label>
                <select class="form-control" name="employee">
                    <option hidden>Select an employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ request()->input('employee') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
        <div class="col-md-3">
            <label for="time_in" class="col-sm-3 control-label">Start Date</label>
            <div class="bootstrap-timepicker">
                <input type="date" class="form-control timepicker" id="start" name="start" required>
            </div>
        </div>
        <div class="col-md-3">
            <label for="time_out" class="col-sm-6 control-label">End Date</label>
            <div class="bootstrap-timepicker">
                <input type="date" class="form-control timepicker" id="end" name="end" required>
            </div>
        </div>
        <div class="col-md-2">
            <label for="time_out" class="col-sm-6 control-label"><br></label>
        <button type="submit" class="btn btn-primary form-control">
            Filter
        </button>
        </div>
    </div>
    </form>
    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b> Employee Payment</b></center>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-hover dt-responsive display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th> Name</th>
                        <th>Department</th>
                        <th>	Total Hours</th>
                        <th>Hourly Rate</th>
                        <th>	Total Pay</th>
                      {{--  <th>	Action</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @if (!empty($dailyabsence))
                        @php
                            $totalValue = 0;
                        @endphp
                        @foreach($dailyabsence as $attendancesalls)
                            @php
                            $pay = $attendancesalls->pay;
                            @endphp
                            <tr>
                                <td>{{ $attendancesalls->attendance_date}}</td>
                                <td>{{ $attendancesalls->name }}</td>
                                <td>{{ $attendancesalls->position }}</td>
                                <td>{{ $attendancesalls->time_difference }}</td>
                                <td>{{$attendancesalls->hourrate }}</td>
                                <td>${{ $attendancesalls->time_difference * $attendancesalls->hourrate }}</td>
                            </tr>
                            @php
                                $totalValue += $attendancesalls->time_difference * $attendancesalls->hourrate;
                            @endphp
                        @endforeach
                        <tr>
                            <td colspan="5"><strong>Total Payment Amount:</strong></td>
                            <td>${{ $totalValue }}</td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <div class="col-md-4">
                                    <form method="POST" action="{{ route('pay') }}">
                                        @csrf
                                        <input type="hidden" name="emp" value="{{$empi}}">
                                        <input type="hidden" name="sta" value="{{$sta}}">
                                        <input type="hidden" name="dend" value="{{$dend}}">

                                    <button type="submit"  @if($totalValue == 0) disabled @elseif($pay == 1) disabled @else class="btn btn-primary form-control" @endif>
                                        Pay Amount ${{$totalValue}}
                                    </button>
                                        @if($pay == 1)
                                            <div class="alert alert-danger alert-dismissible">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong> Already! </strong>{{ $error }}
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="6"><center>Please Select Start - End Date</center></td>
                        </tr>
                    @endif
                    {{--@foreach ($employees as $employee)

                        <tr>
                            <td>{{! $d = date('Y-m-d') }}{{date('Y-M') }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                            @php
                                $dailyabsence = DB::table('attendances AS t1')
                                           ->join('employees AS t2', 't1.emp_id', '=', 't2.id')
                                           ->select(
                                               't1.status',
                                               't1.attendance_time',
                                               't1.attendance_date',
                                               't2.name',
                                               't2.position',
                                                't2.hourrate',
                                                DB::raw('TIMESTAMPDIFF(HOUR,
            (SELECT t3.attendance_time FROM attendances AS t3 WHERE t3.emp_id = t1.emp_id AND t3.attendance_date = t1.attendance_date AND t3.status = "IN" ORDER BY t3.attendance_time LIMIT 1),
            t1.attendance_time
        ) AS time_difference')
                                           )
                                           ->where('t1.status', 'OUT')
                                           ->where('t1.emp_id', $employee->id)
                                           ->where('t1.attendance_date', $d)
                                           ->orderBy('t1.attendance_date', 'asc')
                                           ->orderBy('t1.attendance_time', 'asc')
                                           ->first();
                                @endphp
                            <td>{{ $dailyabsence->time_difference ?? '' }}</td>
                            <td>${{ $employee->hourrate ?? '' }}</td>
                            <td>@php if (!empty($dailyabsence->time_difference)) {
                                      echo '$'.$dailyabsence->time_difference * $employee->hourrate;
                                }
                                @endphp</td>
                           --}}{{-- <td>
                                <form method="POST" action="{{ route('pay') }}">

                                </form></td>--}}{{--
                        </tr>
                    @endforeach--}}
                   {{-- @if (sizeof($dailyabsence))

                        --}}{{--@foreach($dailyabsence as $dailyabsences)
                            <tr>
                                <td>{{ $dailyabsences->attendance_date }}</td>
                                <td>{{ $dailyabsences->name }}</td>
                                <td>{{ $dailyabsences->position }}</td>
                                <td>{{$dailyabsences->status }}</td>
                                <td>{{$dailyabsences->attendance_time }}</td>
                            </tr>
                        @endforeach--}}{{--

                    @else
                        <tr>
                            <td colspan="4"><center>No attendance records found</center></td>
                        </tr>
                    @endif--}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

   {{-- <script>
        $(function () {
            $('#employee').change(function () {
                $(this).parents('form').submit();
            });
        });
    </script>--}}
@endsection

