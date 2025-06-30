@extends('../layouts.app')

@section('title', __('Add New City'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Add New City') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('cities.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">{{ __('City Name') }}</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="state_id">{{ __('State') }}</label>
                            <select name="state_id" id="state_id" class="form-control select2 @error('state_id') is-invalid @enderror" required>
                                <option value="">{{ __('Select State') }}</option>
                            </select>
                            @error('state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                    <a class="btn btn-light" href="{{ route('cities.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#state_id').select2({
            placeholder: '{{ __('Select State') }}',
            allowClear: true,
            ajax: {
                url: '{{ route("api.states.search") }}',
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
                        results: data.data,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 0
        });

        // Load initial states
        $.ajax({
            url: '{{ route("api.states.search") }}',
            dataType: 'json',
            data: { search: '', page: 1 },
            success: function(data) {
                if (data.data) {
                    data.data.forEach(function(item) {
                        var option = new Option(item.text, item.id, false, false);
                        $('#state_id').append(option);
                    });
                }

                // Set selected value if exists
                @if(old('state_id'))
                    var oldValue = {{ old('state_id') }};
                    $('#state_id').val(oldValue).trigger('change');
                @endif

                $('#state_id').trigger('change');
            }
        });
    });
</script>
@endpush
