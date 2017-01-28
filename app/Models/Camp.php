<?php
namespace App\Models;
class Camp extends Model
{
    protected $fillable = ['name', 'address', 'longitude', 'latitude', 'code', 'lga_id'];
    protected $appends  = ['state'];

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

    public function persons()
    {
        return $this->hasMany(Person::class);
    }
}