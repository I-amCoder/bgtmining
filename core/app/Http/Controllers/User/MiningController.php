<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MiningHistory;
use App\Models\MiningPlan;
use App\Models\PaymentMethod;
use App\Models\PlanDeposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MiningController extends Controller
{
    public function showMine()
    {
        $pageTitle = "BGT Mining";
        return view($this->activeTemplate . 'user.mining.index', compact('pageTitle'));
    }

    public function plans()
    {
        $pageTitle = "Plans Upgrade";
        $plans = MiningPlan::all();
        return view($this->activeTemplate . 'user.mining.plans', compact('pageTitle', 'plans'));
    }

    public function buyPlan($id)
    {

        $pageTitle = "Buy Plan";
        $plan = MiningPlan::findOrFail($id);

        if (auth()->user()->plan_id == $id) {
            return to_route('user.mining.plans')->withNotify([['error', 'You\'ve already subscribed to this plan']]);
        }

        $jazzcash = PaymentMethod::where('status', 1)->where('method_slug', 'jazzcash')->first();
        $easypaisa = PaymentMethod::where('status', 1)->where('method_slug', 'easypaisa')->first();
        $bank = PaymentMethod::where('status', 1)->where('method_slug', 'bank')->first();

        return view($this->activeTemplate . 'user.mining.buy_plan', compact('pageTitle', 'plan', 'jazzcash', 'easypaisa', 'bank'));
    }

    public function buyPlanProcess(Request $request, $id)
    {
        if ($request->hasFile('slip')) {
            $slip = fileUploader($request->file('slip'), 'assets/images/payment_slips');
            $method = PaymentMethod::where('method_slug', $request->method)->firstOrFail();

            $plan = MiningPlan::findOrFail($id);
            $deposit = new PlanDeposit();
            $deposit->user_id = auth()->id();
            $deposit->mining_plan_id = $plan->id;
            $deposit->payment_method_id = $method->id;
            $deposit->amount = $plan->price;
            $deposit->proof = $slip;
            $deposit->status = "pending";

            $deposit->save();

            $notify[] = ['success', 'Your deposit request has been sumitted successfully, wait for admin for action'];
            return back()->withNotify($notify);
        } else {
            return back();
        }
    }

    public function mine()
    {
        $user = User::find(auth()->id());

        // Check if user is eligible
        if (now() < $user->next_mining_time ?? now()->subDay()) {
            $notify[] = ['error', 'Please wait for your mining time'];
            return back()->withNotify($notify);
        }

        // Check if user has plan
        if ($user->mining_plan) {
            $plan = $user->mining_plan;
        } else {
            $plan = MiningPlan::first();
            $user->plan_id = $plan->id;
        }

        $rate = $plan->return_interest;
        if ($plan->return_for == 1) {
            $earning = ($plan->price * $rate) / 100;
        } else {
            $earning = $rate;
        }

        // Create Mining History
        $history = new MiningHistory();

        $history->plan_id = $plan->id;

        $history->user_id = $user->id;

        $history->next_mining_time = now()->addDay();

        $user->next_mining_time = now()->addDay();

        $user->mining_balance += $earning;

        $history->amount = $earning;

        try {
            DB::beginTransaction();
            $history->save();
            $user->save();
            DB::commit();

            $notify[] = ['success', 'Earned Successfully'];
            return back()->withNotify($notify);
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug')) dd($th->getMessage());
            $notify[] = ['error', 'Error, Contact Developer'];

            return back()->withNotify($notify);
        }
    }
}
