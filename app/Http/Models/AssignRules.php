<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class AssignRules extends Model
{
    protected $table = 'assign_rules';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assign_id', 'rules_id'
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
        return app()->make('PGV')->search($paginate, 'App\Http\Models\AssignRules', '', $condition, $with);
    }

    public function attributesLabel($key='')
    {
        $attributes = array(
            'assign_id' => 'Assign',
            'rules_id' => 'Rules',
            'id' => 'Id',
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
    }

    public function assign()
    {
        // return $this->hasOne('App\Http\Models\Assign');
        return $this->belongsTo('App\Http\Models\Assign');
    }
}
