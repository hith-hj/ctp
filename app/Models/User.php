<?php

namespace App\Models;

use App\Mail\verificationCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Billable;
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 0;

    public $translatedAttributes = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'avatar',
        'status',
        'post_code',
        'address',
        'code',
        'firebase_token',
        'email_verified_at',
        'mobile_verified_at',
        'reset_token',
        'reset_verified',
        'app_notification_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public $visibleAttributes = [
        'first_name' => 'text',
        'last_name' => 'text',
        'email' => 'text',
        'phone_number' => 'text',
        'status' => 'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'token',
        'status',
        'created_at',
        'updated_at',
        'code',
        'email_verified_at',
    ];

    public $mediaAttributes = [
        'avatar' => 'image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function shippingDetails(): HasOne
    {
        return $this->hasOne(ShippingDetails::class);
    }

    public function wishList(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'favorites')->withPivot('product_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function generateActivationCode(): User
    {
        $mobile = $this->phone_number;
        $token = rand(100000, 999999);
        $message = __('api.your_activation_code_is').' '.$token;

        $codeSentError = sendSms($mobile, $message);

        if (false) {
            return $codeSentError;
        }

        $this->code = $token;
        $this->status = 0;
        $this->mobile_verified_at = null;

        return $this;
    }

    public function sendEmailVerificationCode()
    {
        $code = rand(100000, 999999);
        Mail::to($this->email)->send(new verificationCode($code));
        $this->code = $code;

        return $this;
    }

    public function checkEmailVerificationCode()
    {
        $this->code = null;
        $this->status = 1;
        $this->email_verified_at = now();

        return $this;
    }

    public function setFirebaseToken($token): User
    {
        $this->firebase_token = $token;

        return $this;
    }

    public function userNotifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function activateUserAccount(): User
    {
        $this->update([
            'code' => null,
            'status' => 1,
            'mobile_verified_at' => Carbon::now(),
        ]);

        return $this;
    }

    public function activateUser(): User
    {
        $this->update([
            'code' => null,
            'status' => 1,
            'mobile_verified_at' => Carbon::now(),
        ]);

        return $this;
    }

    public function generatePasswordToken()
    {
        $mobile = $this->phone_number;
        $token = rand(100000, 999999);
        $message = __('api.your_reset_code_is').' '.$token;

        $codeSentError = sendSms($mobile, $message);

        if (! $codeSentError) {
            return $codeSentError;
        }

        $this->reset_token = $token;
        $this->reset_verified = 'no';

        return $this;
    }

    public function checkPasswordCode($token): bool
    {
        return $this->reset_token == $token;
    }

    public function changePassword($password): bool
    {
        if ($this->reset_verified == 'yes') {
            $this->update([
                'password' => $password,
                'reset_token' => null,
                'reset_verified' => 'no',
            ]);

            return true;
        }

        return false;
    }

    public function isActive(): bool
    {
        // return $this->status && $this->mobile_verified_at;
        return $this->status && $this->email_verified_at;
    }
}
