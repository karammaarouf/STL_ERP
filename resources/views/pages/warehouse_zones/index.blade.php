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
                                <th class="text-center" scope="col">{{ __('Options') }}</th>
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
                                    <td class="text-center align-middle border-1">
                                        <div class="d-flex gap-1 justify-content-center align-items-center">
                                            @can('show-warehouse-zone')
                                                <a href="{{ route('warehouse-zones.show', $zone->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="{{ __('Details') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endcan
                                            
                                            @can('edit-warehouse-zone')
                                                <a href="{{ route('warehouse-zones.edit', $zone->id) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="{{ __('Edit') }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan
                                            
                                            @can('delete-warehouse-zone')
                                                <form action="{{ route('warehouse-zones.destroy', $zone->id) }}" 
                                                      method="POST" 
                                                      style="display:inline;" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            title="{{ __('Delete') }}"
                                                            onclick="return confirm('{{ __('Are you sure you want to delete this zone?') }}')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
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
