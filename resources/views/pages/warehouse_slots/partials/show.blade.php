@extends('../layouts.app')

@section('title', __('Slot Details'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Slot Details') }}: {{ $warehouseSlot->code }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Slot Code') }}:</strong></label>
                    <p>{{ $warehouseSlot->code }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Belongs to Rack') }}:</strong></label>
                    <p>{{ $warehouseSlot->rack->code ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Belongs to Section') }}:</strong></label>
                    <p>{{ $warehouseSlot->rack->section->name ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Belongs to Zone') }}:</strong></label>
                    <p>{{ $warehouseSlot->rack->section->zone->name ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Belongs to Warehouse') }}:</strong></label>
                    <p>{{ $warehouseSlot->rack->section->zone->warehouse->name ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Max Weight') }}:</strong></label>
                    <p>{{ $warehouseSlot->max_weight }} kg</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Max Volume') }}:</strong></label>
                    <p>{{ $warehouseSlot->max_volume }} m³</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Current Weight') }}:</strong></label>
                    <p>{{ $warehouseSlot->current_weight }} kg</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Current Volume') }}:</strong></label>
                    <p>{{ $warehouseSlot->current_volume }} m³</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Creation Date') }}:</strong></label>
                    <p>{{ $warehouseSlot->created_at->format('Y-m-d H:i A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Last Updated') }}:</strong></label>
                    <p>{{ $warehouseSlot->updated_at->format('Y-m-d H:i A') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            @can('edit-warehouse-slot')
                <a href="{{ route('warehouse-slots.edit', $warehouseSlot->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
            @endcan
            <a class="btn btn-light" href="{{ route('warehouse-slots.index') }}">{{ __('Back to List') }}</a>
        </div>
    </div>
</div>
@endsection