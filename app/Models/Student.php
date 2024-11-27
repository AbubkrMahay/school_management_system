<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function lectures()
    {
        return $this->belongsToMany(Lecture::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'student_user');
    }
    protected $fillable = [
        'name',
        'email',
        'date_of_birth',
        'grade',
    ];
}
