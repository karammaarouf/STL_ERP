@extends('../layouts.app')

@section('title', __('Add New Slot'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Add New Slot') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('warehouse-slots.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="code">{{ __('Slot Code') }}</label>
                        <input class="form-control @error('code') is-invalid @enderror" type="text" id="code" name="code" value="{{ old('code') }}" required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="rack_id">{{ __('Rack') }}</label>
                        <select name="rack_id" id="rack_id" class="form-control @error('rack_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Rack') }}</option>
                            @foreach ($racks as $rack)
                                <option value="{{ $rack->id }}" {{ old('rack_id') == $rack->id ? 'selected' : '' }}>{{ $rack->code }} ({{ $rack->section->name ?? 'N/A' }} - {{ $rack->section->zone->name ?? 'N/A' }} - {{ $rack->section->zone->warehouse->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                        @error('rack_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="max_weight">{{ __('Max Weight (kg)') }}</label>
                        <input class="form-control @error('max_weight') is-invalid @enderror" type="number" step="0.01" id="max_weight" name="max_weight" value="{{ old('max_weight') }}" required>
                        @error('max_weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="max_volume">{{ __('Max Volume (m³)') }}</label>
                        <input class="form-control @error('max_volume') is-invalid @enderror" type="number" step="0.01" id="max_volume" name="max_volume" value="{{ old('max_volume') }}" required>
                        @error('max_volume')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="current_weight">{{ __('Current Weight (kg)') }}</label>
                        <input class="form-control @error('current_weight') is-invalid @enderror" type="number" step="0.01" id="current_weight" name="current_weight" value="{{ old('current_weight', 0) }}">
                        @error('current_weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="current_volume">{{ __('Current Volume (m³)') }}</label>
                        <input class="form-control @error('current_volume') is-invalid @enderror" type="number" step="0.01" id="current_volume" name="current_volume" value="{{ old('current_volume', 0) }}">
                        @error('current_volume')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                    <a class="btn btn-light" href="{{ route('warehouse-slots.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection