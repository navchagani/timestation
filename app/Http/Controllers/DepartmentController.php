<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\DepartmentEmp;

class DepartmentController extends Controller
{

    public function index()
    {

        return view('admin.department')->with('department', Department::all());
        flash()->success('Success','department has been created successfully !');

    }


    public function store(DepartmentEmp $request)
    {
        $request->validated();
        $department = new department;
        $department->name = $request->name;
        $department->save();
        flash()->success('Success','department has been created successfully !');
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
