<?php

namespace App\Http\Controllers;

use DateTime;
use DB;
use App\Models\Employee;
use App\Models\Latetime;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AttendanceEmp;

class AttendanceController extends Controller
{
    //show attendance
    public function index()
    {
        return view('admin.attendance')->with(['attendances' => Attendance::all()]);
    }

    //show late times
    public function indexLatetime()
    {
        return view('admin.latetime')->with(['latetimes' => Latetime::all()]);
    }
    public function empattandenceupdate(Request $request)
    {
        $inid = $request->input('inid');
        $outid = $request->input('outid');
        $starttime = $request->input('starttime');
        $indateemp = $request->input('indateemp');
        $endtime = $request->input('endtime');
        $enddateemp = $request->input('enddateemp');
        $position = $request->input('position');
        $deduction = $request->input('deduction');
        $type = $request->input('type');
        $note = $request->input('note');

        DB::table('attendances')
            ->where('id', $inid)
            ->update(['attendance_time' => $starttime,'attendance_date' => $indateemp,'deduction' => $deduction,'type' => $type,'note' => $note]);
        DB::table('attendances')
            ->where('id', $outid)
            ->update(['attendance_time' => $endtime,'attendance_date' => $enddateemp,'deduction' => $deduction,'type' => $type,'note' => $note]);
        flash()->success('Success','Addandence Record has been Updated successfully !');
        return redirect()->route('employees.index')->with('success');
    }
    public function addempattandenceupdate(Request $request)
    {
        $emp_id = $request->input('emp_id');
        $starttime = $request->input('starttime');
        $indateemp = $request->input('indateemp');
        $endtime = $request->input('endtime');
        $enddateemp = $request->input('enddateemp');
        $position = $request->input('position');
        $deduction = $request->input('deduction');
        $type = $request->input('type');
        $note = $request->input('note');


        $attendance = new Attendance;
        $attendance->emp_id = $emp_id;
        $attendance->attendance_time = $starttime;
        $attendance->attendance_date = $indateemp;
        $attendance->deduction = $deduction;
        $attendance->type = $type;
        $attendance->note = $note;
        $attendance->status = 'IN'; // Set status to 0 for check-in
        $attendance->manual = 1;
        $attendance->save();
        $attendances = new Attendance;
        $attendances->emp_id = $emp_id;
        $attendances->attendance_time = $endtime;
        $attendances->attendance_date = $enddateemp;
        $attendances->deduction = $deduction;
        $attendances->type = $type;
        $attendances->note = $note;
        $attendances->status = 'OUT'; // Set status to 0 for check-in
        $attendances->manual = 1;
        $attendances->save();
        flash()->success('Success','Addandence Record has been add successfully !');
        return redirect()->route('employees.index')->with('success');

    }

    // public static function lateTime(Employee $employee)
    // {
    //     $current_t = new DateTime(date('H:i:s'));
    //     $start_t = new DateTime($employee->schedules->first()->time_in);
    //     $difference = $start_t->diff($current_t)->format('%H:%I:%S');

    //     $latetime = new Latetime();
    //     $latetime->emp_id = $employee->id;
    //     $latetime->duration = $difference;
    //     $latetime->latetime_date = date('Y-m-d');
    //     $latetime->save();
    // }

    public static function lateTimeDevice($att_dateTime, Employee $employee)
    {
        $attendance_time = new DateTime($att_dateTime);
        $checkin = new DateTime($employee->schedules->first()->time_in);
        $difference = $checkin->diff($attendance_time)->format('%H:%I:%S');

        $latetime = new Latetime();
        $latetime->emp_id = $employee->id;
        $latetime->duration = $difference;
        $latetime->latetime_date = date('Y-m-d', strtotime($att_dateTime));
        $latetime->save();
    }

}
