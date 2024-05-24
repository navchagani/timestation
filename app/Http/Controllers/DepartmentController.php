<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\DepartmentEmp;
use App\Models\Employee;

class DepartmentController extends Controller
{

    public function index()
    {
        $Empgname = Employee::join('attendances', 'employees.id', '=', 'attendances.emp_id')
            ->join('department', 'employees.position', '=', 'department.name')
            ->groupBy('employees.position','department.type','department.id') // Include 'position' in the group by
            ->selectRaw('employees.position as position')
            ->selectRaw('department.type as type')
            ->selectRaw('department.id as did')// Use the alias 't2' for the department table
            ->selectRaw('count(DISTINCT employees.id) as count')
            ->selectRaw('SUM(CASE WHEN attendances.status = "IN" THEN 1 ELSE 0 END) as ine')
            ->selectRaw('SUM(CASE WHEN attendances.status = "OUT" THEN 1 ELSE 0 END) as oute')
            ->get();
        return view('admin.department')->with(['department', Department::all(),'empgnams' => $Empgname]);
        flash()->success('Success','department has been created successfully !');

    }


    public function store(DepartmentEmp $request)
    {
        $request->validated();
        $department = new department;
        $department->name = $request->name;
        $department->type = $request->DepartmentType;
        $department->reporting = $request->reporting ?? 0;
        $department->timededuction = $request->deduction ?? 0;
        $department->assign = $request->assign ?? 0;
        $department->save();
        flash()->success('Success','Department has been created successfully !');
        return redirect()->route('department.index');

    }

    public function update(DepartmentEmp $request, Department $department)
    {
        /*$request['time_in'] = str_split($request->time_in, 5)[0];
        $request['time_out'] = str_split($request->time_out, 5)[0];

        $request->validated();*/

        $department->name = $request->name;
        $department->save();
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
