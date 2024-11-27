<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function givePermissionTo($permission)
    {
        return $this->permissions()->attach($permission);
    }

    public function revokePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }
    protected $fillable = [
        'name',
    ];
    use HasFactory;
}
