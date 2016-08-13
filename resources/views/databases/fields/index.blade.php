@extends('app')

@section('title', 'Tables Detail')

@section('content')
<a href="{{url('fields/create')}}" class="btn btn-primary" title="Create Field">Create</a>
<div class="clearfix"></div><br />
<?php
echo app()->make('PGV')->create(
    array(  // Setting
        'id' => 'tbl-fields',
        'model' => 'Fields'
    ),
    $modelFields, //  Model
    array( // Columns
        'fields_name',
        'fields_data_type',
        array(
            'name' => 'fields_status', 
            'title' => 'Status', 
            'filter' => array(
                'type' => 'dropdownlist', 
                'data' => array(
                    ''  => '-- Select --',
                    '0' => 'Notyet Create',
                    '1' => 'Created',
                    '2' => 'Deleted',
                )
            ),
            'type'  => 'alias',
            'value' => array(
                '0' => 'Notyet Create',
                '1' => 'Created',
                '2' => 'Deleted',
            )
        ),
        array(
            'value' => 'app()->make("Fields")->printButtonDetail($data);',
            'filter' => false,
            'type' => 'function',
        ),
    )
);
?>
<a href="{{url('databases')}}" class="btn btn-danger" title="Back">Back</a>
@endsection