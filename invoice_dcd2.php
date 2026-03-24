<?php
include 'dbconfig.php';

// Get current page number and search query from query parameters
$pageNumber = isset($_GET['page']) ? intval($_GET['page']) : 1;
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$recordsPerPage = 100; // Number of records per page
$offset = ($pageNumber - 1) * $recordsPerPage;

// Define the SQL query to retrieve data with search functionality
$sqlQuery = "
    SELECT depot_name, inv, COUNT(*) as count
    FROM raheel1 
    WHERE product_name = 'DIGAS COLIC DROP 20ML'
    AND (
            ivc_date = '23-Jul-24' OR ivc_date = '24-Jul-24' OR ivc_date = '25-Jul-24' OR ivc_date = '26-Jul-24' OR
            ivc_date = '27-Jul-24' OR ivc_date = '28-Jul-24' OR ivc_date = '29-Jul-24' OR ivc_date = '30-Jul-24' OR
            ivc_date = '31-Jul-24'
        )
    AND (
        depot_name LIKE '%$searchQuery%' OR
        inv LIKE '%$searchQuery%'
    )
    GROUP BY depot_name, inv
    HAVING COUNT(*) > 1
    LIMIT $offset, $recordsPerPage
";

// Execute the query
$result = mysqli_query($conn, $sqlQuery);

// Check if query execution was successful
if (!$result) {
    die(json_encode(['error' => "Query failed: " . mysqli_error($conn)]));
}

// Fetch the results
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Get total record count with search
$totalQuery = "
    SELECT COUNT(*) as total
    FROM (
        SELECT 1
        FROM raheel1 
        WHERE product_name = 'DIGAS COLIC DROP 20ML'
        AND (
            ivc_date = '23-Jul-24' OR ivc_date = '24-Jul-24' OR ivc_date = '25-Jul-24' OR ivc_date = '26-Jul-24' OR
            ivc_date = '27-Jul-24' OR ivc_date = '28-Jul-24' OR ivc_date = '29-Jul-24' OR ivc_date = '30-Jul-24' OR
            ivc_date = '31-Jul-24'
        )
        AND (
            depot_name LIKE '%$searchQuery%' OR
            inv LIKE '%$searchQuery%'
        )
        GROUP BY depot_name, inv
        HAVING COUNT(*) > 1
    ) as countTable
";

// Execute the total count query
$totalResult = mysqli_query($conn, $totalQuery);
if (!$totalResult) {
    die(json_encode(['error' => "Total count query failed: " . mysqli_error($conn)]));
}

$total = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($total / $recordsPerPage);

// Output the data and pagination info as JSON
$response = [
    'data' => $rows,
    'totalPages' => $totalPages,
    'totalRecords' => $total
];

echo json_encode($response);
?>
