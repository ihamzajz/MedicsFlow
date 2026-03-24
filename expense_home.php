<?php
include("header.php");
?>
<div class="container">
    <div class="row">

        <!-- 1st col start -->
        <div class="col-md-4">
            <h6 class="pb-2 pt-3" style="font-weight:700">Cash / Purchase Requisition Form</h6>
            <table class="table table-home" style="border:0.3px solid black!important">
                <thead>
                    <tr>
                        <th>
                            Forms
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <a href="cash_purchase_form.php">
                                <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Submit Form
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="cash_purchase_userlist.php">
                                <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Request History
                            </a>
                        </td>
                    </tr>
                    <?php if ($fname == 'Jawaid Iqbal' or $fname == 'Syed Jawwad Ali' or $fname == 'Zohaib Uddin Ansari'  or $be_depart == 'it') { ?>

                        <tr>
                            <th>
                                Admin
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <a href="cash_purchase_admin_list.php">
                                    <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Admin Approval
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (($fname == 'Syed Owais Ahmed' or $fname == 'Muhammad Yaman' or $fname == 'Muhammad Yaman' or $fname == 'Danish Tanveer' or $fname == 'Mustafa Ahmed Jamal' or $fname == 'Nasarullah Khan') or $be_depart == 'it') { ?>
                        <tr>
                            <th>
                                Finance
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <a href="cash_purchase_finance_list.php">
                                    <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Finance Approval
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if ($be_role == 'ceo' or $be_depart == 'it') { ?>
                        <tr>
                            <th>
                                CEO
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <a href="cash_purchase_ceo_list.php">
                                    <i class="fa-solid fa-arrow-right-long"></i> &nbsp; CEO Approval
                                </a>
                            </td>
                        </tr>

                    <?php } ?>

                </tbody>
            </table>
        </div>
        <!-- 1st col end -->





        <!-- 2nd col start  -->

        <div class="col-md-4 offset-md-1">
            <h6 class="pb-2 pt-3" style="font-weight:700">Expense Claim Form</h6>
            <table class="table table-home" style="border:0.3px solid black!important">

                <thead>
                    <tr>

                        <th>
                            Forms
                        </th>
                    </tr>
                </thead>


                <tbody>
                    <tr>
                        <td>
                            <a href="expense_claim_form.php">
                                <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Submit Form
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a href="expense_claim_userlist.php">
                                <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Request History
                            </a>
                        </td>
                    </tr>



                    <?php if ($fname == 'Jawaid Iqbal' or $fname == 'Syed Jawwad Ali' or $fname == 'Zohaib Uddin Ansari'  or $be_depart == 'it') { ?>

                        <tr>
                            <th>
                                Admin
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <a href="expense_claim_admin_list.php">
                                    <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Admin Approval
                                </a>
                            </td>
                        </tr>
                    <?php } ?>





                    <?php if (($fname == 'Syed Owais Ahmed' or $fname == 'Muhammad Yaman' or $fname == 'Muhammad Yaman' or $fname == 'Danish Tanveer' or $fname == 'Mustafa Ahmed Jamal' or $fname == 'Nasarullah Khan') or $be_depart == 'it') { ?>

                        <tr>
                            <th>
                                Finance
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <a href="expense_claim_finance_list.php">
                                    <i class="fa-solid fa-arrow-right-long"></i> &nbsp; Finance Approval
                                </a>
                            </td>
                        </tr>

                    <?php } ?>




                    <?php if ($be_role == 'ceo' or $be_depart == 'it') { ?>

                        <tr>
                            <th>
                                CEO
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <a href="expense_claim_ceo_list.php">
                                    <i class="fa-solid fa-arrow-right-long"></i> &nbsp; CEO Approval
                                </a>
                            </td>
                        </tr>
                    <?php } ?>



                </tbody>
            </table>
        </div>
        <!-- 2nd col end -->
    </div>

</div>
</div>
<!--page content-->
</div>
<!--wrapper-->
<?php
include 'footer.php'
?>