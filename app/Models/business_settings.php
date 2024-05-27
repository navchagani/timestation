<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class business_settings extends Model
{
    use HasFactory;

    protected $table = 'business_settings';

    protected $fillable = [
        'business_id',
        'business_name',
        'address',
        'area',
        'email',
        'phone',
        'attendance_mode',
        'GPS_location_tagging',
        'covid_19_screening',
        'time_rounding',
        'TimeRounding_Display',
        'DateFormat',
        'TimeFormat',
        'HoursFormat',
        'automaticTimeDeduction',
        'automaticTimeDeductionThreshold',
        'DefaultReportDateRange',
        'DefaultReportDateRange_Today',
        'Card_Text_Size',
        'Card_field_1',
        'Card_field_2',
        'Card_field_3',
        'Card_field_4',
    ];
}
