<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUser();
    }

    public function getUserById($id): ?User
    {
        return $this->userRepository->getUserById($id);
    }

    public function createUser($data): User
    {
        return $this->userRepository->createUser($data);
    }

    public function updateUser($id, array $data): ?User
    {
        $User = $this->userRepository->getUserById($id);
        if (!$User) {
            return null;
        }
        $this->userRepository->updateUser($User, $data);
        return $User;
    }

    public function deleteUser($id): ?User
    {
        $User = $this->userRepository->getUserById($id);
        if (!$User) {
            return null;
        }
        $this->userRepository->deleteUser($User);
        return $User;
    }
}
