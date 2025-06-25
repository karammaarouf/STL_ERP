@extends('../layouts.app')

@section('title', __('Province Details'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('Province Details') }}: {{ $state->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Province Name') }}:</strong></label>
                        <p>{{ $state->name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Country Name') }}:</strong></label>
                        <p>{{ $state->country->name }}</p>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Creation Date') }}:</strong></label>
                        <p>{{ $state->created_at->format('Y-m-d H:i A') }}</p>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Last Updated') }}:</strong></label>
                        <p>{{ $state->updated_at->format('Y-m-d H:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
             @can('edit-state')
                <a href="{{ route('states.edit', $state->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
             @endcan
            <a class="btn btn-light" href="{{ route('states.index') }}">{{ __('Back to List') }}</a>
        </div>
    </div>
</div>
@endsection