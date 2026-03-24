<?php
include 'dbconfig.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 15;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Fetch data from the database with search term
$query = "
    SELECT depot_name, inv, COUNT(*) as count
    FROM raheel1 
    WHERE product_name = 'DIGAS SYRUP 120ML'
    GROUP BY depot_name, inv
    HAVING COUNT(*) > 1
";

if ($search) {
    $query .= " AND (depot_name LIKE '%$search%' OR inv LIKE '%$search%')";
}

$query .= " LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

$data = '';
while ($row = mysqli_fetch_assoc($result)) {
    $data .= "<tr>
        <td>{$row['depot_name']}</td>
        <td>{$row['inv']}</td>
        <td>{$row['count']}</td>
    </tr>";
}

// Calculate total number of rows with search term
$total_query = "
    SELECT COUNT(*) as total
    FROM (
        SELECT depot_name, inv
        FROM raheel1 
        WHERE product_name = 'DIGAS SYRUP 120ML'
        GROUP BY depot_name, inv
        HAVING COUNT(*) > 1
    ) as subquery
";

if ($search) {
    $total_query .= " WHERE depot_name LIKE '%$search%' OR inv LIKE '%$search%'";
}

$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total = $total_row['total'];

// Pagination controls
$totalPages = ceil($total / $limit);
$currentPage = floor($offset / $limit) + 1;
$blockSize = 10;
$currentBlock = ceil($currentPage / $blockSize);
$startPage = ($currentBlock - 1) * $blockSize + 1;
$endPage = min($totalPages, $currentBlock * $blockSize);

$pagination = '<div class="pagination text-center">';
// Adjust the offsets for block navigation
$previousBlockOffset = max(0, ($startPage - $blockSize - 1) * $limit);
$nextBlockOffset = ($endPage * $limit);

if ($currentPage > 1) {
    $pagination .= '<button data-offset="0" class="btn btn-dark mx-1">First</button>';
    $pagination .= '<button data-offset="' . $previousBlockOffset . '" class="btn btn-dark mx-1">Previous</button>';
} else {
    $pagination .= '<button disabled class="btn btn-dark mx-1">First</button>';
    $pagination .= '<button disabled class="btn btn-dark mx-1">Previous</button>';
}

for ($i = $startPage; $i <= $endPage; $i++) {
    $pageOffset = ($i - 1) * $limit;
    // Highlight active page with btn-info, others with btn-primary
    $buttonClass = ($currentPage == $i) ? 'btn-outline-primary' : 'btn-primary';
    $pagination .= '<button data-offset="' . $pageOffset . '" class="btn ' . $buttonClass . ' mx-1">' . $i . '</button>';
}

if ($currentPage < $totalPages) {
    $pagination .= '<button data-offset="' . $nextBlockOffset . '" class="btn btn-dark mx-1">Next</button>';
    $pagination .= '<button data-offset="' . (($totalPages - 1) * $limit) . '" class="btn btn-dark mx-1">Last</button>';
} else {
    $pagination .= '<button disabled class="btn btn-dark mx-1">Next</button>';
    $pagination .= '<button disabled class="btn btn-dark mx-1">Last</button>';
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

mysqli_close($conn);
?>
