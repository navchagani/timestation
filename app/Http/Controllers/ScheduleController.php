<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Schedule;
use App\Http\Requests\ScheduleEmp;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
class ScheduleController extends Controller
{

    public function index()
    {
        $events = [];
        $data = Schedule::all();
        if ($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = \Calendar::event(
                    $value->slug ."\n". $value->time_in ."\n". $value->time_out . "\n", // or use "<br>"
                    true,
                    new \DateTime($value->time_in),
                    new \DateTime($value->time_out.'+1 day'),
                    null,
                    // Add color
                    [
                        'color'=> $value->color,
                        'textColor' => $value->textColor,
                    ]
                );
            }
        }

        $calendar = \Calendar::addEvents($events);

        // Display success flash message
        flash()->success('Success', 'Schedule has been created successfully !');

        return view('admin.schedule', compact('events', 'calendar'))
            ->with('schedules', Schedule::all())
            ->with('employees', Employee::all());
    }


    public function store(ScheduleEmp $request)
    {
        $request->validated();

        $schedule = new schedule;
        $schedule->slug = $request->name;
        $schedule->time_in = $request->time_in;
        $schedule->time_out = $request->time_out;
        $schedule->color = $request->color;
        $schedule->save();




        flash()->success('Success','Schedule has been created successfully !');
        return redirect()->route('schedule.index');

    }

    public function update(ScheduleEmp $request, Schedule $schedule)
    {
        $request['time_in'] = str_split($request->time_in, 5)[0];
        $request['time_out'] = str_split($request->time_out, 5)[0];

        $request->validated();

        $schedule->slug = $request->slug;
        $schedule->time_in = $request->time_in;
        $schedule->time_out = $request->time_out;
        $schedule->save();
        flash()->success('Success','Schedule has been Updated successfully !');
        return redirect()->route('schedule.index');


    }


    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        flash()->success('Success','Schedule has been deleted successfully !');
        return redirect()->route('schedule.index');
    }
}
