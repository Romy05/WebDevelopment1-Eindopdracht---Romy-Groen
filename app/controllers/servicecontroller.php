<?php
namespace App\Controllers;
use App\Models\Enums\UserType;

class ServiceController
{

    private $serviceService;

    function __construct()
    {
        $this->serviceService = new \App\Services\ServiceService();
    }

    public function index()
    {
        $model = $this->serviceService->getAll();
        require __DIR__ . '/../views/service/index.php';
    }

    public function create()
    {
        
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            require __DIR__ . '/../views/service/create.php';
        }
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $name = htmlspecialchars($_POST['name']);
            $price = htmlspecialchars($_POST['price']);
            $description = htmlspecialchars($_POST['description']);
            $duration_minutes = htmlspecialchars($_POST['duration_minutes']);
            
            $service = new \App\Models\Service();
            $service->name = $name;
            $service->description = $description;
            $service->price = $price;
            $service->duration_minutes = $duration_minutes;
            $this->serviceService->insert($service);
            $this->index();
        }  
    }
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            $id = $_GET['id'];
            $model = $this->serviceService->getById($id);
            var_dump($model);
            require __DIR__ . '/../views/service/edit.php';
        }
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            
            $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
            $model = $this->serviceService->getById($id);
            
            $name = htmlspecialchars($_POST['name']);
            $description = !empty($_POST['description']) ? htmlspecialchars($_POST['description']) : "";
            $price = htmlspecialchars($_POST['price']);
            $duration_minutes = htmlspecialchars($_POST['duration_minutes']);
            
           

            $service = new \App\Models\Service();
            $service->name = $name;
            $service->description = $description;
            $service->price = $price;
            $service->duration_minutes = $duration_minutes;
            $service->id=$id;
            
            $this->serviceService->update($service);
            $this->index();
        }
    }
    public function delete()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            $id = $_GET['id'];
            
            if ($this->serviceService->delete($id)){
                $this->index();
            } else {
                echo "Something went wrong while deleting the service";
            }
        }
    }
}