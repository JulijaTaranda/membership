<?php
require_once 'functions.php';

// Check if member ID is in URL
if (isset($_GET['id'])) {

    // Get $id from the URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {
        // Connect to the database using the connect() function from functions.php
        $db = connect();

        // Create the SQL statement here to delete a member by id
        $deleteMemberStmt = $db->prepare('DELETE FROM members WHERE id = :id');
        // Execute it here
        $deleteMemberStmt->execute(['id' => $id]);
        
    
        // Let's check if a row was affected with the rowCount() method
        if ($deleteMemberStmt->rowCount()) {
            // Row was deleted, let's set a success message
            $type = 'success';
            $message = 'Member deleted';
        } else {
            // No row was deleted, let's set an error message
            $type = 'error';
            $message = 'Member not deleted';
        }

    } catch (Exception $e) {
        // An exception was thrown, let's set the exception's message
        $type = 'error';
        $message = 'Exception message: ' . $e->getMessage();
    }
    // Close the database connection
    $deleteMemberStmt = null;
    $db = null;

    // Re-redirect back to the main member page, pass the message and message type as GET variables
    header('location:' . 'members.php?type=' . $type . '&message=' . $message);
} else {
    //Redirect to Home page if there is no member ID
    header('location:'. 'index.php');
}