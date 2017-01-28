<?php
namespace App\Models;
/**
 * Class LGA
 * @package App\Models
 */
class LGA extends Model
{
    protected $fillable = ['name','code', 'state_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function camps()
    {
        return $this->hasMany(Camp::class);
    }

    /**
     * Persons with this LGA as their LGA of origin
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function persons()
    {
        return $this->hasMany(Person::class);
    }
}