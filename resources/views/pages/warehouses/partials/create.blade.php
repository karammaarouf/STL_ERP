@extends('../layouts.app')

@section('title', __('Add New Warehouse'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Add New Warehouse') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('warehouses.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="name">{{ __('Warehouse Name') }}</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="code">{{ __('Warehouse Code') }}</label>
                        <input class="form-control @error('code') is-invalid @enderror" type="text" id="code" name="code" value="{{ old('code') }}" required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="city_id">{{ __('City') }}</label>
                        <select name="city_id" id="city_id" class="form-control select2 @error('city_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select City') }}</option>
                        </select>
                        @error('city_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="type">{{ __('Warehouse Type') }}</label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="main" {{ old('type') == 'main' ? 'selected' : '' }}>{{ __('Main') }}</option>
                            <option value="branch" {{ old('type') == 'branch' ? 'selected' : '' }}>{{ __('Branch') }}</option>
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="total_capacity_weight">{{ __('Capacity (Weight)') }}</label>
                        <input class="form-control @error('total_capacity_weight') is-invalid @enderror" type="number" step="0.01" id="total_capacity_weight" name="total_capacity_weight" value="{{ old('total_capacity_weight', 0) }}">
                        @error('total_capacity_weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="total_capacity_volume">{{ __('Capacity (Volume)') }}</label>
                        <input class="form-control @error('total_capacity_volume') is-invalid @enderror" type="number" step="0.01" id="total_capacity_volume" name="total_capacity_volume" value="{{ old('total_capacity_volume', 0) }}">
                        @error('total_capacity_volume')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                    <a class="btn btn-light" href="{{ route('warehouses.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#city_id').select2({
            placeholder: "{{ __('Search for a city...') }}",
            minimumInputLength: 0,
            allowClear: true,
            
            ajax: {
                url: '{{ route("api.cities.search") }}',
                dataType: 'json',
                delay: 500,
                data: function(params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.data,
                        pagination: data.pagination
                    };
                },
                cache: true
            }
        });
        
        // تحميل أول 5 مدن افتراضياً
        $.ajax({
            url: '{{ route("api.cities.search") }}',
            dataType: 'json',
            data: {
                search: '',
                page: 1
            },
            success: function(data) {
                if (data.data.length > 0) {
                    var defaultOptions = data.data.map(function(city) {
                        return new Option(city.text, city.id, false, false);
                    });
                    $('#city_id').append(defaultOptions).trigger('change');
                }
            }
        });
    });
</script>
@endpush
