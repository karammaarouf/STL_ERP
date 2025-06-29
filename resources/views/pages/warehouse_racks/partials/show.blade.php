@extends('../layouts.app')

@section('title', __('Rack Details'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Rack Details') }}: {{ $warehouseRack->code }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Rack Code') }}:</strong></label>
                    <p>{{ $warehouseRack->code }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Belongs to Section') }}:</strong></label>
                    <p>{{ $warehouseRack->section->name ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Belongs to Zone') }}:</strong></label>
                    <p>{{ $warehouseRack->section->zone->name ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Belongs to Warehouse') }}:</strong></label>
                    <p>{{ $warehouseRack->section->zone->warehouse->name ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Creation Date') }}:</strong></label>
                    <p>{{ $warehouseRack->created_at->format('Y-m-d H:i A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Last Updated') }}:</strong></label>
                    <p>{{ $warehouseRack->updated_at->format('Y-m-d H:i A') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            @can('edit-warehouse-rack')
                <a href="{{ route('warehouse-racks.edit', $warehouseRack->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
            @endcan
            <a class="btn btn-light" href="{{ route('warehouse-racks.index') }}">{{ __('Back to List') }}</a>
        </div>
    </div>
</div>
@endsection