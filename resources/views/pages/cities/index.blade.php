@extends('../layouts.app')

@section('title', __('Cities'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ __('City List') }}</h5>
                        @can('create-city')
                            <a href="{{ route('cities.create') }}" class="btn btn-primary">{{ __('Add New City') }}</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('City Name') }}</th>
                                    <th scope="col">{{ __('State Name') }}</th>
                                    @canany(['edit-city', 'delete-city', 'show-city'])
                                        <th class="text-center" scope="col">{{ __('Options') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cities as $city)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td> <i class="flag-icon flag-icon-{{ strtolower($city->state->country->iso_code) }}"></i>
                                            {{ $city->name }}</td>
                                        <td>{{ $city->state->name ?? __('Not Found') }}</td>

                                        @canany(['edit-city', 'delete-city', 'show-city'])
                                            <td class="text-center align-middle border-1">
                                                <div class="d-flex gap-1 justify-content-center align-items-center">
                                                    @can('show-city')
                                                        <a href="{{ route('cities.show', $city->id) }}" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="{{ __('Details') }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    
                                                    @can('edit-city')
                                                        <a href="{{ route('cities.edit', $city->id) }}" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    
                                                    @can('delete-city')
                                                        <form action="{{ route('cities.destroy', $city->id) }}" 
                                                              method="POST" 
                                                              style="display:inline;" 
                                                              class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-danger delete-btn" 
                                                                    title="{{ __('Delete') }}"
                                                                    data-city-name="{{ $city->name }}">
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
                                        <td colspan="4" class="text-center">{{ __('No data to display') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        @include('pagination.page', ['page' => $cities])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

