<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label($name, $label, ['class' => 'col-md-4 control-label']) }}
    <div class="col-md-6">
        <?php
        $attributes = !empty($attributes) && is_array($attributes)
            ? array_merge(['class' => 'form-control'], $attributes)
            : ['class' => 'form-control'];
        echo Form::password($name, $attributes);
        ?>

        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>
