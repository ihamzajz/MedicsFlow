<?php
include 'dbconfig.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Fetch data from the database with search term
$query = "SELECT * FROM fixed_assets_disposal_form";

// Adding the WHERE clause if search term is provided
if ($search) {
    $query .= " WHERE 
        id LIKE '%$search%' OR
        disposal_department LIKE '%$search%' OR
        applicant LIKE '%$search%' OR
        date_of_application LIKE '%$search%' OR
        dc_name LIKE '%$search%' OR
        dc_asset_number LIKE '%$search%' OR
        dc_date_of_purchase LIKE '%$search%' OR
        dc_quantity LIKE '%$search%' OR
        dc_brand_specification LIKE '%$search%' OR
        dc_disposition_date LIKE '%$search%' OR
        dc_original_valueid LIKE '%$search%' OR
        dc_original_value LIKE '%$search%' OR
        dc_depreciation_value LIKE '%$search%' OR
       dc_networth LIKE '%$search%' OR
       disposal_reason LIKE '%$search%' OR
        disposal_method LIKE '%$search%' OR
        department_head_opinion LIKE '%$search%' OR
        finance_status LIKE '%$search%' 
        '";
}
$query .= " LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

$data = '';
while ($row = mysqli_fetch_assoc($result)) {
    $data .= "<tr>

      <td><a class='btn btn-sm btn-success' href='asset_disposal_dashboard_report.php?id={$row['id']}'>Report</a></td>
        <td>{$row['id']}</td>
         <td>{$row['applicant']}</td>
        <td>{$row['disposal_department']}</td>
        <td>{$row['date_of_application']}</td>
        <td>{$row['dc_name']}</td>
        <td>{$row['dc_asset_number']}</td>
        <td>{$row['dc_date_of_purchase']}</td>
        <td>{$row['dc_quantity']}</td>
        <td>{$row['dc_brand_specification']}</td>
        <td>{$row['dc_disposition_date']}</td>
        <td>{$row['dc_original_value']}</td>
        <td>{$row['dc_depreciation_value']}</td>
        <td>{$row['dc_networth']}</td>
        <td>{$row['disposal_reason']}</td>
        <td>{$row['disposal_method']}</td>
        <td>{$row['department_head_opinion']}</td>
        <td>{$row['finance_status']}</td>
        
    </tr>";
}

// Calculate total number of rows with search term
$total_query = "SELECT COUNT(*) as total FROM fixed_assets_disposal_form";

// Adding the WHERE clause for the total query if search term is provided
if ($search) {
    $query .= " WHERE 
        id LIKE '%$search%' OR
        disposal_department LIKE '%$search%' OR
        applicant LIKE '%$search%' OR
        date_of_application LIKE '%$search%' OR
        dc_name id LIKE '%$search%' OR
        dc_asset_number  LIKE '%$search%' OR
        dc_date_of_purchase LIKE '%$search%' OR
        dc_quantity id LIKE '%$search%' OR
        dc_brand_specification LIKE '%$search%' OR
        dc_disposition_date LIKE '%$search%' OR
        dc_original_valueid LIKE '%$search%' OR
        dc_original_value LIKE '%$search%' OR
        dc_depreciation_value LIKE '%$search%' OR
       dc_networth LIKE '%$search%' OR
       disposal_reason LIKE '%$search%' OR
        disposal_method LIKE '%$search%' OR
        department_head_opinion LIKE '%$search%' OR
        finance_status LIKE '%$search%' 
        '";
}

$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total = $total_row['total'];

// Pagination controls
$perPage = 10;
$totalPages = ceil($total / $limit);
$currentPage = floor($offset / $limit) + 1;

// Calculate block-based pagination
$blockSize = 10;
$currentBlock = ceil($currentPage / $blockSize);
$startPage = ($currentBlock - 1) * $blockSize + 1;
$endPage = min($totalPages, $currentBlock * $blockSize);

$pagination = '<div class="pagination text-center pt-2">';
if ($currentBlock > 1) {
    $pagination .= '<button data-offset="0" class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">First</button>';
    $pagination .= '<button data-offset="' . (($currentBlock - 2) * $blockSize * $limit) . '" class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">Previous</button>';
} else {
    $pagination .= '<button disabled class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">First</button>';
    $pagination .= '<button disabled class="btn btn-dark mx-1" style="font-size: 11px; border-radius: 0px;">Previous</button>';
}

for ($i = $startPage; $i <= $endPage; $i++) {
    $pageOffset = ($i - 1) * $limit;
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
$pagination .= '<div class="text-center">Page ' . $currentPage . ' of ' . $totalPages . '</div>';

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
