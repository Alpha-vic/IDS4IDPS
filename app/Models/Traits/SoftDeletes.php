<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;

/**
 * Class SoftDeletes
 *
 * @package App\Models\Traits
 */
trait SoftDeletes
{
    use EloquentSoftDeletes;

    /**
     * SoftDeletes constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        /**
         * Set dates property to enable soft-deleting
         */
        $this->dates = ['deleted_at'];
        /**
         * call the constructor of the inheriting class
         */
        parent::__construct($attributes);
    }

}
