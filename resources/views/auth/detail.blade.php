@extends('layouts.app')
@section('title')
Detail User
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Detail</div>
                <div class="panel-body">
                    <div class="form-horizontal">
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
                        {{ Form::formSpan('Name', $model->name) }}
                        {{ Form::formSpan('E-mail Address', $model->email) }}
                        {{ Form::formSpan('User Name', $model->user_name) }}
                        {{ Form::formSpan('Rule', $model->rules->name) }}
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{{ url('/users/management') }}" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
