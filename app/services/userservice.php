<?php
namespace App\Services;

class UserService {
    public function getAll() {
        $repository = new \App\Repositories\UserRepository();
        return $repository->getAll();
    }
    public function getById($id){
        $repository = new \App\Repositories\UserRepository();
        return $repository->getById($id);
    }
    public function getByEmail($email){
        $repository = new \App\Repositories\UserRepository();
        return $repository->getByEmail($email);
    }
    public function update($user) {
        $repository = new \App\Repositories\UserRepository();
        return $repository->update($user);
    }
    public function insert($user) {
        $repository = new \App\Repositories\UserRepository();
        return $repository->insert($user);
    }
    public function delete($id) {
        $repository = new \App\Repositories\UserRepository();
        return $repository->delete($id);
    }
    public function getAllEmployees() {
        $repository = new \App\Repositories\UserRepository();
        return $repository->getAllEmployees();
    }
}