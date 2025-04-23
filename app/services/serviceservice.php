<?php
namespace App\Services;

class ServiceService{

    public function getAll() {
        $repository = new \App\Repositories\ServiceRepository();
        return $repository->getAll();
    }
    public function getById($id){
        $repository = new \App\Repositories\ServiceRepository();
        return $repository->getById($id);
    }
    public function update($service) {
        $repository = new \App\Repositories\ServiceRepository();
        return $repository->update($service);
    }
    public function insert($service) {
        $repository = new \App\Repositories\ServiceRepository();
        return $repository->insert($service);
    }
    public function delete($id) {
        $repository = new \App\Repositories\ServiceRepository();
        return $repository->delete($id);
    }
}