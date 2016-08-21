<?php

namespace App\Jobs;

/**
* @author Josep
* Tools to create Gridview
*/

use DB;

class PiratesGridView
{
    /**
     * Create search for PGV
     * @param int       $paginate
     * @param string    $modelName path model
     * @param string    $tableName
     * @param array     $condition
     * [
     *   [
     *      'key'       =>
     *      'operator'  =>
     *      'value'     =>
     *   ],
     * ]
     * @param string    $with   for relation query only for model
     */
    public function search($paginate=10, $modelName='', $tableName='', $condition=array(), $with='')
    {
        if (!empty($paginate) && ( !empty($modelName) || !empty($tableName))) {
            $search = app()->make('Helpers')->getPost('search');
            $column = app()->make('Helpers')->getPost('column');

            if (!empty($tableName) && is_string($tableName)) { //Use Query Builder
                $model = DB::table($tableName);
            } elseif(!empty($modelName) && is_string($modelName)) { //Use ORM
                $model = $modelName::query();
                if (!empty($with)) {
                    $model->with($with);
                }
            }
            if (!empty($condition) && is_array($condition)) {
                foreach ($condition as $kCondition => $vCondition) {
                    // dd($vCondition);
                    if (!empty($vCondition['key']) && isset($vCondition['value'])) {
                        if (empty($vCondition['operator'])) {
                            $vCondition['operator'] = '=';
                        }
                        $model->where(
                            $vCondition['key'],
                            $vCondition['operator'],
                            $vCondition['value']);
                    }
                }
            }

            if ($column) {
                // $model = DB::table($this->table);
                if (is_array($search)) {
                    $search = array_filter($search, function($v, $k) {
                        return $v != '';
                    }, ARRAY_FILTER_USE_BOTH);
                    if (!empty($search)) {
                        foreach ($search as $kSearch => $vSearch) {
                            $operator = "=";
                            if (str_contains($vSearch, "%")) {
                                $operator = "like";
                            }
                            $model->where($kSearch, $operator, $vSearch);
                        }
                    }
                }
                $model      = $model->paginate($paginate);
                $setting    = app()->make('Helpers')->decodeJson64($_POST['setting']);
                $column     = app()->make('Helpers')->decodeJson64($_POST['column']);
                $html       = app()->make('PGV')->create($setting, $model, $column, true);
                echo $html; exit;
            } else {
                $model = $model->paginate($paginate);
                return $model;
            }
        }
    }

    /**
     * Create
     * @param array $model data will be source for gridview
     * @param array $column list column for gridview
     * [
     *   string ==> field_name
     *   array (
     *     name  =>
     *     title =>
     *     value =>
     *     default =>
     *     filter =>
     *        false == no filter,
     *        true == defaul filter, use textbox
     *        [
     *
     *        ]
     *     type => [datetime, date, currency, upper, lower, ucfirst, ucword, raw, html ]
     *   )
     * ]
     * @param array $setting setting table
     * [
     *    model => string model name use for table
     *    id    => string id for table
     *    class => mix class for table
     * ]
     * @param bool $isPartial
     * @return string html gridview
     */
    public function create($setting=array(), $model='', $columns=array(), $isPartial=false)
    {
        if (!empty($model) && is_object($model)) {
            $head       = $this->createHead($columns, $setting);
            $body       = $this->createBody($model, $columns);
            $idTable    = !empty($setting['id']) ? $setting['id'] : '';
            $classTable = $this->createClassTable($setting);
            $pagination = $model->render();
            $tokenCol   = base64_encode(json_encode($columns));
            $tokenSet   = base64_encode(json_encode($setting));
            $divPGV     = empty($isPartial) ? "<div class='div-pgv'>" : "";
            $divEndPGV  = empty($isPartial) ? "</div>" : "";
            $html = "$divPGV<div class='table-responsive table-pgv'>
                <input type='hidden' class='pgv-col' value='$tokenCol' />
                <input type='hidden' class='pgv-set' value='$tokenSet' />
                <table class='$classTable' id='$idTable'>$head$body</table>
                <div class='table-pagination'>
                    $pagination
                </div>$divEndPGV
            </div>";
            return $html;
        }
    }

    /**
     * Create Thead for gridview
     */
    private function createHead($columns=array(), $setting=array())
    {
        if (!empty($columns)
            && is_array($columns)) {
            $head = $this->createTableHead($columns, $setting);
            return "<thead>$head</thead>";
        }
    }

    /**
     * Genetate Thead for table
     * @param array $column list column for gridview
     * [
     *   string ==> field_name
     *   array (
     *     name  =>
     *     title =>
     *     value =>
     *     default =>
     *     filter => false
     *     type => [datetime, date, currency, upper, lower, ucfirst, ucword, raw, html ]
     *   )
     * ]
     */
    private function createTableHead($columns=array(), $setting=array())
    {
        if (!empty($columns)
            && is_array($columns)) {
            $model = !empty($setting['model']) ? $setting['model'] : '';
            $arrTitle = array();
            foreach ($columns as $kColumn => $vColumn) {
                if ($kColumn !== 'color') {
                    $arrTitle[] = $this->generateTitleTable($vColumn, $model);
                }
            }

            if (!empty($arrTitle) && is_array($arrTitle)) {
                return "<th>".implode("</th><th>", $arrTitle)."</th>";
            }
        }
    }

    /**
     * Generate Title for Columns of table
     * @param array $column list column for gridview
     * [
     *   string ==> field_name
     *   array (
     *     name  =>
     *     title =>
     *     value =>
     *     default =>
     *     filter => false
     *     type => [datetime, date, currency, upper, lower, ucfirst, ucword, raw, html ]
     *   )
     * ]
     * @param string $model name of sv container model
     * @return string Rolumn Name
     */
    private function generateTitleTable($column=array(), $model='')
    {
        if (!empty($column)) {
            if (isset($column['title'])) {
                return $column['title'];
            }
            $columnName = $this->getColumnName($column);
            $title = app()->make('Helpers')->createTitle($columnName);
            if (!empty($model)) {
                $attributesLabel = app()->make($model)->attributesLabel();
                if (!empty($attributesLabel[$columnName])) {
                    return $attributesLabel[$columnName];
                }
            }
            return $title;
        }
    }


    /**
     * Create Tbody for gridview
     */
    private function createBody($model=array(), $columns=array())
    {
        if (!empty($model)
            && !empty($columns)
            && is_array($columns)) {
            $filter = $this->createTableFilter($model, $columns);
            $body   = $this->createTableData($model, $columns);
            return "<tbody>$filter$body</tbody>";
        }
    }

    /**
     * Generate Filter Column for table
     *
     * @param array $columns list column for gridview
     * [
     *   string ==> field_name
     *   array (
     *     name  =>
     *     title =>
     *     value =>
     *     default =>
     *     filter =>
     *        false == no filter,
     *        true == defaul filter, use textbox
     *        [
     *
     *        ]
     *     type => [datetime, date, currency, upper, lower, ucfirst, ucword, raw, html ]
     *   )
     * ]
     */
    private function createTableFilter($model=array(), $columns=array())
    {
        if (!empty($columns)
            && is_array($columns)) {
            $filterColumn = array();
            foreach ($columns as $kColumn => $vColumn) {
                if ($kColumn !== 'color') {
                    if (!isset($vColumn['filter']) || $vColumn['filter'] !== false) {
                        $columnName = $this->getColumnName($vColumn);
                        $detaultAttributes = array(
                            'class' => 'form-control pgv-search',
                            'data-name' => $columnName
                        );
                        if (is_string($vColumn)) {
                            $filterColumn[] = app()->make('DOM')->create('textfiled', $detaultAttributes);
                        } elseif(is_array($vColumn)) {
                            if (empty($vColumn['filter'])) {
                                $filterColumn[] = app()->make('DOM')->create('textfiled', $detaultAttributes);
                            } elseif(!empty($vColumn['filter']['type'])
                                && is_string($vColumn['filter']['type'])) {

                                $value = isset($vColumn['filter']['value']) ? $vColumn['filter']['value'] : '';
                                $data = isset($vColumn['filter']['data']) ? $vColumn['filter']['data'] : array();
                                $filterColumn[] = app()->make('DOM')->create(
                                    $vColumn['filter']['type'],
                                    $detaultAttributes,
                                    $value,
                                    $data
                                );
                            }
                        }
                    } else {
                        $filterColumn[] = "";
                    }
                }
            }
            if (!empty($filterColumn) && is_array($filterColumn)) {
                return "<tr class='tr-filter'><td>".implode("</td><td>", $filterColumn)."</td></tr>";
            }
        }
    }

    private function createTableData($model=array(), $columns=array())
    {
        if (!empty($model)
            && !empty($columns)
            && is_array($columns)) {
            $html = "";
            $countRow = 0;
            foreach ($model as $kModel => $vModel) {
                if (!empty($columns) && is_array($columns)) {
                    $style = '';
                    if (array_key_exists('color', $columns)) {
                        if (is_string($columns['color'])) {
                            $style = 'background-color: '.$columns['color'].';';
                        } elseif (is_array($columns['color']) && array_key_exists('value', $columns['color'])) {
                            $style = 'background-color: '.$columns['color']['value'].';';
                        }
                    }
                    $html .= "<tr class='tr-$countRow'";
                    $html .= !empty($style) ? " style='$style' " : "";
                    $html .= ">";
                    $countColumn = 0;
                    foreach ($columns as $kColumn => $vColumn) {
                        if ($kColumn !== 'color') {
                            $html .= "<td class='td-row-$countRow td-column-$countColumn'>";
                            $html .= $this->createTableField($vModel, $vColumn);
                            $html .= "</td>";
                            $countColumn++;
                        }
                    }
                    $html .= "</tr>";
                }
                $countRow++;
            }
            return $html;
        }
    }

    /**
     * Create Field from mix column
     * @param obj row of fata
     * @param mix $column
     *   string ==> field_name
     *   array (
     *     name  =>
     *     title =>
     *     value =>
     *     default =>
     *     filter => false
     *     type => [
     *          datetime,
     *          date,
     *          currency,
     *          upper,
     *          lower,
     *          ucfirst,
     *          ucword,
     *          raw,
     *          template,
     *      ]
     *     color => [
     *          'value' => '#000',
     *          'condition' =>
     *      ]
     *   )
     */
    private function createTableField($data='', $column='')
    {

        if (!empty($data) && !empty($column)) {
            $field = "";
            $columnName = $this->getColumnName($column);
            if (!empty($columnName)) {
                $field = isset($data->$columnName) ? $data->$columnName : "";
            }

            /* For Relation */
            if(empty($field) && strpos($columnName, '.') !== false) {
                $arrColumnName = explode('.', $columnName);
                foreach ($arrColumnName as $kRelation => $vRelation) {
                    if (empty($field)) {
                        $field = $data->$vRelation;
                    } else {
                        $x = [];
                        $arrField = $field->toArray();
                        if (array_key_exists(0, $arrField)) { // For One to many
                            for ($i=0; $i < sizeof($field); $i++) {
                                $x[] = $field[$i][$vRelation];
                            }
                            $field = implode(", ", $x);
                        } else { // For one to one
                            $field = isset($field->$vRelation)
                                ? $field->$vRelation : '';
                        }
                    }
                }
            }

            if (!empty($column['value'])) {
                $columnValue = $column['value'];
                if (is_string($columnValue)) {
                    $field = $this->setTypeField($columnValue, 'template', $data);
                    //Create Type
                    if (!empty($column['type'])) {
                        $field = $this->setTypeField($field, $column['type'], $data);
                    }

                } elseif (is_array($columnValue)) {
                    if (!empty($column['type']) && $column['type'] == 'alias') {
                        $field = $this->setTypeField((string) $field, $column['type'], $column['value']);
                    } else {
                        $tmpField = array();
                        foreach ($columnValue as $kColVal => $vColVal) {
                            $field = $this->setTypeField($vColVal, 'template', $data);
                            if (!empty($column['type'])) {
                                $field = $this->setTypeField($vColVal, $column['type'], $data);
                            }
                            $tmpField[] = $field;
                        }
                        if (!empty($tmpField) && is_array($tmpField)) {
                            $field = array_filter($tmpField);
                            $field = "<ul><li>". implode("</li><li>", $field) ."</li></ul>";
                        }
                    }
                }

            } else {
                //Create Type
                if (!empty($column['type'])) {
                    $field = $this->setTypeField($field, $column['type'], $data);
                }
            }

            return $field;
        }
    }

    // private function generateTypeField($value='', $type='')
    // {
    //     if (is_string($type)) {
    //         $value = $this->setTypeField($value, $type);
    //     } elseif(is_array($type)) {
    //         foreach ($type as $kType => $vType) {
    //             $value = $this->setTypeField($value, $type);
    //         }
    //     }
    //     return $value;
    // }

    /**
     * [datetime, date, currency, upper, lower, ucfirst, ucword, raw, template, function, alias ]
     * @param string $value value will show
     * @param string $type Type of filed
     * @param obj row of fata
     */
    private function setTypeField($value='', $type='', $data='')
    {
        if (is_string($value)
            && !empty($type) && is_string($type)) {

            switch (strtolower($type)) {
                case 'datetime':
                    # code...
                    break;
                case 'date':
                    # code...
                    break;
                case 'currency':
                    # code...
                    break;
                case 'upper':
                    return strtoupper($value);
                    break;
                case 'lower':
                    return strtolower($value);
                    break;
                case 'ucfirst':
                    return ucfirst(strtolower($value));
                    break;
                case 'ucword':
                    return ucword(strtolower($value));
                    break;
                case 'raw':
                    return $value;
                    break;
                case 'template':
                    $data = is_array($data) ? $data : $data->getAttributes();
                    foreach ($data as $kData => $vData) {
                        $value = str_replace("#$kData#", $vData, $value);
                    }
                    return $value;
                    break;
                case 'function':
                    try {
                        $value = substr($value, -1) == ";" ? $value : $value.";";
                        $value = '$_value = '.$value;
                        eval($value);
                        return !is_array($_value) || !is_object($_value)? $_value : '-';
                    } catch (Exception $e) {
                        return "-";
                    }
                    break;
                case 'alias':
                    return isset($data[$value]) ? $data[$value] : '-';
                    break;
            }
        }
    }

    /**
     * Create list class for table
     * @param array $setting setting table
     * [
     *    model => string model name use for table
     *    id    => string id for table
     *    class => mix class for table
     * ]
     * @return string class table
     */
    private function createClassTable($setting='')
    {
        // Default Class
        $classTable = array(
            'table',
            'table-striped',
            'table-bordered',
            'table-hover',
            'table-condensed',
        );

        if (!empty($setting['class'])) {
            if (is_array($setting['class'])) {
                $classTable[] = array_collapse($classTable, $setting['class']);
            } elseif (is_string($setting['class'])) {
                $classTable[] = $setting['class'];
            }
        }
        return implode(" ", $classTable);
    }

    private function getColumnName($column='')
    {
        if (is_string($column)) {
            return $column;
        } elseif (is_array($column)) {
            return !empty($column['name']) ? $column['name'] : "";
        }
    }
}
