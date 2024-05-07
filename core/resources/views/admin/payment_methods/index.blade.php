@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12 my-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white">Jazz Cash</h4>
                </div>
                <form action="{{ route('admin.payment_method.update', 'jazzcash') }}" method="POST">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="jazzcash_account_name" class="form-label">Account Holder Name</label>
                            <input value="{{ old('jazzcash_account_name', $jazzcash->details['account_name'] ?? '') }}"
                                type="text" name="jazzcash_account_name" id="jazzcash_account_name"
                                placeholder="Account Holder Name" class="form-control">
                            @error('jazzcash_account_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jazzcash_account_number" class="form-label">Account Number</label>
                            <input value="{{ old('jazzcash_account_number', $jazzcash->details['account_number'] ?? '40') }}"
                                type="text" name="jazzcash_account_number" id="jazzcash_account_number"
                                placeholder="Account Number" class="form-control">
                            @error('jazzcash_account_number')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jazzcash_charge" class="form-label">Gateway Charge</label>
                            <input value="{{ old('jazzcash_charge', $jazzcash->charge ?? 0) }}" type="text"
                                name="jazzcash_charge" id="jazzcash_charge" placeholder="Account Gateway Charge"
                                class="form-control">
                            @error('jazzcash_charge')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="jazzcash_status" @checked($jazzcash->status) class="form-check-input"
                                type="checkbox" value="1" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Enable
                            </label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-outline-success">Update</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-12 my-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white">Easypaisa</h4>
                </div>
                <form action="{{ route('admin.payment_method.update', 'easypaisa') }}" method="POST">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="easypaisa_account_name" class="form-label">Account Holder Name</label>
                            <input value="{{ old('easypaisa_account_name', $easypaisa->details['account_name'] ?? '') }}"
                                type="text" name="easypaisa_account_name" id="easypaisa_account_name"
                                placeholder="Account Holder Name" class="form-control">
                            @error('easypaisa_account_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="easypaisa_account_number" class="form-label">Account Number</label>
                            <input
                                value="{{ old('easypaisa_account_number', $easypaisa->details['account_number'] ?? '') }}"
                                type="text" name="easypaisa_account_number" id="easypaisa_account_number"
                                placeholder="Account Number" class="form-control">
                            @error('easypaisa_account_number')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="easypaisa_charge" class="form-label">Gateway Charge</label>
                            <input value="{{ old('easypaisa_charge', $easypaisa->charge ?? 0) }}" type="text"
                                name="easypaisa_charge" id="easypaisa_charge" placeholder="Account Gateway Charge"
                                class="form-control">
                            @error('easypaisa_charge')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="easypaisa_status" @checked($easypaisa->status ?? false) class="form-check-input"
                                type="checkbox" value="1" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Enable
                            </label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-outline-success">Update</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-12 my-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white">Bank Account</h4>
                </div>
                <form action="{{ route('admin.payment_method.update', 'bank') }}" method="POST">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="bank_account_name" class="form-label">Account Holder Name</label>
                            <input value="{{ old('bank_account_name', $bank->details['account_name'] ?? '') }}"
                                type="text" name="bank_account_name" id="bank_account_name"
                                placeholder="Account Holder Name" class="form-control">
                            @error('bank_account_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bank_account_name" class="form-label">Account Holder Name</label>
                            <input value="{{ old('bank_account_name', $bank->details['account_name'] ?? '') }}"
                                type="text" name="bank_account_name" id="bank_account_name"
                                placeholder="Account Holder Name" class="form-control">
                            @error('bank_account_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bank_account_number" class="form-label">Account Number</label>
                            <input value="{{ old('bank_account_number', $bank->details['account_number'] ?? '') }}"
                                type="text" name="bank_account_number" id="bank_account_number"
                                placeholder="Account Number" class="form-control">
                            @error('bank_account_number')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bank_charge" class="form-label">Gateway Charge</label>
                            <input value="{{ old('bank_charge', $bank->charge ?? 0) }}" type="text"
                                name="bank_charge" id="bank_charge" placeholder="Account Gateway Charge"
                                class="form-control">
                            @error('bank_charge')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="bank_status" @checked($bank->status ?? false) class="form-check-input"
                                type="checkbox" value="1" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Enable
                            </label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-outline-success">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
