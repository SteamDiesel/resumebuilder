<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
    use HasFactory;

    protected $fillable = [
        'body'
    ];

    /**
     * Get the user that owns the paragraph.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
