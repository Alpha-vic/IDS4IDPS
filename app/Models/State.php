<?php
namespace App\Models;
/**
 * Class State
 * @package App\Models
 */
class State extends Model
{
    protected $fillable = ['code', 'name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lgas()
    {
        return $this->hasMany(LGA::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function camps()
    {
        return $this->hasManyThrough(Camp::class, LGA::class);
    }

    /**
     * Persons with this state as their state of origin
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function persons()
    {
        return $this->hasManyThrough(Person::class, LGA::class);
    }
}