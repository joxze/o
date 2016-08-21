<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $rulesAdmin = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_name', 'email', 'password', 'rules_id', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function search($paginate=10, $condition=array())
    {
        // return app()->make('PGV')->search($paginate, '', 'users', $condition);
        return app()->make('PGV')->search($paginate, '\App\User', '', $condition);
    }

    public function attributesLabel($key='')
    {
        $attributes = array(
            'name' => 'Name',
            'user_name' => 'User Name',
            'email' => 'Email',
        );
        if (!empty($key) && isset($attributes[$key])) {
            return $attributes[$key];
        } else {
            return $attributes;
        }
    }

    public function rules()
    {
        return $this->belongsTo('App\Http\Models\Rules');
        // return $this->hasMany('App\Models\Rules');
    }

    public function getStatusAttribute($status)
    {
        return !empty($status) ? 'Active' : 'Non Active';
    }
}
