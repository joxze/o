@extends('layouts.app')

@section('title')
Register User
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    {!! Form::model(
                        $model,
                        [
                            'method'=>'post',
                            'class'=>'form-horizontal',
                            'files' => true
                        ]
                    ) !!}
                        <?php if (!empty($model->image)): ?>
                            <?php
                            $host = env('APP_URL_FILES', '');
                            $foto = $host.'/avatars/'.$model->image;
                            ?>
                            <div class="form-group">
                                <div class="col-md-10" style="text-align: center;">
                                    {{Html::image($foto, $alt="Photo", ['width'=>'200', 'height'=>'200', 'class' => 'img-circle']) }}
                                </div>
                            </div>
                        <?php endif; ?>
                        {{ Form::formFile('image', $errors, 'Image') }}
                        {{ Form::formText('id', $errors, 'ID') }}
                        {{ Form::formText('name', $errors, 'Name') }}
                        {{ Form::formText('email', $errors, 'E-mail Address') }}
                        {{ Form::formText('user_name', $errors, 'User Name') }}
                        {{ Form::formSelect('rules_id', $rules, $errors, 'Rule') }}
                        {{ Form::formPassword('password', $errors, 'Password') }}
                        {{ Form::formPassword('password_confirmation', $errors, 'Retype Password') }}


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{{ url('/users/management') }}" class="btn btn-danger">Back</a>
                                <?php $labelSave = empty($model) ? 'Register' : 'Update' ?>
                                {!! Form::submit($labelSave, ['class'=>'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
