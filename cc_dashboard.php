<?php
include 'dbconfig.php';

/* =========================
   AJAX HANDLER (TOP ONLY)
========================= */
if (isset($_POST['ajax'])) {

    $where = [];

    if (!empty($_POST['year'])) {
        $year = mysqli_real_escape_string($conn, $_POST['year']);
        $where[] = "YEAR(i_date_initiated) = '$year'";
    }

    if (!empty($_POST['date_from']) && !empty($_POST['date_to'])) {
        $from = mysqli_real_escape_string($conn, $_POST['date_from']);
        $to   = mysqli_real_escape_string($conn, $_POST['date_to']);
        $where[] = "DATE(i_date_initiated) BETWEEN '$from' AND '$to'";
    }

    if (!empty($_POST['department'])) {
        $dept = mysqli_real_escape_string($conn, $_POST['department']);
        $where[] = "user_department = '$dept'";
    }

    if (!empty($_POST['status'])) {
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $where[] = "status = '$status'";
    }

    if (!empty($_POST['dept_head_status'])) {
        $dhead = mysqli_real_escape_string($conn, $_POST['dept_head_status']);
        $where[] = "dept_head_status = '$dhead'";
    }

    if (!empty($_POST['qchead_status'])) {
        $qchead = mysqli_real_escape_string($conn, $_POST['qchead_status']);
        $where[] = "qchead_status = '$qchead'";
    }

    if (!empty($_POST['search'])) {
        $search = mysqli_real_escape_string($conn, trim($_POST['search']));
        $where[] = "(
            code LIKE '%$search%' OR
            username LIKE '%$search%' OR
            user_department LIKE '%$search%' OR
            user_role LIKE '%$search%' OR
            i_area_of_change LIKE '%$search%' OR
            status LIKE '%$search%'
        )";
    }

    $sql = "SELECT * FROM qc_ccrf";
    if ($where) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    // $order = 'i_date_initiated DESC';
    // if (!empty($_POST['order_by']) && in_array($_POST['order_by'], ['ASC','DESC'])) {
    //     $order = 'i_date_initiated ' . $_POST['order_by'];
    // }

    $orderDir = 'DESC';
if (!empty($_POST['order_by']) && in_array($_POST['order_by'], ['ASC','DESC'])) {
    $orderDir = $_POST['order_by'];
}

$order = "
    CAST(SUBSTRING_INDEX(code, '-', -1) AS UNSIGNED) $orderDir,
    CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(code, '-', 2), '-', -1) AS UNSIGNED) $orderDir
";


    $sql .= " ORDER BY $order";

    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    $rows = '';

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $rows .= "
            <tr>
                <td>
                    <a href='cc_dashboard_details.php?id={$row['id']}' class='btn-fixed-text'>
                        <i class='fa-solid fa-arrow-up'></i> Dashboard
                    </a>
                </td>
                <td>{$row['code']}</td>
                <td>{$row['username']}</td>
                <td>{$row['user_department']}</td>
                <td>{$row['user_role']}</td>
                <td>{$row['i_date_initiated']}</td>
                <td>{$row['i_area_of_change']}</td>
                <td>{$row['dept_head_status']}</td>
                <td>{$row['qchead_status']}</td>
                <td>{$row['status']}</td>
            </tr>";
        }
    } else {
        $rows = "<tr><td colspan='10' class='text-center'>No records found</td></tr>";
    }

    echo json_encode([
        'rows'  => $rows,
        'count' => $count
    ]);
    exit;
}
?>


<?php include "header.php"; ?>

<!-- =========================
     PAGE UI
========================= -->

<div class="container-fluid mt-2">

    <div class="d-flex align-items-center justify-content-between mb-2">
        <a class="btn btn-dark btn-sm" href="cc_home.php">
            <i class="fa-solid fa-home"></i> Home
        </a>
        <h6 class="m-0 text-center" style="flex:1;font-weight:600">Change Control List</h6>
    </div>

    <!-- FILTER CARD -->
    <div class="card mb-2 filtercard" style="border:0.5px solid #7F8CAA!important;background-color:#e1e5f2">
        <div class="card-body py-2">
            <div class="row g-2 align-items-end">

                <div class="col-md-2">
                    <label class="form-label small">Year</label>
                    <select id="year" class="form-select form-select-sm">
                        <option value="">All Years</option>
                        <?php
                        $currentYear = date('Y');
                        for ($y = $currentYear; $y >= $currentYear - 20; $y--) {
                            echo "<option value='$y'>$y</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small">Date From</label>
                    <input type="date" id="date_from" class="form-control form-control-sm">
                </div>

                <div class="col-md-2">
                    <label class="form-label small">Date To</label>
                    <input type="date" id="date_to" class="form-control form-control-sm">
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Department</label>
                    <select id="department" class="form-select form-select-sm">
                        <option value="">All Departments</option>
                        <option>Information Technology</option>
                        <option>Finance</option>
                        <option>Human Resources</option>
                        <option>Production</option>
                        <option>QA</option>
                        <option>Research and Development</option>
                        <option>Supply Chain</option>
                        <option>Tax</option>
                        <option>Warehouse</option>
                        <option>Commercial</option>
                        <option>Marketing</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small">Status</label>
                    <select id="status" class="form-select form-select-sm">
                        <option value="">All</option>
                        <option>Open</option>
                        <option>Closed</option>
                    </select>
                </div>

                <!-- NEW HEAD STATUS FILTER -->
                <div class="col-md-2">
                    <label class="form-label small">Head Status</label>
                    <select id="dept_head_status" class="form-select form-select-sm">
                        <option value="">All</option>
                        <option>Approved</option>
                        <option>Rejected</option>
                        <option>Pending</option>
                    </select>
                </div>

                <!-- NEW QA STATUS FILTER -->
                <div class="col-md-2">
                    <label class="form-label small">Quality Status</label>
                    <select id="qchead_status" class="form-select form-select-sm">
                        <option value="">All</option>
                        <option>Approved</option>
                        <option>Rejected</option>
                        <option>Pending</option>
                    </select>
                </div>

                <!-- ORDER BY FILTER -->
                <div class="col-md-2">
                    <label class="form-label small">Order By</label>
                    <select id="order_by" class="form-select form-select-sm">
                        <option value="DESC">Newest First</option>
                        <option value="ASC">Oldest First</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small mb-2">Search (All fields)</label>
                    <input id="search" type="text"
                        class="form-control form-control-sm"
                        placeholder="Type to search…">
                </div>

                <div class="col-md-2">
                    <div class="text-muted small">
                        Showing <strong><span id="recordCount">0</span></strong> records
                    </div>
                </div>
                <div class="col-md-1">
                    <button id="clearFilters"
                        class="btn btn-sm btn-danger w-100 d-none">
                        Clear
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th>Details</th>
                    <th>Code</th>
                    <th>User</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Date Initiated</th>
                    <th>Area of Change</th>
                    <th>Head Status</th>
                    <th>QA Status</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tableData"></tbody>
        </table>
    </div>

</div>

<!-- =========================
     JS (BOTTOM)
========================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        function loadData() {
            const data = {
                ajax: 1,
                year: $('#year').val(),
                date_from: $('#date_from').val(),
                date_to: $('#date_to').val(),
                department: $('#department').val(),
                status: $('#status').val(),
                dept_head_status: $('#dept_head_status').val(),
                qchead_status: $('#qchead_status').val(),
                order_by: $('#order_by').val(),
                search: $.trim($('#search').val())
            };

            $.post('', data, function(res) {

                let result;
                try {
                    result = JSON.parse(res);
                } catch (e) {
                    console.error('Bad JSON:', res);
                    return;
                }

                $('#tableData').html(result.rows);
                $('#recordCount').text(result.count);

                const hasFilter = Object.values(data).some(v => v && v !== 1);
                $('#clearFilters').toggleClass('d-none', !hasFilter);
            });
        }

        loadData();

        $('#year, #date_from, #date_to, #department, #status, #dept_head_status, #qchead_status, #order_by').on('change', loadData);
        $('#search').on('keyup', loadData);

        $('#clearFilters').on('click', function() {
            $('#year, #date_from, #date_to, #department, #status, #dept_head_status, #qchead_status, #order_by, #search').val('');
            loadData();
        });

    });
</script>

<?php include "footer.php"; ?>