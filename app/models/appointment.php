<?php
namespace App\Models;
use JsonSerializable;

class Appointment implements JsonSerializable {
    
    public $services = [];
    public int $id;
    public int $userId;
    public string $license_plate;
    public string $date;

    // JSON Serialization method
    public function jsonSerialize(): mixed {
        return get_object_vars($this); // Returns an associative array of all properties
    }

    public function getTotalDurationInMinutes(): int {
        $totalDuration = 0;

        foreach ($this->services as $service) {
            $totalDuration += $service->getDurationInMinutes(); // Add the duration of each service to the total
        }

        return $totalDuration;
    }

    // Getters and Setters

    /**
     * Get the value of id
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Set the value of id
     * @param int $id
     * @return self
     */
    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of userId
     * @return int
     */
    public function getUserId(): int {
        return $this->userId;
    }

    /**
     * Set the value of userId
     * @param int $userId
     * @return self
     */
    public function setUserId(int $userId): self {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get the value of license_plate
     * @return string
     */
    public function getLicensePlate(): string {
        return $this->license_plate;
    }

    /**
     * Set the value of license_plate
     * @param string $licensePlate
     * @return self
     */
    public function setLicensePlate(string $licensePlate): self {
        $this->license_plate = $licensePlate;
        return $this;
    }

    /**
     * Get the value of date
     * @return string
     */
    public function getDate(): string {
        return $this->date;
    }

    /**
     * Set the value of date
     * @param string $date
     * @return self
     */
    public function setDate(string $date): self {
        $this->date = $date;
        return $this;
    }

    /**
     * Get the value of services
     * @return array
     */
    public function getServices(): array {
        return $this->services;
    }

    /**
     * Set the value of services
     * @param array $services
     * @return self
     */
    public function setServices(array $services): self {
        $this->services = $services;
        return $this;
    }
}
?>
