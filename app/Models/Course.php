<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'description', 'duration'];

    public function students()
    {
        return $this->belongsToMany(User::class);
    }




//    public function teacher()
//    {
//        return $this->belongsTo(Teacher::class);
//    }

}
