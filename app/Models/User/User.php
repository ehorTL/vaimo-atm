<?php

namespace App\Models\User;

class User{
    private $firstName;
    private $lastName;
    private $gender;
    private $phoneNumbers;
    private $emails;

    private $otherPassportData;

    function __construct($firstName, $lastName, $gender, $phoneNumbers, $emails, $otherPassportData)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->phoneNumbers = $phoneNumbers;
        $this->emails = $emails;
        $this->otherPassportData = $otherPassportData;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function getGender(){
        return $this->gender;
    }

    public function getPhoneNumbers(){
        return $this->phoneNumbers;
    }

    public function getEmails(){
        return $this->emails;
    }
}