<?php
include "header.php";
?>
<div class="container">
    <div class="row ">
        <div class="col-md-4">
            <h5 class="pb-2 pt-3" style="font-weight:600">Travel Request Form</h5>
            <table class="table table-home" style="border:0.3px solid black!important">
                <thead>
                    <tr>
                        <th class="home-heading">
                            Forms
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="home-heading">
                            <a href="trf.php">
                                <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Submit Form
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="trf_userlist.php">
                                <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Request History</i>
                            </a>
                        </td>
                    </tr>
                    <!-- Department head -->
                    <tr>
                        <th colspan="2" class="home-heading">Department Head Approval
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <a href="trf_head_list.php">
                                <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Department Head Approval</i>
                            </a>
                        </td>
                    </tr>
                    <?php if ($fname == 'Jawaid Iqbal' or $fname == 'Syed Jawwad Ali' or $fname == 'Zohaib Uddin Ansari'  or $be_depart == 'it') { ?>
                        <!-- Admin Approval -->
                        <tr>
                            <th colspan="2" class="home-heading">Admin Approval
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <a href="trf_admin_list.php">
                                    <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Admin Approval</i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php if (($fname == 'Syed Owais Ahmed' or $fname == 'Muhammad Yaman' or $fname == 'Muhammad Yaman' or $fname == 'Danish Tanveer' or $fname == 'Mustafa Ahmed Jamal' or $fname == 'Nasarullah Khan') or $be_depart == 'it') { ?>
                        <tr>
                            <th colspan="2" class="home-heading">Finance Approval
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <a href="trf_finance_list.php">
                                    <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Finance Approval</i>
                                </a>
                            </td>
                        </tr>

                    <?php } ?>

                    <!-- CFO Approval -->
                    <!-- <tr>
                        <th colspan="2" class="home-heading">CFO Approval
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <a href="workorder_head_list.php">
                                <i class="fa-solid fa-arrow-right-long"></i> &nbsp; CFO Approval</i>
                            </a>
                        </td>
                    </tr> -->

                    <!-- CEO Approval -->
                    <!-- <tr>
                        <th colspan="2" class="home-heading">CEO Approval
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <a href="workorder_head_list.php">
                                <i class="fa-solid fa-arrow-right-long"></i> &nbsp; CEO Approval</i>
                            </a>
                        </td>
                    </tr> -->

                    <!-- Dashboard Approval -->
                    <tr>
                        <th colspan="2" class="home-heading">Dashboard
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <a href="workorder_head_list.php">
                                <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Dashboard</i>
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>


</div>
</div>
</div>

<?php
include 'footer.php'
?>