<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPassword as ResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public function sendPasswordResetNotification($token)
    {
        $url = env('APP_URL').'/' . 'reset-password/' . $token . '?email=' . $this->email;
        $this->notify(new \App\Notifications\Auth\QueuedResetPassword($url));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\Auth\QueuedVerifyEmail);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $keyType = "string";

    protected $primaryKey = 'cpf';

    public $incrementing = false;

    protected $fillable = [
        'nome',
        'sobrenome',
        'cpf',
        'email',
        'telefone',
        'status',
        'password',
        'fk_perfil',
        'fk_unidade',
        'image',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'timestamp',
        'password' => 'hashed',
    ];

    public function perfil()
    {
        return $this->hasOne(Perfil::class, 'id_perfil', 'fk_perfil');
    }

    public function unidade()
    {
        return $this->hasOne(Unidade::class, 'id', 'fk_unidade');
    }


}
