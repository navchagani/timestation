<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'start_time',
        'finish_time',
        'comments',
        'users_id',
        'employees_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
