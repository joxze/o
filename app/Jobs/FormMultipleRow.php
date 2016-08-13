<?php

/**
* @author Josep
* Tools to gnerate Form with Multiple Row
*/

namespace App\Jobs;

class FormMultipleRow
{
    /**
     * Tools to generte Form with Multiple Row
     * @param string $template HTML Template
     * <div class='col-lg-1'>
     *  <input value='#key1#'/>
     * </div>
     * <div class='col-lg-1'>
     *  <input  value='#key2#'/>
     * </div>
     * <div class='col-lg-1'>
     *  #buttonForm# ==> Special Variabel for button
     * </div>
     * Special Variable in template :
     * - #count# for count data
     * - #buttonForm# for button add or min
     * @param array $data
     * [
     *  [
     *    'key1' => 'value11'
     *    'key2' => 'value21',
     *  ],
     *  [
     *    'key1' => 'value12'
     *    'key2' => 'value22',
     *  ]
     * ]
     */
    public function create($template='', $data=array())
    {
        if (!empty($template)) {
            $main   = $this->createTemplate($template, $data);
            $body   = $this->createBody($template, $data);
            $html   = "<div class='form-multiple-row'>".
                "<div class='main-form'>$main</div>".
                "<div class='form-row'>$body</div>".
            "</div>";
            return app()->make('DOM')->minifyHTML($html);
        }
    }

    public function createTemplate($template='', $data=array())
    {
        if (!empty($template) && !empty($data[0]) && is_array($data[0])) {
            $count              = $this->countArray($data);
            $data               = $data[0];
            $data               = app()->make('Helpers')->forceSetArray($data);
            $data['buttonForm'] = app()->make('DOM')->create(
                'button',
                array(
                    'class'     =>'add-multiple-row',
                    'data-count'=>$count
                ),
                '+'
            );
            return $this->createForm($template, $data);
        }
    }

    public function createBody($template='', $data=array())
    {
        if (!empty($template) && !empty($data) && is_array($data)) {
            $html   = "";
            $count  = 0;
            foreach ($data as $kData => $vData) {
                $vData = array_filter($vData);
                if (!empty($vData) && is_array($vData)) {
                    $vData['buttonForm'] = app()->make('DOM')->create(
                        'button',
                        array(
                            'class'     =>'remove-multiple-row btn btn-danger',
                            'data-count'=>$count
                        ),
                        '-'
                    );
                    $arrAtributesFrame = array(
                        'class'     => 'div-multiple-row multiple-row-'.$count,
                        'data-id'   => $count,
                    );
                    $_html = $this->createForm($template, $vData);
                    $html .= $this->createDivFrame($_html, $arrAtributesFrame);
                    $count++;
                }
            }
            return $html;
        }
    }

    /**
     * Generate Template from attributes and fill with data
     * @param   mix     $attributes attributes or template will create for form
     * @param   array   $data       data that will fill on template
     * @return  string  html template will create form
     */
    public function createForm($template='', $data=array())
    {
        if (!empty($template) && is_string($template)) {
            return app()->make('Helpers')->fillTemplate($template, $data);
        }
    }

    /**
     * Create Div outter for html string
     * @param   string  $html
     * @param   array   $attributes
     */
    private function createDivFrame($html='', $attributes='')
    {
        $attributes['class'] = array_key_exists('class', $attributes) ? 'div-row '.$attributes['class'] : 'div-row ';
        $class = app()->make('DOM')->generateAttributesDom($attributes);
        return "<div $class>$html</div>";
    }

    private function countArray($data='')
    {
        if (is_array($data)) {
            $count = 0;
            foreach ($data as $kData => $vData) {
                $vData = array_filter($vData);
                if (!empty($vData) && is_array($vData)) {
                    $count++;
                }
            }
            return $count;
        }
    }
}
