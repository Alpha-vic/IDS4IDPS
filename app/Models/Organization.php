<?php
namespace App\Models;

use App\Models\Traits\FindByEmail;
use App\Models\Traits\FindByPhone;
use App\Models\Traits\SoftDeletes;

class Organization extends Model
{
    use FindByEmail;
    use FindByPhone;
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'address', 'photo', 'website'];
}