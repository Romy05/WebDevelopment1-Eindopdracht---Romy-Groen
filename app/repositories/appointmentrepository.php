<?php
namespace App\Repositories;

use PDO;
use App\Models\Appointment;
use App\Models\Service;

class AppointmentRepository extends Repository{

    public function getAll() {
        // Fetch all appointments from the 'appointments' table
        $stmt = $this->connection->prepare("SELECT * FROM appointments");
        $stmt->execute();
        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Initialize an array to store appointment objects
        $appointmentsWithServices = [];

        foreach ($appointments as $appointmentRow) {
            $appointment = new Appointment();
            $appointment->id = (int)$appointmentRow['id'];
            $appointment->userId = (int)$appointmentRow['user_id'];
            $appointment->license_plate = $appointmentRow['license_plate'];
            $appointment->date = $appointmentRow['date'];

            // Fetch associated services for the current appointment
            $servicesStmt = $this->connection->prepare("
                SELECT s.id, s.name, s.description, s.duration_minutes, s.price 
                FROM services s
                JOIN appointment_services as_table ON s.id = as_table.service_id
                WHERE as_table.appointment_id = :appointment_id
            ");
            $servicesStmt->bindParam(':appointment_id', $appointment->id, PDO::PARAM_INT);
            $servicesStmt->execute();
            $servicesRows = $servicesStmt->fetchAll(PDO::FETCH_ASSOC);

            // Initialize an array for the services of this appointment
            $services = [];
            foreach ($servicesRows as $serviceRow) {
                $service = new Service();
                $service->id = (int)$serviceRow['id'];
                $service->name = $serviceRow['name'];
                $service->description = $serviceRow['description'];
                $service->duration_minutes = (int)$serviceRow['duration_minutes'];
                $service->price = (float)$serviceRow['price'];
                $services[] = $service;
            }

            // Assign the services to the current appointment
            $appointment->services = $services;

            // Add the appointment (with services) to the result array
            $appointmentsWithServices[] = $appointment;
        }

        return $appointmentsWithServices; // Return the array of appointments with services
    }
    public function getByWeek(int $weekOffset) {
        // Calculate start and end date for the week
        $startOfWeek = date('Y-m-d', strtotime("Monday this week +$weekOffset week"));
        $endOfWeek = date('Y-m-d', strtotime("Sunday this week +$weekOffset week"));
    
        // Fetch appointments within the given date range
        $stmt = $this->connection->prepare("
            SELECT * FROM appointments 
            WHERE date BETWEEN :start_date AND :end_date
        ");
        $stmt->bindParam(':start_date', $startOfWeek, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endOfWeek, PDO::PARAM_STR);
        $stmt->execute();
        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Initialize an array to store appointments with their associated services
        $appointmentsWithServices = [];
    
        foreach ($appointments as $appointmentRow) {
            // Create an Appointment object and assign data
            $appointment = new Appointment();
            $appointment->id = (int)$appointmentRow['id'];
            $appointment->userId = (int)$appointmentRow['user_id'];
            $appointment->license_plate = $appointmentRow['license_plate'];
            $appointment->date = $appointmentRow['date'];
    
            // Fetch associated services for the current appointment
            $servicesStmt = $this->connection->prepare("
                SELECT s.id, s.name, s.description, s.duration_minutes, s.price 
                FROM services s
                JOIN appointment_services as_table ON s.id = as_table.service_id
                WHERE as_table.appointment_id = :appointment_id
            ");
            $servicesStmt->bindParam(':appointment_id', $appointment->id, PDO::PARAM_INT);
            $servicesStmt->execute();
            $servicesRows = $servicesStmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Initialize an array for the services of this appointment
            $services = [];
            foreach ($servicesRows as $serviceRow) {
                $service = new Service();
                $service->id = (int)$serviceRow['id'];
                $service->name = $serviceRow['name'];
                $service->description = $serviceRow['description'];
                $service->duration_minutes = (int)$serviceRow['duration_minutes'];
                $service->price = (float)$serviceRow['price'];
                $services[] = $service;
            }
    
            // Assign the services to the current appointment
            $appointment->services = $services;
    
            // Add the appointment (with services) to the result array
            $appointmentsWithServices[] = $appointment;
        }
    
        return $appointmentsWithServices; // Return the array of appointments with services
    }
    
    public function addAppointment(Appointment $appointment): bool {
        // Directly use PHP's built-in DateTime class
        $dateObj = \DateTime::createFromFormat('M d', $appointment->date);
        
        if ($dateObj) {
            $formattedDate = $dateObj->format('Y-m-d');  // Now it's in the correct format
        } else {
            // Handle error: Invalid date format
            throw new Exception('Invalid date format');
        }
    
        try {
            // Start a transaction
            $this->connection->beginTransaction();
    
            // Insert appointment into the appointments table using the Appointment object
            $stmt = $this->connection->prepare("
                INSERT INTO appointments (user_id, license_plate, date)
                VALUES (:user_id, :license_plate, :date)
            ");
            $stmt->bindParam(':user_id', $appointment->userId, PDO::PARAM_INT);
            $stmt->bindParam(':license_plate', $appointment->license_plate, PDO::PARAM_STR);
            $stmt->bindParam(':date', $formattedDate, PDO::PARAM_STR);
    
            // Execute the query and check for success
            if (!$stmt->execute()) {
                // If insertion failed, roll back the transaction
                $this->connection->rollBack();
                return false;
            }
    
            // Get the last inserted appointment ID
            $appointmentId = $this->connection->lastInsertId();
    
            // Now associate the services with the new appointment
            foreach ($appointment->services as $service) {
                // Insert each service into the appointment_services table
                $serviceStmt = $this->connection->prepare("
                    INSERT INTO appointment_services (appointment_id, service_id)
                    VALUES (:appointment_id, :service_id)
                ");
                $serviceStmt->bindParam(':appointment_id', $appointmentId, PDO::PARAM_INT);
                $serviceStmt->bindParam(':service_id', $service->id, PDO::PARAM_INT);
    
                // If any service insertion fails, roll back the transaction
                if (!$serviceStmt->execute()) {
                    $this->connection->rollBack();
                    return false;
                }
            }
    
            // Commit the transaction since everything was successful
            $this->connection->commit();
    
            return true; // Successfully added the appointment and services
        } catch (Exception $e) {
            // In case of an error, roll back the transaction
            $this->connection->rollBack();
            return false;
        }
    }        
}