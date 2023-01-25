<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'paragraph_order',
        'start',
        'end',
    ];

    protected $casts = [
        'start' => 'datetime:Y-m-d',
        'end' => 'datetime:Y-m-d',
    ];
    // 'paragraph_order' => 'array'



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    /**
     * Get the role's paragraphs in order as they appear in the paragraph_order column.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function paragraphOrder(): Attribute
    {
        // $getParagraphs = function($e){
        //     foreach(json_decode($e) as $id){
        //         Paragraph::find($id)
        //     }
        // }
        return Attribute::make(
            get: fn ($value) => ($value == '[]') ? [] : Paragraph::whereIn('id',json_decode($value))->orderByRaw("FIELD(id," .
            implode(',', json_decode($value)) .
            ")")->get(),
            set: fn ($value) => dd($value)
        );
    }

}
