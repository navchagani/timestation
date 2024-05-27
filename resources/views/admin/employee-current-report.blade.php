@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            <center> <b> Current Employee Status</b></center>
        </div>
        <div class="card-body">
        <form method="POST" action="{{ route('filterempattendance') }}">
            @csrf
            <div class="form-group row">
                <div class="col-md-2">
                    <label class="required" for="employee">Select Reports</label>
                    <select class="form-control" name="employeereport" id="employeereport">
                        <option hidden>Please Select</option>
                        <option value="/administrator-list">Administrator list</option>
                        <option value="/attendance-counter">Attendance Counter</option>
                        <option value="/attendance-list">Attendance Only</option>
                        <option value="/department-list">Department list</option>
                        <option value="/department-member">Department Members</option>
                        <option value="/department-summary">Department Summary</option>
                        <option value="/employee-summary">Employee Summary</option>
                        <option value="/inactive-employee">Inactive Employee </option>
                        <option value="/employee-permission">Employee Permission</option>
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
                    <label for="time_out" class="col-sm-6 control-label"><br></label>
                    <button type="submit" class="btn btn-primary form-control">
                        Run Report
                    </button>
                </div>
        </form>


            </div>
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-hover dt-responsive display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th> Name</th>
                        <th>	Primary Department	</th>
                        <th>	Current  Department	</th>
                        <th>Status</th>
                        <th>Date / Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($employees as $employee)

                        <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->position }}</td>
                            @php
                                $dailyabsence = DB::table('attendances AS t1')
                                           ->join('employees AS t2', 't1.emp_id', '=', 't2.id')
                                           ->select(
                                               't1.status',
                                               't1.attendance_time',
                                               't1.attendance_date',
                                               't2.name',
                                               't2.position'
                                           )
                                           ->where('t1.emp_id', $employee->id)
                                           ->where('t1.attendance_date', '>=', '2024-05-01')
                                           ->where('t1.attendance_date', '<=', '2024-05-31')
                                           //->whereRaw('MONTH(t1.attendance_date) = MONTH(CURDATE()) AND YEAR(t1.attendance_date) = YEAR(CURDATE())')
                                          // ->orderBy('t1.attendance_date', 'desc')
                                            //->orderBy('t1.attendance_time', 'asc')
                                            //->take(1)
                                            ->first();
                                @endphp
                            <td> {{ $dailyabsence->status ?? 'N/A'}}</td>
                            <td> {{ $dailyabsence->attendance_date ?? 'N/A'}} {{ $dailyabsence->attendance_time ?? ''}}</td>
                        </tr>
                    @endforeach
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

