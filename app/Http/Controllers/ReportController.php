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
        return view('admin.attendance-counter')->with(['employees'=> Employee::all()]);
    }
}
