<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MiningHistory;
use App\Models\MiningPlan;
use App\Models\User;
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
