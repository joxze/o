@extends('app')

@section('title', 'Create Tables')

@section('content')
<form method="POST">
{{ csrf_field() }}
<div class="col-lg-12 row">
    <h1>Create Table</h1>
        <div class="col-lg-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-lg-3">
                <label for="table-name">Table Name</label>
            </div>
            <div class="col-lg-5">
                <input
                    type="text"
                    name="tables_name"
                    value="{{ old('tables_name') }}"
                    placeholder="Table Name"
                    id="table-name"
                    class="form-control">
            </div>
        </div>
        <div class="clearfix"></div><br />
        <hr />
        <h3>List of Field</h3>
        <?php
        $templateMultipleRow = '
        <div class="col-lg-12">
            <div class="col-lg-3">
                <label for="add-fields-#count#">'.app()->make('Fields')->attributesLabel('fields_name').'</label>
                <input type="text" name="fields_name[]" class="form-control" id="add-fields-#count#" value="#fields_name#" />
            </div>
            <div class="col-lg-3">
                <label for="add-fields-#count#">'.app()->make('Fields')->attributesLabel('fields_data_type').'</label>
                <input type="text" name="fields_data_type[]" class="form-control" id="add-fields-#count#" value="#fields_data_type#" />
            </div>
            <div class="col-lg-2">
                <label for="add-fields-#count#">'.app()->make('Fields')->attributesLabel('fields_length').'</label>
                <input type="text" name="fields_length[]" class="form-control" id="add-fields-#count#" value="#fields_length#" />
            </div>
            <div class="col-lg-2">
                <label for="add-fields-#count#">'.app()->make('Fields')->attributesLabel('default_value').'</label>
                <input type="text" name="default_value[]" class="form-control" id="add-fields-#count#" value="#default_value#" />
            </div>
            <div class="col-lg-2"><br />#buttonForm#</div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>';
        echo app()->make('FormMultipleRow')->create($templateMultipleRow, $model);
        ?>
</div>
<div class="clearfix"></div><br />
<a href="{{url('databases')}}" class="btn btn-danger" title="Back To Tables">Back</a>
<input type="submit" class="btn btn-primary" value="Save">
</form>
@endsection
