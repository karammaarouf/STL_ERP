@extends('../layouts.app')

@section('title', __('Pallets'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ __('Pallet List') }}</h5>
                        @can('create-pallet')
                            <a href="{{ route('pallets.create') }}" class="btn btn-primary">{{ __('Add New Pallet') }}</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Barcode') }}</th>
                                    <th scope="col">{{ __('Warehouse') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Current Weight') }}</th>
                                    <th scope="col">{{ __('Current Volume') }}</th>
                                    @canany(['edit-pallet', 'delete-pallet', 'show-pallet'])
                                        <th class="text-center" scope="col">{{ __('Options') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pallets as $pallet)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $pallet->barcode }}</td>
                                        <td>{{ $pallet->warehouse->name ?? __('N/A') }}</td>
                                        <td>{{ __(ucfirst($pallet->status)) }}</td>
                                        <td>{{ $pallet->current_weight }}</td>
                                        <td>{{ $pallet->current_volume }}</td>
                                        @canany(['edit-pallet', 'delete-pallet', 'show-pallet'])
                                            <td class="text-center align-middle border-1">
                                                <div class="d-flex gap-1 justify-content-center align-items-center">
                                                    @can('show-pallet')
                                                        <a href="{{ route('pallets.show', $pallet->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="{{ __('Details') }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan

                                                    @can('edit-pallet')
                                                        <a href="{{ route('pallets.edit', $pallet->id) }}"
                                                            class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete-pallet')
                                                        <form action="{{ route('pallets.destroy', $pallet->id) }}"
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
                                        <td colspan="7" class="text-center">{{ __('No data to display') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @include('pagination.page', ['page' => $pallets])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection