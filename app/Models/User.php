<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone_no',
        'date_of_birth',
        'email',
        'password',
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

    //dateFilter
    public function scopeDateFilter( $query, $from_date=null, $to_date=null ){
        if( !empty( $from_date ) ){
            $from_date = date( "Y-m-d 00:00:01", strtotime( $from_date ) );
            $to_date = ( !empty( $to_date ) )? date( "Y-m-d 23:59:59", strtotime( $to_date ) ) : date( "Y-m-d 23:59:59" );

            $query->whereBetween( 'date_of_birth', [ $from_date, $to_date ] );
        }
        return $query;
    }
}
