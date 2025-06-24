@extends('../layouts.app')

@section('title', __('Add New User'))

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Add New User') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">{{ __('User Name') }}</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="email">{{ __('Email') }}</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="password">{{ __('Password') }}</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Roles') }}</label>
                            <select class="form-control" name="roles[]" multiple>
                                @foreach($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                    <a class="btn btn-light" href="{{ route('users.index') }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection