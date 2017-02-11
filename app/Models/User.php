<?php
namespace App\Models;

use App\Models\Traits\FindByEmail;
use App\Models\Traits\FindByPhone;
use App\Models\Traits\HasRole;
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
    use FindByPhone;
    use FindByEmail;
    use HasRole;

    const ROLE_ADMIN = 'admin';
    const ROLE_DEO   = 'deo';
    const IMAGE_DIR  = 'public'.DS.'profile-photos';

    protected $fillable = ['first_name', 'last_name', 'middle_name', 'email', 'phone', 'password'];
    protected $hidden   = ['password', 'remember_token', 'photo'];
    protected $appends  = ['name', 'photoUrl', 'thumb', 'url', 'isFollowed'];

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
