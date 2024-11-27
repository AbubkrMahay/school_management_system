<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    public function students() {
        return $this->belongsToMany(Student::class);
    }
    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }
    public function subjects() {
        return $this->belongsToMany(Subject::class);
    }
    protected $fillable = [
        'name',
        'grade',
        'teacher_id',
    ];
}
