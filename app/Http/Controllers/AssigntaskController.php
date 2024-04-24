<?php


namespace App\Http\Controllers;
use App\Http\Requests\DepartmentEmp;
use App\Models\Assign;
use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Schedule;
use App\Http\Requests\EmployeeRec;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\AssignEmp;


class AssigntaskController extends Controller
{
    public function index()
    {
        $user = Auth::id();
        $Empgname = Assign::join('employees', 'tasks.employee_id', '=', 'employees.id')
            ->selectRaw('employees.name as ename, tasks.name, tasks.duration, tasks.created_at, tasks.is_active, tasks.completed')
            ->get();
        return view('admin.assign')->with(['assigns'=> $Empgname,'employees'=> Employee::all(),'userid'=>$user]);
    }

    public function store(AssignEmp $request)
    {
        $request->validated();

        $assign = new Assign;
        $assign->name = $request->name;
        $assign->user_id = $request->userid;
        $assign->employee_id = $request->employees;
        $assign->duration = $request->duration;
        $assign->save();

        flash()->success('Success','Tasks has been created successfully !');
        return view('admin.assign')->with(['assigns'=> Assign::all(),'employees'=> Employee::all(),'userid'=>$request->userid]);

    }
}
