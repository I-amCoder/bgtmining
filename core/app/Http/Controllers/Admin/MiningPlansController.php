<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MiningPlan;
use Illuminate\Http\Request;

class MiningPlansController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Plans";
        $plans = MiningPlan::latest()->get();

        return view('admin.plans.index', compact('pageTitle', 'plans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plan_name' => 'required',
            'price' => 'required|numeric',
            'return_interest' => 'required|numeric',
            'return_type' => 'required|in:0,1',
        ]);

        $data['status'] = 1;

        MiningPlan::create($data);

        $notify[] = ['success', 'Plan Created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $plan = MiningPlan::findOrFail($id);

        $data = $request->validate([
            'plan_name' => 'required',
            'price' => 'required|numeric',
            'return_interest' => 'required|numeric',
            'return_type' => 'required|in:0,1',
        ]);

        $data['status'] = 1;

        MiningPlan::where('id', $plan->id)->update($data);

        $notify[] = ['success', 'Plan Updated successfully'];
        return back()->withNotify($notify);
    }

    public function  delete($id)
    {
        $plan = MiningPlan::findOrFail($id);
        $plan->delete();
        $notify[] = ['success', 'Plan Deleted successfully'];
        return back()->withNotify($notify);
    }
}
