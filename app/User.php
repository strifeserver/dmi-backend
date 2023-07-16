<?php

namespace App;

use Carbon\Carbon;
use Crypt;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;
    use SoftDeletes;
    protected $table = 'core_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash', 'username', 'email', 'password', 'first_name', 'last_name', 'mobile_number', 'account_status', 'google2fa_secret', 'password_updated_at', 'otp', 'temporary_password', 'temporary_password_created', 'account_lock_end', 'access_level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function store(array $request): array
    {
        $returns = [];
        $id = optional($request)->get('id', '');
        $fields = $this->fillable;

        $submittedData = collect($request)->only($fields)->toArray();
        $execute = $this::create($submittedData)->id;
        $executeStatus = (is_integer($execute)) ? 1 : 0;
        $returns['status'] = $executeStatus;
        $returns['data_id'] = $execute;

        return $returns;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setGoogle2faSecretAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['google2fa_secret'] = Crypt::encrypt($value);
        }
    }

    public function getGoogle2faSecretAttribute($value)
    {
        try {
            $value = Crypt::decrypt($value);
        } catch (\Throwable $th) {
        }
        return $value;
    }

    public function setPasswordUpdatedAtAttribute($value)
    {
        $this->attributes['password_updated_at'] = Carbon::now();
    }

    public function core_passwords()
    {
        return $this->hasMany('App\core_password');
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = Crypt::encrypt($value);
    }

    public function getFirstNameAttribute($value)
    {
        return Crypt::decrypt($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = Crypt::encrypt($value);
    }

    public function getLastNameAttribute($value)
    {
        return Crypt::decrypt($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = Crypt::encrypt($value);
    }

    public function getEmailAttribute($value)
    {
        return Crypt::decrypt($value);
    }

    public function getcreatedAtAttribute($value)
    {
        if (!empty($value)) {
            return date('Y-m-d h:i:s A', strtotime($value));
        }
    }

    public function getupdatedAtAttribute($value)
    {
        if (!empty($value)) {
            return date('Y-m-d h:i:s A', strtotime($value));
        }
    }

}
