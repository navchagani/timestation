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
    public function attendancecounter()
    {
        $start = $request['start'] ?? 2024-05-05;
        $end = $request['end'] ?? 2024-05-10;
        return view('admin.attendance-counter')->with(['employees'=> Employee::all(),'start' => $start,'end' => $end]);
    }
    public function filters(Request $request)
    {
        $start = $request['start'];
        $end = $request['end'];
        $empid = $request['employee'];
        return view('admin.attendance-counter')->with(['employees'=> Employee::all(),'start' => $start,'end' => $end]);
    }
}
