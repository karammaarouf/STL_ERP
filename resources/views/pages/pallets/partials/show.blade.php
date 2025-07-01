@extends('../layouts.app')

@section('title', __('Pallet Details'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Pallet Details') }}: {{ $pallet->barcode }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Barcode') }}:</strong></label>
                    <p>{{ $pallet->barcode }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Warehouse') }}:</strong></label>
                    <p>{{ $pallet->warehouse->name ?? __('N/A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Status') }}:</strong></label>
                    <p>{{ __(ucfirst($pallet->status)) }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Current Weight') }}:</strong></label>
                    <p>{{ $pallet->current_weight }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Current Volume') }}:</strong></label>
                    <p>{{ $pallet->current_volume }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Creation Date') }}:</strong></label>
                    <p>{{ $pallet->created_at->format('Y-m-d H:i A') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>{{ __('Last Updated') }}:</strong></label>
                    <p>{{ $pallet->updated_at->format('Y-m-d H:i A') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            @can('edit-pallet')
                <a href="{{ route('pallets.edit', $pallet->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
            @endcan
            <a class="btn btn-light" href="{{ route('pallets.index') }}">{{ __('Back to List') }}</a>
        </div>
    </div>
</div>
@endsection