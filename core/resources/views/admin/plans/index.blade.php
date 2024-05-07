@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-header">
                    <button class="btn btn-outline-success float-end add-plan">Create +</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Interest')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($plans  as $plan)
                                    <tr>
                                        <td>{{ $plan->plan_name }}</td>
                                        <td>{{ $plan->price }}</td>
                                        <td>{{ $plan->return_interest . ($plan->return_type == 1 ? ' %' : '') }}</td>
                                        <td>{{ $plan->status }}</td>
                                        <td>
                                            <button data-href="{{ route('admin.plans.update', $plan->id) }}"
                                                data-name="{{ $plan->plan_name }}" data-price="{{ $plan->price }}"
                                                data-return_interest="{{ $plan->return_interest }}"
                                                data-return_type="{{ $plan->return_type }}"
                                                class="btn btn-outline-warning btn-sm edit-plan"><i
                                                    class="fa fa-edit"></i></button>
                                            <button data-href="{{ route('admin.plans.delete',$plan->id) }}" class="btn btn-outline-danger btn-sm delete-plan"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100">Currently you don't have any plans</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="planModalLabel">Plan Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="_method">
                        <div class="form-group">
                            <label for="plan_name" class="form-label">Plan Name</label>
                            <input type="text" class="form-control @error('plan_name') is-invalid @enderror"
                                name="plan_name" id="plan_name" required placeholder="Plan Name">
                            @error('plan_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price" class="form-label">Plan Price</label>
                            <input type="number" step="any" class="form-control @error('price') is-invalid @enderror" name="price"
                                id="price" required placeholder="Plan Price">
                            @error('price')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="return_interest" class="form-label">Daily Mining</label>
                            <input type="number" step="any" class="form-control @error('return_interest') is-invalid @enderror"
                                name="return_interest" id="return_interest" required placeholder="Return Interest">
                            @error('return_interest')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="return_type" class="form-label">Mining Type</label>
                            <select class="form-control @error('return_type') is-invalid @enderror" name="return_type"
                                id="return_type" required>
                                <option value="0">Fixed</option>
                                <option value="1">Percentage</option>
                            </select>
                            @error('return_type')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletePlanModal" tabindex="-1" aria-labelledby="deletePlanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePlanModalLabel">Delete Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <p>Are you sure to delete this plan</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete Plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(".add-plan").click(function(e) {
            e.preventDefault();
            let modal = $("#planModal");
            modal.find('form').attr('action', "{{ route('admin.plans.store') }}");
            modal.find('input[name=_method]').val('post');
            modal.find('input[name=plan_name]').val('');
            modal.find('input[name=price]').val('');
            modal.find('input[name=return_interest]').val('');
            modal.find('select[name=return_type]').val(0);
            modal.modal('show');
        });

        $(".edit-plan").click(function(e) {
            e.preventDefault();
            let modal = $("#planModal");
            modal.find('form').attr('action', $(this).data('href'));
            modal.find('input[name=_method]').val('put');
            modal.find('input[name=plan_name]').val($(this).data('name'));
            modal.find('input[name=price]').val($(this).data('price'));
            modal.find('input[name=return_interest]').val($(this).data('return_interest'));
            modal.find('select[name=return_type]').val($(this).data('return_type'));
            modal.modal('show');
        });

        $(".delete-plan").click(function (e) {
            e.preventDefault();
            let modal = $("#deletePlanModal");
            modal.find('form').attr('action', $(this).data('href'));
            modal.modal('show');
        });
    </script>
@endpush
