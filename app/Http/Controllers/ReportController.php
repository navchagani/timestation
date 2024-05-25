<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

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
        $start = $request['start'] ?? '2024-05-05';
        $end = $request['end'] ?? '2024-05-10';
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
        $start = $request['start'] ?? '2024-05-05';
        $end = $request['end'] ?? '2024-05-10';
        $empid = $request['employee'] ?? [];
        return view('admin.attendance-list')->with(['employeesa'=> Employee::all(),'employees'=> Employee::all(),'start' => $start,'end' => $end,'empid' => $empid]);
    }
}
