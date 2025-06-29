@extends('../layouts.app')

@section('title', __('Warehouse Slots'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ __('Warehouse Slot List') }}</h5>
                        @can('create-warehouse-slot')
                            <a href="{{ route('warehouse-slots.create') }}" class="btn btn-primary">{{ __('Add New Slot') }}</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Slot Code') }}</th>
                                    <th scope="col">{{ __('Rack Code') }}</th>
                                    <th scope="col">{{ __('Section Name') }}</th>
                                    <th scope="col">{{ __('Zone Name') }}</th>
                                    <th scope="col">{{ __('Warehouse Name') }}</th>
                                    <th scope="col">{{ __('Max Weight') }}</th>
                                    <th scope="col">{{ __('Max Volume') }}</th>
                                    @canany(['edit-warehouse-slot', 'delete-warehouse-slot', 'show-warehouse-slot'])
                                        <th class="text-center" scope="col">{{ __('Options') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($warehouseSlots as $slot)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $slot->code }}</td>
                                        <td>{{ $slot->rack->code ?? __('N/A') }}</td>
                                        <td>{{ $slot->rack->section->name ?? __('N/A') }}</td>
                                        <td>{{ $slot->rack->section->zone->name ?? __('N/A') }}</td>
                                        <td>{{ $slot->rack->section->zone->warehouse->name ?? __('N/A') }}</td>
                                        <td>{{ $slot->max_weight }} kg</td>
                                        <td>{{ $slot->max_volume }} m³</td>
                                        @canany(['edit-warehouse-slot', 'delete-warehouse-slot', 'show-warehouse-slot'])
                                            <td class="text-center align-middle border-1">
                                                <div class="d-flex gap-1 justify-content-center align-items-center">
                                                    @can('show-warehouse-slot')
                                                        <a href="{{ route('warehouse-slots.show', $slot->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="{{ __('Details') }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan

                                                    @can('edit-warehouse-slot')
                                                        <a href="{{ route('warehouse-slots.edit', $slot->id) }}"
                                                            class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete-warehouse-slot')
                                                        <form action="{{ route('warehouse-slots.destroy', $slot->id) }}"
                                                            method="POST" style="display:inline;" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-outline-danger delete-btn sweet-5"
                                                                title="{{ __('Delete') }}" type="button"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        @endcanany
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">{{ __('No data to display') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @include('pagination.page', ['page' => $warehouseSlots])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection