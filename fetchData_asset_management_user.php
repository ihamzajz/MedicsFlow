<?php
include 'dbconfig.php';
session_start();

if (!isset($_SESSION['be_depart'])) {
    die(json_encode(['error' => 'Session be_depart not set']));
}
$be_depart = $_SESSION['be_depart'];
$be_depart = mysqli_real_escape_string($conn, $_SESSION['be_depart']);
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 15;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Base WHERE clause
$where = "WHERE department_be = '$be_depart'";

// Append search if needed
if ($search) {
    $where .= " AND (
        id LIKE '%$search%' OR 
        name_description LIKE '%$search%' OR
        asset_tag_number LIKE '%$search%' OR
        department_location LIKE '%$search%' OR
        asset_location LIKE '%$search%' OR
        purchase_date LIKE '%$search%' OR
        final_status LIKE '%$search%'
    )";
}

// Main data query
$query = "SELECT * FROM assets $where LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Count query
$total_query = "SELECT COUNT(*) as total FROM assets $where";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total = $total_row['total'] ?? 0;

// Format data
$data = '';
while ($row = mysqli_fetch_assoc($result)) {
    $data .= "<tr>
        <td><a class='btn btn-sm btn-view' href='asset_details.php?id={$row['id']}'><i class='fa-solid fa-arrow-up'></i> Details</a></td>
        <td>{$row['name_description']}</td>
        <td>{$row['asset_tag_number']}</td>
        <td>{$row['department_location']}</td>
        <td>{$row['asset_location']}</td>
        <td>{$row['purchase_date']}</td>
        <td>{$row['id']}</td>
        <td>{$row['final_status']}</td>
        <td>
            <a href='#' class='btn btn-sm btn-delete text-danger' onclick='confirmDelete({$row['id']})'>
                <i class='fa-solid fa-trash-can'></i> Delete
            </a>
        </td>
        <td style='display:none!important'>{$row['final_status']}</td>
    </tr>";
}

// Pagination logic
$totalPages = ceil($total / $limit);
$currentPage = floor($offset / $limit) + 1;
$blockSize = 10;
$currentBlock = ceil($currentPage / $blockSize);
$startPage = ($currentBlock - 1) * $blockSize + 1;
$endPage = min($totalPages, $currentBlock * $blockSize);

$pagination = '<div class="pagination text-center pt-2">';
if ($currentBlock > 1) {
    $pagination .= '<button data-offset="0" class="btn btn-dark mx-1" style="font-size:11px;">First</button>';
    $pagination .= '<button data-offset="' . (($currentBlock - 2) * $blockSize * $limit) . '" class="btn btn-dark mx-1" style="font-size:11px;">Previous</button>';
} else {
    $pagination .= '<button disabled class="btn btn-dark mx-1" style="font-size:11px;">First</button>';
    $pagination .= '<button disabled class="btn btn-dark mx-1" style="font-size:11px;">Previous</button>';
}

for ($i = $startPage; $i <= $endPage; $i++) {
    $pageOffset = ($i - 1) * $limit;
    $btnClass = ($currentPage == $i) ? 'btn-outline-primary' : 'btn-primary';
    $pagination .= '<button data-offset="' . $pageOffset . '" class="btn ' . $btnClass . ' mx-1" style="font-size:11px;">' . $i . '</button>';
}

if ($currentBlock < ceil($totalPages / $blockSize)) {
    $pagination .= '<button data-offset="' . ($currentBlock * $blockSize * $limit) . '" class="btn btn-dark mx-1" style="font-size:11px;">Next</button>';
    $pagination .= '<button data-offset="' . (($totalPages - 1) * $limit) . '" class="btn btn-dark mx-1" style="font-size:11px;">Last</button>';
} else {
    $pagination .= '<button disabled class="btn btn-dark mx-1" style="font-size:11px;">Next</button>';
    $pagination .= '<button disabled class="btn btn-dark mx-1" style="font-size:11px;">Last</button>';
}

$pagination .= '</div>';
$pagination .= '<div class="text-center">Page ' . $currentPage . ' of ' . $totalPages . '</div>';

echo json_encode([
    'data' => [
        'rows' => $data,
        'pagination' => $pagination
    ],
    'total' => $total,
    'nextOffset' => $offset + $limit
]);

mysqli_close($conn);
