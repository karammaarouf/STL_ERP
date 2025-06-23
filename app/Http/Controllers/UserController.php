<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->userService->getRoles();
        return view('pages.users.partials.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->createUser($request->validated());

        return redirect()->route('users.index')
            ->with('success', __('User created successfully'));
    }

    public function show(User $user)
    {
        return view('pages.users.partials.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = $this->userService->getRoles();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('pages.users.partials.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->updateUser($user, $request->validated());

        return redirect()->route('users.index')
            ->with('success', __('User updated successfully'));
    }

    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);

        return redirect()->route('users.index')
            ->with('success', __('User deleted successfully'));
    }
}
