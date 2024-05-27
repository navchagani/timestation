<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Department;
use App\Http\Requests\DepartmentEmp;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use App\Models\business_settings;


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


    public function addSettings(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'company_name' => 'required',
            'attendance_mode' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Plz fill all required fields.');
        }

        $business_settings = new business_settings();

        $business_settings::create([
            'company_name' => $request->company_name,
            'attendance_mode' => $request->attendance_mode,
            'GPS_location_tagging' => $request->gps_location_tagging ? 1  : 0,
            'covid_19_screening' => $request->covid_screening ? 1 : 0,
            'time_rounding' => $request->TimeRounding,
            'TimeRounding_Display' => $request->display_round,
            'DateFormat' => $request->DateFormat,
            'TimeFormat' => $request->TimeFormat,
            'HoursFormat' => $request->hours_format,
            'DefaultReportDateRange' => $request->DefaultReportDateRange,
            'DefaultReportDateRange_Today' => $request->include_today ? 1 : 0,
            'automaticTimeDeduction' => $request->automaticTimeDeduction,
            'automaticTimeDeductionThreshold' => $request->automaticTimeDeductionThreshold,
            'Card_field_1' => $request->Card_field_1,
            'Card_field_2' => $request->Card_field_2,
            'Card_field_3' => $request->Card_field_3,
            'Card_field_4' => $request->Card_field_4,
        ]);

        return back()->with('success', 'Settings saved successfully.');
    }
}
