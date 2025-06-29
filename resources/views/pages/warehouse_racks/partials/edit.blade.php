@extends('../layouts.app')

@section('title', __('Edit Rack'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Edit Rack') }}: {{ $warehouseRack->code }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('warehouse-racks.update', $warehouseRack->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="code">{{ __('Rack Code') }}</label>
                        <input class="form-control @error('code') is-invalid @enderror" type="text" id="code" name="code" value="{{ old('code', $warehouseRack->code) }}" required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="section_id">{{ __('Section') }}</label>
                        <select name="section_id" id="section_id" class="form-control @error('section_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Section') }}</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}" {{ old('section_id', $warehouseRack->section_id) == $section->id ? 'selected' : '' }}>{{ $section->name }} ({{ $section->zone->name ?? 'N/A' }} - {{ $section->zone->warehouse->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                        @error('section_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
                    <a class="btn btn-light" href="{{ route('warehouse-racks.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection