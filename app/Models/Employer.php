<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Get the employer for the resume.
     */
    public function resumes()
    {
        return $this->belongsToMany(Resume::class);
    }

    /**
     * Get the user for the employer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the roles or positions for the employer.
     */
    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
