@extends('../layouts.app')

@section('title', __('Add New Section'))


@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Add New Section') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('warehouse-sections.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="name">{{ __('Section Name') }}</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="code">{{ __('Section Code') }}</label>
                        <input class="form-control @error('code') is-invalid @enderror" type="text" id="code" name="code" value="{{ old('code') }}" required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="zone_id">{{ __('Zone') }}</label>
                        <select name="zone_id" id="zone_id" class="form-control select2 @error('zone_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Zone') }}</option>
                        </select>
                        @error('zone_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                    <a class="btn btn-light" href="{{ route('warehouse-sections.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $('#zone_id').select2({
            ajax: {
                url: '{{ route("api.zones.search") }}',
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
                        results: data.data.map(function(zone) {
                            return {
                                id: zone.id,
                                text: zone.name + ' (' + (zone.warehouse ? zone.warehouse.name : 'N/A') + ')'
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
            placeholder: '{{ __('Select Zone') }}'
        });

        // Load initial zones
        $.ajax({
            url: '{{ route("api.zones.search") }}',
            dataType: 'json',
            data: { search: '', page: 1 },
            success: function(data) {
                var options = data.data.map(function(zone) {
                    return new Option(zone.name + ' (' + (zone.warehouse ? zone.warehouse.name : 'N/A') + ')', zone.id, false, false);
                });
                $('#zone_id').append(options).trigger('change');

                // Set selected value if exists
                @if(old('zone_id'))
                    var oldValue = {{ old('zone_id') }};
                    $('#zone_id').val(oldValue).trigger('change');
                @endif
            }
        });
    });
</script>
@endpush