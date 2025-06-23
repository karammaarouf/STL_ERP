@extends('../layouts.app')

@section('title', __('Users'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>{{ __('Users List') }}</h5>
                        @can('create-user')
                            <a href="{{ route('users.create') }}" class="btn btn-primary">{{ __('Add New User') }}</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('User Name') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Roles') }}</th>
                                    @canany(['edit-user', 'delete-user'])
                                    <th scope="col">{{ __('Options') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if(!empty($user->getRoleNames()))
                                                @foreach($user->getRoleNames() as $v)
                                                    <label class="badge badge-success">{{ $v }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        @canany(['edit-user', 'delete-user'])
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn" type="button" id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $user->id }}">
                                                    @can('edit-user')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">{{ __('Edit') }}</a>
                                                    </li>
                                                    @endcan
                                                    @can('show-user')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('users.show', $user->id) }}">{{ __('User Details') }}</a>
                                                    </li>
                                                    @endcan
                                                    @can('delete-user')
                                                    <li>
                                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item" onclick="return confirm('{{__('Are you sure you want to delete this user?')}}')">{{__('Delete')}}</button>
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
                                        <td colspan="5" class="text-center">{{__('No data to display')}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                      @include('pagination.page', ['page' => $users])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection