@extends('../layouts.app')

@section('title', __('Warehouse Racks'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ __('Warehouse Rack List') }}</h5>
                        @can('create-warehouse-rack')
                            <a href="{{ route('warehouse-racks.create') }}" class="btn btn-primary">{{ __('Add New Rack') }}</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Rack Code') }}</th>
                                    <th scope="col">{{ __('Section Name') }}</th>
                                    <th scope="col">{{ __('Zone Name') }}</th>
                                    <th scope="col">{{ __('Warehouse Name') }}</th>
                                    @canany(['edit-warehouse-rack', 'delete-warehouse-rack', 'show-warehouse-rack'])
                                        <th class="text-center" scope="col">{{ __('Options') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($warehouseRacks as $rack)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $rack->code }}</td>
                                        <td>{{ $rack->section->name ?? __('N/A') }}</td>
                                        <td>{{ $rack->section->zone->name ?? __('N/A') }}</td>
                                        <td>{{ $rack->section->zone->warehouse->name ?? __('N/A') }}</td>
                                        @canany(['edit-warehouse-rack', 'delete-warehouse-rack', 'show-warehouse-rack'])
                                            <td class="text-center align-middle border-1">
                                                <div class="d-flex gap-1 justify-content-center align-items-center">
                                                    @can('show-warehouse-rack')
                                                        <a href="{{ route('warehouse-racks.show', $rack->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="{{ __('Details') }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan

                                                    @can('edit-warehouse-rack')
                                                        <a href="{{ route('warehouse-racks.edit', $rack->id) }}"
                                                            class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete-warehouse-rack')
                                                        <form action="{{ route('warehouse-racks.destroy', $rack->id) }}"
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
                                        <td colspan="6" class="text-center">{{ __('No data to display') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @include('pagination.page', ['page' => $warehouseRacks])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection