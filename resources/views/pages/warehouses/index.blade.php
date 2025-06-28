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
                                        <th class="text-center" scope="col">{{ __('Options') }}</th>
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
                                            <td class="text-center align-middle border-1">
                                                <div class="d-flex gap-1 justify-content-center align-items-center">
                                                    @can('show-warehouse')
                                                        <a href="{{ route('warehouses.show', $warehouse->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="{{ __('Details') }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan

                                                    @can('edit-warehouse')
                                                        <a href="{{ route('warehouses.edit', $warehouse->id) }}"
                                                            class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete-warehouse')
                                                        <form action="{{ route('warehouses.destroy', $warehouse->id) }}"
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
