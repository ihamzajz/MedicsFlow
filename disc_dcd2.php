<?php
include 'dbconfig.php';

// Get current page number and search query from query parameters
$pageNumber = isset($_GET['page']) ? intval($_GET['page']) : 1;
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$recordsPerPage = 100; // Number of records per page
$offset = ($pageNumber - 1) * $recordsPerPage;

// Function to calculate free products
function calculateFreeProducts($quantity) {
    $freeProducts = 0;

    while ($quantity >= 100) {
        $freeProducts += 15;
        $quantity -= 100;
    }
    while ($quantity >= 50) {
        $freeProducts += 6;
        $quantity -= 50;
    }
    while ($quantity >= 11) {
        $freeProducts += 1;
        $quantity -= 11;
    }

    return $freeProducts;
}

// Define the SQL query to retrieve paginated data
$sqlQuery = "
    SELECT inv, SUM(sales_qty) as total_sales_qty, SUM(bounty_qty) as total_bounty_qty, dp, depot_name, cust, customer_name, address, class, ivc_date, prd, pack, batch, sales_value, tp_medics, cp_medics, cp_value, deff, product_name 
    FROM raheel1 
    WHERE product_name = 'DIGAS COLIC DROP 20ML'
           AND (
            ivc_date = '23-Jul-24' OR
            ivc_date = '24-Jul-24' OR 
            ivc_date = '25-Jul-24' OR 
            ivc_date = '26-Jul-24' OR
            ivc_date = '27-Jul-24' OR
            ivc_date = '28-Jul-24' OR
            ivc_date = '29-Jul-24' OR 
            ivc_date = '30-Jul-24' OR
            ivc_date = '31-Jul-24'
        )
AND (
    dp LIKE '%$searchQuery%' OR
    depot_name LIKE '%$searchQuery%' OR
    cust LIKE '%$searchQuery%' OR
    customer_name LIKE '%$searchQuery%' OR
    address LIKE '%$searchQuery%' OR
    class LIKE '%$searchQuery%' OR
    inv LIKE '%$searchQuery%' OR
    ivc_date LIKE '%$searchQuery%' OR
    prd LIKE '%$searchQuery%' OR
    product_name LIKE '%$searchQuery%' OR
    pack LIKE '%$searchQuery%' OR
    batch LIKE '%$searchQuery%' OR
    sales_qty LIKE '%$searchQuery%' OR
    sales_value LIKE '%$searchQuery%' OR
    bounty_qty LIKE '%$searchQuery%' OR
    bonus_value LIKE '%$searchQuery%' OR
    tp_medics LIKE '%$searchQuery%' OR
    cp_medics LIKE '%$searchQuery%' OR
    cp_value LIKE '%$searchQuery%' OR
    deff LIKE '%$searchQuery%'
)
    GROUP BY inv
    HAVING SUM(bounty_qty) != SUM(CASE
        WHEN sales_qty >= 100 THEN FLOOR(sales_qty / 100) * 15
        WHEN sales_qty >= 50 THEN FLOOR(sales_qty / 50) * 6
        WHEN sales_qty >= 11 THEN FLOOR(sales_qty / 11)
        ELSE 0
    END)
    LIMIT $offset, $recordsPerPage
";

// Retrieve paginated data
$result = mysqli_query($conn, $sqlQuery);

if (!$result) {
    die(json_encode(['error' => "Query failed: " . mysqli_error($conn)]));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['expected_bonus_qty'] = calculateFreeProducts($row['total_sales_qty']);
    $data[] = $row;
}

// Retrieve total records for pagination
$totalQuery = "
    SELECT COUNT(*) as total
    FROM (
        SELECT inv
        FROM raheel1 
        WHERE product_name = 'DIGAS COLIC DROP 20ML'
               AND (
            ivc_date = '23-Jul-24' OR
            ivc_date = '24-Jul-24' OR 
            ivc_date = '25-Jul-24' OR 
            ivc_date = '26-Jul-24' OR
            ivc_date = '27-Jul-24' OR
            ivc_date = '28-Jul-24' OR
            ivc_date = '29-Jul-24' OR 
            ivc_date = '30-Jul-24' OR
            ivc_date = '31-Jul-24'
        )
AND (
    dp LIKE '%$searchQuery%' OR
    depot_name LIKE '%$searchQuery%' OR
    cust LIKE '%$searchQuery%' OR
    customer_name LIKE '%$searchQuery%' OR
    address LIKE '%$searchQuery%' OR
    class LIKE '%$searchQuery%' OR
    inv LIKE '%$searchQuery%' OR
    ivc_date LIKE '%$searchQuery%' OR
    prd LIKE '%$searchQuery%' OR
    product_name LIKE '%$searchQuery%' OR
    pack LIKE '%$searchQuery%' OR
    batch LIKE '%$searchQuery%' OR
    sales_qty LIKE '%$searchQuery%' OR
    sales_value LIKE '%$searchQuery%' OR
    bounty_qty LIKE '%$searchQuery%' OR
    bonus_value LIKE '%$searchQuery%' OR
    tp_medics LIKE '%$searchQuery%' OR
    cp_medics LIKE '%$searchQuery%' OR
    cp_value LIKE '%$searchQuery%' OR
    deff LIKE '%$searchQuery%'
)

        GROUP BY inv
        HAVING SUM(bounty_qty) != SUM(CASE
            WHEN sales_qty >= 100 THEN FLOOR(sales_qty / 100) * 15
            WHEN sales_qty >= 50 THEN FLOOR(sales_qty / 50) * 6
            WHEN sales_qty >= 11 THEN FLOOR(sales_qty / 11)
            ELSE 0
        END)
    ) as discrepancyTable
";
$totalResult = mysqli_query($conn, $totalQuery);

if (!$totalResult) {
    die(json_encode(['error' => "Total count query failed: " . mysqli_error($conn)]));
}

$totalRecords = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Return JSON response
$response = [
    'data' => $data,
    'totalRecords' => $totalRecords,
    'totalPages' => $totalPages
];

echo json_encode($response);
?>
