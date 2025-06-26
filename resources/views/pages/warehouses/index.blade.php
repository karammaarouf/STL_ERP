@extends('../layouts.app')

@section('title', __('Warehouses'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>{{ __('Warehouse List') }}</h5>
                    @can('create-warehouse')
                        <a href="{{ route('warehouses.create') }}" class="btn btn-primary">{{ __('Add New Warehouse') }}</a>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Warehouse Name') }}</th>
                                <th scope="col">{{ __('Code') }}</th>
                                <th scope="col">{{ __('City') }}</th>
                                <th scope="col">{{ __('State') }}</th>
                                <th scope="col">{{ __('Country') }}</th>
                                <th scope="col">{{ __('Type') }}</th>
                                @canany(['edit-warehouse', 'delete-warehouse', 'show-warehouse'])
                                <th scope="col">{{ __('Options') }}</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($warehouses as $warehouse)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $warehouse->name }}</td>
                                    <td>{{ $warehouse->code }}</td>
                                    <td>{{ $warehouse->city->name ?? __('N/A') }}</td>
                                    <td>{{ $warehouse->city->state->name ?? __('N/A') }}</td>
                                    <td>{{ $warehouse->city->state->country->name ?? __('N/A') }}</td>
                                    <td>{{ __($warehouse->type) }}</td>
                                    @canany(['edit-warehouse', 'delete-warehouse', 'show-warehouse'])
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn" type="button" id="dropdownMenuButton{{ $warehouse->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $warehouse->id }}">
                                                @can('show-warehouse')
                                                <li><a class="dropdown-item" href="{{ route('warehouses.show', $warehouse->id) }}">{{ __('Details') }}</a></li>
                                                @endcan
                                                @can('edit-warehouse')
                                                <li><a class="dropdown-item" href="{{ route('warehouses.edit', $warehouse->id) }}">{{ __('Edit') }}</a></li>
                                                @endcan
                                                @can('delete-warehouse')
                                                <li>
                                                    <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('{{ __('Are you sure you want to delete this warehouse?') }}')">{{ __('Delete') }}</button>
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
                                    <td colspan="8" class="text-center">{{ __('No data to display') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                  @include('pagination.page', ['page' => $warehouses])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
