@extends($activeTemplate . 'layouts.master_without_menu')

@section('content')
    <div class="card custom--card">
        <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="mt-0">
                @php echo $myTicket->statusBadge; @endphp

                [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
            </h5>

            @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                <button class="btn btn--danger close-button btn--sm confirmationBtn" data-action="{{ route('ticket.close', $myTicket->id) }}" data-question="@lang('Are you sure you want to close this support ticket?')" type="button">
                    <i class="fa fa-lg fa-times-circle"></i>
                </button>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row justify-content-between">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form--label">@lang('Message')</label>
                            <textarea class="form--control " name="message" required rows="4">{{ old('message') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button class="btn btn--base-two btn--sm addFile" type="button"><i class="fa fa-plus"></i> @lang('Add New')</button>
                </div>
                <div class="form-group">
                    <label class="form--label">@lang('Attachments')</label> <small class="text-danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small>
                    <input class="form--control custom-input-field" name="attachments[]" type="file" />
                    <div id="fileUploadsContainer"></div>
                    <p class="my-2 ticket-attachments-message text-muted">
                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                    </p>
                </div>
                <div class="text-end">
                    <button class="btn btn--base-two" type="submit"> <i class="fa fa-reply"></i> @lang('Reply')</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            @foreach ($messages as $message)
                @if ($message->admin_id == 0)
                    <div class="row border border--base border-radius-3 my-3 py-3 mx-2">
                        <div class="col-md-3 border-end text-end">
                            <h5 class="my-3">{{ $message->ticket->name }}</h5>
                        </div>
                        <div class="col-md-9">
                            <p class="text-muted fw-bold my-3">
                                @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                            <p>{{ $message->message }}</p>
                            @if ($message->attachments->count() > 0)
                                <div class="mt-2">
                                    @foreach ($message->attachments as $k => $image)
                                        <a class="me-3 text--base" href="{{ route('ticket.download', encrypt($image->id)) }}"><i class="fa fa-file"></i> @lang('Attachment') {{ ++$k }} </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="row border border-warning border-radius-3 my-3 py-3 mx-2" style="background-color: #ffd96729">
                        <div class="col-md-3 border-end text-end">
                            <h5 class="my-3">{{ $message->admin->name }}</h5>
                            <p class="lead text-muted">@lang('Staff')</p>
                        </div>
                        <div class="col-md-9">
                            <p class="text-muted fw-bold my-3">
                                @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                            <p>{{ $message->message }}</p>
                            @if ($message->attachments->count() > 0)
                                <div class="mt-2">
                                    @foreach ($message->attachments as $k => $image)
                                        <a class="me-3 text--base" href="{{ route('ticket.download', encrypt($image->id)) }}"><i class="fa fa-file"></i> @lang('Attachment') {{ ++$k }} </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <x-user-confirmation-modal />

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
