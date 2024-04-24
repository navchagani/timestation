<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Assign extends Model
{
    protected $table = 'tasks';
    public function getRouteKeyName()
    {
        return 'name';
    }

}
