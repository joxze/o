@extends('layouts.app')

@section('title')
Rules
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Rules</div>
                <div class="panel-body">
                    <a href="{{ url('/rules/create') }}" class="btn btn-primary">Add Rules</a>
                    <div class="clearfix"></div><br />
                    <?php
                    echo app()->make('PGV')->create(
                        array(  // Setting
                            'id' => 'tbl-rules',
                            'model' => 'Rules'
                        ),
                        $model, //  Model
                        array( // Columns
                            'name',
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
                                    '<a href="/rules/assign/#id#">Assign</a>',
                                    '<a href="/rules/detail/#id#">Detail</a>',
                                    '<a href="/rules/update/#id#">Edit</a>',
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
