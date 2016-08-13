<?php

namespace App\Jobs;

/**
* @author Josep
* Help Meeee !!!!
*/
class Helpers
{
    /**
     *
     */
    public function getPost($key='')
    {
        return isset($_POST[$key]) ? $_POST[$key] : false;
    }
    /**
     *
     */
    public function getQuery($key='')
    {
        return isset($_POSTGET[$key]) ? $_GET[$key] : false;
    }

    /**
     * decode json was encryp by base 64
     * @param string $value
     * @return array
     */
    public function decodeJson64($value='')
    {
        if (!empty($value)) {
            try {
                return json_decode(base64_decode($value), true);
            } catch (Exception $e) {

            }
        }
    }

    public function addSpace($value='', $spaceAdd=0)
    {
        $space  = str_repeat(" ", $spaceAdd);
        if (is_string($value)) {
            $value = explode("\n", $value);
        }

        if (!empty($value) && is_array($value)) {
            $arr    = array();
            foreach ($value as $kVal => $vVal) {
                $arr[] = $space.$vVal;
            }
            if (is_string($value)) {
                return implode("\n", $arr);
            } else {
                return $arr;
            }
        }
    }

    public function createTitle($value='')
    {
        if (!empty($value) && is_string($value)) {
            return ucwords(strtolower(str_replace("_", " ", $value)));
        }
    }

    /**
     * Read File
     * @param string $path path file will read
     * @return string value of the file
     */
    public function readFile($path='')
    {
        if (!empty($path)) {
            $file   = fopen($path, "r") or die("Unable to open file!");
            $result = fread($file, filesize($path));
            fclose($file);
            return $result;
        }
    }

    /**
     * Create File
     * @param string $path location file
     * @param string $content value of the file
     * @return bool
     */
    public function writeFile($path='', $content='')
    {
        if (!empty($path)) {
            try {
                $file = fopen($path, "w");
                fwrite($file, $content);
                fclose($file);
                chmod($path, 0777);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }

    /**
     * Fill Template with data
     * @param string    $template   html template
     * @param array     $data
     */
    public function fillTemplate($template='', $data='')
    {
        if (!empty($template)
            && is_string($template)
            && is_array($data)) {

            foreach ($data as $kData => $vData) {
                $template = str_replace("#$kData#", $vData, $template);
            }
        }
        return $template;
    }

    /**
     * Set all value of array with value
     */
    public function forceSetArray($array='', $value='')
    {
        if (is_array($array)) {
            $newArray = array();
            foreach ($array as $kArray => $vArray) {
                if (is_string($vArray) || is_integer($vArray)) {
                    $newArray[$kArray] = $value;
                } elseif (is_array($vArray)) {
                    $newArray[$kArray] = $this->forceSetArray($vArray);
                }
            }
            return $newArray;
        }
    }
}
