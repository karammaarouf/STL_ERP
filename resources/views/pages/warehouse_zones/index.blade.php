@extends('../layouts.app')

@section('title', __('Warehouse Zones'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{ __('Warehouse Zone List') }}</h5>
                    @can('create-warehouse-zone')
                        <a href="{{ route('warehouse-zones.create') }}" class="btn btn-primary">{{ __('Add New Zone') }}</a>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Zone Name') }}</th>
                                <th scope="col">{{ __('Zone Code') }}</th>
                                <th scope="col">{{ __('Warehouse Name') }}</th>
                                @canany(['edit-warehouse-zone', 'delete-warehouse-zone', 'show-warehouse-zone'])
                                <th scope="col">{{ __('Options') }}</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($warehouseZones as $zone)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $zone->name }}</td>
                                    <td>{{ $zone->code }}</td>
                                    <td>{{ $zone->warehouse->name ?? __('N/A') }}</td>
                                    @canany(['edit-warehouse-zone', 'delete-warehouse-zone', 'show-warehouse-zone'])
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn" type="button" id="dropdownMenuButton{{ $zone->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $zone->id }}">
                                                @can('show-warehouse-zone')
                                                <li><a class="dropdown-item" href="{{ route('warehouse-zones.show', $zone->id) }}">{{ __('Details') }}</a></li>
                                                @endcan
                                                @can('edit-warehouse-zone')
                                                <li><a class="dropdown-item" href="{{ route('warehouse-zones.edit', $zone->id) }}">{{ __('Edit') }}</a></li>
                                                @endcan
                                                @can('delete-warehouse-zone')
                                                <li>
                                                    <form action="{{ route('warehouse-zones.destroy', $zone->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('{{ __('Are you sure you want to delete this zone?') }}')">{{ __('Delete') }}</button>
                                                    </form>
                                                </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </td>
                                    @endcanany
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{ __('No data to display') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                  @include('pagination.page', ['page' => $warehouseZones])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
