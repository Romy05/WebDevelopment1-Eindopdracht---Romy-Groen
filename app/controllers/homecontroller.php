<?php
namespace App\Controllers;

class HomeController
{
    private $userService;
    private $appointmentController;

    function __construct()
    {
        $this->userService = new \App\Services\UserService();
        $this->appointmentController = new \App\Controllers\AppointmentController();
    }

    public function index()
    {
        $model = $this->userService->getAll();
        require __DIR__ . '/../views/home/index.php';
    }
    public function login()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            require __DIR__ . '/../views/home/login.php';
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $user = $this->userService->getByEmail($email);
            if ($user != null && password_verify($password, $user->hashed_password)) {
                $_SESSION['user'] = $user;
                $this->index();

            } else {
                require __DIR__ . '/../views/home/login.php';
                ?>
                <script>
                
                    const errorMessageDiv = document.getElementById('error-message');
                    errorMessageDiv.style.display = 'block';
                    errorMessageDiv.textContent = "Invalid email or password!";
                
            </script><?php
            }
        }
        
    }
    public function logout()
    {
         
        session_unset();  
        session_destroy();  

        header("Location: /");
        exit;
    }
    public function register(){
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            require __DIR__ . '/../views/home/register.php';
        }
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = htmlspecialchars($_POST['email']);
            $raw_password = htmlspecialchars($_POST['password']);
            $password = password_hash($raw_password, PASSWORD_DEFAULT);
            $type_of_user = \App\Models\enums\UserType::Customer;
            $first_name = !empty($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : null;
            $last_name = !empty($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : null;
            $phone_number = !empty($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : null;
            $address = htmlspecialchars($_POST['address']);
            $city = htmlspecialchars($_POST['city']);
            $zip = htmlspecialchars($_POST['zip']);

            if ($this->userService->getByEmail($email) !== null) {
                $error = "This email is already registered.";
    
                $formData = $_POST;
    
                require __DIR__ . '/../views/home/register.php';
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

            
            $_SESSION['user'] = $user;
            $this->index();
        }
    }
    public function settings(){
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            $model = $this->userService->getById($_SESSION['user']->id);
            require __DIR__ . '/../views/home/settings.php';
        }
        
    }
}