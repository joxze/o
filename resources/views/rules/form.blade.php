@extends('layouts.app')

@section('title')
{{ $labelProses }} Rules
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $labelProses }} Rules</div>
                <div class="panel-body">
                    {!! Form::model(
                        $model,
                        [
                            'method'=>'post',
                            'class'=>'form-horizontal',
                        ]
                    ) !!}
                        {{ Form::formText('id', $errors, 'ID') }}
                        {{ Form::formText('name', $errors, 'Name') }}
                        {{ Form::formSelect('status', ['1'=>'Active','0'=>'Non Active'], $errors, 'Status') }}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{{ url('/rules') }}" class="btn btn-danger">Back</a>
                                {!! Form::submit($labelProses, ['class'=>'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
