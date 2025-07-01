@extends('../layouts.app')

@section('title', __('Add New Pallet'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Add New Pallet') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pallets.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="barcode">{{ __('Barcode') }}</label>
                        <input class="form-control @error('barcode') is-invalid @enderror" type="text" id="barcode" name="barcode" value="{{ old('barcode') }}" required>
                        @error('barcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="warehouse_id">{{ __('Warehouse') }}</label>
                        <select name="warehouse_id" id="warehouse_id" class="form-control select2 @error('warehouse_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Warehouse') }}</option>
                        </select>
                        @error('warehouse_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="status">{{ __('Status') }}</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="empty" {{ old('status') == 'empty' ? 'selected' : '' }}>{{ __('Empty') }}</option>
                            <option value="loaded" {{ old('status') == 'loaded' ? 'selected' : '' }}>{{ __('Loaded') }}</option>
                            <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>{{ __('Reserved') }}</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="current_weight">{{ __('Current Weight') }}</label>
                        <input class="form-control @error('current_weight') is-invalid @enderror" type="number" step="0.01" id="current_weight" name="current_weight" value="{{ old('current_weight', 0.00) }}" required>
                        @error('current_weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="current_volume">{{ __('Current Volume') }}</label>
                        <input class="form-control @error('current_volume') is-invalid @enderror" type="number" step="0.01" id="current_volume" name="current_volume" value="{{ old('current_volume', 0.00) }}" required>
                        @error('current_volume')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                    <a class="btn btn-light" href="{{ route('pallets.index') }}">{{ __('Cancel') }}</a>
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
                                text: warehouse.name
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
                    return new Option(warehouse.name, warehouse.id, false, false);
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