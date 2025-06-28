@extends('../layouts.app')

@section('title', __('Edit Country'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Edit Country') }}: {{ $country->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('countries.update', $country->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Required for update route --}}

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">{{ __('Country Name') }}</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $country->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="iso_code">{{ __('Country Code (2 characters)') }}</label>
                            <div class="input-group">
                                <input class="form-control @error('iso_code') is-invalid @enderror" type="text" id="iso_code" name="iso_code" value="{{ old('iso_code', $country->iso_code) }}" maxlength="3" required>
                                <span class="input-group-text" id="flag-display" style="min-width: 60px; justify-content: center;">
                                    <img id="country-flag" src="" alt="" style="width: 32px; height: 24px; display: none; border-radius: 3px;">
                                    <span id="flag-placeholder" class="text-muted">🏳️</span>
                                </span>
                            </div>
                            @error('iso_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
                    <a class="btn btn-light" href="{{ route('countries.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const isoCodeInput = $('#iso_code');
    const countryFlag = $('#country-flag');
    const flagPlaceholder = $('#flag-placeholder');
    
    // Function to update flag display
    function updateFlag(isoCode) {
        if (isoCode && isoCode.length >= 2) {
            const flagUrl = `https://flagcdn.com/32x24/${isoCode.toLowerCase()}.png`;
            
            // Test if flag exists
            const img = new Image();
            img.onload = function() {
                countryFlag.attr('src', flagUrl);
                countryFlag.attr('alt', `${isoCode.toUpperCase()} Flag`);
                countryFlag.show();
                flagPlaceholder.hide();
            };
            img.onerror = function() {
                countryFlag.hide();
                flagPlaceholder.show();
            };
            img.src = flagUrl;
        } else {
            countryFlag.hide();
            flagPlaceholder.show();
        }
    }
    
    // Update flag on input
    isoCodeInput.on('input', function() {
        const value = $(this).val().trim();
        updateFlag(value);
    });
    
    // Initial load for edit form
    updateFlag(isoCodeInput.val());
});
</script>
@endpush
