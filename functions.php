<?php

// Connect to the database and return the database object
function connect() {

    $hostname = 'localhost';
    $dbname = 'tiers';
    $username = 'root';
    $password = 'pass';

    $dsn = "mysql:host=$hostname;dbname=$dbname";
    
    try{
      return $db = new PDO($dsn, $username, $password);
    } catch (Exception $e) {
      echo $e->getMessage();
    }
}

// Get a list of all tiers in the database
function getTiers() {
    try {
        // Get the database object
        $db = connect();

        // Create a query to get all fields for all tiers
        $tiersQuery = $db->query('SELECT * FROM tiers');
        // Return all records
       return  $tiersQuery->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        // If an error occurs echo the error
        echo $e->getMessage();
    }
}