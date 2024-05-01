<?php

namespace App\Http\Controllers;

use App\Models\MiningHistory;
use App\Models\MiningPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MiningController extends Controller
{
    public function mine()
    {
        $user = User::find(auth()->id());

        // Check if user is eligible
        if (now() < $user->next_mining_time) {
            return back();
        }

        // Check if user has plan
        if ($user->plan) {
            $plan = $user->plan;
        } else {
            $plan = MiningPlan::first();
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

        $history->amount = $earning;

        try {
            DB::beginTransaction();

            $history->save();
            $user->save();

            DB::commit();

            return back();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug')) dd($th->getMessage());
            return back();
        }
    }
}
