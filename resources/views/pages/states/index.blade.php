@extends('../layouts.app')

@section('title', __('States'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ __('State List') }}</h5>
                        @can('create-state')
                            <a href="{{ route('states.create') }}" class="btn btn-primary">{{ __('Add New State') }}</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('State Name') }}</th>
                                    <th scope="col">{{ __('Country Name') }}</th>
                                    @canany(['edit-state', 'delete-state', 'show-state'])
                                        <th class="text-center" scope="col">{{ __('Options') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($states as $state)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $state->name }}</td>
                                        <td> <i class="flag-icon flag-icon-{{ strtolower($state->country->iso_code) }}"></i>
                                            {{ $state->country->name }} </td>

                                        @canany(['edit-state', 'delete-state', 'show-state'])
                                            <td class="text-center align-middle border-1">
                                                <div class="d-flex gap-1 justify-content-center align-items-center">
                                                    @can('show-state')
                                                        <a href="{{ route('states.show', $state->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="{{ __('Details') }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan

                                                    @can('edit-state')
                                                        <a href="{{ route('states.edit', $state->id) }}"
                                                            class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete-state')
                                                        <form action="{{ route('states.destroy', $state->id) }}" method="POST"
                                                            style="display:inline;" class="d-inline delete-form">
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
                                        <td colspan="4" class="text-center">لا توجد بيانات لعرضها</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @include('pagination.page', ['page' => $states])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
