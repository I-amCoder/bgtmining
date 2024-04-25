@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $registrationContent = getContent('registration.content', true);
        $policyElements = getContent('policy_pages.element');
    @endphp

    <section class="account-section style--two">
        <div class="left">
            <div class="line-bg">
                <img alt="image" src="{{ asset($activeTemplateTrue . 'images/line-bg.png') }}">
            </div>
            <div class="account-form-area">
                <div class="text-center">
                    <a class="account-logo" href="{{ url('/') }}"><img alt="image" src="{{ getImage('assets/images/logoIcon/logo.png') }}"></a>
                </div>

                <form action="{{ route('user.register') }}" class="mt-5" method="POST" onsubmit="return submitUserForm();">
                    @csrf

                    <div class="row">
                        @if (session()->get('reference') != null)
                            <div class="form-group col-sm-12">
                                <label>@lang('Referred By')</label>
                                <input class="form-control" id="referenceBy" name="referBy" readonly type="text" value="{{ session()->get('reference') }}">
                            </div>
                        @endif

                        <div class="form-group col-sm-6">
                            <label>@lang('Username')</label>
                            <input class="form-control checkUser" id="username" name="username" required type="text" value="{{ old('username') }}">
                            <small class="text-danger usernameExist"></small>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>@lang('Email Address')</label>
                            <input class="form-control checkUser" id="email" name="email" required type="email" value="{{ old('email') }}">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>@lang('Country')</label>
                            <select class="form-control" id="country" name="country" required>
                                @foreach ($countries as $key => $country)
                                    <option data-code="{{ $key }}" data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}">{{ __($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>@lang('Mobile')</label>
                            <div class="input-group ">
                                <span class="input-group-text mobile-code">

                                </span>
                                <input name="mobile_code" type="hidden">
                                <input name="country_code" type="hidden">

                                <input class="form-control checkUser" name="mobile" placeholder="@lang('Your Phone Number')" required type="number" value="{{ old('mobile') }}">
                            </div>
                            <small class="text-danger mobileExist"></small>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>@lang('Password')</label>
                            <input class="form-control  @if($general->secure_password) secure-password @endif" name="password" required type="password">
                        </div>

                        <div class="form-group col-sm-6">
                            <label>@lang('Confirm Password')</label>
                            <input class="form-control" name="password_confirmation" required type="password">
                        </div>
                    </div>

                    @if ($general->agree)
                        <div class="form-group custom-checkbox mt-2">
                            <input @checked(old('agree')) class="form-check-input" id="agree" name="agree" type="checkbox">
                            <label class="form-check-label" for="agree">
                                @lang('I agree with')&nbsp;
                                @foreach ($policyElements as $policy)
                                    <a class="text--base" href="{{ route('policy.pages', encrypt([slug(@$policy->data_values->title), $policy->id])) }}" target="_blank">{{ __($policy->data_values->title) }}</a>
                                    @if (!$loop->last)
                                        ,&nbsp;
                                    @endif
                                @endforeach
                            </label>
                        </div>
                    @endif

                    <x-captcha />

                    <div>
                        <button class="btn--base w-100" id="recaptcha" type="submit">@lang('Register Now')</button>
                    </div>
                    <div class="row align-items-center mt-3">
                        <div class="col-lg-12">
                            <p>@lang('Already Have An Account')? <a class="mt-3 base--color" href="{{ route('user.login') }}">@lang('Login Now')</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="right bg_img" data-background="{{ getImage('assets/images/frontend/registration/' . @$registrationContent->data_values->image, '1150x950') }}">
            <div class="content text-center">
                <h2 class="text-white mb-4">{{ __(@$registrationContent->data_values->heading) }}</h2>
                <p class="text-white">{{ __(@$registrationContent->data_values->sub_heading) }}</p>
            </div>
        </div>
    </section>

    <div aria-hidden="true" aria-labelledby="existModalCenterTitle" class="modal fade" id="existModalCenter" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login')</h6>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-sm btn--base" href="{{ route('user.login') }}">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
