<?php
namespace App\Models;
use App\Models\Enums\UserType;
use JsonSerializable;
class User implements JsonSerializable {

    public int $id;
    public string $email;
    public string $hashed_password;
    public string $salt;
    public UserType $type_of_user; 
    public ?string $first_name;
    public ?string $last_name;
    public ?string $phone_number;
    public string $address;
    public string $city;
    public string $zip;


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
     * Get the value of email
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Set the value of email
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    /**
     * Get the value of password
     * @return string
     */
    public function getPassword(): string {
        return $this->hashed_password;
    }

    /**
     * Set the value of password
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self {
        $this->hashed_password = $password;
        return $this;
    }

    /**
     * Get the value of salt
     * @return string
     */
    public function getSalt(): string {
        return $this->salt;
    }

    /**
     * Set the value of salt
     * @param string $salt
     * @return self
     */
    public function setSalt(string $salt): self {
        $this->salt = $salt;
        return $this;
    }

    /**
     * Get the value of type (UserType)
     * @return UserType
     */
    public function getType(): UserType {
        return $this->type_of_user;
    }

    /**
     * Set the value of type (UserType)
     * @param UserType $type
     * @return self
     */
    public function setType(UserType $type_of_user): self {
        $this->type_of_user = $type_of_user;
        return $this;
    }

     /**
     * @return string
     */
    public function getFirstName(): string {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return self
     */
    public function setFirstName(string $first_name): self {
        $this->first_name = $first_name;
        return $this;
    }

     /**
     * @return string
     */
    public function getLastName(): string {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return self
     */
    public function setLastName(string $last_name): self {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * Get the value of phone_number
     * @return string
     */
    public function getPhoneNumber(): string {
        return $this->phone_number;
    }

    /**
     * Set the value of phoneNumber
     * @param string $phone_number
     * @return self
     */
    public function setPhoneNumber(string $phone_number): self {
        $this->phone_number = $phone_number;
        return $this;
    }

    /**
     * Get the value of address
     * @return string
     */
    public function getAddress(): string {
        return $this->address;
    }

    /**
     * Set the value of address
     * @param string $address
     * @return self
     */
    public function setAddress(string $address): self {
        $this->address = $address;
        return $this;
    }

    /**
     * Get the value of city
     * @return string
     */
    public function getCity(): string {
        return $this->city;
    }

    /**
     * Set the value of city
     * @param string $city
     * @return self
     */
    public function setCity(string $city): self {
        $this->city = $city;
        return $this;
    }

    /**
     * Get the value of zip
     * @return string
     */
    public function getZip(): string {
        return $this->zip;
    }

    /**
     * Set the value of zip
     * @param string $zip
     * @return self
     */
    public function setZip(string $zip): self {
        $this->zip = $zip;
        return $this;
    }
}
?>
