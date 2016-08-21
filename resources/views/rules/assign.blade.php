@extends('layouts.app')

@section('title')
Assign Rule - {{ ucwords(strtolower($rules->name)) }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Rules For {{ ucwords(strtolower($rules->name)) }}</div>
                <div class="panel-body">
                    <a href="{{ url('/rules/add-assign-rules/'.$id) }}" class="btn btn-primary">Add Assign For {{ ucwords(strtolower($rules->name)) }}</a>
                    <a href="{{ url('/rules/add-assign/'.$id) }}" class="btn btn-primary">Add Assign Controller</a>
                    <div class="clearfix"></div><br />
                    <table id="data-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Controller</th>
                                <th>Action</th>
                                <th>Name</th>
                                <th>Method</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model as $kModel => $vModel)
                            <tr>
                                <td>{{ $vModel->assign->controller }}</td>
                                <td>{{ $vModel->assign->action }}</td>
                                <td>{{ $vModel->assign->name }}</td>
                                <td>{{ $vModel->assign->method }}</td>
                                <td><a href="{{ url('/rules/assign/delete/'.$vModel->id) }}" >Delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ url('/rules') }}" class="btn btn-danger">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
