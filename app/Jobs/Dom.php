<?php

/**
* @author Josep
* Tools to gnerate HTML DOM
*/

namespace App\Jobs;

class Dom
{
    /**
     * Tools to generte Dom Html
     * @param string $type type DOM HTML
     *   [textfiled, textarea, datepicker, number, dropdown, radio, check, button]
     * @param array $attributes attributes for dom html
     */
    public function create($type='', $attributes=array(), $value='', $data=array())
    {
        if (!empty($type) && is_string($type) && is_array($attributes)) {
            switch (strtolower($type)) {
                case 'textfiled':
                    return $this->textfiled($attributes, $value);
                    break;
                case 'password':
                    return $this->password($attributes, $value);
                    break;
                case 'textarea':
                    return $this->textarea($attributes, $value);
                    break;
                case 'datepicker':
                    return $this->datepicker($attributes, $value);
                    break;
                case 'number':
                    return $this->number($attributes, $value);
                    break;
                case 'email':
                    return $this->email($attributes, $value);
                    break;
                case 'dropdownlist':
                    return $this->dropdownlist($attributes, $value, $data);
                    break;
                case 'radio':
                    # code...
                    break;
                case 'check':
                    # code...
                    break;
                case 'button':
                    return $this->button($attributes, $value);
                    break;

                default:
                    # code...
                    break;
            }
        }
    }

    /**
     * Create Html Textfiled
     * @param array $attributes attributes of html
     * @param string value
     * @return string html textfiled
     */
    private function textfiled($attributes='', $value='')
    {
        $attributes = array_collapse(
            array(
                $attributes,
                array(
                    'type' => 'text',
                    $value=>$value
                )
            )
        );
        $attributes = array_filter($attributes);
        $attr = $this->generateAttributesDom($attributes);
        return "<input $attr />";
    }

    /**
     * Create Html datepicker
     * @param array $attributes attributes of html
     * @param string value
     * @return string html datepicker
     */
    private function datepicker($attributes='', $value='')
    {
        if (isset($attributes['class']) && is_string($attributes['class'])) {
            $attributes['class'] .= " datepicker";
        } else {
            $attributes['class'] = "datepicker";
        }
        $attributes = array_collapse(
            array(
                $attributes,
                array(
                    'type' => 'text',
                    $value=>$value
                )
            )
        );
        $attributes = array_filter($attributes);
        $attr = $this->generateAttributesDom($attributes);
        return "<input $attr />";
    }

    private function number($attributes='', $value='')
    {
        if (isset($attributes['class']) && is_string($attributes['class'])) {
            $attributes['class'] .= " force-number";
        } else {
            $attributes['class'] = "force-number";
        }
        $attributes = array_collapse(
            array(
                $attributes,
                array(
                    'type' => 'number',
                    $value=>$value
                )
            )
        );
        $attributes = array_filter($attributes);
        $attr = $this->generateAttributesDom($attributes);
        return "<input $attr />";
    }

    private function email($attributes='', $value='')
    {
        if (isset($attributes['class']) && is_string($attributes['class'])) {
            $attributes['class'] .= " email";
        } else {
            $attributes['class'] = "email";
        }
        $attributes = array_collapse(
            array(
                $attributes,
                array(
                    'type' => 'email',
                    $value=>$value
                )
            )
        );
        $attributes = array_filter($attributes);
        $attr = $this->generateAttributesDom($attributes);
        return "<input $attr />";
    }

    private function password($attributes='', $value='')
    {
        $attributes = array_collapse(
            array (
                $attributes,
                array(
                    'type' => 'password',
                    $value=>$value
                )
            )
        );
        $attributes = array_filter($attributes);
        $attr = $this->generateAttributesDom($attributes);
        return "<input $attr />";
    }

    private function textarea($attributes='', $value='')
    {
        $attr = $this->generateAttributesDom($attributes);
        return "<textarea $attr>$value</textarea>";
    }

    private function dropdownlist($attributes='', $value='', $data=array())
    {
        $attr = $this->generateAttributesDom($attributes);
        $option = "";
        if (!empty($data) && is_array($data)) {
            foreach ($data as $kData => $vData) {
                $selected = "";
                if ($kData === $value) {
                    $selected = "selected='selected'";
                }
                $option .= "<option $selected value='$kData'>$vData</option>";
            }
        }
        return "<select $attr>$option</select>";
    }

    private function button($attributes='', $value='')
    {
        if (!empty($attributes['class']) && is_string($attributes['class'])) {
            if (strpos($attributes['class'], 'btn-') === false) {
                $attributes['class'] .= ' btn btn-primary';
            }
        } else {
            $attributes['class'] = 'btn btn-primary';
        }
        $attr = $this->generateAttributesDom($attributes);
        return "<span $attr>$value</span>";
    }

    public function generateAttributesDom($attributes='')
    {
        if (!empty($attributes) && is_array($attributes)) {
            $arrRes = array();
            foreach ($attributes as $kAttr => $vAttr) {
                $arrRes[] = "$kAttr = '$vAttr'";
            }
            if (!empty($arrRes) && is_array($arrRes)) {
                return implode(" ", $arrRes);
            }
        }
    }

    /**
     * Minify HTML
     * @param string $html
     * @return string minify html
     */
    public function minifyHTML($html)
    {
        // $search = array(
        //     '/ {2,}/',
        //     '/|\t?:\r?\n[ \t]*)+/s'
        // );
        // $replace = array(
        //     ' ',
        //     ''
        // );
        // $html = preg_replace($search, $replace, $html);
        return $html;
    }
}
