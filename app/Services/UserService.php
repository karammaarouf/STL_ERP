<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class UserService
{
    public function getAllUsers(int $pagination = 10)
    {
        return User::paginate($pagination);
    }

    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user->assignRole($data['roles']);

        return $user;
    }

    public function updateUser(User $user, array $data): User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data = Arr::except($data, ['password']);
        }

        if ($data['email'] === $user->email) {
            $data = Arr::except($data, ['email']);
        }

        $user->update($data);
        $user->syncRoles($data['roles']);

        return $user;
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    public function getRoles()
    {
        return Role::pluck('name', 'name')->all();
    }
}