<?php
/**
* @author Josep
* Assign
*/
namespace App\Http\Controllers;

use \App\Http\Models\AssignRules as AssignRules;
use Illuminate\Http\Request;
use Symfony\Component\Finder\Finder;
use hanneskod\classtools\Iterator\ClassIterator;

class AssignController extends Controller
{

    /**
     * form add Assign
     */
    public function getAddAssign()
    {
        $finder = new Finder;
        $iter = new ClassIterator($finder->in('../app/Http/Controllers'));
        $arrController = [];
        // Print the file names of classes, interfaces and traits in 'src'
        foreach ($iter->getClassMap() as $classname => $splFileInfo) {
            $class = str_replace("App\Http\Controllers\\", "", $classname);
            $method = [];
            foreach (get_class_methods($classname) as $_m) {
                if (
                    strpos($_m, 'action') === 0
                    || strpos($_m, 'get') === 0
                    || strpos($_m, 'post') === 0
                    || strpos($_m, 'put') === 0
                    || strpos($_m, 'delete') === 0
                ) {
                    $arrControler[] = [
                        'class' => $class,
                        'method' => $_m
                    ];
                }
            }
        }
        dd($arrController);
        return View('assign.assign', get_defined_vars());
    }
}
