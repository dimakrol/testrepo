<?php

namespace App\Models;

use App\Mail\ForgotPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
//use Stripe\Customer;
use Image;
use Laravel\Cashier\Billable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $gender
 * @property string|null $email
 * @property string|null $password
 * @property string|null $facebook_id
 * @property string|null $ip_address
 * @property string|null $date_of_birth
 * @property string|null $stripe_customer_id
 * @property string|null $last_signin
 * @property int $is_admin
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $slug
 * @property string|null $role
 * @property string|null $description
 * @property string|null $thumbnail_url
 * @property string|null $country_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @property-read mixed $thumbnail_path
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VideoGenerated[] $videosGenerated
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastSignin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStripeCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereThumbnailUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, Sluggable, Billable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'first_name'
            ]
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'password','last_name',
        'gender','facebook_id','ip_address','date_of_birth',
        'payment_date','stripe_customer_id','last_signin',
        'description', 'role', 'country_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videosGenerated()
    {
        return $this->hasMany(VideoGenerated::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }


    public function uploadThumbnail($imageFile)
    {
        $imageName = time().str_random(10).'.'.$imageFile->extension();

        $imageContent = Image::make($imageFile->getRealPath())
            ->resize(75, 75)->stream()
            ->__toString();

        $path = 'usersthumbnails'.DIRECTORY_SEPARATOR.$imageName;
        $s3 = Storage::disk('s3');
        $s3->put($path, $imageContent, 'public');

        $this->thumbnail_url = $path;
    }

    public function getThumbnailPathAttribute()
    {
        if ($this->thumbnail_url) {
            return Storage::disk('s3')->url("{$this->thumbnail_url}");
        }
        return '';
    }

    public function getThumbnail()
    {
        return Storage::disk('s3')->url($this->thumbnail_url);
    }

    public function deleteThumbnail()
    {
        return Storage::disk('s3')->delete($this->thumbnail_url);
    }

    /**
     * Determine if the Stripe model has a given subscription.
     *
     * @param  string  $subscription
     * @param  string|null  $plan
     * @return bool
     */
    public function subscribed($subscription = 'default', $plan = null)
    {
        if (is_array($subscription)) {
            foreach ($subscription as $s) {
                if ($subscription = $this->subscription($s)) {
                    break;
                }
            }
        } else {
            $subscription = $this->subscription($subscription);
        }

        if (is_null($subscription)) {
            return false;
        }

        if (is_null($plan)) {
            return $subscription->valid();
        }

//        return $subscription->valid() &&
//            $subscription->stripe_plan === $plan;
    }

    /**
     * Get a subscription instance by name.
     *
     * @param  string  $subscription
     */
    public function subscription($subscription = 'default')
    {
        return $this->subscriptions->sortByDesc(function ($value) {
            return $value->created_at->getTimestamp();
        })
            ->first(function ($value) use ($subscription) {
                return $value->name === $subscription;
            });
    }

    public function fullName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function cancelStripeSubscription(Customer $customer)
    {

    }

    public function sendPasswordResetNotification($token)
    {
        Mail::to($this->email)
            ->send(new ForgotPassword([
                'name' => $this->first_name,
                'frogot_link' => url(config('app.url').route('password.reset', $token, false))
            ]));
        //$this->notify(new ResetPasswordNotification($token));
    }
}
