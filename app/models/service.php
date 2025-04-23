<?php
namespace App\Models;
use JsonSerializable;
class Service implements JsonSerializable {
    
    public int $id;
    public string $name;
    public ?string $description;
    public int $duration_minutes;
    public float $price;


    public function jsonSerialize(): mixed {
        return get_object_vars($this); 
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
     * Get the value of name
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the value of name
     * @param string $name
     * @return self
     */
    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the value of description
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Set the value of description
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }

    /**
     * Get the value of duration_minutes$duration_minutes
     * @return int
     */
    public function getDurationInMinutes(): int {
        return $this->duration_minutes;
    }

    /**
     * Set the value of duration_minutes$duration_minutes
     * @param int $duration_minutes
     * @return self
     */
    public function setDurationInMinutes(int $duration_minutes): self {
        $this->duration_minutes = $duration_minutes;
        return $this;
    }

    /**
     * Get the value of price
     * @return float
     */
    public function getPrice(): float {
        return $this->price;
    }

    /**
     * Set the value of price
     * @param float $price
     * @return self
     */
    public function setPrice(float $price): self {
        $this->price = $price;
        return $this;
    }
    public function getMilitaryTime(): string {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        return sprintf('%02d:%02d', $hours, $minutes);
    }
}
?>
