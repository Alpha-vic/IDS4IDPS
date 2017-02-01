<?php
namespace App\Models\Traits;
trait PersonalNames
{
    /**
     * @param $first_name
     *
     * @return string
     */
    public function getFirstNameAttribute($first_name)
    {
        return ucwords(strtolower($first_name));
    }

    /**
     * @param $str
     */
    public function setFirstNameAttribute($str)
    {
        $this->attributes['first_name'] = trim($str);
    }

    /**
     * @param $last_name
     *
     * @return string
     */
    public function getLastNameAttribute($last_name)
    {
        return ucwords(strtolower($last_name));
    }

    /**
     * @param $str
     */
    public function setLastNameAttribute($str)
    {
        $this->attributes['last_name'] = trim($str);
    }

    /**
     * @param $middle_name
     *
     * @return string
     */
    public function getMiddleNameAttribute($middle_name)
    {
        return ucwords(strtolower($middle_name));
    }

    /**
     * @param $str
     */
    public function setMiddleNameAttribute($str)
    {
        $this->attributes['middle_name'] = trim($str);
    }

    public function name($with_middle_name = true)
    {
        $name = $this->first_name;
        if (!empty($this->middle_name) and $with_middle_name) {
            $name .= " {$this->middle_name}";
        }
        $name .= " {$this->last_name}";

        return $name;
    }
}