@extends('../layouts.app')

@push('styles')
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary fw-bold">{{ __('Warehouse Management') }}</h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="locations-container">
                    <!-- Warehouses Column -->
                    @include('pages.warehouses_management.partials.warehouses-column')

                    <!-- Zones Column -->
                    @include('pages.warehouses_management.partials.zones-column')

                    <!-- Sections Column -->
                    @include('pages.warehouses_management.partials.sections-column')

                    <!-- Racks Column -->
                    @include('pages.warehouses_management.partials.racks-column')

                    <!-- Slots Column -->
                    @include('pages.warehouses_management.partials.slots-column')

                </div>
            </div>
        </div>
    </div>
@endsection

@include('pages.warehouses_management.partials.styles')