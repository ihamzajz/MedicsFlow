<?php
include "header.php";
?>


<div class="d-flex align-items-center justify-content-between">
    <a class="btn btn-dark btn-sm" href="cc_home.php" style="">
        <i class="fa-solid fa-home"></i> Home
    </a>
    <h6 class="m-0 text-center" style="flex:1;font-weight:600">QC Head Approval</h6>
    <input id="filter" type="text" class="form-control w-25" placeholder="Search here..."
        style="height: 27px; font-size:12px;border:.5px solid black;border-radius:0px!important">
</div>


<?php

include 'dbconfig.php';

$select = "SELECT * FROM qc_ccrf WHERE qchead_status2 = 'Pending' ";

$select_q = mysqli_query($conn, $select);
$data = mysqli_num_rows($select_q);
?>

<div class="table-responsive">
    <table class="table table-bordered mt-1" id="myTable">
        <thead>
            <tr>
                <th colspan="3">Action</th>
                <th scope="col">Code</th>
                <th scope="col">User</th>
                <th scope="col">Department</th>
                <th scope="col">Date Initiated</th>
                <th scope="col">Area of Change</th>

                <th>Dashboard</th>

            </tr>
        </thead>

        <?php
        if ($data) {
            while ($row = mysqli_fetch_array($select_q)) {
                ?>
                <tbody class="searchable">
                    <tr id="row_<?php echo $row['id']; ?>">
                        <!-- <td><a href="cc_qchead_approve.php?id=<?php echo $row['id']; ?>" class="btn btn-success"><i class="fa-regular fa-circle-check"></i> Approve</a></td> -->
                        <td><a href="#" class="btn-approve" onclick="promptReason2(<?php echo $row['id']; ?>)"><i
                                    class="fa-regular fa-circle-check"></i>
                                Approve</a></td>
                        <td><a href="#" class="btn-reject" onclick="promptReason(<?php echo $row['id']; ?>)"><i
                                    class="fa-regular fa-circle-xmark"></i>
                                Reject</a></td>
                        <!-- <td>
                            <a href="cc_qchead_critical.php?id=<?php echo $row['id']; ?>" class="btn-cc_edit"
                                onclick="return showCriticalAlert();">
                                <i class="fa-solid fa-bolt"></i> Mark Critical
                            </a>
                        </td> -->

                        <td>
                            <a href="cc_qchead_critical.php?id=<?php echo $row['id']; ?>" class="btn-input-text"
                                onclick="return showCriticalAlert();">
                                <i class="fa-solid fa-arrow-up" style=""></i> Critical
                            </a>
                        </td>
                        <script>
                            function showCriticalAlert() {
                                alert("Request has been sent to CEO for approval.");
                                return true; // Let the link continue to cc_qchead_critical.php
                            }
                        </script>

                        <td><?php echo $row['code'] ?> </td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['user_department'] ?></td>
                        <td><?php echo $row['i_date_initiated'] ?> </td>
                        <td><?php echo $row['i_area_of_change'] ?> </td>

                        <!-- <td>
                            <a href="cc_viewform.php?id=<?php echo $row['id']; ?>" class="btn-fixed-text"><i
                                    class="fa-regular fa-eye"></i> Dashboard</a>
                                </td>
                        <td> -->

                        <!-- <a href="cc_viewform.php?id=<?php echo $row['id']; ?>"><button class="btn-cc_edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    Closing
                                </button></a>
                        </td> -->

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






</div> <!--content-->
</div> <!--wrapper-->


<script>
    function promptReason(itemId) {
        var reason = prompt("Enter reason for rejection:");
        if (reason != null && reason.trim() !== "") {
            window.location.href = "cc_qchead_reject2.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
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
    function promptReason2(itemId) {
        var reason = prompt("Enter Comments:");
        if (reason != null && reason.trim() !== "") {
            window.location.href = "cc_qchead_approve2.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
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





<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        // Ensure the sidebar is active (visible) by default
        $('#sidebar').addClass('active'); // Change to addClass to show sidebar initially

        // Handle sidebar collapse toggle
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        // Update the icon when collapsing/expanding
        $('[data-bs-toggle="collapse"]').on('click', function () {
            var target = $(this).find('.toggle-icon');
            if ($(this).attr('aria-expanded') === 'true') {
                target.removeClass('fa-plus').addClass('fa-minus');
            } else {
                target.removeClass('fa-minus').addClass('fa-plus');
            }
        });
    });
</script>


<!-- table export -->
<script src="
    https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js
    "></script>
<script type="text/javascript" src="libs/FileSaver/FileSaver.min.js"></script>
<script type="text/javascript" src="../libs/jsPDF/polyfills.umd.js"></script>
<script type="text/javascript" src="tableExport.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#excel').click(function () {
            $('#myTable').tableExport({ type: 'excel', ignoreColumn: [16, 17, 18] });
        });
    });
</script>

<script>
    $(document).ready(function () {
        (function ($) {
            $('#filter').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable tr').hide();
                $('.searchable tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })

        }(jQuery));
    });
</script>

<script src="assets/js/main.js"></script>


</body>

</html>