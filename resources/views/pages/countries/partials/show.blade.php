@extends('../layouts.app')

@section('title', 'تفاصيل الدولة')

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>تفاصيل الدولة: {{ $country->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>اسم الدولة:</strong></label>
                        <p>{{ $country->name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>رمز الدولة:</strong></label>
                        <p>{{ $country->iso_code }}</p>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>تاريخ الإنشاء:</strong></label>
                        <p>{{ $country->created_at->format('Y-m-d H:i A') }}</p>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>تاريخ آخر تحديث:</strong></label>
                        <p>{{ $country->updated_at->format('Y-m-d H:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
             @can('edit-country')
                <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-primary">تعديل</a>
             @endcan
            <a class="btn btn-light" href="{{ route('countries.index') }}">الرجوع إلى القائمة</a>
        </div>
    </div>
</div>
@endsection
