<?php
namespace App\Controllers;
use App\Models\Enums\UserType;

class UserController
{

    private $userService;

    function __construct()
    {
        $this->userService = new \App\Services\UserService();
    }

    public function index()
    {
        $model = $this->userService->getAll();
        require __DIR__ . '/../views/user/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            require __DIR__ . '/../views/user/create.php';
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {


            $email = htmlspecialchars($_POST['email']);
            $raw_password = htmlspecialchars($_POST['password']);
            $password = password_hash($raw_password, PASSWORD_DEFAULT);
            $type_of_user = UserType::from($_POST['type_of_user']);
            $first_name = !empty($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : null;
            $last_name = !empty($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : null;
            $phone_number = !empty($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : null;
            $address = htmlspecialchars($_POST['address']);
            $city = htmlspecialchars($_POST['city']);
            $zip = htmlspecialchars($_POST['zip']);

            if ($this->userService->getByEmail($email) !== null) {
                $error = "This email is already registered.";
    
               
                $formData = $_POST;
    
                require __DIR__ . '/../views/user/create.php';
                exit;
            }

            $user = new \App\Models\User();
            $user->email = $email;
            $user->hashed_password = $password;
            $user->type_of_user = $type_of_user;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->phone_number = $phone_number;
            $user->address = $address;
            $user->city = $city;
            $user->zip = $zip;

            $this->userService->insert($user);
            $this->index();
        
        }
    }
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            $id = $_GET['id'];
            $model = $this->userService->getById($id);
            require __DIR__ . '/../views/user/edit.php';
        }
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            
            $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
            $model = $this->userService->getById($id);
            $email = htmlspecialchars($_POST['email']);
            $emailUser = $this->userService->getByEmail($email);
            if (($emailUser !== null)&& ($emailUser->id !== $id)) {
                
                $error = "This email is already registered.";
    
                // Preserve form data
                $formData = $_POST;
                
    
                require __DIR__ . '/../views/user/edit.php';
                exit;
            }

            if (isset($_POST['edit_password_checkbox']) && $_POST['edit_password_checkbox'] === 'on') {
                $raw_password = htmlspecialchars($_POST['password']);
                $password = password_hash($raw_password, PASSWORD_DEFAULT);
            }
           
            else{
                $password = $model->hashed_password;
            }
            $type_of_user = $model->type_of_user;
            $first_name = !empty($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : null;
            $last_name = !empty($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : null;
            $phone_number = !empty($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : null;
            $address = htmlspecialchars($_POST['address']);
            $city = htmlspecialchars($_POST['city']);
            $zip = htmlspecialchars($_POST['zip']);

            $user = new \App\Models\User();
            $user->id = $id;
            $user->email = $email;
            $user->hashed_password = $password;
            $user->type_of_user = $type_of_user;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->phone_number = $phone_number;
            $user->address = $address;
            $user->city = $city;
            $user->zip = $zip;
            $this->userService->update($user);
            $this->index();
        }
    }
    public function delete()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            $id = $_GET['id'];
            
            if ($this->userService->delete($id)){
                $this->index();
            } else {
                echo "Something went wrong while deleting user";
            }
        }
    }
}