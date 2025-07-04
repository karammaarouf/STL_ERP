@extends('../layouts.app')

@section('title', __('City Details'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('City Details') }}: {{ $city->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('City Name') }}:</strong></label>
                        <p>{{ $city->name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('State Name') }}:</strong></label>
                        <p>{{ $city->state->name ?? __('Not Found') }}</p>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Creation Date') }}:</strong></label>
                        <p>{{ $city->created_at->format('Y-m-d H:i A') }}</p>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Last Updated') }}:</strong></label>
                        <p>{{ $city->updated_at->format('Y-m-d H:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
             @can('edit-city')
                 <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
             @endcan
            <a class="btn btn-light" href="{{ route('cities.index') }}">{{ __('Back to List') }}</a>
        </div>
    </div>
</div>
@endsection
