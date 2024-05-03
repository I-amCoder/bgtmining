<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Payment Methods";

        return view('admin.payment_methods.index', compact('pageTitle'));
    }

    public function update(Request $request)
    {
        dd($request->all());
    }
}
