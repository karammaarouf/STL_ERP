@extends('../layouts.app')

@section('title', 'إضافة دولة جديدة')

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>إضافة دولة جديدة</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('countries.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">اسم الدولة</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="iso_code">رمز الدولة (3 أحرف)</label>
                            <input class="form-control @error('iso_code') is-invalid @enderror" type="text" id="iso_code" name="iso_code" value="{{ old('iso_code') }}" maxlength="3" required>
                            @error('iso_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">حفظ</button>
                    <a class="btn btn-light" href="{{ route('countries.index') }}">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
