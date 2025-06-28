@extends('layouts.app')

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
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Roles') }}</th>
                                    @canany(['edit-user', 'delete-user'])
                                        <th class="text-center" scope="col">{{ __('Options') }}</th>
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
                                            @can('edit-user')
                                                <div class="media">
                                                    <label
                                                        class="col-form-label m-r-10">{{ $user->is_active ? __('Active') : __('Inactive') }}</label>
                                                    <div class="media-body text-start switch-sm icon-state">
                                                        <form action="{{ route('users.toggle-status', $user->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <label class="switch">
                                                                <input class="status-toggle" type="checkbox"
                                                                    {{ $user->is_active ? 'checked' : '' }}
                                                                    onchange="this.form.submit()">
                                                                <span class="switch-state"></span>
                                                            </label>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $user->is_active ? __('Active') : __('Inactive') }}
                                                </span>
                                            @endcan
                                        </td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $v)
                                                    <label class="badge badge-success">{{ $v }}</label>
                                                @endforeach
                                            @endif
                                        </td>

                                        @canany(['edit-user', 'delete-user', 'show-user'])
                                            <td class="text-center align-middle border-1">
                                                <div class="d-flex gap-1 justify-content-center align-items-center">
                                                    @can('show-user')
                                                        <a href="{{ route('users.show', $user->id) }}" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="{{ __('Details') }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    
                                                    @can('edit-user')
                                                        <a href="{{ route('users.edit', $user->id) }}" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    
                                                    @can('delete-user')
                                                        <form action="{{ route('users.destroy', $user->id) }}" 
                                                              method="POST" 
                                                              style="display:inline;" 
                                                              class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-danger delete-btn" 
                                                                    title="{{ __('Delete') }}"
                                                                    data-user-name="{{ $user->name }}">
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
                                        <td colspan="6" class="text-center">{{ __('No data to display') }}</td>
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
