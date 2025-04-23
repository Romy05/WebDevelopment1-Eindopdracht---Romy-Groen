<?php
namespace App\Services;

use App\Models\Appointment;
use App\Repositories\AppointmentRepository;

class AppointmentService {

    
    public function getAll() {
        $repository = new AppointmentRepository();
        return $repository->getAll();
    }
 
    public function create(Appointment $appointment) {
        $repository = new AppointmentRepository();
        return $repository->addAppointment($appointment);
    }
    public function getByWeek($week){
        $repository = new AppointmentRepository();
        return $repository->getByWeek($week);
    }
}
