<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_teacher');
    }
    protected $fillable = [
        'name',
        'email',
    ];
}
