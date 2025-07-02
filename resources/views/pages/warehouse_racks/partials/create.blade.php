@extends('../layouts.app')

@section('title', __('Add New Rack'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Add New Rack') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('warehouse-racks.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="code">{{ __('Rack Code') }}</label>
                        <input class="form-control @error('code') is-invalid @enderror" type="text" id="code" name="code" value="{{ old('code') }}" required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="section_id">{{ __('Section') }}</label>
                        <select name="section_id" id="section_id" class="form-control select2 @error('section_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Section') }}</option>
                        </select>
                        @error('section_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                    <a class="btn btn-light" href="{{ route('warehouse-racks.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $('#section_id').select2({
            ajax: {
                url: '{{ route("api.sections.search") }}',
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
                        results: data.data.map(function(section) {
                            return {
                                id: section.id,
                                text: section.name + ' (' + (section.zone ? section.zone.name : 'N/A') + ' - ' + 
                                      (section.zone && section.zone.warehouse ? section.zone.warehouse.name : 'N/A') + ')'
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
            placeholder: '{{ __('Select Section') }}'
        });

        // Load initial sections
        $.ajax({
            url: '{{ route("api.sections.search") }}',
            dataType: 'json',
            data: { search: '', page: 1 },
            success: function(data) {
                var options = data.data.map(function(section) {
                    return new Option(
                        section.name + ' (' + (section.zone ? section.zone.name : 'N/A') + ' - ' + 
                        (section.zone && section.zone.warehouse ? section.zone.warehouse.name : 'N/A') + ')',
                        section.id,
                        false,
                        false
                    );
                });
                $('#section_id').append(options).trigger('change');

                // Set selected value if exists
                @if(old('section_id'))
                    var oldValue = {{ old('section_id') }};
                    $('#section_id').val(oldValue).trigger('change');
                @endif
            }
        });
    });
</script>
@endpush