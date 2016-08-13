<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
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

    public function search($paginate=10, $condition=array())
    {
        return app()->make('PGV')->search($paginate, '', 'rules', $condition);
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

    public function getStatus($status='')
    {
        return $status == '1' ? 'Active' : 'Not Active';
    }

    public function rules()
    {
        return $this->hasMany('App\User');
    }
}
