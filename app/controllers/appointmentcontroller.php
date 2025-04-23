<?php
namespace App\Controllers;
use App\Models\Appointment;


class AppointmentController{

    private $userService;
    private $serviceService;
    private $appointmentService;


    function __construct()
    {
        $this->userService = new \App\Services\UserService();
        $this->serviceService = new \App\Services\ServiceService();
        $this->appointmentService = new \App\Services\AppointmentService();

    }

    public function index()
    {
        $model = $this->appointmentService->getAll();
        
        require __DIR__ . '/../views/appointment/index.php';
        
    }
    public function success()
    {
        require __DIR__ . '/../views/appointment/create/success.php';
    }
    
    public function create()
    {
        
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $modelappointments = $this->appointmentService->getByWeek(0);
            $totalEmployees =$this->userService->getAllEmployees();
            $model = unserialize($_SESSION['appointment_data']);
            require __DIR__ . '/../views/appointment/create/index.php';
            
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $appointment = unserialize($_SESSION['appointment_data']);

           if (isset($_POST['date'])) {
            $appointment->setDate($_POST['date']); 
            }
            $this->appointmentService->create($appointment);
            $this->success();
            exit;
        }
        
    }
    
    public function service()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            require __DIR__ . '/../views/appointment/create/service.php';
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            
            $appointment = new Appointment();
            $appointment->userId = $_SESSION['user']->id;
            $appointment->license_plate = htmlspecialchars($_POST['license-plate']);
            $selectedServices = $_POST['services'] ?? [];
            foreach($selectedServices as $serviceId){
                $service = $this->serviceService->getById($serviceId);
                $appointment->services[] = $service;
            }
            
            
            $_SESSION['appointment_data'] = serialize($appointment);
            header("Location: /appointment/create");
            exit;
        }
        
        
    }

}
?>