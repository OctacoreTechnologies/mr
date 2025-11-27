<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles,HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function quotations(){
        return $this->hasMany(Quotation::class,'user_id');
    }

    public function customers(){
        return $this->hasMany(Customer::class,'customer_id');

    }

    public function leads(){
        return $this->hasMany(Lead::class,'user_id');
    }

    public function leadFollows(){
        return $this->hasMany(Lead::class,'followed_by');
    }

    public function saleOrderFollows(){
        return $this->hasMany(SaleOrder::class,'followed_by');
    }

    public function customerFollows(){
        return $this->hasMany(Customer::class,'followed_by');
    }

    public function quotationFollows(){
        return $this->hasMany(Quotation::class,'followed_by');
    }
}
