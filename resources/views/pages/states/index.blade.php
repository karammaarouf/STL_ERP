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
                                    <th scope="col">{{ __('Options') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($states as $state)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $state->name }}</td>
                                        <td> <i class="flag-icon flag-icon-{{ strtolower($state->country->iso_code) }}"></i>  {{ $state->country->name  }} </td>

                                        @canany(['edit-state', 'delete-state', 'show-state'])
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn" type="button" id="dropdownMenuButton{{ $state->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $state->id }}">
                                                    @can('edit-state')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('states.edit', $state->id) }}">{{ __('Edit') }}</a>
                                                    </li>
                                                    @endcan
                                                    @can('show-state')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('states.show', $state->id) }}">{{ __('State Details') }}</a>
                                                    </li>
                                                    @endcan
                                                    @can('delete-state')
                                                    <li>
                                                        <form action="{{ route('states.destroy', $state->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item" onclick="return confirm('هل أنت متأكد من رغبتك في حذف هذه المحافظة؟')">حذف</button>
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
