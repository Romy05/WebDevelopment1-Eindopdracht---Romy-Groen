<?php
namespace App\Models\enums;
use jsonSerializable;
enum UserType :string implements JsonSerializable {
    case Employee = 'employee';
    case Customer = 'customer';

    public function jsonSerialize(): string {
        return match($this) {
            UserType::Employee => 'employee',
            UserType::Customer => 'customer'
        };
    }

}