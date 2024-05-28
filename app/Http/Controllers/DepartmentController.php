<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Department;
use App\Http\Requests\DepartmentEmp;
use App\Models\Employee;

class DepartmentController extends Controller
{

    public function index()
    {
        $Empgname = Employee::join('attendances', 'employees.id', '=', 'attendances.emp_id')
            ->join('department', 'employees.position', '=', 'department.name')
            ->groupBy('department.id','employees.position', 'department.type', 'department.reporting', 'department.timededuction', 'department.assign')
            ->selectRaw('employees.position as position')
            ->selectRaw('department.type as type')
            ->selectRaw('department.id as did')
            ->selectRaw('department.reporting as reporting')
            ->selectRaw('department.timededuction as timededuction')
            ->selectRaw('department.assign as assign')
            ->selectRaw('count(DISTINCT employees.id) as count')
            ->selectRaw('SUM(CASE WHEN attendances.status = "IN" THEN 1 ELSE 0 END) as ine')
            ->selectRaw('SUM(CASE WHEN attendances.status = "OUT" THEN 1 ELSE 0 END) as oute')
            ->get();
        return view('admin.department')->with(['departments'=>Department::all(),'empgnams' => $Empgname]);
        flash()->success('Success','department has been created successfully !');

    }


    public function store(DepartmentEmp $request)
    {

        $request->validated();
        $department = new department;
        $department->name = $request->name;
        $department->type = $request->type;
        $department->reporting = $request->reporting ?? 0;
        $department->timededuction = $request->timededuction ?? 0;
        $department->assign = $request->assign ?? 0;
        $department->save();
        flash()->success('Success','Department has been created successfully !');
        return redirect()->route('department.index');

    }

    public function update(DepartmentEmp $request, Department $department)
    {

        DB::table('department')
            ->where('id', $request->did)
            ->update(['name' => $request->name,'type' => $request->DepartmentType,'reporting' => $request->reporting ?? 0,'timededuction' => $request->deduction ?? 0,'assign' => $request->assign ?? 0]);
        flash()->success('Success','department has been Updated successfully !');
        return redirect()->route('department.index');


    }


    public function destroy(Department $department)
    {
        $department->delete();
        flash()->success('Success','Schedule has been deleted successfully !');
        return redirect()->route('schedule.index');
    }
}
