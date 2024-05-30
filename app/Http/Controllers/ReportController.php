<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Employee;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /* public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.report');
    }
    public function administrator()
    {
        return view('admin.administratorlist')->with(['users'=> User::all()]);
    }
    //Attendance Counter s
    public function attendancecounter()
    {
        $start = $request['start'] ?? date("Y-m-05");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['employee'] ?? [];
        return view('admin.attendance-counter')->with(['employeesa'=> Employee::all(),'employees'=> Employee::all(),'start' => $start,'end' => $end,'empid' => $empid]);
    }
    public function filters(Request $request)
    {
        // Default start and end dates
        $start = $request['start'];
        $end = $request['end'];
        $empid = $request->input('employee');

        // Retrieve employees based on empid
        if ($empid == 'Select an employee') {
             $employee = Employee::all();
        } else {
             $employee = Employee::where('id', $empid)->get();
        }

        // Pass data to the view
        return view('admin.attendance-counter')->with([
            'employeesa' => Employee::all(),
            'employees' => $employee,
            'start' => $start,
            'end' => $end,
            'empid' => $empid
        ]);
    }
    //Attendance Counter e
    //Attendance list s
    public function attendancelist()
    {
        $start = $request['start'] ?? date("Y-m-05");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['employee'] ?? [];
        return view('admin.attendancelist')->with(['employeesa'=> Employee::all(),'employees'=> Employee::all(),'start' => $start,'end' => $end,'empid' => $empid]);
    }
    public function filterattendance(Request $request)
    {
        // Default start and end dates
        $start = $request['start'];
        $end = $request['end'];
        $empid = $request->input('employee');

        // Retrieve employees based on empid
        if ($empid == 'Select an employee') {
            $employee = Employee::all();
        } else {
            $employee = Employee::where('id', $empid)->get();
        }

        // Pass data to the view
        return view('admin.attendancelist')->with([
            'employeesa' => Employee::all(),
            'employees' => $employee,
            'start' => $start,
            'end' => $end,
            'empid' => $empid
        ]);
    }
    public function employeedailyReport()
    {

        $start = $request['start'] ?? date("Y-m-05");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['employee'] ?? [];

        return view('admin.employee-daily-report')->with(['employeesa' => Employee::all(),'employees' => Employee::all(),'attendancesall' => [],'start' => $start,'end' => $end,'empid' => $empid]);
    }
    public function filterempattendance(Request $request)
    {
        // Default start and end dates
        $start = $request['start'];
        $end = $request['end'];
        $empid = $request->input('employee');
        if ($empid == 'Select an employee') {
            $employee = Employee::all();
        } else {
            $employee = Employee::where('id', $empid)->get();
        }
        return view('admin.employee-daily-report')->with(['employeesa' => Employee::all(),'employees' => $employee,'attendancesall' => [],'start' => $start,'end' => $end,'empid' => $empid]);

    }

    public function currentemployee()
    {
        $empid = $request['employee'] ?? [];
        return view('admin.employee-current-report')->with(['employeesa' => Employee::all(),'employees' => Employee::all(),'attendancesall' => [],'empid' => $empid]);
    }
    public function departmentlist()
    {
        $departmentlist = Employee::join('department', 'department.name', '=', 'employees.position')
            ->select('department.name','department.type')
            ->selectRaw('count(employees.id) as count')
            ->groupby('department.id','department.name','department.type')
            ->get();
        return view('admin.departmentlist')->with(['departmentlist' => $departmentlist]);
    }
    public function departmentmember()
    {
        $departmentlist = Employee::join('department', 'department.name', '=', 'employees.position')
            ->select('department.name as dename','department.type','employees.name as empname','employees.hourrate as hourrate')
            //->groupby('department.id','department.name','department.type')
            ->get();
        return view('admin.department-member')->with(['departmentlist' => $departmentlist,'departments'=>Department::all()]);
    }
    public function departmentfilters(Request $request)
    {
        // Default start and end dates
        $departmentid = $request->input('department');
        $departmentlist = Employee::join('department', 'department.name', '=', 'employees.position')
            ->select('department.name as dename','department.type','employees.name as empname','employees.hourrate as hourrate')
            ->where('department.name',$departmentid)
            ->groupby('department.id','department.name','department.type','employees.name','employees.hourrate')
            ->get();
        return view('admin.department-member')->with(['departmentlist' => $departmentlist,'departments'=>Department::all()]);
    }

    public function departmentsummarys()
    {
        $start = $request['start'] ?? date("Y-m-05");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['employee'] ?? [];

        // Subquery to calculate total hours worked per attendance entry
$subquery = DB::table('attendances AS in_att')
    ->join('attendances AS out_att', function($join) {
        $join->on('in_att.emp_id', '=', 'out_att.emp_id')
            ->on('in_att.attendance_date', '=', 'out_att.attendance_date')
            ->where('in_att.status', '=', 'IN')
            ->where('out_att.status', '=', 'OUT');
    })
    ->select('in_att.emp_id', 'in_att.attendance_date',
        DB::raw('TIMESTAMPDIFF(HOUR, in_att.attendance_time, out_att.attendance_time) as hours_worked'))
    ->whereBetween('in_att.attendance_date', [$start, $end]);

// Main query to calculate total earnings by position
$dailyabsence = DB::table('employees AS t2')
    ->joinSub($subquery, 't1', function($join) {
        $join->on('t2.id', '=', 't1.emp_id');
    })
    ->select('t2.position', DB::raw('SUM(t1.hours_worked) as total_hours, SUM(t1.hours_worked * t2.hourrate) as total_earnings'))
    ->groupBy('t2.position')
    ->get();
        return view('admin.departmentsummary')->with(['employeesa'=> $dailyabsence,'employees'=> Employee::all(),'start' => $start,'end' => $end,]);
    }
    public function departmentsummaryfilters(Request $request)
    {
        $start = $request['start'] ?? date("Y-m-05");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['employee'] ?? [];

        // Subquery to calculate total hours worked per attendance entry
        $subquery = DB::table('attendances AS in_att')
            ->join('attendances AS out_att', function($join) {
                $join->on('in_att.emp_id', '=', 'out_att.emp_id')
                    ->on('in_att.attendance_date', '=', 'out_att.attendance_date')
                    ->where('in_att.status', '=', 'IN')
                    ->where('out_att.status', '=', 'OUT');
            })
            ->select('in_att.emp_id', 'in_att.attendance_date',
                DB::raw('TIMESTAMPDIFF(HOUR, in_att.attendance_time, out_att.attendance_time) as hours_worked'))
            ->whereBetween('in_att.attendance_date', [$start, $end]);

// Main query to calculate total earnings by position
        $dailyabsence = DB::table('employees AS t2')
            ->joinSub($subquery, 't1', function($join) {
                $join->on('t2.id', '=', 't1.emp_id');
            })
            ->select('t2.position', DB::raw('SUM(t1.hours_worked) as total_hours, SUM(t1.hours_worked * t2.hourrate) as total_earnings'))
            ->groupBy('t2.position')
            ->get();
        return view('admin.departmentsummary')->with(['employeesa'=> $dailyabsence,'employees'=> Employee::all(),'start' => $start,'end' => $end,]);

    }

    public function employeesummarys()
    {
        $start = $request['start'] ?? date("Y-m-05");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['employee'] ?? [];

        // Subquery to calculate total hours worked per attendance entry
        $subquery = DB::table('attendances AS in_att')
            ->join('attendances AS out_att', function($join) {
                $join->on('in_att.emp_id', '=', 'out_att.emp_id')
                    ->on('in_att.attendance_date', '=', 'out_att.attendance_date')
                    ->where('in_att.status', '=', 'IN')
                    ->where('out_att.status', '=', 'OUT');
            })
            ->select('in_att.emp_id', 'in_att.attendance_date',
                DB::raw('TIMESTAMPDIFF(HOUR, in_att.attendance_time, out_att.attendance_time) as hours_worked'))
            ->whereBetween('in_att.attendance_date', [$start, $end]);

// Main query to calculate total earnings by position, including employees with no attendance records
        $dailyabsence = DB::table('employees AS t2')
            ->leftJoinSub($subquery, 't1', function($join) {
                $join->on('t2.id', '=', 't1.emp_id');
            })
            ->select('t2.name', 't2.position','t2.hourrate', DB::raw('IFNULL(SUM(t1.hours_worked), 0) as total_hours, IFNULL(SUM(t1.hours_worked * t2.hourrate), 0) as total_earnings'))
            ->groupBy('t2.name', 't2.position', 't2.hourrate')
            ->get();
        return view('admin.employeesummary')->with(['employeesa'=> $dailyabsence,'employees'=> Employee::all(),'start' => $start,'end' => $end,]);
    }
    public function employeepermissions()
    {
        $start = $request['start'] ?? date("Y-m-05");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['employee'] ?? [];

        // Subquery to calculate total hours worked per attendance entry
        $subquery = DB::table('attendances AS in_att')
            ->join('attendances AS out_att', function($join) {
                $join->on('in_att.emp_id', '=', 'out_att.emp_id')
                    ->on('in_att.attendance_date', '=', 'out_att.attendance_date')
                    ->where('in_att.status', '=', 'IN')
                    ->where('out_att.status', '=', 'OUT');
            })
            ->select('in_att.emp_id', 'in_att.attendance_date',
                DB::raw('TIMESTAMPDIFF(HOUR, in_att.attendance_time, out_att.attendance_time) as hours_worked'))
            ->whereBetween('in_att.attendance_date', [$start, $end]);

// Main query to calculate total earnings by position, including employees with no attendance records
        $dailyabsence = DB::table('employees AS t2')
            ->leftJoinSub($subquery, 't1', function($join) {
                $join->on('t2.id', '=', 't1.emp_id');
            })
            ->select('t2.name', 't2.position','t2.hourrate', DB::raw('IFNULL(SUM(t1.hours_worked), 0) as total_hours, IFNULL(SUM(t1.hours_worked * t2.hourrate), 0) as total_earnings'))
            ->groupBy('t2.name', 't2.position', 't2.hourrate')
            ->get();
        return view('admin.employeepermission')->with(['employeesa'=> $dailyabsence,'employees'=> Employee::all(),'start' => $start,'end' => $end,]);

    }

    public function inactiveemployee()
    {
        $start = $request['start'] ?? date("Y-m-05");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['department'] ?? [];
        return view('admin.employeeinactive')->with(['employees'=> Employee::all(),'department' => Department::all(),'start' => $start,'end' => $end,'empid' => $empid]);
    }
    public function employeeinactivefilters(Request $request)
    {
        $start = $request['start'] ?? date("Y-m-05");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['department'] ?? [];
        $employee = Employee::where('position', $empid)->get();
        return view('admin.employeeinactive')->with(['employees'=> $employee,'department' => Department::all(),'start' => $start,'end' => $end,'empid' => $empid]);
    }

    public function employeedailyoneReport()
    {

        $start = $request['start'] ?? date("Y-m-01");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['employee'] ?? [];

        return view('admin.employee-one-week-report')->with(['employeesa' => Employee::all(),'employees' => Employee::all(),'attendancesall' => [],'start' => $start,'end' => $end,'empid' => $empid]);
    }
    public function filterempattendanceone(Request $request)
    {
        // Default start and end dates
        $start = $request['start'];
        $end = $request['end'];
        $empid = $request->input('employee');
        if ($empid == 'Select an employee') {
            $employee = Employee::all();
        } else {
            $employee = Employee::where('id', $empid)->get();
        }
        return view('admin.employee-one-week-report')->with(['employeesa' => Employee::all(),'employees' => $employee,'attendancesall' => [],'start' => $start,'end' => $end,'empid' => $empid]);

    }
    public function employeedailytwoReport()
    {

        $start = $request['start'] ?? date("Y-m-01");
        $end = $request['end'] ?? date("Y-m-15");
        $empid = $request['employee'] ?? [];

        return view('admin.employee-two-week-report')->with(['employeesa' => Employee::all(),'employees' => Employee::all(),'attendancesall' => [],'start' => $start,'end' => $end,'empid' => $empid]);
    }

    public function filterempattendancetwo(Request $request)
    {
        // Default start and end dates
        $start = $request['start'];
        $end = $request['end'];
        $empid = $request->input('employee');
        if ($empid == 'Select an employee') {
            $employee = Employee::all();
        } else {
            $employee = Employee::where('id', $empid)->get();
        }
        return view('admin.employee-two-week-report')->with(['employeesa' => Employee::all(),'employees' => $employee,'attendancesall' => [],'start' => $start,'end' => $end,'empid' => $empid]);

    }
    public function dailyabsenceReport()
    {
        $start = $request['start'] ?? date("Y-m-01");
        $empid = $request['employee'] ?? [];
        return view('admin.employee-daily-and-absence-report')->with(['employees' => Employee::all(),'department' => Department::all(),'empid' => $empid,'start' => $start]);
    }
    public function dailyfilters(Request $request)
    {
        $start = $request['start'] ?? date("Y-m-01");
        $empid = $request['employee'] ?? [];
        return view('admin.employee-daily-and-absence-report')->with(['employees' => Employee::all(),'department' => Department::all(),'empid' => $empid,'start' => $start]);
    }
    public function currentdevice()
    {
        return view('admin.currentdevice')->with(['users'=> User::all()]);
    }
    public function sheetReport()
    {
        $start = $request['start'] ?? date("Y-m-01");
        $end = $request['end'] ?? date("Y-m-15");
        $empid = $request['employee'] ?? [];

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
                //->where('t1.emp_id', $emp)
                ->orderBy('t1.attendance_date', 'asc')
                ->orderBy('t1.attendance_time', 'asc')
                ->get();

        return view('admin.sheet-report')->with(['employees' => Employee::all(),'attendancesall' => $attendancesall,'start' => $start,'end' => $end,'empid' => $empid]);
    }

    public function payrollexport()
    {
        $start = $request['start'] ?? date("Y-m-01");
        $end = $request['end'] ?? date("Y-m-15");
        $empid = $request['employee'] ?? [];

        // Subquery to calculate total hours worked per attendance entry
        $attendancesall = DB::table('attendances AS in_att')
            ->join('attendances AS out_att', function($join) {
                $join->on('in_att.emp_id', '=', 'out_att.emp_id')
                    ->on('in_att.attendance_date', '=', 'out_att.attendance_date')
                    ->where('in_att.status', '=', 'IN') // Considering only clock in time
                    ->where('out_att.status', '=', 'OUT');
            })->join('employees AS t2', 'in_att.emp_id', '=', 't2.id')
            ->select('t2.empid','t2.hourrate','t2.name','in_att.emp_id', 'in_att.attendance_date', 'in_att.attendance_time', 'out_att.attendance_time as iou', 'in_att.status','out_att.attendance_date as ou',
                DB::raw('TIMESTAMPDIFF(HOUR, in_att.attendance_time, out_att.attendance_time) as hours_worked'))
            ->whereBetween('in_att.attendance_date', [$start, $end])
            ->get();

        return view('admin.payrollexport')->with(['employees' => Employee::all(),'attendancesall' => $attendancesall,'start' => $start,'end' => $end,'empid' => $empid]);
    }
    public function employeedetails()
    {
        $start = $request['start'] ?? date("Y-m-01");
        $end = $request['end'] ?? date("Y-m-15");
        $empid = $request['employee'] ?? [];

        // Subquery to calculate total hours worked per attendance entry
        $attendancesall = DB::table('attendances AS in_att')
            ->join('attendances AS out_att', function($join) {
                $join->on('in_att.emp_id', '=', 'out_att.emp_id')
                    ->on('in_att.attendance_date', '=', 'out_att.attendance_date')
                    ->where('in_att.status', '=', 'IN') // Considering only clock in time
                    ->where('out_att.status', '=', 'OUT');
            })->join('employees AS t2', 'in_att.emp_id', '=', 't2.id')
            ->select('t2.position','t2.hourrate','t2.name','in_att.emp_id', 'in_att.attendance_date', 'in_att.attendance_time', 'out_att.attendance_time as iou', 'in_att.status','out_att.attendance_date as ou',
                DB::raw('TIMESTAMPDIFF(HOUR, in_att.attendance_time, out_att.attendance_time) as hours_worked'))
            ->whereBetween('in_att.attendance_date', [$start, $end])
            ->get();

        return view('admin.employeedetails')->with(['employees' => Employee::all(),'attendancesall' => $attendancesall,'start' => $start,'end' => $end,'empid' => $empid,'department' => Department::all()]);
    }
    public function payrollheartland()
    {
        $start = $request['start'] ?? date("Y-m-05");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['employee'] ?? [];

        // Subquery to calculate total hours worked per attendance entry
        $subquery = DB::table('attendances AS in_att')
            ->join('attendances AS out_att', function($join) {
                $join->on('in_att.emp_id', '=', 'out_att.emp_id')
                    ->on('in_att.attendance_date', '=', 'out_att.attendance_date')
                    ->where('in_att.status', '=', 'IN')
                    ->where('out_att.status', '=', 'OUT');
            })
            ->select('in_att.emp_id', 'in_att.attendance_date',
                DB::raw('TIMESTAMPDIFF(HOUR, in_att.attendance_time, out_att.attendance_time) as hours_worked'))
            ->whereBetween('in_att.attendance_date', [$start, $end]);

// Main query to calculate total earnings by position, including employees with no attendance records
        $dailyabsence = DB::table('employees AS t2')
            ->leftJoinSub($subquery, 't1', function($join) {
                $join->on('t2.id', '=', 't1.emp_id');
            })
            ->select('t2.empid','t2.name', 't2.position','t2.hourrate', DB::raw('IFNULL(SUM(t1.hours_worked), 0) as total_hours, IFNULL(SUM(t1.hours_worked * t2.hourrate), 0) as total_earnings'))
            ->groupBy('t2.name', 't2.position', 't2.hourrate','t2.empid')
            ->get();
        return view('admin.payrollheartland')->with(['employeesa'=> $dailyabsence,'employees'=> Employee::all(),'start' => $start,'end' => $end,'empid' => $empid,'department' => Department::all()]);
    }
    public function manualtime()
    {
        $start = $request['start'] ?? date("Y-m-01");
        $end = $request['end'] ?? date("Y-m-15");
        $empid = $request['employee'] ?? [];

        // Subquery to calculate total hours worked per attendance entry
        $attendancesall = DB::table('attendances AS in_att')
            ->join('attendances AS out_att', function($join) {
                $join->on('in_att.emp_id', '=', 'out_att.emp_id')
                    ->on('in_att.attendance_date', '=', 'out_att.attendance_date')
                    ->where('in_att.status', '=', 'IN') // Considering only clock in time
                    ->where('out_att.status', '=', 'OUT');
            })->join('employees AS t2', 'in_att.emp_id', '=', 't2.id')
            ->select('t2.position','t2.hourrate','t2.name','in_att.emp_id', 'in_att.attendance_date', 'in_att.attendance_time', 'out_att.attendance_time as iou', 'in_att.status','out_att.attendance_date as ou',
                DB::raw('TIMESTAMPDIFF(HOUR, in_att.attendance_time, out_att.attendance_time) as hours_worked'))
            ->whereBetween('in_att.attendance_date', [$start, $end])
            ->get();

        return view('admin.manualtime')->with(['employees' => Employee::all(),'attendancesall' => $attendancesall,'start' => $start,'end' => $end,'empid' => $empid,'department' => Department::all()]);
    }
}
