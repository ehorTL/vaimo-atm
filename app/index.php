<?php

/**
 Main script for application work demonstration.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\User\User;
use App\Models\User\Gender;

$users = array();
$user1 = new User('Alice', 'Smith', Gender::MALE, [],[], null);
$user2 = new User('Bob', 'Brown', Gender::FEMALE, [], [], null);
$users[] = $user1;
$users[] = $user2;

//print_r($user1);
//print_r($user2);
//print_r($users);





