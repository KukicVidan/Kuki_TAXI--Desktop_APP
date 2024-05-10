<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $date = $_POST["date"];
    $location = $_POST["location_from"];
    $location2 = $_POST["location_to"];
    $amount = $_POST["amount"];
    $client = $_POST["client_name"];

    // Database connection
    require_once "db_connection.php";

    // Prepare SQL statement
    $sql = "INSERT INTO taxi_drives (date, location_from, location_to, amount, client_name) VALUES (:date, :location_from, :location_to, :amount, :client_name)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':location_from', $location);
    $stmt->bindParam(':location_to', $location2);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':client_name', $client);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "Uspesno unjeto u bazu!";
        header("Location: input_form.php");
        exit;
    } else {
        echo "Error: " . $conn->lastErrorMsg();
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the form page if accessed directly
    header("Location: input_form.php");
    exit;
}
?>
