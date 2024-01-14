<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'nid',
        'phone',
        'dob',
        'avater',
        'gender',
        'religion',
        'nationality',
        'bloodgroup',
        'present_address',
        'permanent_address',
        'shop_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'received_by');
    }
    public function cashDeposites()
    {
        return $this->hasMany(CashDeposite::class, 'created_by');
    }
    public function cashReceived()
    {
        return $this->hasMany(CashDeposite::class, 'received_by');
    }

    // Get sum of total payment collection of user {{ user()->sell  }}
    public function getSellAttribute()
    {
        return $this->payments()->sum('amount');
    }

    // Get sum of succesfully deposited amount of user {{ user()->deposites  }}
    public function getDepositeAttribute()
    {
        return $this->cashDeposites()->where('status', 1)->sum('amount');
    }

    // Get total collection - successfully deposites {{ user()->cash  }}
    public function getCashAttribute()
    {
        return ($this->getSellAttribute() - $this->getDepositeAttribute());
    }

    // Get sum of succesfully received amount from other user {{ user()->received  }}
    public function getReceivedAttribute()
    {
        return $this->cashReceived()->where('status', 1)->sum('amount');
    }

    // Get total collection - successfully deposites + received amount {{ user()->cashinhand  }}
    public function getCashinhandAttribute()
    {
        return $this->getCashAttribute() + $this->getReceivedAttribute();
    }
}
