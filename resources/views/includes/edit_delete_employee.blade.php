<!-- Edit -->
<div class="modal fade" id="edit{{ $employee->name }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <h4 class="modal-title"><b><span class="employee_id">Edit Employee</span></b></h4>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('employees.update', $employee->name) }}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Name</label>


                        <input type="text" class="form-control" id="name" name="name" value="{{ $employee->name }}"
                            required>

                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Position</label>


                        <input type="text" class="form-control" id="position" name="position" value="{{ $employee->position }}"
                            required>

                    </div>


                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>


                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $employee->email }}" >

                    </div>
                    {{--<div class="form-group">
                        <label for="schedule" class="col-sm-3 control-label">Schedule</label>


                        <select class="form-control" id="schedule" name="schedule" required>
                            <option value="" selected>- Select -</option>
                            @foreach ($schedules as $schedule)
                                <option value="{{ $schedule->slug }}">{{ $schedule->slug }} -> from
                                    {{ $schedule->time_in }} to {{ $schedule->time_out }} </option>
                            @endforeach

                        </select>

                    </div>--}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i>
                    Update</button>
                </form>
            </div>
            <table id="datatable-buttons" class="table table-striped table-hover dt-responsive display nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                <tr>
                    <th>Department</th>
                    <th>Date </th>
                    <th>IN</th>
                    <th>OUT</th>
                    <th>Deduction</th>
                    <th>Hours</th>
                    <th>Notes</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $check_attd = \App\Models\Attendance::where('emp_id', $employee->id)->orderBy('attendance_date', 'desc')->get();
                    $previous_date = null;
                @endphp

                @if($check_attd->count() > 0)
                    @foreach ($check_attd as $check_attds)
                        @if($previous_date != $check_attds->attendance_date)
                        @php
                            $check_attdo = \App\Models\Attendance::where('emp_id', $employee->id)
                                                                    ->where('status', 'OUT')
                                                                    ->where('attendance_date', $check_attds->attendance_date)
                                                                    ->first();
                            $out_time = ($check_attdo) ? $check_attdo->attendance_time : '';
                            $out_id = ($check_attdo) ? $check_attdo->id : '';
                            $difference = null;
                            if($out_time) {
                                $existingAttendanceTime = DateTime::createFromFormat('H:i:s', $check_attds->attendance_time);
                                $existingAttendanceEnd = DateTime::createFromFormat('H:i:s', $out_time);
                                $difference = $existingAttendanceTime->diff($existingAttendanceEnd);
                            }
                        @endphp

                        <tr>
                            <td>{{ $employee->position }}</td>
                            <td>{{$check_attds->attendance_date}}</td>
                            <td>{{$check_attds->attendance_time}}</td>
                            <td>{{$out_time}}</td>
                            <td>{{$check_attds->deduction}}</td> <!-- Display hours difference -->
                            <td>{{ ($difference) ? $difference->h : '' }}</td>
                            <td>{{$check_attds->note}}</td>
                            <td> <a href="#edit_emp_attand{{$check_attds->id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i> Edit</a></td>
                        </tr>
                        <div class="modal fade" id="edit_emp_attand{{ $check_attds->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header " style="align-items: center">

                                        <h4 class="modal-title "><span class="employee_id">Manual Adjustment &rarr; {{$employee->name}}</span></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" method="POST" action="{{ route('empattandenceupdate') }}">
                                            @csrf
                                            <input type="hidden" name="inid" value="{{$check_attds->id}}">
                                            <input type="hidden" name="outid" value="{{$out_id}}">
                                            <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="position">Time In:	 </label>
                                                <input type="time" class="form-control" name="starttime"
                                                       value="{{$check_attds->attendance_time}}" />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="position">ON: </label>
                                                {{--{{ Form::time('time', \Carbon\Carbon::now()->timezone('Europe/Brussels')->format('H:i'), ['class' => 'form-control']) }}--}}
                                                <input type="date"  name="indateemp" value="{{ $check_attds->attendance_date }}"  class="form-control" />

                                            </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="position">Time OUT:	 </label>
                                                    <input type="time"  name="endtime" class="form-control" value="{{$out_time}}"/>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="position">ON : </label>
                                                    {{--{{ Form::time('time', \Carbon\Carbon::now()->timezone('Europe/Brussels')->format('H:i'), ['class' => 'form-control']) }}--}}
                                                    <input type="date"  name="enddateemp" value="{{ $check_attds->attendance_date }}"  class="form-control" />

                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                <select class="form-control" id="position" name="position">
                                                    <option value="" selected> {{ $employee->position }}</option>
                                                    {{-- @foreach($departments as $department)
                                                         <option value="{{$department->name}}">{{$department->name}}</option>
                                                     @endforeach--}}

                                                </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                <select class="form-control" name="deduction">
                                                    <option value="0" selected>Auto</option>
                                                    <option value="0">None</option>
                                                    <option value="15">15 Minutes</option>
                                                    <option value="30">30 Minutes</option>
                                                    <option value="45">45 Minutes</option>
                                                    <option value="60">1 Hour</option>
                                                    <option value="120">2 Hours</option>
                                                    <option value="180">3 Hours</option>
                                                    <option value="240">4 Hours</option>
                                                    <option value="300">5 Hours</option>
                                                    <option value="360">6 Hours</option>
                                                    <option value="420">7 Hours</option>
                                                    <option value="480">8 Hours</option>
                                                    <option value="540">9 Hours</option>
                                                    <option value="600">10 Hours</option>
                                                    <option value="660">11 Hours</option>
                                                    <option value="720">12 Hours</option>
                                                    <option value="-2">Custom</option>
                                                </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <select class="form-control" name="type">
                                                        <option value="0" selected>None</option>
                                                        <option value="1">Lunch</option>
                                                        <option value="2">Break</option>
                                                        <option value="3">Leave</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="position">Note: </label>
                                               <textarea name="note" rows="4" cols="50">
                                               </textarea>
                                            </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                                                class="fa fa-close"></i> Close</button>
                                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-trash"></i> Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $previous_date = $check_attds->attendance_date;
                        @endphp
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" style="text-align: center;">No attendance records found</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete -->

