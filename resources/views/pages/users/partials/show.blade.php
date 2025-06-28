@extends('../layouts.app')

@section('title', __('User Details'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('User Details') }}: {{ $user->name }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('User Name') }}:</strong></label>
                        <p>{{ $user->name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Email') }}:</strong></label>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Roles') }}:</strong></label>
                        <p>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif
                        </p>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Creation Date') }}:</strong></label>
                        <p>{{ $user->created_at->format('Y-m-d H:i A') }}</p>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Last Updated') }}:</strong></label>
                        <p>{{ $user->updated_at->format('Y-m-d H:i A') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('Status') }}:</strong></label>
                        <div class="media">
                            <label class="col-form-label m-r-10">{{ $user->is_active ? __('Active') : __('Inactive') }}</label>
                            <div class="media-body text-start switch-bg icon-state">
                                @can('edit-user')
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
                                @else
                                <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $user->is_active ? __('Active') : __('Inactive') }}
                                </span>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
             @can('edit-user')
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
             @endcan
            <a class="btn btn-light" href="{{ route('users.index') }}">{{ __('Back to List') }}</a>
        </div>
    </div>
</div>
@endsection