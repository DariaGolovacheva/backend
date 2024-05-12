<?php

function print_error($error)
{
    print($error);
    exit();
}

function validate_data($data)
{
    $errors = [];

    // Validate Full Name (fio)
    if (empty($data['fio'])) {
        $errors['fio'] = 'Please enter your full name.';
    } elseif (strlen($data['fio']) > 255) {
        $errors['fio'] = 'Full name must be less than 255 characters.';
    }

    // Validate Telephone Number (telephone)
    if (empty($data['telephone'])) {
        $errors['telephone'] = 'Please enter your telephone number.';
    } elseif (!preg_match('/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/', $data['telephone'])) {
        $errors['telephone'] = 'Invalid telephone number.';
    }

    // Validate Email Address (email)
    if (empty($data['email'])) {
        $errors['email'] = 'Please enter your email address.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email address format.';
    }

    // Validate Date of Birth (bday)
    if (empty($data['bday'])) {
        $errors['bday'] = 'Please enter your date of birth.';
    } // Additional validation for date of birth can be added if needed

    // Validate Gender (sex)
    if (empty($data['sex'])) {
        $errors['sex'] = 'Please select your gender.';
    } // Additional validation for gender can be added if needed

    // Validate Selected Programming Languages (langs)
    if (empty($data['langs'])) {
        $errors['langs'] = 'Please select at least one programming language.';
    } // Additional validation for selected programming languages can be added if needed

    // Validate Biography (biography)
    if (empty($data['biography'])) {
        $errors['biography'] = 'Please enter your biography.';
    } elseif (strlen($data['biography']) > 512) {
        $errors['biography'] = 'Biography must be less than 512 characters.';
    }

    // Validate Agreement to Terms and Conditions (contract)
    if (empty($data['contract'])) {
        $errors['contract'] = 'Please agree to the terms and conditions.';
    }

    // If there are no errors, return true
    // Otherwise, return the array of errors
    return empty($errors) ? true : $errors;
}

function save_to_database($data)
{
    // Database connection details
    $user = 'u67498'; // Replace with your database username
    $pass = '2427367'; // Replace with your database password
    $dbname = 'u67498'; // Replace with your database name

    try {
        // Establish database connection
        $db = new PDO('mysql:host=localhost;dbname=' . $dbname, $user, $pass, [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Prepare INSERT statement for users table
        $user_stmt = $db->prepare("INSERT INTO users (full_name, telephone, email, date_of_birth, gender, biography, agreed_to_terms) VALUES (?, ?, ?, ?, ?, ?, 1)");

        // Bind parameters and execute INSERT statement
        $user_stmt->execute([$data['fio'], $data['telephone'], $data['email'], $data['bday'], $data['sex'], $data['biography']]);

        // Prepare INSERT statement for user_programming_languages table
        $lang_stmt = $db->prepare("INSERT INTO user_programming_languages (user_id, lang_id) VALUES (?, ?)");

        // Assuming $data['langs'] is an array of selected programming languages
        foreach ($data['langs'] as $lang) {
            // Bind parameters and execute INSERT statement for each language
            $lang_stmt->execute([$db->lastInsertId(), $lang]);
        }

        // Print success message
        print("Data successfully saved to the database.");
    } catch (PDOException $e) {
        // Handle database connection errors
        print_error($e->getMessage());
    }
}

header('Content-Type: text/html; charset=UTF-8');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate form data
    $form_data = $_POST;
    $validation_result = validate_data($form_data);

    if ($validation_result === true) {
        // If validation succeeds, save data to the database
        save_to_database($form_data);
    } else {
        // If validation fails, display validation errors
        foreach ($validation_result as $error) {
            echo "<p>Error: $error</p>";
        }
    }
}

// Include form HTML
include('form.php');
?>
