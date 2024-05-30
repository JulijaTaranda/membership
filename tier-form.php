<?php

// Import functions
require_once 'functions.php';

// To avoid duplicated code, this form will be used to create or update tier. If the url is called with id= then we are using it to edit the user with the specified id. 
if (isset($_GET['id'])) {
    // Get the $id from the URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // user information from the database
    try {
        // Connect to the database using the connect() function in functions.php
        $db = connect();

        // Create $tierQuery to get the tier's information here
        $tierQuery = $db->prepare('SELECT * FROM tiers WHERE id= :id');
        // Execute the query here
        $tierQuery->execute(['id' => $id]);
        // Fetch data and assign it to $tier
        $tier = $tierQuery->fetch();
    } catch (Exception $e) {
        // Echo the message if there was an exception
        echo $e->getMessage();
    }

    // Close the database connection here
     $db = null;
}

// Get the tiers 
$tiers = getTiers();

?>

<?php require_once '_header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Home</a>
<a href='tiers.php' class='btn btn-secondary m-2 active' role='button'>Tiers</a>

<div style='margin:20px'>
    <div class='row'>
        <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Tier Form</h1>
    </div>
    <div class='row'>
        <form method='post' action='add-edit-tier.php'>
            <!--  Add a hidden field with the ID (if it exists) so it is sent with the form -->
            <input type='hidden' name='id' value='<?= $tier['id'] ?? '' ?>'>
            <div class='form-group my-3'>
                <label for='firstName'>Title</label>
                <input type='text' name='title' class='form-control' id='title' placeholder='Enter title' required
                    autofocus value='<?= isset($tier['title']) ? htmlentities($tier['title']) : '' ?>'>
            </div>
            <div class='form-group my-3'>
                <label for='price'>Price</label>
                <input type='number' name='price' class='form-control' id='price' placeholder='Enter price' required
                    value='<?= isset($tier['price']) ? htmlentities($tier['price'])  : '' ?>'>
            </div>
            <button type='submit' class='btn btn-primary my-3' name='submit'>Submit</button>
        </form>
    </div>
    <a href="/tiers.php">Back</a>
</div>

<?php require_once '_footer.php' ?>