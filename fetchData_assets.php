<?php
include 'dbconfig.php';

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 30;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Fetch data from the database with search term
$query = "SELECT * FROM assets";

// Adding the WHERE clause if search term is provided
if ($search) {
    $query .= " WHERE 
        s_no LIKE '%$search%' OR
        part_of_far LIKE '%$search%' OR
        remarks LIKE '%$search%' OR
        type LIKE '%$search%' OR
        comments LIKE '%$search%' OR
        part_of_machine LIKE '%$search%' OR
        old_code LIKE '%$search%' OR
        new_code LIKE '%$search%' OR
        name_description LIKE '%$search%' OR
        department1 LIKE '%$search%' OR
        asset_location LIKE '%$search%' OR
        purchase_date LIKE '%$search%' OR
        asset_class LIKE '%$search%' OR
        no_of_units LIKE '%$search%' OR
        model LIKE '%$search%' OR
        usage LIKE '%$search%' OR
        amount LIKE '%$search%' OR
        status LIKE '%$search%' OR
        remarks2 LIKE '%$search%' OR
        part_of_far2 LIKE '%$search%' OR
        department2 LIKE '%$search%' OR
        unique_nuim LIKE '%$search%' OR
        item_description LIKE '%$search%' OR
        balances LIKE '%$search%' OR
        supplier_name LIKE '%$search%' OR
        department_name LIKE '%$search%' OR
        category LIKE '%$search%' OR
        invoice_date LIKE '%$search%' OR
        invoice_number LIKE '%$search%' OR
        original_amount LIKE '%$search%' OR
        available_amount LIKE '%$search%' OR
        asset_tag_number LIKE '%$search%' OR
        quantity LIKE '%$search%' OR
        location LIKE '%$search%' OR
        cost LIKE '%$search%' OR
        comments LIKE '%$search%'";
}
$query .= " LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

$data = '';
while ($row = mysqli_fetch_assoc($result)) {
    $data .= "<tr>
     <td><a class='btn btn-sm btn-success' href='asset_receipt_dashboard_report.php?id={$row['id']}'>Report</a></td>
        <td>{$row['id']}</td>
         <td>{$row['fullname']}</td>
         <td>{$row['user_department']}</td>
        <td>{$row['s_no']}</td>
        <td>{$row['part_of_far']}</td>
        <td>{$row['remarks']}</td>

        <td>{$row['type']}</td>
        <td>{$row['comments']}</td>
        <td>{$row['part_of_machine']}</td>
        <td>{$row['old_code']}</td>

        <td>{$row['new_code']}</td>
        <td>{$row['name_description']}</td>
        <td>{$row['department1']}</td>
        <td>{$row['asset_location']}</td>


        <td>{$row['purchase_date']}</td>
        <td>{$row['asset_class']}</td>
        <td>{$row['no_of_units']}</td>
        <td>{$row['model']}</td>

        <td>{$row['usage']}</td>
        <td>{$row['amount']}</td>
        <td>{$row['status']}</td>
        <td>{$row['remarks2']}</td>

        <td>{$row['part_of_far2']}</td>
        <td>{$row['department2']}</td>
        <td>{$row['unique_nuim']}</td>
        <td>{$row['item_description']}</td>

        <td>{$row['balances']}</td>
        <td>{$row['supplier_name']}</td>
        <td>{$row['department_name']}</td>
        <td>{$row['category']}</td>

        <td>{$row['invoice_date']}</td>
        <td>{$row['invoice_number']}</td>
        <td>{$row['original_amount']}</td>
        <td>{$row['available_amount']}</td>
        
        <td>{$row['asset_tag_number']}</td>
        <td>{$row['quantity']}</td>
        <td>{$row['location']}</td>
        <td>{$row['cost']}</td>
       
    </tr>";
}

// Calculate total number of rows with search term
$total_query = "SELECT COUNT(*) as total FROM assets";

// Adding the WHERE clause for the total query if search term is provided
if ($search) {
    $query .= " WHERE 
        s_no LIKE '%$search%' OR
        part_of_far LIKE '%$search%' OR
        remarks LIKE '%$search%' OR
        type LIKE '%$search%' OR
        comments LIKE '%$search%' OR
        part_of_machine LIKE '%$search%' OR
        old_code LIKE '%$search%' OR
        new_code LIKE '%$search%' OR
        name_description LIKE '%$search%' OR
        department1 LIKE '%$search%' OR
        asset_location LIKE '%$search%' OR
        purchase_date LIKE '%$search%' OR
        asset_class LIKE '%$search%' OR
        no_of_units LIKE '%$search%' OR
        model LIKE '%$search%' OR
        usage LIKE '%$search%' OR
        amount LIKE '%$search%' OR
        status LIKE '%$search%' OR
        remarks2 LIKE '%$search%' OR
        part_of_far2 LIKE '%$search%' OR
        department2 LIKE '%$search%' OR
        unique_nuim LIKE '%$search%' OR
        item_description LIKE '%$search%' OR
        balances LIKE '%$search%' OR
        supplier_name LIKE '%$search%' OR
        department_name LIKE '%$search%' OR
        category LIKE '%$search%' OR
        invoice_date LIKE '%$search%' OR
        invoice_number LIKE '%$search%' OR
        original_amount LIKE '%$search%' OR
        available_amount LIKE '%$search%' OR
        asset_tag_number LIKE '%$search%' OR
        quantity LIKE '%$search%' OR
        location LIKE '%$search%' OR
        cost LIKE '%$search%' OR
        comments LIKE '%$search%'";
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
