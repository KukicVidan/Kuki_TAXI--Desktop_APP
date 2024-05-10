<?php
// Include the database connection file
require_once "db_connection.php";

// Query to fetch all data from the database
$sql = "SELECT * FROM taxi_drives ORDER BY date";

// Execute the query
$result = $conn->query($sql);

// Check if there are any results
if ($result) {
    // Initialize an array to store the results grouped by month
    $results_by_month = array();
    $total_earned_per_month = array(); // Array to store total earnings for each month

    // Loop through each row of the result set
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        // Extract the month and year from the date_of_drive field
        $month_year = date('F Y', strtotime($row['date']));

        // Add the money_amount to the total for the corresponding month
        if (!isset($total_earned_per_month[$month_year])) {
            $total_earned_per_month[$month_year] = 0;
        }
        $total_earned_per_month[$month_year] += $row['amount'];

        // Add the row to the corresponding month in the results array
        $results_by_month[$month_year][] = $row;
    }

    // Display the results
    echo "<h1>Zarada po mjesecu: <strong><br><br>";
    // Calculate the total amount earned
    $total_amount_earned = 0;
    foreach ($results_by_month as $month => $drivings) {
        echo "<details>";
        echo "<summary>⬇️$month</summary>";
        echo "<ul>";
        // Loop through the drivings for the current month
        foreach ($drivings as $driving) {
            echo "<li>📅{$driving['date']}.    ({$driving['location_from']} 🚕 {$driving['location_to']})   -  <span>{$driving['amount']}💸</span> :📞 {$driving['client_name']}</li>";
            // Add the money_amount to the total
            $total_amount_earned += $driving['amount'];
        }
        echo "</ul>";
        // Display total earnings for the current month
        echo "<span>Ukupno zaradeno u ovom mjesecu:</span> 💸<span>{$total_earned_per_month[$month]}</span> BAM";
        echo "</details>";
    }
    echo "<br>Kuki taxi zarada do sad: 💸<span>$total_amount_earned</span>  BAM</strong></h1>";
} else {
    echo "Nema voznji.";
}

// Close the database connection
$conn->close();
?>
