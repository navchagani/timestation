<?php

namespace App\Http\Controllers;

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

    public function departmentsummary()
    {
        $start = $request['start'] ?? date("Y-m-05");
        $end = $request['end'] ?? date("Y-m-10");
        $empid = $request['employee'] ?? [];
        return view('admin.departmentsummary')->with(['employeesa'=> Employee::all(),'employees'=> Employee::all(),'start' => $start,'end' => $end,'empid' => $empid]);
    }
}
