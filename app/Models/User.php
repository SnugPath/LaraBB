<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'username_clean',
        'ip',
        'email_verified_at',
        'password_changed_at',
        'type',
        'rank_id',
        'birthday',
        'last_visit',
        'lang',
        'time_zone',
        'dst',
        'dateformat',
        'avatar',
        'signature_original',
        'signature_converted',
        'show_images',
        'show_signature',
        'show_avatars',
        'word_censoring',
        'attach_signature',
        'allow_bbcode',
        'allow_notifications',
        'allow_view_mail',
        'allow_mass_email',
        'allow_pm',
        'remmember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_changed_at' => 'datetime',
        'last_visit' => 'datetime',
        'birthday' => 'date'
    ];

    public function custom_fields_data() {
        return $this->hasMany(CustomFieldData::class, 'user_id');
    }

    public function rank() {
        return $this->belongsTo(Rank::class, 'rank_id');
    }

    public function forum_subscriptions() {
        return $this->belongsToMany(Forum::class, 'forums_subscriptions', 'user_id', 'forum_id');
    }

    public function bans() {
        return $this->hasMany(BanList::class, 'user_id');
    }

    public function notifications() {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function topic_subscriptions() {
        return $this->belongsToMany(Topic::class, 'topics_subscriptions', 'user_id', 'topic_id');
    }

    public function warnings() {
        return $this->hasMany(Warning::class, 'user_id');
    }

    public function given_warnings() {
        return $this->hasMany(Warning::class, 'warned_by');
    }

    public function sessions() {
        return $this->hasMany(Session::class, 'user_id');
    }

    public function private_messages() {
        return $this->hasMany(PrivateMessage::class, 'to');
    }

    public function private_messages_sent() {
        return $this->hasMany(PrivateMessage::class, 'author_id');
    }
}
