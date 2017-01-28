<?php
namespace App\Models;

class Relationship extends Model
{
    protected $fillable = ['name'];

    public function subject()
    {
        return $this->belongsTo(Person::class, 'subject_id');
    }

    public function object()
    {
        return $this->belongsTo(Person::class, 'object_id');
    }
}