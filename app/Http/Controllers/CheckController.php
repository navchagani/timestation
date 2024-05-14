<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;

class CheckController extends Controller
{
    public function index()
    {

        return view('admin.check')->with(['employees' => Employee::all()]);
    }

    public function CheckStore(Request $request)
    {
        if (isset($request->attd)) {
            foreach ($request->attd as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($employee = Employee::whereId(request('emp_id'))->first()) {
                        if (
                            !Attendance::whereAttendance_date($keys)
                                ->whereEmp_id($key)
                                ->whereType(0)
                                ->first()
                        ) {
                            $data = new Attendance();

                            $data->emp_id = $key;
                            $emp_req = Employee::whereId($data->emp_id)->first();
                            $data->attendance_time = date('H:i:s', strtotime($emp_req->schedules->first()->time_in));
                            $data->attendance_date = $keys;

                            // $emps = date('H:i:s', strtotime($employee->schedules->first()->time_in));
                            // if (!($emps >= $data->attendance_time)) {
                            //     $data->status = 0;

                            // }
                            $data->save();
                        }
                    }
                }
            }
        }
        if (isset($request->leave)) {
            foreach ($request->leave as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($employee = Employee::whereId(request('emp_id'))->first()) {
                        if (
                            !Leave::whereLeave_date($keys)
                                ->whereEmp_id($key)
                                ->whereType(1)
                                ->first()
                        ) {
                            $data = new Leave();
                            $data->emp_id = $key;
                            $emp_req = Employee::whereId($data->emp_id)->first();
                            $data->leave_time = $emp_req->schedules->first()->time_out;
                            $data->leave_date = $keys;
                            // if ($employee->schedules->first()->time_out <= $data->leave_time) {
                            //     $data->status = 1;

                            // }
                            //
                            $data->save();
                        }
                    }
                }
            }
        }
        flash()->success('Success', 'You have successfully submited the attendance !');
        return back();
    }
    public function filter(Request $request)
    {
        $start = $request['start'];
        $end = $request['end'];
        $empid = $request['employee'];

        $dailyabsenceQuery  = DB::table('attendances AS t1')
            ->join('employees AS t2', 't1.emp_id', '=', 't2.id')
            ->select(
                't1.status',
                't1.attendance_time',
                't1.attendance_date',
                't1.pay',
                't2.name',
                't2.position',
                't2.hourrate',
                DB::raw('TIMESTAMPDIFF(HOUR,
            (SELECT t3.attendance_time FROM attendances AS t3 WHERE t3.emp_id = t1.emp_id AND t3.attendance_date = t1.attendance_date AND t3.status = "IN" ORDER BY t3.attendance_time LIMIT 1),
            t1.attendance_time
        ) AS time_difference')
            )
            ->where('t1.status', 'OUT')
            ->where('t1.attendance_date', '>=', $start) // Filter records with attendance_date greater than or equal to $start
            ->where('t1.attendance_date', '<=', $end)   // Filter records with attendance_date less than or equal to $end
            ->where('t1.emp_id', $empid);

        // Sum the time differences
        // Check if any records are returned
        if ($dailyabsenceQuery->count() > 0) {
           $dailyabsence = $dailyabsenceQuery->get();

        } else {
            $dailyabsence = []; // Set to an empty array instead of 0
        }
        return view('admin.employee-summary-report')->with(['employees' => Employee::all(),'dailyabsence' => $dailyabsence,'empi' => $empid,'sta' => $start,'dend' => $end])->withError('Amount pay');
    }
    public function sheetReport(Request $request)
    {
        $emp = $request->input('employee');
        if($emp) {
            $attendancesall = DB::table('attendances AS t1')
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
                ->where('t1.emp_id', $emp)
                ->orderBy('t1.attendance_date', 'asc')
                ->orderBy('t1.attendance_time', 'asc')
                ->get();
        }else{
            $attendancesall = []; // Set to an empty array instead of 0
        }
    return view('admin.sheet-report')->with(['employees' => Employee::all(),'attendancesall' => $attendancesall]);
    }
    public function pay(Request $request)
    {
        $start = $request['sta'];
        $end = $request['dend'];
        $empid = $request['emp'];
        DB::table('attendances')
            ->where('emp_id', $empid)
            ->where('attendance_date', '>=', $start) // Filter records with attendance_date greater than or equal to $start
            ->where('attendance_date', '<=', $end)   // Filter records with attendance_date less than or equal to $end
            ->update(['pay' => 1]);
        return view('admin.employee-summary-report')->with(['employees' => Employee::all()])->withSuccess('Pay Amount');
    }
    public function dailyabsenceReport()
    {
        /*$d =date('Y-m-d');
        $dailyabsence = DB::table('attendances AS t1')
            ->join('employees AS t2', 't1.emp_id', '=', 't2.id')
            ->select(
                't1.status',
                't1.attendance_time',
                't1.attendance_date',
                't2.name',
                't2.position'
            )
            ->where('t1.status', 'IN')
            ->where('t1.attendance_date', $d)
            ->orderBy('t1.attendance_date', 'asc')
            ->orderBy('t1.attendance_time', 'asc')
            ->groupBy('t1.emp_id')
            ->get();*/


        // Assuming $Empgname is already formatted correctly


        return view('admin.employee-daily-and-absence-report')->with(['employees' => Employee::all()]);
    }
    public function summaryReport()
    {

        return view('admin.employee-summary-report')->with(['employees' => Employee::all()]);
    }
    public function employeedailyReport()
    {
        return view('admin.employee-daily-report')->with(['employees' => Employee::all(),'attendancesall' => []]);
    }


}
