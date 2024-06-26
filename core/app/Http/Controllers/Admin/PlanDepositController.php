<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CryptoCurrency;
use App\Models\PlanDeposit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlanDepositController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Plan Deposits";
        $deposits = PlanDeposit::latest()->get();
        return view('admin.plans.deposits', compact('deposits', 'pageTitle'));
    }

    public function approve($id)
    {
        $deposit = PlanDeposit::findOrFail($id);

        $deposit->status = "Approved";

        $user = $deposit->user;

        $plan = $deposit->plan;

        $user->plan_id = $plan->id;

        $user->next_mining_time = now()->addDay();

        try {
            DB::beginTransaction();
            $deposit->save();
            $user->save();
            $general = gs();
            if ($general->deposit_commission) {
                levelCommission($user, $deposit->amount, CryptoCurrency::where('symbol', 'BGT')->first()->id, strtoupper(Str::random(11)), 'deposit', true);
            }
            DB::commit();
        } catch (\Throwable $th) {
            if (config('app.debug')) dd($th->getMessage());

            $notify[] = ['error', "Error while approving"];

            return back()->withNotify($notify);
        }

        $notify[] = ['success', "Deposit Approved Successfully"];

        return back()->withNotify($notify);
    }

    public function reject($id)
    {
        $deposit = PlanDeposit::findOrFail($id);
        $deposit->status = "Rejected";
        $deposit->save();

        $notify[] = ["success", "Deposit Rejected Successfully"];

        return back()->withNotify($notify);
    }
}
