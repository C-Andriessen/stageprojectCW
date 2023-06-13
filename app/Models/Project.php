<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'projects_users');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'projects_users', 'project_id', 'role_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
