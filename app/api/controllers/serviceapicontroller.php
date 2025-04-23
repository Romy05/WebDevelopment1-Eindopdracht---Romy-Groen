<?php
namespace App\Api\Controllers;
use App\Models\Service;
use App\Services\ServiceService;

class ServiceApiController{

    private ServiceService $serviceService;

    function __construct()
    {
        $this->serviceService = new \App\Services\ServiceService();
    }

    public function index(){
        if ($_SERVER['REQUEST_METHOD'] == "GET") {

            $services = $this->serviceService->getAll();
            $json= json_encode($services);
            header("Content-type: application/json");
            echo $json;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $json = file_get_contents('php://input');
            $object = json_decode($json);

            $service = new Service();
            $service->setId($object->id);
            $service->setName($object->name);
            $service->setDescription($object->description);
            $service->setDurationInMinutes($object->duration_minutes);
            $service->setPrice($object->price);


            $this->serviceService->insert($service);
        }
    }
}