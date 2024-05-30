<?php
require_once 'functions.php';

// Check if tier ID is in URL
if (isset($_GET['id'])) {

    // Get $id from the URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {

        // Connect to the database using the connect() function in functions.php
        $db = connect();

        // Before deleting a tier, let's check that members are not on that tier
        $tierQuery = $db->prepare('SELECT * FROM members WHERE tier_id = :id');
        // Execute the query
        $tierQuery->execute(['id' => $id]);
        // Assign information to the variable $tier
        $tier = $tierQuery->fetch(PDO::FETCH_ASSOC);
        // If a user is on that tier, create an error and re-direct to the tiers page
        if ($tier) {
            $type = 'error';
            $message = 'Tier cannot be deleted because a user is on the tier';
        } else {
            // No user on that tier, let's delete it

            // the statement to delete a tier by id
            $deleteTierStmt = $db->prepare('DELETE FROM tiers WHERE id = :id');
            // Execute it here
            $deleteTierStmt-> execute(['id' => $id]);
            // check if a row was affected with the rowCount() method
            if ($deleteTierStmt->rowCount()) {
                // Row was deleted, let's set a success message
                $type = 'success';
                $message = 'Tier deleted';
            } else {
                // No row was deleted, let's set an error message
                $type = 'error';
                $message = 'Tier not deleted';
            }
        }
    } catch (Exception $e) {
        // An exception was thrown, let's set the exception's message
        $type = 'error';
        $message = 'Exception message: ' . $e->getMessage();
    }
    // Close the database connection
    $tierQuery = null;
    $deleteTierStmt = null;
    $db = null;

    // Re-redirect back to the main tiers page, pass the message and message type as GET variables
    header('location:' . 'tiers.php?type=' . $type . '&message=' . $message);
} else {
    //Redirect to Home page
    header('location:' . 'index.php');
}