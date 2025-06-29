@extends('../layouts.app')

@section('title', __('Section Details'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Section Details') }}: {{ $warehouseSection->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Section Name') }}:</strong></label>
                    <p>{{ $warehouseSection->name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Section Code') }}:</strong></label>
                    <p>{{ $warehouseSection->code }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Belongs to Zone') }}:</strong></label>
                    <p>{{ $warehouseSection->zone->name ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Belongs to Warehouse') }}:</strong></label>
                    <p>{{ $warehouseSection->zone->warehouse->name ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Creation Date') }}:</strong></label>
                    <p>{{ $warehouseSection->created_at->format('Y-m-d H:i A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Last Updated') }}:</strong></label>
                    <p>{{ $warehouseSection->updated_at->format('Y-m-d H:i A') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            @can('edit-warehouse-section')
                <a href="{{ route('warehouse-sections.edit', $warehouseSection->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
            @endcan
            <a class="btn btn-light" href="{{ route('warehouse-sections.index') }}">{{ __('Back to List') }}</a>
        </div>
    </div>
</div>
@endsection