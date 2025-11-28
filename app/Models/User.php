<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
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
    public function items() {
        return $this->hasMany(Item::class);
    }

    public function bids() {
        return $this->hasMany(Bid::class);
    }
    public function sentMessages() {
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function receivedMessages() {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    public function comments() { return $this->hasMany(Comment::class); }
public function topups() { return $this->hasMany(Topup::class); }
}
