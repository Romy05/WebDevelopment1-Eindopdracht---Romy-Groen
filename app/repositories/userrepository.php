<?php
namespace App\Repositories;

use PDO;
use App\Models\User;
use App\Models\Enums\UserType;

class UserRepository extends Repository {

    public function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM users");
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = array_map(function ($row) {
            $user = new User();
            $user->id = (int)$row['id'];
            $user->hashed_password = $row['hashed_password'];
            $user->email = $row['email'];
            $user->type_of_user = UserType::from($row['type_of_user']); // Convert string to enum
            $user->first_name = $row['first_name']; 
            $user->last_name = $row['last_name'];
            $user->phone_number = $row['phone_number'];
            $user->address = $row['address'];
            $user->city = $row['city'];
            $user->zip = $row['zip'];
            return $user;
        }, $rows);

        return $users;
    }
    public function getAllEmployees() {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE type_of_user = :type_of_user");
        $stmt->execute([':type_of_user' => UserType::Employee->jsonSerialize()]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = array_map(function ($row) {
            $user = new User();
            $user->id = (int)$row['id'];
            $user->hashed_password = $row['hashed_password'];
            $user->email = $row['email'];
            $user->type_of_user = UserType::from($row['type_of_user']); // Convert string to enum
            $user->first_name = $row['first_name']; 
            $user->last_name = $row['last_name'];
            $user->phone_number = $row['phone_number'];
            $user->address = $row['address'];
            $user->city = $row['city'];
            $user->zip = $row['zip'];
            return $user;
        }, $rows);

        return $users;
    }
    public function getByEmail($email){
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null; // User not found
        }

        $user = new User();
        $user->id = (int)$row['id'];
        $user->hashed_password = $row['hashed_password'];
        $user->email = $row['email'];
        $user->type_of_user = UserType::from($row['type_of_user']);
        $user->first_name = $row['first_name']; 
        $user->last_name = $row['last_name'];
        $user->phone_number = $row['phone_number'];
        $user->address = $row['address'];
        $user->city = $row['city'];
        $user->zip = $row['zip'];

        return $user;
    }
    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null; // User not found
        }

        $user = new User();
        $user->id = (int)$row['id'];
        $user->hashed_password = $row['hashed_password'];
        $user->email = $row['email'];
        $user->type_of_user = UserType::from($row['type_of_user']);
        $user->first_name = $row['first_name']; 
        $user->last_name = $row['last_name'];
        $user->phone_number = $row['phone_number'];
        $user->address = $row['address'];
        $user->city = $row['city'];
        $user->zip = $row['zip'];

        return $user;
    }

    public function insert($user) {
        $stmt = $this->connection->prepare("INSERT INTO `users` (`hashed_password`, `email`, `type_of_user`, `first_name`, `last_name`, `phone_number`, `address`, `city`, `zip`)
        VALUES (:hashed_password, :email, :type_of_user, :first_name, :last_name, :phone_number, :address, :city, :zip)");

        $results = $stmt->execute([
            ':hashed_password' => $user->hashed_password,
            ':email' => $user->email,
            ':type_of_user' => $user->type_of_user->jsonSerialize(), // Convert enum to string
            ':first_name' => $user->first_name,
            ':last_name' => $user->last_name,
            ':phone_number' => $user->phone_number,
            ':address' => $user->address,
            ':city' => $user->city,
            ':zip' => $user->zip
        ]);

        return $results;
    }

    public function update($user) {
        $stmt = $this->connection->prepare("UPDATE users SET 
            email = :email, 
            first_name = :first_name,
            last_name = :last_name,
            hashed_password = :hashed_password,  
            type_of_user = :type_of_user, 
            phone_number = :phone_number, 
            address = :address, 
            city = :city, 
            zip = :zip
            WHERE id = :id");

        $results = $stmt->execute([
            ':id' => $user->id,
            ':email' => $user->email,
            ':first_name' => $user->first_name,
            ':last_name' => $user->last_name,
            ':hashed_password' => $user->hashed_password,
            ':type_of_user' => $user->type_of_user->jsonSerialize(), // Convert enum to string
            ':phone_number' => $user->phone_number,
            ':address' => $user->address,
            ':city' => $user->city,
            ':zip' => $user->zip
        ]);

        return $results;
    }
    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM users WHERE id = :id");
    
        $results = $stmt->execute([
            ':id' => $id
        ]);
    
        return $results;
    }
    
}
