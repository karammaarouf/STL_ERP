@extends('../layouts.app')

@section('title', __('Add New Zone'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Add New Zone') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('warehouse-zones.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="name">{{ __('Zone Name') }}</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="code">{{ __('Zone Code') }}</label>
                        <input class="form-control @error('code') is-invalid @enderror" type="text" id="code" name="code" value="{{ old('code') }}" required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="warehouse_id">{{ __('Warehouse') }}</label>
                        <select name="warehouse_id" id="warehouse_id" class="form-control select2 @error('warehouse_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Warehouse') }}</option>
                        </select>
                        @error('warehouse_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                    <a class="btn btn-light" href="{{ route('warehouse-zones.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $('#warehouse_id').select2({
            ajax: {
                url: '{{ route("api.warehouses.search") }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(function(warehouse) {
                            return {
                                id: warehouse.id,
                                text: warehouse.name + ' (' + warehouse.code + ')'
                            };
                        }),
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            placeholder: '{{ __('Select Warehouse') }}'
        });

        // Load initial warehouses
        $.ajax({
            url: '{{ route("api.warehouses.search") }}',
            dataType: 'json',
            data: { search: '', page: 1 },
            success: function(data) {
                var options = data.data.map(function(warehouse) {
                    return new Option(warehouse.name + ' (' + warehouse.code + ')', warehouse.id, false, false);
                });
                $('#warehouse_id').append(options).trigger('change');

                // Set selected value if exists
                @if(old('warehouse_id'))
                    var oldValue = {{ old('warehouse_id') }};
                    $('#warehouse_id').val(oldValue).trigger('change');
                @endif
            }
        });
    });
</script>
@endpush
