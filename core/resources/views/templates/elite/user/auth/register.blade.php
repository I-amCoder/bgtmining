@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = getContent('registration.content', true);
        $policyElements = getContent('policy_pages.element');
    @endphp
    <section class="account">
        <div class="account-inner">
            <div class="account-left">
                <div class="account-left__thumb">
                    <img alt="Thumb" src="{{ getImage('assets/images/frontend/registration/' . @$content->data_values->image, '735x605') }}">
                </div>
            </div>
            <div class="account-right">
                <div class="account-form-wrapper">
                    <h1 class="title">{{ __($pageTitle) }}</h1>
                    <h5 class="sub-title">{{ __(@$content->data_values->heading) }}</h5>
                    <p class="desc">{{ __(@$content->data_values->subheading) }}</p>
                    <form action="{{ route('user.register') }}" class="account-form" method="post" onsubmit="return submitUserForm();">
                        @csrf

                        @if (session()->get('reference') != null)
                            <div class="form-group">
                                <label class="form--label">@lang('Referred By')</label>
                                <input class="form--control" id="referenceBy" name="referBy" readonly type="text" value="{{ session()->get('reference') }}">
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="form--label">@lang('Username')</label>
                            <input class="form--control checkUser" id="username" name="username" required type="text" value="{{ old('username') }}">
                            <small class="text-danger usernameExist"></small>
                        </div>
                        <div class="form-group">
                            <label class="form--label">@lang('Email Address')</label>
                            <input class="form--control checkUser" id="email" name="email" required type="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label class="form--label">@lang('Country')</label>
                            <select class="select form--control" id="country" name="country" required>
                                @foreach ($countries as $key => $country)
                                    <option data-code="{{ $key }}" data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}">{{ __($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form--label">@lang('Mobile')</label>
                            <div class="input-group">
                                <span class="input-group-text mobile-code">

                                </span>
                                <input name="mobile_code" type="hidden">
                                <input name="country_code" type="hidden">

                                <input class="form-control form--control checkUser" name="mobile" placeholder="@lang('Your Phone Number')" required type="number" value="{{ old('mobile') }}">
                            </div>
                            <small class="text-danger mobileExist"></small>
                        </div>

                        <div class="form-group">
                            <label class="form--label">@lang('Password')</label>
                            <div class="position-relative">
                                <input class="form--control  @if ($general->secure_password) secure-password @endif" id="password" name="password" required type="password">
                                <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form--label">@lang('Confirm Password')</label>
                            <div class="position-relative">
                                <input class="form--control" id="password_confirmation" name="password_confirmation" required type="password">
                                <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password_confirmation"></div>
                            </div>
                        </div>

                        @if ($general->agree)
                            <div class="form-group d-flex align-items-center justify-content-start">
                                <input @checked(old('agree')) class="form-check-input" id="agree" name="agree" required type="checkbox">
                                <label class="form-check-label" for="agree">@lang('I agree with')</label>
                                @foreach ($policyElements as $policy)
                                    <a class="link" href="{{ route('policy.pages', encrypt([slug(@$policy->data_values->title), $policy->id])) }}" target="_blank">{{ __($policy->data_values->title) }}</a>
                                    @if (!$loop->last)
                                        ,&nbsp;
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <x-captcha :path="$activeTemplate . 'partials.'" />

                        <div class="form-group">
                            <button class="btn btn--base-two w-100" id="recaptcha" type="submit">@lang('Register Now')</button>
                        </div>
                        <div class="form-group mb-0">
                            <p class="switch text-center">@lang('Already have an account?') <a class="link" href="{{ route('user.login') }}">@lang('Login')</a></p>
                        </div>
                    </form>
                </div>

                <div class="account-footer">
                    <p class="account-footer__text">
                        &copy; {{ date('Y') }}
                        <a href="{{ route('home') }}" class="text--base">
                            {{ __(gs('site_name')) }}
                        </a>
                        @lang('All Rights Reserved')
                    </p>
                    <div class="account-footer__right">
                        @foreach ($policyElements as $policy)
                            <a class="account-footer__right-link" href="{{ route('policy.pages', encrypt([slug(@$policy->data_values->title), $policy->id])) }}">{{ __($policy->data_values->title) }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="custom--modal order-modal modal fade" id="existModalCenter" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i></button>
                <div class="modal-body text-center">
                    <h4 class="notice-text">@lang('You are with us')</h4>
                    @lang('You already have an account please Login')
                    <div class="buttons">
                        <a class="btn btn--xm btn--base mt-2" href="{{ route('user.login') }}">@lang('Login')</a>
                    </div>
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

@push('style')
    <style>
        .custom--modal .modal-body .notice-text {
            margin-bottom: 18px;
        }
    </style>
@endpush
