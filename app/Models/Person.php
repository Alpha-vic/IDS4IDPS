<?php
namespace App\Models;

use App\Models\Traits\PersonalNames;

class Person extends Model
{
    use PersonalNames;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name',
        'birth_date', 'sex', 'height', 'photo', 'description',
        'code', 'lga_id', 'camp_id', 'email', 'phone'
    ];
    protected $appends = ['state'];

    public function relationships()
    {
        return $this->belongsToMany(Relationship::class, 'relationships', 'subject');
    }

    public function lga()
    {
        return $this->belongsTo(LGA::class);
    }

    public function state()
    {
        return $this->lga->state;
    }

    public function getStateAttribute()
    {
        return $this->state();
    }

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }
}