<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Latetime;
use App\Models\Attendance;
use App\Models\Department;


class AdminController extends Controller
{


    public function index()
    {
        //Dashboard statistics
        $d =date('Y-m-d');
        $totalEmp =  count(Employee::all());
        $AllAttendance = count(Attendance::whereAttendance_date(date("Y-m-d"))->get());
        $ontimeEmp = count(Attendance::whereAttendance_date(date("Y-m-d"))->whereStatus('1')->get());
        $latetimeEmp = count(Attendance::whereAttendance_date(date("Y-m-d"))->whereStatus('0')->get());
        $Empgname = Employee::join('attendances', 'employees.id', '=', 'attendances.emp_id')
            ->whereDate('attendances.attendance_date', '=', date('Y-m-d'))
            ->groupBy('employees.position') // Include 'position' in the group by
            ->selectRaw('employees.position as position')
            ->selectRaw('count(DISTINCT employees.id) as count')
            ->selectRaw('SUM(CASE WHEN attendances.status = "IN" THEN 1 ELSE 0 END) as ine')
            ->selectRaw('SUM(CASE WHEN attendances.status = "OUT" THEN 1 ELSE 0 END) as oute')
            ->get();
        if($AllAttendance > 0){
                $percentageOntime = str_split(($ontimeEmp/ $AllAttendance)*100, 4)[0];
            }else {
                $percentageOntime = 0 ;
            }

        $data = [$totalEmp, $ontimeEmp, $latetimeEmp, $percentageOntime];
        $attendances = Attendance::orderBy('created_at', 'desc')->get();
        return view('admin.index')->with(['data' => $data,'attendances' => $attendances,'empgnams' => $Empgname]);
    }
    public function RecentActivity()
    {
        //Dashboard statistics
        $d =date('Y-m-d');
        $totalEmp =  count(Employee::all());
        $AllAttendance = count(Attendance::whereAttendance_date(date("Y-m-d"))->get());
        $ontimeEmp = count(Attendance::whereAttendance_date(date("Y-m-d"))->whereStatus('1')->get());
        $latetimeEmp = count(Attendance::whereAttendance_date(date("Y-m-d"))->whereStatus('0')->get());


        $data = [$totalEmp, $ontimeEmp, $latetimeEmp];
        $attendances = Attendance::join('employees', 'attendances.emp_id', '=', 'employees.id')
            ->selectRaw('attendances.status as status')
            ->selectRaw('attendances.attendance_time as attendance_time')
            ->selectRaw('attendances.attendance_date as attendance_date')
            ->selectRaw('employees.name as name')
            ->orderBy('attendances.created_at', 'desc')->get();
        // Assuming $Empgname is already formatted correctly

        return response()->json([
            'data' => $data,
            'attendances' => $attendances,
        ]);

    }
    public function getone() {
        $msg = "This is a simple message.";
        return response()->json(array('msg'=> $msg), 200);
    }
}
