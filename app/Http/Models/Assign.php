<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    protected $table = 'assign';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'controller', 'action', 'name', 'method'
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
        return app()->make('PGV')->search($paginate, 'App\Http\Models\Assign', '', $condition, $with);
    }

    public function attributesLabel($key='')
    {
        $attributes = array(
            'controller' => 'Controller',
            'action' => 'Action',
            'name' => 'Name',
            'method' => 'Method',
        );
        if (!empty($key) && isset($attributes[$key])) {
            return $attributes[$key];
        } else {
            return $attributes;
        }
    }

    public function assignRules()
    {
        return $this->hasMany('App\Http\Models\AssignRules');
    }
}
