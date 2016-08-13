@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <a href="{{ url('/users/register') }}" class="btn btn-primary">Register new user</a>
                    <div class="clearfix"></div><br />
                    <?php
                    echo app()->make('PGV')->create(
                        array(  // Setting
                            'id' => 'tbl-users',
                            'model' => 'User'
                        ),
                        $model, //  Model
                        array( // Columns
                            'name',
                            'email',
                            'user_name',
                            array(
                                'name' => 'status',
                                'title' => 'Status',
                                'filter' => array(
                                    'type' => 'dropdownlist',
                                    'data' => array(
                                        ''  => '-- Select --',
                                        '0' => 'Not Active',
                                        '1' => 'Active'
                                    )
                                ),
                            ),
                            array(
                                'value' => array(
                                    '<a href="/users/detail/#id#">Detail</a>',
                                    '<a href="/users/edit/#id#">Edit</a>',
                                ),
                                'filter' => false
                            )
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
