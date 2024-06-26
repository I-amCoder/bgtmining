<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CryptoCurrency;
use App\Models\MiningHistory;
use App\Models\MiningPlan;
use App\Models\Advertisement;
use App\Models\PaymentMethod;
use App\Models\CommissionLog;
use App\Models\Transaction;
use App\Models\PlanDeposit;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MiningController extends Controller
{
    public function showMine()
    {
        $pageTitle = "BGT Mining";
        return view($this->activeTemplate . 'user.mining.index', compact('pageTitle'));
    }

    public function history(Request $request)
    {
        $pageTitle = "BGT Mining History";
       $userId = auth()->id(); // Get the authenticated user's ID
$records = MiningHistory::where('user_id', $userId)->latest()->get();
   $remarks      = Transaction::distinct('remark')->whereNotNull('remark')->get('remark');
        $transactions = Transaction::where('user_id',  $userId)->where('crypto_currency_id', '!=', null);

        if ($request->search) {
            $transactions = $transactions->where('trx', $request->search);
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type', $request->type);
        }

        if ($request->crypto) {
            $transactions = $transactions->where('crypto_currency_id', $request->crypto);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark', $request->remark);
        }

        $transactions = $transactions->with(['crypto'])->orderBy('id', 'desc')->paginate(getPaginate());
        $cryptos = CryptoCurrency::latest()->get();


        return view($this->activeTemplate . 'user.mining.history', compact('pageTitle', 'records', 'transactions', 'cryptos', 'remarks'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric'
        ]);

        // Custom Validators
        if ($request->amount > auth()->user()->mining_balance) {
            return back()->withErrors(['amount' => 'Insufficient Mining Amount']);
        }

        $amount = $request->amount;


        $currency = CryptoCurrency::where('symbol', 'BGT')->first();

        if ($currency) {

            $wallet = Wallet::where('user_id', auth()->id())->where('crypto_currency_id', $currency->id)->first();

            if ($wallet) {
                auth()->user()->mining_balance -= $amount;
                $wallet->balance += $amount;

                auth()->user()->save();
                $wallet->save();

                return back()->withNotify([['success', 'Balance Transfered Successfully']]);
            }
        }
        return back()->withNotify([['error', 'Error while transferring balance']]);
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
           $userId = auth()->id(); // Get the authenticated user's ID
        $deposits = PlanDeposit::where('user_id', $userId)->latest()->get();

        if (auth()->user()->plan_id == $id) {
            return to_route('user.mining.plans')->withNotify([['error', 'You\'ve already subscribed to this plan']]);
        }

        $jazzcash = PaymentMethod::where('status', 1)->where('method_slug', 'jazzcash')->first();
        $easypaisa = PaymentMethod::where('status', 1)->where('method_slug', 'easypaisa')->first();
        $bank = PaymentMethod::where('status', 1)->where('method_slug', 'bank')->first();

        return view($this->activeTemplate . 'user.mining.buy_plan', compact('pageTitle', 'plan', 'deposits','jazzcash', 'easypaisa', 'bank'));
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
