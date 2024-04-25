@extends($activeTemplate . 'layouts.master_without_menu')
@section('content')
        <form action="{{ route('ticket.store') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form--label">@lang('Subject')</label>
                        <input class="form--control " name="subject" required type="text" value="{{ old('subject') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form--label">@lang('Priority')</label>
                        <select class="form--control " name="priority" required>
                            <option value="3">@lang('High')</option>
                            <option value="2">@lang('Medium')</option>
                            <option value="1">@lang('Low')</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form--label">@lang('Message')</label>
                        <textarea class="form--control " id="inputMessage" name="message" required rows="6">{{ old('message') }}</textarea>
                    </div>
                </div>
            </div>

            <div>
                <div class="text-end">
                    <button class="btn btn--base-two btn--sm mt-4 addFile" type="button">
                        <i class="fa fa-plus"></i> @lang('Add New')
                    </button>
                </div>
                <div class="file-upload">
                    <label class="form--label">@lang('Attachments')</label> <small class="text-danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small>
                    <input class="form-control form--control custom-input-field mb-2" id="inputAttachments" name="attachments[]" type="file" />
                    <div id="fileUploadsContainer"></div>
                    <p class="ticket-attachments-message text-muted">
                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                    </p>
                </div>
            </div>

            <div class="text-end mt-4">
                <button class="btn btn--base-two" type="submit">@lang('Submit')</button>
            </div>
        </form>
@endsection

@push('breadcrumb-plugins')
    <a class="ptable-header-right__link" href="{{ route('ticket.index') }}">
        <span class="icon"><i class="las la-list"></i></span>
        <span class="text">@lang('All Tickets')</span>
    </a>
@endpush

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control custom-input-field" required />
                        <button type="button" class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
