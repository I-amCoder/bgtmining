<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Payment Methods";
        $jazzcash = PaymentMethod::where('method_slug', 'jazzcash')->first();
        $easypaisa = PaymentMethod::where('method_slug', 'easypaisa')->first();
        $bank = PaymentMethod::where('method_slug', 'bank')->first();
        return view('admin.payment_methods.index', compact('pageTitle', 'jazzcash', 'easypaisa', 'bank'));
    }

    public function update(Request $request, $method)
    {

        if (!in_array($method, ['jazzcash', 'easypaisa', 'bank'])) {
            abort(404);
        }

        switch ($method) {
            case 'jazzcash':
                $this->updateJazzcash($request);
                break;
            case 'easypaisa':
                $this->updateEasypaisa($request);
                break;
            case 'bank':
                $this->updateBank($request);
                break;
        }

        $notify[] = ['success', 'Method Updated Successfully'];
        return back()->withNotify($notify);
    }

    protected function updateJazzcash(Request $request)
    {
        $request->validate([
            'jazzcash_account_name' => 'required|string',
            'jazzcash_account_number' => 'required|numeric',
            'jazzcash_charge' => 'required|numeric|min:0'
        ]);

        $method = PaymentMethod::where('method_slug', 'jazzcash')->firstOrCreate();
        if ($request->has('jazzcash_status')) {
            $method->status = $request->jazzcash_status;
        } else {
            $method->status = 0;
        }

        $details = [
            'account_name' => $request->jazzcash_account_name,
            'account_number' => $request->jazzcash_account_number,
        ];


        $method->method_name = "JazzCash";
        $method->method_slug = "jazzcash";
        $method->charge = $request->jazzcash_charge;
        $method->details = $details;

        $method->save();
    }


    protected function updateEasypaisa(Request $request)
    {
        $request->validate([
            'easypaisa_account_name' => 'required|string',
            'easypaisa_account_number' => 'required|numeric',
            'easypaisa_charge' => 'required|numeric|min:0'
        ]);

        $method = PaymentMethod::where('method_slug', 'easypaisa')->firstOrCreate();

        if ($request->has('easypaisa_status')) {
            $method->status = $request->easypaisa_status;
        } else {
            $method->status = 0;
        }

        $details = [
            'account_name' => $request->easypaisa_account_name,
            'account_number' => $request->easypaisa_account_number,
        ];


        $method->method_name = "Easypaisa";
        $method->method_slug = "easypaisa";
        $method->charge = $request->easypaisa_charge;
        $method->details = $details;

        $method->save();
    }
    protected function updateBank(Request $request)
    {
        $request->validate([
            'bank_account_number' => 'required|numeric',
            'bank_account_name' => 'required|string',
            'bank_account_number' => 'required|numeric',
            'bank_charge' => 'required|numeric|min:0'
        ]);

        $method = PaymentMethod::where('method_slug', 'bank')->firstOrCreate();
        if ($request->has('bank_status')) {
            $method->status = $request->bank_status;
        } else {
            $method->status = 0;
        }

        $details = [
            'bank_name' => $request->bank_account_name,
            'account_name' => $request->bank_account_name,
            'account_number' => $request->bank_account_number,
        ];

        $method->method_name = "Bank";
        $method->method_slug = "bank";
        $method->charge = $request->bank_charge;
        $method->details = $details;

        $method->save();
    }
}
