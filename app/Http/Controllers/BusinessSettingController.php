<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Department;
use App\Http\Requests\DepartmentEmp;
use App\Models\Employee;

class BusinessSettingController extends Controller
{

    public function index()
    {

        return view('admin.businesssetting');


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
