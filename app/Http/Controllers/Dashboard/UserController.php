<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Services\UserService;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\UserRequest;
use App\Http\Requests\Dashboard\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index()
    {
        $Users = $this->userService->getAllUsers();
        $roles = Role::pluck('name', 'id');
        return view('dashboard.users.index', compact('Users', 'roles'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'id');

        return view('dashboard.users.create', compact('roles'));
    }

    public function show($id)
    {
        $User = $this->userService->getUserById($id);
        return view('dashboard.users.show', compact('User'));
    }

    public function store(UserRequest $request)
    {
        $attributes = $request->validated();

        $roleId = $attributes['role'];
        unset($attributes['role']);

        $user = $this->userService->createUser($attributes);

        $role = Role::select('name')->where('id', $roleId)->first();
        $user->assignRole($role->name);

        return redirect()->route('dashboard.users.index')->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        $user = $this->userService->getUserById($id);
        $roles = Role::pluck('name', 'id');
        return view('dashboard.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $attributes = $request->validated();

        if (!empty($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        } else {
            // Remove password from array if not set to avoid updating it with null
            unset($attributes['password']);
        }

        // Assuming the role is part of the form submission and needs to be handled.
        if (isset($attributes['role'])) {
            $roleId = $attributes['role'];
            unset($attributes['role']);

            // Update the user details via a service, if you use one
            $user = $this->userService->updateUser($id, $attributes);

            // Fetch the role name and assign it to the user
            $role = Role::select('name')->where('id', $roleId)->first();
            if ($role) {
                $user->syncRoles([$role->name]); // syncRoles will remove old roles and assign the new one
            }
        } else {
            // If role isn't set, just update the user attributes
            $user = $this->userService->updateUser($id, $attributes);
        }

        return redirect()->route('dashboard.users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('dashboard.users.index')->with('success', 'User deleted successfully');
    }
}
