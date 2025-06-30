@extends('../layouts.app')

@section('title', __('Add New Province'))

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Add New Province') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('states.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="name">{{ __('Province Name') }}</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="country_id">{{ __('Country') }}</label>
                                <select name="country_id" id="country_id" class="form-control select2 @error('country_id') is-invalid @enderror" required>
                                    <option value="">{{ __('Select Country') }}</option>
                                </select>
                                @error('country_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                        <a class="btn btn-light" href="{{ route('states.index') }}">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $('#country_id').select2({
            placeholder: '{{ __('Select Country') }}',
            allowClear: true,
            ajax: {
                url: '{{ route("api.countries.search") }}',
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

        // Load initial countries
        $.ajax({
            url: '{{ route("api.countries.search") }}',
            dataType: 'json',
            data: { search: '', page: 1 },
            success: function(data) {
                // Create the default option
                var defaultOption = new Option('{{ __('Select Country') }}', '', true, false);
                $('#country_id').append(defaultOption);

                // Add the retrieved options
                if (data.data) {
                    data.data.forEach(function(item) {
                        var option = new Option(item.text, item.id, false, false);
                        $('#country_id').append(option);
                    });
                }

                // Set selected value if exists
                @if(old('country_id'))
                    var oldValue = {{ old('country_id') }};
                    $('#country_id').val(oldValue).trigger('change');
                @endif

                $('#country_id').trigger('change');
            }
        });
    });
</script>
@endpush