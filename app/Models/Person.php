<?php

namespace App\Models;

use App\Models\Traits\PersonalNames;
use App\Models\Traits\Photo;
use App\Models\Traits\SoftDeletes;
use Carbon\Carbon;

class Person extends Model
{
    use PersonalNames;
    use Photo;
    use SoftDeletes;

    protected $table    = 'persons';
    protected $fillable = [
        'first_name', 'middle_name', 'last_name',
        'birth_date', 'sex', 'height', 'photo', 'description',
        'code', 'lga_id', 'camp_id', 'email', 'phone', 'status',
        'left_thumb', 'right_thumb'
    ];
    protected $casts    = ['birth_date' => 'date'];
    protected $appends  = ['state', 'age'];

    const STATUS_TMP      = 0;
    const STATUS_ENROLLED = 1;
    const IMAGE_DIR       = 'public'.DS.'idp-photos';

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
        return (is_object($this->lga) ? $this->lga->state : null);
    }

    public function getStateAttribute()
    {
        return $this->state();
    }

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

    public function age()
    {
        $now = Carbon::now(TIMEZONE);

        return (-1 * $now->diffInYears($this->birth_date, false));
    }

    public function getAgeAttribute()
    {
        return $this->age();
    }
}