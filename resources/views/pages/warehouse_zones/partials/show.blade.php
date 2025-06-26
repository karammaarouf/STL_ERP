@extends('../layouts.app')

@section('title', __('Zone Details'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Zone Details') }}: {{ $warehouseZone->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Zone Name') }}:</strong></label>
                    <p>{{ $warehouseZone->name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Zone Code') }}:</strong></label>
                    <p>{{ $warehouseZone->code }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Belongs to Warehouse') }}:</strong></label>
                    <p>{{ $warehouseZone->warehouse->name ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Creation Date') }}:</strong></label>
                    <p>{{ $warehouseZone->created_at->format('Y-m-d H:i A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Last Updated') }}:</strong></label>
                    <p>{{ $warehouseZone->updated_at->format('Y-m-d H:i A') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            @can('edit-warehouse-zone')
                <a href="{{ route('warehouse-zones.edit', $warehouseZone->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
            @endcan
            <a class="btn btn-light" href="{{ route('warehouse-zones.index') }}">{{ __('Back to List') }}</a>
        </div>
    </div>
</div>
@endsection
