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
                                    <th scope="col">{{ __('Options') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cities as $city)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>  <i class="flag-icon flag-icon-{{ strtolower($city->state->country->iso_code) }}"></i> {{ $city->name }}</td>

                                        <td>{{ $city->state->name ?? __('Not Found') }}</td>

                                        @canany(['edit-city', 'delete-city', 'show-city'])
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn" type="button" id="dropdownMenuButton{{ $city->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $city->id }}">
                                                    @can('edit-city')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('cities.edit', $city->id) }}">{{ __('Edit') }}</a>
                                                    </li>
                                                    @endcan
                                                    @can('show-city')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('cities.show', $city->id) }}">{{ __('City Details') }}</a>
                                                    </li>
                                                    @endcan
                                                    @can('delete-city')
                                                    <li>
                                                        <form action="{{ route('cities.destroy', $city->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item" onclick="return confirm('هل أنت متأكد من رغبتك في حذف هذه المدينة؟')">{{ __('Delete') }}</button>
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
