<?php
namespace App\Api\Controllers;
use App\Models\Appointment;
use App\Services\AppointmentService;
class AppointmentApiController{

    private AppointmentService $appointmentService;

    function __construct()
    {
        $this->appointmentService = new \App\Services\AppointmentService();
    }

    public function getWeek(){
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            // Check if the 'week' query parameter exists
            if (isset($_GET['week'])) {
                $week = $_GET['week'];
                
                // Fetch appointments for the given week (assuming you have a method for this)
                $modelappointments = $this->appointmentService->getByWeek($week);
                
                // Create an array for the response
                $appointments = [];
                foreach ($modelappointments as $appointment) {
                    $appointments[] = [
                        'id' => $appointment->getId(),
                        'date' => $appointment->getDate(),
                        'duration' => $appointment->getTotalDurationInMinutes(),
                        'services' => $appointment->getServices()
                    ];
                }

                // Return the data as a JSON response
                header('Content-Type: application/json');
                echo json_encode($appointments);
                exit;
            } else {
                // Handle the case when the 'week' parameter is not provided
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Week parameter is required']);
                exit;
            }
        }
    }
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === "GET") {

            $appointments = $this->appointmentService->getAll();
            $json= json_encode($appointments);
            header("Content-type: application/json");
            echo $json;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $json = file_get_contents('php://input');
            $object = json_decode($json);

            $appointment = new Appointment();
            $appointment->setId($object->id);
            $appointment->setUserId($object->userId);
            $appointment->setLicensePlate($object->license_plate);
            $appointment->setDate($object->date);
            $appointment->setServices($object->services); 


            $this->appointmentService->create($appointment);
        }
    }
}