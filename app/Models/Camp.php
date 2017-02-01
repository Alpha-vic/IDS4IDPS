<?php
namespace App\Models;
use App\Models\Traits\FindByCode;
use App\Models\Traits\SoftDeletes;

class Camp extends Model
{
    use FindByCode;
    use SoftDeletes;

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