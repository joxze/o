<?php

namespace App\Jobs;

/**
* @author Josep
* Create Migrate File using pirates generator
*/
class GeneratorModel
{
	/**
     * Create Migration
     * @param int $tableId
     */
	public function createModel($tableId='')
    {
        if (!empty($tableId) && is_integer($tableId)) {
            $modelTables    = \App\Http\Models\Tables::find($tableId);
                $modelFields    = \App\Http\Models\Fields::where('tables_id', $tableId)->get();
            if ($modelTables && $modelFields && empty($modelTables->tables_status)) {
                $tableName      = camel_case($modelTables->tables_name);
                $fileName       = $tableName.".php";
                $pathTemplate   = public_path('O/template/model_template.txt');
                $pathDest       = app_path('Http/Models/'.$fileName);
                $template       = app()->make('Helpers')->readFile($pathTemplate);

                $valTemplate['date']        = Carbon::now()->toDayDateTimeString();
                $valTemplate['desc']        = "Model Of table $modelTables->tables_name";
                $valTemplate['name']        = $tableName;
                $valTemplate['table_name']  = $modelTables->tables_name;
                $valTemplate['table_pk']    = $this->getPK($modelFields);
                $valTemplate['label']       = $this->createLabelModel($modelFields);

                foreach ($valTemplate as $kTemplate => $vTemplate) {
                    $template = str_replace("#$kTemplate#", $vTemplate, $template);
                }
                $template = "<?php\n$template";
                $write = app()->make('Helpers')->writeFile($pathDest, $template);

                if ($write) {
                    $cekModel = DB::table('service_container')->where('path', "\App\Http\Models\\".$tableName)->get();
                    if (empty($cekModel)) {
                        DB::table('service_container')->insert(
                            [
                                'name' => $tableName,
                                'path' => "\App\Http\Models\\".$tableName,
                                'type' => 'model',
                                'created_at' => date('Y-m-d H:i:s')
                            ]
                        );
                    }
                }

                return $write;
            }
        }
    }

    /**
     * Get PK Frol field tables
     * @param   obj     $modelFields
     * @return  string  pk field name
     */
    public function getPK($modelFields='')
    {
        if (!empty($modelFields)) {
            foreach ($modelFields as $kFields => $vFields) {
                if ($vFields->fields_data_type == 'increments') {
                    return $vFields->fields_name;
                }
            }
        }
    }

    /**
     * Create Array AttributesLabel for model template
     * @param   obj     $modelFields
     * @return  string  Array AttributesLabel for model template
     */
    public function createLabelModel($modelFields='')
    {
        if (!empty($modelFields)) {
            $label = array();
            foreach ($modelFields as $kFields => $vFields) {
                $fieldsName = $vFields->fields_name;
                $labelName  = app()->make('Helpers')->createTitle($fieldsName);
                $label[]    = "'".$fieldsName."' => '".$labelName."'";
            }
            $label = app()->make("Helpers")->addSpace($label, 4);
            $label = implode(", \n", $label);
            $label = $label."\n);";
            $label = app()->make("Helpers")->addSpace($label, 8);
            $label = "array(\n".$label;
            return implode("\n", $label);
        }
    }
}
