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
                        {{ Form::formText('name', $errors, 'Name') }}
                        {{ Form::formFile('image', $errors, 'Image') }}
                        {{ Form::formText('email', $errors, 'E-mail Address') }}
                        {{ Form::formText('user_name', $errors, 'User Name') }}
                        {{ Form::formSelect('rules_id', $rules, $errors, 'Rule') }}
                        {{ Form::formPassword('password', $errors, 'Password') }}
                        {{ Form::formPassword('password_confirmation', $errors, 'Retype Password') }}



                       <!--  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                           {{ Form::label('email', 'E-Mail Address', ['class' => 'col-md-4 control-label']) }}

                           <div class="col-md-6">
                               <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                               @if ($errors->has('email'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('email') }}</strong>
                                   </span>
                               @endif
                           </div>
                       </div> -->

                        <!-- <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                            {{ Form::label('user_name', 'User Name', ['class' => 'col-md-4 control-label']) }}

                            <div class="col-md-6">
                                <input id="user_name" type="text" class="form-control" name="user_name" value="{{ old('user_name') }}">

                                @if ($errors->has('user_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('rules_id') ? ' has-error' : '' }}">
                            {{ Form::label('rules_id', 'Rules', ['class' => 'col-md-4 control-label']) }}

                            <div class="col-md-6">
                                {!! Form::select('rules_id', $rules, null, ['class'=>'form-control']) !!}

                                @if ($errors->has('rules_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rules_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {{ Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) }}

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            {{ Form::label('password-confirm', 'Confirm Password', ['class' => 'col-md-4 control-label']) }}

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{{ url('/users/management') }}" class="btn btn-danger">Back</a>
                                {!! Form::submit('Register', ['class'=>'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
