<?php

// Include the SignatureController class
require_once 'c:\\users\micha\grants\laravel\app\Http\Controllers\SignatureController.php'; 



// Import the necessary classes
use App\Http\Controllers\SignatureController;
use App\Models\Application;
use App\Models\User;

// Create an instance of the SignatureController
$signatureController = new SignatureController();

// Example data for testing
$application = new Application(); // You need to replace this with actual Application data
$user = new User(); // You need to replace this with actual User data

// Test the createSigning method
$newContract = $signatureController->createSigning($application, $user);

// Display the result of createSigning
echo "createSigning Result:\n";
print_r($newContract);

// Test the SigningStatus method
$signatureStatus = $signatureController->SigningStatus($newContract); // Assuming $newContract is a valid Signature instance

// Display the result of SigningStatus
echo "\nSigningStatus Result: $signatureStatus\n";