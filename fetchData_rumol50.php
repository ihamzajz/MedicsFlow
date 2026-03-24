<?php
include 'dbconfig.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 100;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Fetch data from the database with search term
$query = "SELECT * FROM raheel1 WHERE product_name = 'RUMOL CREAM 50GMS'";

if ($search) {
    $query .= " AND (dp LIKE '%$search%' OR depot_name LIKE '%$search%' OR cust LIKE '%$search%' OR customer_name LIKE '%$search%' OR address LIKE '%$search%' OR class LIKE '%$search%' OR inv LIKE '%$search%' OR ivc_date LIKE '%$search%' OR prd LIKE '%$search%' OR pack LIKE '%$search%' OR batch LIKE '%$search%' OR sales_value LIKE '%$search%' OR tp_medics LIKE '%$search%' OR cp_medics LIKE '%$search%' OR cp_value LIKE '%$search%' OR deff LIKE '%$search%' OR product_name LIKE '%$search%' OR sales_qty LIKE '%$search%' OR bounty_qty LIKE '%$search%')";
}

$query .= " LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

$data = '';
while ($row = mysqli_fetch_assoc($result)) {
    $data .= "<tr>
        <td>{$row['dp']}</td>
        <td>{$row['depot_name']}</td>
        <td>{$row['cust']}</td>
        <td>{$row['customer_name']}</td>
        <td>{$row['address']}</td>
        <td>{$row['class']}</td>
        <td>{$row['inv']}</td>
        <td>{$row['ivc_date']}</td>
        <td>{$row['prd']}</td>
        <td>{$row['pack']}</td>
        <td>{$row['batch']}</td>
        <td>{$row['sales_value']}</td>
        <td>{$row['tp_medics']}</td>
        <td>{$row['cp_medics']}</td>
        <td>{$row['cp_value']}</td>
        <td>{$row['deff']}</td>
        <td>{$row['product_name']}</td>
        <td>{$row['sales_qty']}</td>
        <td>{$row['bounty_qty']}</td>
    </tr>";
}

// Calculate total number of rows with search term
$total_query = "SELECT COUNT(*) as total FROM raheel1 WHERE product_name = 'RUMOL CREAM 50GMS'";

if ($search) {
    $total_query .= " AND (dp LIKE '%$search%' OR depot_name LIKE '%$search%' OR cust LIKE '%$search%' OR customer_name LIKE '%$search%' OR address LIKE '%$search%' OR class LIKE '%$search%' OR inv LIKE '%$search%' OR ivc_date LIKE '%$search%' OR prd LIKE '%$search%' OR pack LIKE '%$search%' OR batch LIKE '%$search%' OR sales_value LIKE '%$search%' OR tp_medics LIKE '%$search%' OR cp_medics LIKE '%$search%' OR cp_value LIKE '%$search%' OR deff LIKE '%$search%' OR product_name LIKE '%$search%' OR sales_qty LIKE '%$search%' OR bounty_qty LIKE '%$search%')";
}

$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total = $total_row['total'];

// Pagination controls
$totalPages = ceil($total / $limit);
$pagination = '<div class="pagination">';
for ($i = 0; $i < $totalPages; $i++) {
    $page = $i * $limit;
    $pagination .= '<button data-offset="' . $page . '" class="btn btn-secondary mx-1">' . ($i + 1) . '</button>';
}
$pagination .= '</div>';

echo json_encode([
    'data' => [
        'rows' => $data,
        'pagination' => $pagination
    ],
    'nextOffset' => $offset + $limit
]);

// Close connection
mysqli_close($conn);
?>
