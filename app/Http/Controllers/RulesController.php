<?php

namespace App\Http\Controllers;

use \App\Http\Models\AssignRules as AssignRules;
use \App\Http\Models\Rules as Rules;
use Illuminate\Http\Request;
use DB;

class RulesController extends Controller
{
    /**
     * Show List Rules
     */
    public function getIndex()
    {
        $model = app()->make('Rules')->search(15);
        return View('rules.index', get_defined_vars());
    }

    public function getCreate()
    {
        $model=null;
        $labelProses = 'Create';
        return View('rules.form', get_defined_vars());
    }

    public function postCreate(\App\Http\Requests\Rules\CreateRulesRequest $request)
    {
        if ($this->create($request->all())) {
            return redirect('rules');
        }
    }

    /**
     * Create new rules
     */
    protected function create(array $data)
    {
        return Rules::create([
            'name' => $data['name'],
            'status' => $data['status'],
        ]);
    }

    /**
     * View form update rules
     * @param   int     $id     id rules
     */
    public function getUpdate($id)
    {
        $model = \App\Http\Models\Rules::find($id);
        if (!empty($model)) {
            $labelProses = 'Update';
            return View('rules.form', get_defined_vars());
        }
    }

    /**
     * Method to update rules
     */
    public function postUpdate(\App\Http\Requests\Rules\UpdateRulesRequest $request)
    {
        if ($request->get('id') && $this->update($request->all())) {
            return redirect('rules');
        }
    }

    /**
     * Update Rules
     */
    protected function update(array $data)
    {
        $id = $data['id'];
        unset($data['id'], $data['_token']);
        return \App\Http\Models\Rules::find($id)->update($data);
    }

    /**
     * List Assign for this rules
     */
    public function getAssign($id)
    {
        $rules = Rules::find($id);
        if (!empty($rules)) {
            $model = AssignRules::with('assign')
                ->where('rules_id', '=', $id)
                ->get();
            return View('rules.assign', get_defined_vars());
        }
    }

    public function getAddAssignRules($id)
    {
        $rules = Rules::find($id);
        $model = app()->make('Assign')->search(15);
        if (!empty($model)) {
            return View('rules.addAssign', get_defined_vars());
        }
    }

    /**
     * Post to add or delete assign_rules
     * @param   int     assign_id
     * @param   int     rules_id
     * @param   int     status 0 = delete, 1 = create
     */
    public function postAddAssignRules(Request $request)
    {
        if ($request->isMethod('post')) {
            $rulesId = $request->input('rules_id');
            $assignId = $request->input('assign_id');
            if (!empty($rulesId) && !empty($assignId)) {
                if (empty($request->input('type'))) {
                    $model = AssignRules::where('assign_id', '=', $assignId)
                        ->where('rules_id', '=', $rulesId)->delete();
                } else {
                    $model = AssignRules::firstOrCreate(
                        [
                            'assign_id' => $assignId,
                            'rules_id' => $rulesId
                        ]
                    );
                }
                if (!empty($model)) {
                    return response()->json(
                        [
                            'status' => 200,
                            'messages' => 'success',
                            'data' => $model
                        ]
                    );
                }
                return response()->json(
                    [
                        'status' => 404,
                        'messages' => 'erro',
                    ]
                );
            }
        }
    }
}
