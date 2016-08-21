@extends('layouts.app')

@section('title')
Add Assign - {{ ucwords(strtolower($rules->name)) }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Assign For
                    <strong>{{ ucwords(strtolower($rules->name)) }}</strong>
                </div>
                <div class="panel-body">
                    <a href="{{ url('/assign/add-assign') }}" class="btn btn-primary">Add Assign Controller</a>
                    <div class="clearfix"></div><br />
                    <?php
                    echo app()->make('PGV')->create(
                        [  // Setting
                            'id' => 'tbl-Assign',
                            'model' => 'Assign'
                        ],
                        $model, //  Model
                        [ // Columns
                            [
                                'value' => 'DB::table("assign_rules")
                                    ->where("rules_id", "=", '.$id.')
                                    ->where("assign_id", "=", "#id#")
                                    ->get()
                                        ? "<input type=\'checkbox\' value=\'#id#\' data-rule=\''.$id.'\' class=\'chk-assign\' checked=\'checked\' />"
                                        : "<input type=\'checkbox\' value=\'#id#\' data-rule=\''.$id.'\' class=\'chk-assign\' />"',
                                'type' => 'function',
                                'filter' => false
                            ],
                            'controller',
                            'action',
                            'method',
                            'name',
                        ]
                    );
                    ?>
                    <a href="{{ url('/rules/assign/'.$id) }}" class="btn btn-danger">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).on('change', '.chk-assign', function(){
        var data = '';
        var rules_id = $(this).attr('data-rule');
        var assign_id = $(this).val();
        if($(this).is(':checked')){
            data = {
                rules_id : rules_id,
                assign_id : assign_id,
                type : 1,
            }
        } else {
            data = {
                rules_id : rules_id,
                assign_id : assign_id,
                type : 0,
            }
        }

        if (data) {
            $.ajax({
                data    : data,
                // url     : '/rules/add-assign-rules/',
                dataType: 'JSON',
                type    : 'POST',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="ooo"]').attr('content')
                },
                success: function (result,status,xhr) {
                    if (result && result.status == 200) {
                        // var div = _el.closest('.table-pgv');
                        // div = div.closest('.div-pgv');
                        // console.log(div.html());
                        // div.empty();
                        // div.html(result);
                        // div.find('.pgv-search').each(function(){
                        //     var dataSearch = $(this).attr('data-name');
                        //     if (_search[dataSearch]) {
                        //         $(this).val(_search[dataSearch]);
                        //     }
                        // });
                    } else {
                        alert('Error');
                    }
                }
            });
        }
    });
</script>
@endsection
