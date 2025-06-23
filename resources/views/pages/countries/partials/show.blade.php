@extends('../layouts.app')

@section('title', __('Country Details'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('Country Details') }}: {{ $country->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Country Name') }}:</strong></label>
                        <p>{{ $country->name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Country Code') }}:</strong></label>
                        <p>{{ $country->iso_code }}</p>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Creation Date') }}:</strong></label>
                        <p>{{ $country->created_at->format('Y-m-d H:i A') }}</p>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Last Updated') }}:</strong></label>
                        <p>{{ $country->updated_at->format('Y-m-d H:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
             @can('edit-country')
                <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
             @endcan
            <a class="btn btn-light" href="{{ route('countries.index') }}">{{ __('Back to List') }}</a>
        </div>
    </div>
</div>
@endsection
