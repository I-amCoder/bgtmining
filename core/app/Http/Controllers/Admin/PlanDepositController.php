<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanDeposit;
use Illuminate\Http\Request;

class PlanDepositController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Plan Deposits";
        $deposits = PlanDeposit::all();
        return view('admin.plans.deposits', compact('deposits', 'pageTitle'));
    }

    public function approve($id)
    {
        $deposit = PlanDeposit::findOrFail($id);
        $deposit->status = "Approved";
        $deposit->save();

        $notify[] = ["Deposit Approved Successfully"];

        return back()->withNotify($notify);
    }

    public function reject($id)
    {
        $deposit = PlanDeposit::findOrFail($id);
        $deposit->status = "Rejected";
        $deposit->save();

        $notify[] = ["Deposit Rejected Successfully"];

        return back()->withNotify($notify);
    }
}
