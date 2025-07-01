@extends('../layouts.app')

@section('title', __('Edit Pallet'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Edit Pallet') }}: {{ $pallet->barcode }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pallets.update', $pallet->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="barcode">{{ __('Barcode') }}</label>
                        <input class="form-control @error('barcode') is-invalid @enderror" type="text" id="barcode" name="barcode" value="{{ old('barcode', $pallet->barcode) }}" required>
                        @error('barcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="warehouse_id">{{ __('Warehouse') }}</label>
                        <select name="warehouse_id" id="warehouse_id" class="form-control @error('warehouse_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Warehouse') }}</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ old('warehouse_id', $pallet->warehouse_id) == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                        @error('warehouse_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="status">{{ __('Status') }}</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="empty" {{ old('status', $pallet->status) == 'empty' ? 'selected' : '' }}>{{ __('Empty') }}</option>
                            <option value="loaded" {{ old('status', $pallet->status) == 'loaded' ? 'selected' : '' }}>{{ __('Loaded') }}</option>
                            <option value="reserved" {{ old('status', $pallet->status) == 'reserved' ? 'selected' : '' }}>{{ __('Reserved') }}</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="current_weight">{{ __('Current Weight') }}</label>
                        <input class="form-control @error('current_weight') is-invalid @enderror" type="number" step="0.01" id="current_weight" name="current_weight" value="{{ old('current_weight', $pallet->current_weight) }}" required>
                        @error('current_weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="current_volume">{{ __('Current Volume') }}</label>
                        <input class="form-control @error('current_volume') is-invalid @enderror" type="number" step="0.01" id="current_volume" name="current_volume" value="{{ old('current_volume', $pallet->current_volume) }}" required>
                        @error('current_volume')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
                    <a class="btn btn-light" href="{{ route('pallets.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection