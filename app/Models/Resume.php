<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'start',
        'end'
    ];

    protected $casts = [
        'start' => 'date',
        'end' => 'date'
    ];

    /**
     * Get the user for the resume.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get the employer for the resume.
     */
    public function employers()
    {
        return $this->belongsToMany(Employer::class);
    }
}
