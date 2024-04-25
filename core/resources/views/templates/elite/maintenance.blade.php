@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    @php
                        echo __($maintenance->data_values->description);
                    @endphp
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        "use strict";
        (function($) {
            $("header").remove();
            $("footer").remove();
        })(jQuery);
    </script>
@endpush


@push('style')
    <style>
        section {
            display: flex;
            align-items: center;
            min-height: 100vh;
        }
    </style>
@endpush
