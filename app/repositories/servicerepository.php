<?php
namespace App\Repositories;

use PDO;
use App\Models\Service;

class ServiceRepository extends Repository{

    public function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM services");
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $services = array_map(function ($row) {
            $service = new Service();
            $service->id = (int)$row['id'];
            $service->name = $row['name'];
            $service->description = $row['description'];
            $service->duration_minutes = (int)$row['duration_minutes']; 
            $service->price = (float)$row['price'];
            return $service;
        }, $rows);

        return $services;
    }
    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM services WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null; 
        }

        $service = new Service();
            $service->id = (int)$row['id'];
            $service->name = $row['name'];
            $service->description = $row['description'];
            $service->duration_minutes = (int)$row['duration_minutes']; 
            $service->price = (float)$row['price'];
            return $service;
    }
    public function insert($service) {
        $stmt = $this->connection->prepare("INSERT INTO `services` (`name`, `description`, `duration_minutes`, `price`) 
        VALUES (:name, :description, :duration_minutes, :price)");

        $results = $stmt->execute([
            ':name' => $service->name,
            ':description' => $service->description,
            ':duration_minutes' => $service->duration_minutes,
            ':price' => $service->price
        ]);

        return $results;
    }
    public function update($service) {
        $stmt = $this->connection->prepare("UPDATE services SET 
            name = :name,
            description = :description,
            duration_minutes = :duration_minutes,
            price = :price
            WHERE id = :id");

        $results = $stmt->execute([
            ':id' => $service->id,
            ':name' => $service->name,
            ':description' => $service->description,
            ':duration_minutes' => $service->duration_minutes,
            ':price' => $service->price
        ]);

        return $results;
    }
    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM services WHERE id = :id");
    
        $results = $stmt->execute([
            ':id' => $id
        ]);
    
        return $results;
    }

}