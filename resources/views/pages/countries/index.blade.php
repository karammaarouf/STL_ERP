@extends('../layouts.app')

@section('title', __('Countries'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ __('Countries List') }}</h5>
                        @can('create-country')
                            <a href="{{ route('countries.create') }}" class="btn btn-primary">{{ __('Add New Country') }}</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Country Name') }}</th>
                                    <th scope="col">{{ __('Country Code') }}</th>
                                    @canany(['edit-country', 'delete-country', 'show-country'])
                                        <th class="text-center" scope="col">{{ __('Options') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($countries as $country)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td> <i class="flag-icon flag-icon-{{ strtolower($country->iso_code) }}"></i>
                                            {{ $country->name }} </td>
                                        <td>{{ $country->iso_code }}</td>
                                        @canany(['edit-country', 'delete-country', 'show-country'])
                                            <td class="text-center align-middle border-1">
                                                <div class="d-flex gap-1 justify-content-center align-items-center">
                                                    @can('show-country')
                                                        <a href="{{ route('countries.show', $country->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="{{ __('Details') }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan

                                                    @can('edit-country')
                                                        <a href="{{ route('countries.edit', $country->id) }}"
                                                            class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete-country')
                                                        <form action="{{ route('countries.destroy', $country->id) }}"
                                                            method="POST" style="display:inline;" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            {{-- <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                                                title="{{ __('Delete') }}"
                                                                data-country-name="{{ $country->name }}">
                                                                <i class="fa fa-trash"></i>
                                                            </button> --}}
                                                                                                              <button class="btn btn-sm btn-outline-danger delete-btn sweet-5" title="{{ __('Delete') }}" type="button"><i class="fa fa-trash"></i></button>

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
                        @include('pagination.page', ['page' => $countries])
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
