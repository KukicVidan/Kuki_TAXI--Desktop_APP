<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $date = $_POST["date"];
    $location = $_POST["location_from"];
    $location2 = $_POST["location_to"];
    $amount = $_POST["amount"];
    $client = $_POST["client_name"];

    // Validate form fields
    if (empty($date) || empty($location) || empty($amount) || empty($client)) {
        echo "Popunite sva polja.";
    } else {
        // Database connection
        require_once "db_connection.php";

        // Prepare SQL statement with placeholders
        $sql = "INSERT INTO taxi_drives (date, location_from, location_to, amount, client_name) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters to the prepared statement
        $stmt->bindParam(1, $date);
        $stmt->bindParam(2, $location);
        $stmt->bindParam(3, $location2);
        $stmt->bindParam(4, $amount);
        $stmt->bindParam(5, $client);

        // Execute SQL statement
        if ($stmt->execute()) {
            // Close statement
            $stmt->close();

            // Close connection
            $conn->close();

            // Redirect to the form page if inserted successfully
            header("Location: input_form.php");
            exit;
        } else {
            echo "Error: " . $conn->lastErrorMsg();
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    // Redirect to the form page if accessed directly
    header("Location: input_form.php");
    exit;
}
?>

