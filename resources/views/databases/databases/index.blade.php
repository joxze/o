@extends('app')

@section('title', 'Tables Management')

@section('content')
<a href="{{url('databases/create')}}" class="btn btn-primary" title="Create New Fields">Create</a>
<div class="clearfix"></div><br />
<?php
echo app()->make('PGV')->create(
    array(  // Setting
        'id' => 'tbl-Tables',
        'model' => 'modelTables'
    ),
    $model, //  Model
    array( // Columns
        'tables_name',
        array(
            'name' => 'tables_status', 
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
            'value' => array(
                '<a href="/databases/create?id=#tables_id#">Generate</a>',
                '<a href="/fields?id=#tables_id#">Detail</a>',
            ),
            'filter' => false
        )
    )
);
?>
@endsection