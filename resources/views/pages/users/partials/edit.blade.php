@extends('../layouts.app')

@section('title', __('Edit User'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Edit User') }}: {{ $user->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">{{ __('User Name') }}</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="email">{{ __('Email') }}</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="password">{{ __('Password') }}</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password">
                            <small class="form-text text-muted">{{ __('Leave blank if you don\'t want to change it') }}</small>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Roles') }}</label>
                            <select class="form-control" name="roles[]" multiple>
                                @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ in_array($role, $userRole) ? 'selected' : '' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label"><strong>{{ __('Status') }}:</strong></label>
                            <div class="media">
                                <label class="col-form-label m-r-10">{{ $user->is_active ? __('Active') : __('Inactive') }}</label>
                                <div class="media-body text-start switch-bg icon-state">
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
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
                    <a class="btn btn-light" href="{{ route('users.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection