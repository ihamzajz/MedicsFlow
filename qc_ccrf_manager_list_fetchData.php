<?php
include 'dbconfig.php';

$be_depart = $_SESSION['be_depart'];

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 15;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Fetch data from the database with search term
$query = "SELECT * FROM qc_ccrf WHERE user_be_depart = '$be_depart' AND user_be_user = 'user'";

// Adding the WHERE clause if search term is provided
if ($search) {
    $query .= " WHERE 
        s_no LIKE '%$search%' OR
        part_of_far LIKE '%$search%' ";
}
$query .= " LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

$data = '';
while ($row = mysqli_fetch_assoc($result)) {
    $data .= "<tr>
        <td>{$row['id']}</td>
        <td>{$row['s_no']}</td>
       
    </tr>";
}

// Calculate total number of rows with search term
$total_query = "SELECT COUNT(*) as total FROM qc_ccrf";

// Adding the WHERE clause for the total query if search term is provided
if ($search) {
    $query .= " WHERE 
        s_no LIKE '%$search%' OR
        part_of_far LIKE '%$search%'
      ";
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
