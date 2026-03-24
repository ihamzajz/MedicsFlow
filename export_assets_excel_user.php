<?php
include 'dbconfig.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=assets_export.xls");

// Start table
echo "<table border='1'>";

// Table Header
echo "<tr>
<th>Id</th>
<th>S.no</th>
<th>Part Of far</th>
<th>Remarks</th>
<th>Type</th>
<th>Comments</th>
<th>Part Of Machine</th>
<th>Old Code</th>
<th>New Code</th>
<th>Name</th>
<th>Department1</th>
<th>Asset Location</th>
<th>Purchase Date</th>
<th>Asset Class</th>
<th>No Of Units</th>
<th>Model</th>
<th>Usage</th>
<th>Amount</th>
<th>Status</th>
<th>Remarks2</th>
<th>Part of far2</th>
<th>Department2</th>
<th>Unique Nuim</th>
<th>Item Description</th>
<th>Balances</th>
<th>Supplier Name</th>
<th>Department Name</th>
<th>Category</th>
<th>Invoice Date</th>
<th>Invoice Number</th>
<th>Original Amount</th>
<th>Available Amount</th>
<th>Asset Tag Number</th>
<th>Quantity</th>
<th>Location</th>
<th>Cost</th>
<th>Comments</th>
<th>dc_disposal_department</th>
<th>dc_applicant</th>
<th>dc_email</th>
<th>dc_date_of_application</th>
<th>dc_name</th>
<th>dc_asset_number</th>
<th>dc_date_of_purchase</th>
<th>dc_quantity</th>
<th>dc_brand_specification</th>
<th>dc_disposition_date</th>
<th>dc_original_value</th>
<th>dc_depreciation_value</th>
<th>dc_networth</th>
<th>dc_disposal_reason</th>
<th>dc_department_head_opinion</th>
<th>dc_finance_status</th>
<th>dc_finance_date</th>
<th>dc_finance_msg</th>
<th>dc_po_approval_status</th>
<th>dc_reason</th>
<th>dc_status</th>
<th>dc_jv_status</th>
<th>dc_disposal_jv_no</th>
<th>at_rc_name</th>
<th>at_rc_no</th>
<th>at_department</th>
<th>at_date_1</th>
<th>at_transfer_prepared_by</th>
<th>at_date_prepared</th>
<th>at_address</th>
<th>at_asset_tag_number</th>
<th>at_qty</th>
<th>at_s_no</th>
<th>at_description</th>
<th>at_cost</th>
<th>at_bldg</th>
<th>at_room</th>
<th>at_owner_code</th>
<th>at_comments</th>
<th>at_user_name</th>
<th>at_user_date</th>
<th>at_user_department</th>
<th>at_finance_status</th>
<th>at_finance_msg</th>
<th>at_finance_date</th>
<th>at_po_approve_status</th>
<th>at_status</th>
<th>at_reason</th>
<th>at_receiver_msg</th>
<th>at_receiver_status</th>
<th>at_receiver_date</th>
<th>final_status</th>
</tr>";

// Fetch and print data rows
$query = "SELECT * FROM assets";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    foreach ($row as $cell) {
        echo "<td>" . htmlspecialchars($cell) . "</td>";
    }
    echo "</tr>";
}

echo "</table>";
?>
