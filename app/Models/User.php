<?php
namespace App;

use App\Models\Traits\ModelHelpers;
use App\Models\Traits\PersonalNames;
use App\Models\Traits\Photo;
use App\Models\Traits\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as Base;
use Illuminate\Notifications\Notifiable;

class User extends Base implements Authenticatable
{
    use ModelHelpers;
    use Notifiable;
    use SoftDeletes;
    use Photo;
    use PersonalNames;

    const ROLE_ADMIN    = 'admin';
    const ROLE_ACADEMIA = 'de-officer';
    const IMAGE_DIR     = 'public'.DS.'profile-photos';

    protected $fillable = ['first_name', 'last_name', 'middle_name', 'email', 'phone', 'password'];
    protected $hidden   = ['password', 'remember_token', 'photo'];
    protected $appends  = ['name', 'photoUrl', 'thumb', 'url', 'isFollowed'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * @param Role $role
     *
     * @return mixed
     */
    public function hasRole(Role $role)
    {
        return $this->roles->contains($role);
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        $role = Role::where('name', self::ROLE_ADMIN)->first();

        return $this->hasRole($role);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function abilities()
    {
        $abilities = collect();
        foreach ($this->roles as $role)
        {
            $abs = Role::all()->find($role->id)->abilities;
            foreach ($abs as $ab)
            {
                if (!$abilities->contains($ab->key))
                {
                    $abilities->put($ab->key, $ab);
                }
            }
        }

        return $abilities;
    }

    /**
     * @return bool
     */
    public function hasAllAbilities()
    {
        $user_abilities = $this->abilities();
        foreach ($user_abilities as $u_a)
        {
            if ($u_a->key === '*')
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $ability
     *
     * @return bool
     */
    public function hasAbility($ability)
    {
        foreach ($this->abilities() as $u_a)
        {
            if ($u_a->key === '*' || strcasecmp($u_a->key, $ability) === 0)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public static function findByEmail($email)
    {
        return self::findByColumn('email', $email)->first();
    }

    /**
     * @param $phone
     *
     * @return mixed
     */
    public static function findByPhone($phone)
    {
        return self::findByColumn('phone', $phone)->first();
    }

    /**
     * @return bool|null
     */
    public function forceDelete()
    {
        //Unlink photo
        $this->deletePhoto();
        //Unlink thumbnail
        $this->deleteThumbnail();

        return parent::forceDelete();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
