@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-12 my-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white">Jazz Cash</h4>
                </div>
                <form action="">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="account_name" class="form-label">Account Holder Name</label>
                            <input type="text" name="account_name" id="account_name" placeholder="Account Holder Name"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="account_number" class="form-label">Account Number</label>
                            <input type="text" name="account_number" id="account_number" placeholder="Account Number"
                                class="form-control">
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
                <form action="">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="account_name" class="form-label">Account Holder Name</label>
                            <input type="text" name="account_name" id="account_name" placeholder="Account Holder Name"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="account_number" class="form-label">Account Number</label>
                            <input type="text" name="account_number" id="account_number" placeholder="Account Number"
                                class="form-control">
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
                <form action="">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="account_name" class="form-label">Account Holder Name</label>
                            <input type="text" name="account_name" id="account_name" placeholder="Account Holder Name"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="account_number" class="form-label">Account Number</label>
                            <input type="text" name="account_number" id="account_number" placeholder="Account Number"
                                class="form-control">
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
