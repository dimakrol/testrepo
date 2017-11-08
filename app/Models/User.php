<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;
use Stripe\Customer;
use Image;

class User extends Authenticatable
{
    use Notifiable, Sluggable;

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
        'description', 'role'
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
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }


    public function uploadThumbnail($imageFile)
    {
        $imageName = time().str_random(10).'.'.$imageFile->extension();

        $imageContent = Image::make($imageFile->getRealPath())
            ->resize(75, 75, function ($constraint) {
                $constraint->aspectRatio();
            })->stream()
            ->__toString();

        $path = 'usersthumbnails'.DIRECTORY_SEPARATOR.$imageName;
        $s3 = Storage::disk('s3');
        $s3->put($path, $imageContent, 'public');

        $this->thumbnail_url = $path;
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
        $subscription = $this->subscription($subscription);

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
}
