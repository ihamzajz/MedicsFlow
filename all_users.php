<?php
include "header.php";
include "dbconfig.php";

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search setup
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_query = $search ? "WHERE fullname LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%' OR department LIKE '%$search%' OR role LIKE '%$search%'" : "";

// Get total records
$result_count = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users $search_query");
$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $limit);

// Fetch records
$query = "SELECT * FROM users $search_query ORDER BY id DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $query);
?>

<div class="container-fluid">
    <div class="row">
        <div class="d-flex align-items-center justify-content-between pt-5">
            <a class="btn btn-primary btn-sm" href="create_user.php">
                <i class="fa-solid fa-plus"></i> Create
            </a>
            <h5 class="m-0 text-center" style="flex:1;font-weight:600">All Users</h5>

            <!-- Search Form -->
            <form method="GET" class="d-flex align-items-center" style="width: 25%; position: relative;">
                <div style="position: relative; width: 100%;">
                    <input id="filter" type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
                        class="form-control"
                        placeholder="Search here..."
                        style="height: 27px; font-size:12px; border:.5px solid black; border-radius:0px!important; padding-right: 22px;">

                    <!-- Red X inside input (aligned properly) -->
                    <?php if ($search): ?>
                        <a href="?page=1"
                            style="position: absolute; top: 50%; right: 6px; transform: translateY(-50%);
                            color: red; text-decoration: none; font-weight: bold; font-size:16px; line-height:1;">
                            ×
                        </a>
                    <?php endif; ?>

      

                </div>

                <button type="submit" class="btn btn-dark btn-sm ms-1" style="font-size:12px;">Search</button>
            </form>
        </div>

        <div class="table-responsive mt-2">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">Edit</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Department</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody class="searchable">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <td><a href='edit_user.php?id={$row['id']}' class='btn-fixed-text'>
                                    <i class='fa-solid fa-arrow-up'></i> Edit</a></td>
                                <td>{$row['fullname']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['department']}</td>
                                <td>{$row['role']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No records found!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <!-- Total Count -->
            <div style="font-size:13px; font-weight:500;">
                Total Records: <?php echo $total_records; ?>
            </div>

            <!-- Pagination Controls -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mb-0">
                    <!-- First -->
                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=1&search=<?php echo $search; ?>">First</a>
                    </li>

                    <!-- Previous -->
                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">Previous</a>
                    </li>

                    <!-- Page numbers -->
                    <?php
                    $start_page = max(1, $page - 2);
                    $end_page = min($total_pages, $start_page + 4);
                    for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next -->
                    <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">Next</a>
                    </li>

                    <!-- Last -->
                    <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $total_pages; ?>&search=<?php echo $search; ?>">Last</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>