<?php
namespace App\Api\Controllers;
use App\Models\User;
use App\Services\UserService;
class UserApiController{

    private UserService $userService;

    function __construct()
    {
        $this->userService = new \App\Services\UserService();
    }

    public function index(){

        if ($_SERVER['REQUEST_METHOD'] === "GET") {

            $user = $this->userService->getAll();
            $json= json_encode($user);
            header("Content-type: application/json");
            echo $json;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $json = file_get_contents('php://input');
            $object = json_decode($json);

            $user = new User();
            $user->setId($object->id);
            $user->setEmail($object->email);
            $user->setPassword($object->password);
            $user->setSalt($object->salt);
            $user->setType($object->type_of_user);
            $user->setFirstName($object->first_name);
            $user->setLastName($object->last_name);
            $user->setPhoneNumber($object->phone_number);
            $user->setAddress($object->address);
            $user->setCity($object->city);
            $user->setZip($object->zip);

            $this->userService->insert($user);
        }
    }
    public function update() {
        // Ensure it's a PUT request
        if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
            http_response_code(405); // Method Not Allowed
            echo json_encode(["error" => "Method Not Allowed"]);
            return;
        }
    
        // Read JSON input
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
    
        // Validate required fields
        if (!isset($data['email']) || !isset($data['first_name']) || !isset($data['last_name'])) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Missing required fields"]);
            return;
        }
    
        // Sanitize input data
        $email = htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8');
        $firstName = htmlspecialchars($data['first_name'], ENT_QUOTES, 'UTF-8');
        $lastName = htmlspecialchars($data['last_name'], ENT_QUOTES, 'UTF-8');
        $phoneNumber = isset($data['phone_number']) ? htmlspecialchars($data['phone_number'], ENT_QUOTES, 'UTF-8') : null;
        $address = isset($data['address']) ? htmlspecialchars($data['address'], ENT_QUOTES, 'UTF-8') : null;
        $city = isset($data['city']) ? htmlspecialchars($data['city'], ENT_QUOTES, 'UTF-8') : null;
        $zip = isset($data['zip']) ? htmlspecialchars($data['zip'], ENT_QUOTES, 'UTF-8') : null;
        
        // Fetch the user by email (or another identifier like user ID)
        $user = $this->userService->getByEmail($email); // Assuming this method exists
        if (!$user) {
            http_response_code(404); // Not Found
            echo json_encode(["error" => "User not found"]);
            return;
        }
    
        // Update user properties
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPhoneNumber($phoneNumber ?? $user->getPhoneNumber());
        $user->setAddress($address ?? $user->getAddress());
        $user->setCity($city ?? $user->getCity());
        $user->setZip($zip ?? $user->getZip());
    
        // Update password if provided
        if (!empty($data['password']) && !empty($data['confirm_password'])) {
            if ($data['password'] !== $data['confirm_password']) {
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Passwords do not match"]);
                return;
            }
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);
        }
    
        // Save the updated user
        $this->userService->update($user);
    
        // Respond with success
        echo json_encode(["success" => "User updated successfully"]);
    }
    
    
}