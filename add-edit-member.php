<?php

require_once 'functions.php';

if (!empty($_POST)) {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $address = $_POST['address'] ?? '';
    $tier_id = filter_input(INPUT_POST, 'tier_id', FILTER_SANITIZE_NUMBER_INT);

    // Connect to the database using a function imported from functions.php
    $db = connect();

    // A member has an ID only if their information has been saved in the database, check if the member has an ID.
    if (empty($_POST['id'])) {
         // There is no ID, so member doesn't exist in the database. Let's add them.
         try {
            // Insert a member into the database.
            $createMemberStmt = $db->prepare('INSERT INTO members (first_name, last_name, address, tier_id) VALUES (:first_name, :last_name, :address, :tier_id)');
            // Execute it here
            $createMemberStmt->execute(['first_name'=>$first_name, 'last_name'=>$last_name, 'address'=>$address, 'tier_id'=>$tier_id]);
            // rowCount() function to check if a row was modified. If so, assume the statement was successful, otherwise, it likely failed.
            if ($createMemberStmt->rowCount()) {
                // A row was inserted, let's set a success message
                $type = 'success';
                $message = 'Member added';
            } else {
                // No row was inserted, let's set an error message
                $type = 'error';
                $message = 'Member not added';
            }
        } catch (Exception $e) {
            // Member was not added, let's set the exception message
            $type = 'error';
            $message = 'Member not added: ' . $e->getMessage();
        }
    } else {
        // Member exists in the database so we'll update the record

        // Get the member ID
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        // Write the SQL statement to update member information
        try {
            // Update member information
            $updateMemberStmt = $db->prepare('UPDATE members SET first_name = :first_name, last_name = :last_name, address = :address, tier_id = :tier_id WHERE id = :id');
            // Execute it here
           $updateMemberStmt->execute(['first_name' => $first_name, 'last_name' => $last_name, 'address' => $address, 'tier_id' => $tier_id, 'id' => $id]);
            // rowCount() function to check if a row was modified. If so, assume the statement was successful, otherwise, it likely failed.
            if ($updateMemberStmt->rowCount()) {
                // Row was updated, set a success message
                $type = 'success';
                $message = 'Member updated';
            } else {
                // No row was updated, set an error message
                $type = 'error';
                $message = 'Member not updated';
            }
        } catch (Exception $e) {
            // An exception was thrown, let's set the exception's message
            $type = 'error';
            $message = 'Member not updated: ' . $e->getMessage();
        }
    }

    // Close the database connection
    $createMemberStmt = null;
    $updateMemberStmt = null;
    $db = null;

    // Re-redirect back to the main member page, pass the message and message type as GET variables
    header('location:' . 'members.php?type=' . $type . '&message=' . $message);
}