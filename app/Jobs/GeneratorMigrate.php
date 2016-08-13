<?php

namespace App\Jobs;

/**
* @author Josep
* Create Migrate File using pirates generator
*/
class GeneratorMigrate
{
	/**
     * Create Migration
     * @param int $tableId
     */
    public function createMigration($tableId='')
    {
        if (!empty($tableId) && is_integer($tableId)) {
            $modelTables    = \App\Http\Models\Tables::find($tableId);
            $modelFields    = \App\Http\Models\Fields::where('tables_id', $tableId)->get();
            if ($modelTables && $modelFields && empty($modelTables->tables_status)) {
                $migrationCode  = date('Y_m_d')."_".str_pad(6, 6, '0', STR_PAD_LEFT);
                $tableName      = camel_case($modelTables->tables_name);
                $fileName       = $migrationCode."_".$tableName.".php";
                $pathTemplate   = public_path('O/template/migration_template.txt');
                $pathDest       = database_path('migrations/'.$fileName);
                $template       = app()->make('Helpers')->readFile($pathTemplate);

                $valTemplate['date'] = Carbon::now()->toDayDateTimeString();
                $valTemplate['desc'] = "";
                $valTemplate['name'] = $tableName;
                $valTemplate['up']   = $this->createMigrationAdd(
                                            $modelFields,
                                            $modelTables->tables_name
                                        );
                $valTemplate['down'] = $this->createMigtionDelete($modelTables->tables_name);
                $template = app()->make('Helpers')->fillTemplate($template, $valTemplate);
                $template = "<?php\n$template";
                $write = app()->make('Helpers')->writeFile($pathDest, $template);

                return $write;
            }
        }
    }

    /**
     * Create Fill of Up function on migration class
     * @param obj $modelFields Fields will up on table _fields
     * @param string tableName Table Will Create
     * @return string up function for migration class
     */
    public function createMigrationAdd($modelFields='', $tableName='')
    {
        $create = array();
        foreach ($modelFields as $kFields => $vFields) {
            if ($vFields->fields_status === 0) {
                $valCreate = '"'.$vFields->fields_name.'"';
                if (!empty($vFields->fields_length)) {
                    $valCreate .= ', '.$vFields->fields_length;
                }
                $create[] = '$table->'.$vFields->fields_data_type.'('.$valCreate.');';
            }
        }
        $create = array_filter($create);
        if (!empty($create) && is_array($create)) {
            $create[] = '$table->integer("created_by");';
            $create[] = '$table->integer("updated_by");';
            $create[] = '$table->dateTime("deleted_at");';
            $create[] = '$table->timestamps();';
            $create = app()->make("Helpers")->addSpace($create, 4);
            $create = array_collapse(
                array(
                    array('Schema::create("'.$tableName.'", function (Blueprint $table) {'),
                    $create,
                    array('});')
                )
            );
            $create = app()->make("Helpers")->addSpace($create, 8);
            return implode("\n", $create);
        }
    }

    /**
     * Create Fill of Down function on migration class
     * @param string tableName Table Will Create
     * @return string Down fucntion for migration class
     */
    public function createMigtionDelete($tableName='')
    {
        $strDrop = "Schema::drop('$tableName');";
        $drop = app()->make("Helpers")->addSpace($strDrop, 8);
        return implode("\n", $drop);
    }
}
