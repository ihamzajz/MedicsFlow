<?php
include "header.php";
?>
<div class="container-fluid">
    <div class="row">
        <div class="col"></div>
        <div class="d-flex align-items-center justify-content-between">
    <!-- <a class="btn btn-home" href="workorder_home.php">
        <i class="fa-solid fa-home"></i> Home
    </a> -->
    <h5 class="m-0 text-center" style="flex:1;font-weight:600">Post into FBR Portal</h5>
    <a href="import_salesinvc.php" class="btn btn-primary btn-sm mr-2"> <i class="fa-solid fa-file-import"></i> Import</a>
    <input id="filter" type="text" class="form-control w-25 ms-2"
        placeholder="Search here..."
        style="height:27px;font-size:12px;border:.5px solid black;border-radius:0px!important">
</div>


        <?php
        include 'dbconfig.php';
        $id = $_SESSION['id'];
        $name = $_SESSION['fullname'];
        $email = $_SESSION['email'];
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $gender = $_SESSION['gender'];
        $department = $_SESSION['department'];
        $role = $_SESSION['role'];
        $email = $_SESSION['email'];

        $be_depart = $_SESSION['be_depart'];
        $bc_role = $_SESSION['be_role'];

        $select = "SELECT * FROM api_salesinvc order by id desc";
        $select_q = mysqli_query($conn, $select);
        $data = mysqli_num_rows($select_q);
        ?>
         <div class="table-responsive mt-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                         <th>Status</th>
                        <th>Invoice Type</th>
                        <th>Invoice Date</th>
                        <th>sellerNTNCNIC</th>
                        <th>sellerBusinessName</th>
                        <th>sellerProvince</th>
                        <th>sellerAddress</th>
                        <th>buyerNTNCNIC</th>
                        <th>buyerBusinessName</th>
                        <th>buyerProvince</th>
                        <th>buyerAddress</th>
                        <th>buyerRegistrationType</th>
                        <th>invoiceRefNo</th>
                        <th>scenarioId</th>
                        <!-- items -->
                        <th>hsCode</th>
                        <th>productDescription</th>
                        <th>rate</th>
                        <th>uoM</th>
                        <th>quantity</th>
                        <th>totalValues</th>
                        <th>valueSalesExcludingST</th>
                        <th>fixedNotifiedValueOrRetailPrice</th>
                        <th>salesTaxApplicable</th>
                        <th>salesTaxWithheldAtSource</th>
                        <th>extraTax</th>
                        <th>furtherTax</th>
                        <th>sroScheduleNo</th>
                        <th>fedPayable</th>
                        <th>discount</th>
                        <th>saleType</th>
                        <th>sroItemSerialNo</th>
                        <th>status</th>
<th>created_at</th>
                    </tr>
                </thead>
                <?php
                if ($data) {
                    while ($row = mysqli_fetch_array($select_q)) {
                        ?>
                        <tbody class="searchable">
                            <tr id="row_<?php echo $row['id']; ?>">
                            <td>
    <a href="#" class="btn-fixed-text toggle-post">
        <i class="fa-solid fa-arrow-up"></i> Post
    </a>
</td>

<script>
document.addEventListener("click", function(e) {
    if (e.target.closest(".toggle-post")) {
        e.preventDefault();
        let btn = e.target.closest(".toggle-post");
        btn.outerHTML = '<span class="text-success fw-bold">Posted</span>';
    }
});
</script>

                                <!-- <td><a href="digital_invoice_details.php?id=<?php echo $row['id']; ?>" class="btn-fixed-text"><i class="fa-solid fa-arrow-up" style=""></i> Post</a></td> -->
                                <td><?php echo $row['invoiceRefNo']; ?></td>
                                <td><?php echo $row['sellerNTNCNIC']; ?></td>
                                <td><?php echo $row['sellerBusinessName']; ?></td>
                                <td><?php echo $row['sellerProvince']; ?></td>
                                <td><?php echo $row['sellerAddress']; ?></td>
                                <td><?php echo $row['buyerNTNCNIC']; ?></td>
                                <td><?php echo $row['buyerBusinessName']; ?></td>
                                <td><?php echo $row['buyerProvince']; ?></td>
                                <td><?php echo $row['buyerAddress']; ?></td>
                                <td><?php echo $row['buyerRegistrationType']; ?></td>
                                <td><?php echo $row['scenarioId']; ?></td>
                                <td><?php echo $row['hsCode']; ?></td>
                                <td><?php echo $row['productDescription']; ?></td>
                                <td><?php echo $row['rate']; ?></td>
                                <td><?php echo $row['uoM']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $row['totalValues']; ?></td>
                                <td><?php echo $row['valueSalesExcludingST']; ?></td>
                                <td><?php echo $row['fixedNotifiedValueOrRetailPrice']; ?></td>
                                <td><?php echo $row['salesTaxApplicable']; ?></td>
                                <td><?php echo $row['salesTaxWithheldAtSource']; ?></td>
                                <td><?php echo $row['extraTax']; ?></td>
                                <td><?php echo $row['furtherTax']; ?></td>
                                <td><?php echo $row['sroScheduleNo']; ?></td>
                                <td><?php echo $row['fedPayable']; ?></td>
                                <td><?php echo $row['discount']; ?></td>
                                <td><?php echo $row['saleType']; ?></td>
                                <td><?php echo $row['sroItemSerialNo']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
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
</div>
</div>
<?php
include "footer.php"
    ?>