<?php
include "header.php";
?>

<?php

include 'dbconfig.php';
$select = "SELECT * FROM qc_ccrf WHERE i_classification_status2 ='Critical' and ceo_status = 'Pending'";
$select_q = mysqli_query($conn, $select);
$data = mysqli_num_rows($select_q);
?>

<div class="d-flex align-items-center justify-content-between">
    <a class="btn btn-home" href="cc_home" style="">
        <i class="fa-solid fa-home"></i> Home
    </a>
    <h5 class="m-0 text-center" style="flex:1;font-weight:600">CEO Approval</h5>
    <input id="filter" type="text" class="form-control w-25" placeholder="Search here..."
        style="height: 27px; font-size:12px;border:.5px solid black;border-radius:0px!important">
</div>

<div class="table-responsive">
    <table class="table table-bordered mt-1" id="myTable">
        <thead>
            <tr>
                <th colspan="2">Action</th>
                <th scope="col">Code</th>
                <th scope="col">User</th>
                <th scope="col">Department</th>
                <th scope="col">Date Initiated</th>
                <th scope="col">Area of Change</th>
                <th scope="col">Time of Change</th>
                <th scope="col">Dashboard</th>
            </tr>
        </thead>

        <?php
        if ($data) {
            while ($row = mysqli_fetch_array($select_q)) {
                ?>
                <tbody class="searchable">
                    <tr id="row_<?php echo $row['id']; ?>">
                        <td><a href="cc_ceo_approve.php?id=<?php echo $row['id']; ?>" class="btn btn-approve"><i
                                    class="fa-regular fa-circle-check"></i> Approve</a></td>
                        <td>
                            <a href="#" class="btn btn-reject" onclick="promptReason(<?php echo $row['id']; ?>)"><i
                                    class="fa-regular fa-circle-xmark"></i>
                                Reject</a>
                        </td>
                        <td><?php echo $row['code'] ?> </td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['user_department'] ?></td>
                        <td><?php echo $row['i_date_initiated'] ?> </td>
                        <td><?php echo $row['i_area_of_change'] ?> </td>
                        <td><?php echo $row['i_time_of_change'] ?> </td>
                        <td>
                            <a href="cc_dashboard_details.php?id=<?php echo $row['id']; ?>" class="btn btn-fixed-text">
                                <i class="fa-solid fa-arrow-up" style=""></i> Dashboard
                            </a>
                        </td>
                    </tr>
                </tbody>
                <?php
            }
        } else {
            echo "No record found!";
        }
        ?>
    </table>
</div>

</div>
</div>

<script>
    function promptReason(itemId) {
        var reason = prompt("Enter reason for rejection:");
        if (reason != null && reason.trim() !== "") {
            window.location.href = "qc_ccrf_qchead_reject.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
        }
    }
</script>
<script>
    function submitRejectionReason(itemId, reason) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                location.reload();
            }
        };
        xhr.open("POST", "update_rejection_reason.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
    }
</script>

<script>
    function promptReason(itemId) {
        var reason = prompt("Enter reason for rejection:");
        if (reason != null && reason.trim() !== "") {
            window.location.href = "cc_ceo_reject.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
        }
    }
</script>
<script>
    function submitRejectionReason(itemId, reason) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                location.reload();
            }
        };
        xhr.open("POST", "update_rejection_reason.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
    }
</script>

<?php
include "footer.php"
    ?>