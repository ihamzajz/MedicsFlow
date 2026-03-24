<?php
include 'dbconfig.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 30;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Fetch data from the database with search term
$query = "SELECT * FROM raheel1 WHERE product_name = 'DIGAS SYRUP 120ML'";

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
$total_query = "SELECT COUNT(*) as total FROM raheel1 WHERE product_name = 'DIGAS SYRUP 120ML'";

if ($search) {
    $total_query .= " AND (dp LIKE '%$search%' OR depot_name LIKE '%$search%' OR cust LIKE '%$search%' OR customer_name LIKE '%$search%' OR address LIKE '%$search%' OR class LIKE '%$search%' OR inv LIKE '%$search%' OR ivc_date LIKE '%$search%' OR prd LIKE '%$search%' OR pack LIKE '%$search%' OR batch LIKE '%$search%' OR sales_value LIKE '%$search%' OR tp_medics LIKE '%$search%' OR cp_medics LIKE '%$search%' OR cp_value LIKE '%$search%' OR deff LIKE '%$search%' OR product_name LIKE '%$search%' OR sales_qty LIKE '%$search%' OR bounty_qty LIKE '%$search%')";
}

$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total = $total_row['total'];

// Pagination controls
$perPage = 10;
$totalPages = ceil($total / $limit);
$currentPage = floor($offset / $limit) + 1; // Calculate current page

// Calculate block-based pagination
$blockSize = 10; // Number of pages per block
$currentBlock = ceil($currentPage / $blockSize); // Current block
$startPage = ($currentBlock - 1) * $blockSize + 1; // First page in current block
$endPage = min($totalPages, $currentBlock * $blockSize); // Last page in current block

$pagination = '<div class="pagination text-center">';
if ($currentBlock > 1) {
    $pagination .= '<button data-offset="0" class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">First</button>';
    $pagination .= '<button data-offset="' . (($currentBlock - 2) * $blockSize * $limit) . '" class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">Previous</button>';
} else {
    $pagination .= '<button disabled class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">First</button>';
    $pagination .= '<button disabled class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">Previous</button>';
}

for ($i = $startPage; $i <= $endPage; $i++) {
    $pageOffset = ($i - 1) * $limit;
    // Change the class of the active page to `btn-outline-primary`
    $buttonClass = ($currentPage == $i) ? 'btn-outline-primary' : 'btn-primary';
    $pagination .= '<button data-offset="' . $pageOffset . '" class="btn ' . $buttonClass . ' mx-1" style="font-size: 11px; border-radius: 0px;">' . $i . '</button>';
}

if ($currentBlock < ceil($totalPages / $blockSize)) {
    $pagination .= '<button data-offset="' . ($currentBlock * $blockSize * $limit) . '" class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">Next</button>';
    $pagination .= '<button data-offset="' . (($totalPages - 1) * $limit) . '" class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">Last</button>';
} else {
    $pagination .= '<button disabled class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">Next</button>';
    $pagination .= '<button disabled class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">Last</button>';
}

$pagination .= '</div>';
$pagination .= '<div class="text-center"  style="margin-top: -13px; padding-top: 0;">Page ' . $currentPage . ' of ' . $totalPages . '</div>';

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
