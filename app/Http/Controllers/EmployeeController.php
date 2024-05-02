<?php

namespace App\Http\Controllers;
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
use DateTime;

class EmployeeController extends Controller
{

    public function index()
    {

        return view('admin.employee')->with(['employees'=> Employee::all(), 'schedules'=>Schedule::all(),'departments'=>Department::all()]);
    }
    public function getCustomers(){
        $blogs = Employee::latest()->paginate(10);
        return [
            "data" => $blogs
        ];
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user()
                ->join('business_locations', 'users.location_id', '=', 'business_locations.id')
                ->selectRaw('users.name as uname, users.email, business_locations.name as lname')
                ->first();
            if ($user) {
                return response()->json([
                    "success" => true,
                    "data" => [
                        "username" => $user->uname,
                        "email" => $user->email,
                        "location_id" => $user->lname,
                        'employees'=> Employee::all()->toArray()
                    ]
                ], 200);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => [
                        "type" => "invalid_user_password",
                        "info" => "Invalid User or Password"
                    ]
                ], 200);
                //return response()->json(['error' => 'Unauthorised'], 401);
            }
        }else {
            return response()->json([
                "success" => false,
                "data" => [
                    "type" => "invalid_user_password",
                    "info" => "Invalid User or Password"
                ]
            ], 200);
            //return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    public function markattandence(Request $request)
    {
        $valueToCheck = $request->input('pin');
        if ($employee = Employee::where('pin', $valueToCheck)->first()) {
            if (Hash::check($request->pin_code, $employee->pin_code)) {
                $existingAttendance = Attendance::where('attendance_date', date("Y-m-d"))
                    ->where('emp_id', $employee->id)
                    ->orderBy('attendance_time', 'desc')
                    ->first();
                if ($existingAttendance && $existingAttendance->status == 1) {
                    // Employee has already checked out, so insert a new check-in record
                    $attendance = new Attendance;
                    $attendance->emp_id = $employee->id;
                    $attendance->attendance_time = date("H:i:s");
                    $attendance->attendance_date = date("Y-m-d");
                    $attendance->status = 0; // Set status to 0 for check-in
                    $attendance->save();

                    // Calculate time difference
                    $existingAttendanceTime = DateTime::createFromFormat('H:i:s', $existingAttendance->attendance_time);
                    $currentTime = new DateTime();
                    $difference = $existingAttendanceTime->diff($currentTime);

                    return response()->json([
                        "success" => true,
                        "data" => [
                            "employeename" => $employee->name,
                            "perhourrate" => $employee->hourrate,
                            "in" => $existingAttendance->attendance_date .' '. $existingAttendance->attendance_time,
                            "out" => date("Y-m-d H:i:s"),
                            "difference" => $difference->format('%H:%I:%S')
                        ]
                    ], 200);
                }else {
                    // Either there's no existing record for the day or the employee hasn't checked out yet
                    $attendance = new Attendance;
                    $attendance->emp_id = $employee->id;
                    $attendance->attendance_time = date("H:i:s");
                    $attendance->attendance_date = date("Y-m-d");
                    $attendance->status = 1; // Set status to 0 for check-out
                    $attendance->save();
                    return response()->json([
                        "success" => true,
                        "data" => [
                            "employeename" => $employee->name,
                            "in" => date("Y-m-d H:i:s")
                        ]
                    ], 200);
                    //return response()->json(['success' => 'Successful IN'], 200);
                }
            } else {
                return response()->json(['error' => 'Failed to assign the attendance'], 404);
            }
        }else {
            return response()->json([
                "success" => false,
                "data" => [
                    "error" => 'Invalid User'
                ]
            ], 404);
        }
        //return response()->json(['success' => 'Successful in assign the attendance'], 200);
        /*$valueToCheck = $request->input('pin');
        $count = Employee::where('pin', $valueToCheck)->count();
        if ($count > 0) {
            $employee = Employee::where('pin', $valueToCheck)->first();
            var_dump($employee->name);
        } else {
            echo 'Invalid User';
        }*/
        die();
        if (isset($request->attd)) {
            foreach ($request->attd as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($employee = Employee::whereId(request('emp_id'))->first()) {
                        if (
                        !Attendance::whereAttendance_date($keys)
                            ->whereEmp_id($key)
                            ->whereType(0)
                            ->first()
                        ) {
                            $data = new Attendance();

                            $data->emp_id = $key;
                            $emp_req = Employee::whereId($data->emp_id)->first();
                            $data->attendance_time = date('H:i:s', strtotime($emp_req->schedules->first()->time_in));
                            $data->attendance_date = $keys;

                            // $emps = date('H:i:s', strtotime($employee->schedules->first()->time_in));
                            // if (!($emps >= $data->attendance_time)) {
                            //     $data->status = 0;

                            // }
                            $data->save();
                        }
                    }
                }
            }
        }

        flash()->success('Success', 'You have successfully submited the attendance !');
        return back();
    }
    /*{
        $valueToCheck = $request->input('value'); // Assuming you're checking a value against the database
        $count = Employee::where('pin', $valueToCheck)->count();

        if ($count > 0) {
            return response()->json(['duplicate' => true]);
        } else {
            return response()->json(['duplicate' => false]);
        }
    }*/
    public function store(EmployeeRec $request)
    {
        $request->validated();
        $userid = Auth::id();
        $employee = new Employee;
        $employee->name = $request->name;
        $employee->empid = $request->empid;
        $employee->user_id = $userid;
        $employee->title = $request->title;
        $employee->hourrate = $request->hourrate;
        $employee->pin = $request->pin;
        $employee->notification = $request->notification;
        $employee->Papp = $request->Papp;
        $employee->Psite = $request->Psite;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->mobile = $request->mobile;
        $employee->type = $request->typeemp;
        $employee->fsalary = $request->fixedsalary;
        $employee->starttime = $request->starttime;
        $employee->endtime = $request->endtime;
        $employee->pin_code = bcrypt($request->pin_code);
        $employee->save();
/*
        if($request->schedule){

            $schedule = Schedule::whereSlug($request->schedule)->first();

            $employee->schedules()->attach($schedule);
        }*/

        // $role = Role::whereSlug('emp')->first();

        // $employee->roles()->attach($role);

        flash()->success('Success','Employee Record has been created successfully !');

        return redirect()->route('employees.index')->with('success');
    }

    public function checkDuplicate(Request $request)
    {
        $valueToCheck = $request->input('value'); // Assuming you're checking a value against the database

        $count = Employee::where('pin', $valueToCheck)->count();

        if ($count > 0) {
            return response()->json(['duplicate' => true]);
        } else {
            return response()->json(['duplicate' => false]);
        }
    }


    public function update(EmployeeRec $request, Employee $employee)
    {
        $request->validated();

        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->pin_code = bcrypt($request->pin_code);
        $employee->save();

        if ($request->schedule) {

            $employee->schedules()->detach();

            $schedule = Schedule::whereSlug($request->schedule)->first();

            $employee->schedules()->attach($schedule);
        }

        flash()->success('Success','Employee Record has been Updated successfully !');

        return redirect()->route('employees.index')->with('success');
    }


    public function destroy(Employee $employee)
    {
        $employee->delete();
        flash()->success('Success','Employee Record has been Deleted successfully !');
        return redirect()->route('employees.index')->with('success');
    }
}
