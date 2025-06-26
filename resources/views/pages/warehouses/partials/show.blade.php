@extends('../layouts.app')

@section('title', __('Warehouse Details'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('Warehouse Details') }}: {{ $warehouse->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Warehouse Name') }}:</strong></label>
                    <p>{{ $warehouse->name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Warehouse Code') }}:</strong></label>
                    <p>{{ $warehouse->code }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('City') }}:</strong></label>
                    <p>{{ $warehouse->city->name ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Warehouse Type') }}:</strong></label>
                    <p>{{ __($warehouse->type) }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Capacity (Weight)') }}:</strong></label>
                    <p>{{ $warehouse->total_capacity_weight }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Capacity (Volume)') }}:</strong></label>
                    <p>{{ $warehouse->total_capacity_volume }}</p>
                </div>
                 <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Creation Date') }}:</strong></label>
                    <p>{{ $warehouse->created_at->format('Y-m-d H:i A') }}</p>
                </div>
                 <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Last Updated') }}:</strong></label>
                    <p>{{ $warehouse->updated_at->format('Y-m-d H:i A') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
             @can('edit-warehouse')
                <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
             @endcan
            <a class="btn btn-light" href="{{ route('warehouses.index') }}">{{ __('Back to List') }}</a>
        </div>
    </div>
</div>
@endsection
