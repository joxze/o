<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    protected $table = 'rules';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    public function search($paginate=10, $condition=array(), $with='')
    {
        return app()->make('PGV')->search($paginate, 'App\Http\Models\Rules', '', $condition, $with);
    }

    public function attributesLabel($key='')
    {
        $attributes = array(
            'name' => 'Name',
            'status' => 'Status',
            'id' => 'Rules Id',
        );
        if (!empty($key) && isset($attributes[$key])) {
            return $attributes[$key];
        } else {
            return $attributes;
        }
    }

    public function getStatusAttribute($status)
    {
        return !empty($status) ? 'Active' : 'Non Active';
    }

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function assignRules()
    {
        return $this->hasMany('App\Http\Models\AssignRules');
    }

    public function assign()
    {
        return $this->hasManyThrough('App\Http\Models\Assign', 'App\Http\Models\AssignRules', 'rules_id', 'id');
    }
}
