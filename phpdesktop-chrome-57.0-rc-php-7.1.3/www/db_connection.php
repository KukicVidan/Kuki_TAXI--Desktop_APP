<?php
// Specify the path to your SQLite database file
$database_file = "lenkomi.db";

// Attempt to open the database connection
try {
    // Create a new SQLite3 instance
    $conn = new SQLite3($database_file);

    // Check if the connection was successful
    if (!$conn) {
        throw new Exception("Unable to open database.");
    }
} catch (Exception $e) {
    // Handle any exceptions (errors) that occur during the connection process
    echo "Error: " . $e->getMessage();
    exit; // Terminate the script
}
?>
