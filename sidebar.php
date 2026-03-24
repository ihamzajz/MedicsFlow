<!-- Sidebar  -->
<nav id="sidebar" style="background-color:black!important;">
    <div class="sidebar-header" style="background-color:black!important;">
        <h2 style="color:#1c9be7;font-weight:bold;padding:0px!important;margin:0px!important;letter-spacing:1px">Medics Lab</h2>
        <p style="font-size: 16px!important;font-weight:400;color: white;padding:0px!important;margin:0px!important;letter-spacing:1px">Digital Forms</p>

        <p style="font-size: 11px!important;font-weight:400;color: white;padding:0px!important;margin:0px!important;padding-top:8px!important;letter-spacing:1px">
            <?php echo $_SESSION['fullname']; ?>
        </p>
    </div>
    <?php
    include 'dbconfig.php';

    //echo $_SESSION['role'];

    $id = $_SESSION['id'];
    $fname = $_SESSION['fullname'];
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    $password = $_SESSION['password'];
    $gender = $_SESSION['gender'];
    $department = $_SESSION['department'];

    $email = $_SESSION['email'];

    $be_depart = $_SESSION['be_depart'];
    $be_role = $_SESSION['be_role'];

    $sa_user = $_SESSION['sa_user'];
    $sa_depart = $_SESSION['sa_depart'];
    $sa_depart2 = $_SESSION['sa_depart2'];
    $sa_depart3 = $_SESSION['sa_depart3'];
    $sa_role = $_SESSION['sa_role'];


    ?>

    <ul class="list-unstyled components">
        <!-- <p><?php echo $fname ?></p> -->
        <?php if ($username == 'admin123' && $password == 'admin123') { ?>
            <li>
                <a href="reportingtool.php" style="background-color: #DD5746;">Reporting Tool</a>
            </li>
            <li>
                <a href="users.php">Users</a>
            </li>
            <li>
                <a href="newuserhr.php">New User Hr</a>
            </li>
            <li>
                <a href="newuserit.php">New User it</a>
            </li>
            <li>
                <a href="newuseradmin.php">New User admin</a>
            </li>
            <li>
                <a href="newuseradmin.php">New User All</a>
            </li>
        <?php } ?>






        <li>
            <a href="profile.php" style="font-size: 11px!important;letter-spacing:1px">Profile</a>
        </li>







        <?php if ($be_depart == 'it' or $username == 'raheel.ahmed' or $be_depart == 'dir' or $fname == 'Mustafa Ahmed Jamal') { ?>
            <li>
                <a href="salesmain_productlist.php" style="font-size: 11px!important;background-color:#697565;color:White;letter-spacing:1px" class="mb-1">Scheme Verification</a>
            </li>
        <?php } ?>












        <?php if ($be_depart == 'it' or $username == 'alvina.saleem' or $username == 'kashif.makhdoom' or $be_depart == 'dir'  or $username == 'ashhad.hussain' or $fname == 'Mustafa Ahmed Jamal' or $fname == 'Moiz Iqbal Ahmed Khan') { ?>

            <li class="mb-1">
                <a href="#pageSubmenu13" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle1" style="font-size: 11px!important;background-color:#8576FF;letter-spacing:1px">Power BI Dashboards</a>
                <ul class="collapse list-unstyled" id="pageSubmenu13">
                    <?php if ($be_depart == 'it' or $username == 'alvina.saleem' or $username == 'kashif.makhdoom' or $be_depart == 'dir'  or $username == 'ashhad.hussain' or $fname == 'Mustafa Ahmed Jamal') { ?>

                        <li>
                            <a href="online_booking_bidashboard.php" style="font-size: 11px!important;background-color:black!important;letter-spacing:1px">▹ Online Booking</a>
                        </li>

                    <?php } ?>
                    <?php if ($be_depart == 'it' or $fname == 'Moiz Iqbal Ahmed Khan' or $username == 'ehtesham.haq' or $be_depart == 'dir' or $username == 'raheel.ahmed' or $username == 'shayan.m' or $fname == 'Mustafa Ahmed Jamal') { ?>
                        <li>
                            <a href="supply_chain_bidashboard.php" style="font-size: 11px!important;background-color:black!important;letter-spacing:1px">▹ Supply Chain</a>
                        </li>
                    <?php } ?>
                    <?php if ($be_depart == 'it' or $be_depart == 'dir' or $fname == 'Mustafa Ahmed Jamal') { ?>
                        <li>
                            <a href="technology_bidashboard.php" style="font-size: 11px!important;background-color:black!important;letter-spacing:1px">▹ Technology</a>
                        </li>
                    <?php } ?>
                    <?php if ($be_depart == 'it' or $be_depart == 'dir' or $fname == 'Mustafa Ahmed Jamal') { ?>
                        <li>
                            <a href="finance_bidashboard.php" style="font-size: 11px!important;background-color:black!important;letter-spacing:1px">▹ Finance</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>

        <?php } ?>








        <!-- <?php if ($department == 'administrator' or $be_depart == 'it' or $be_depart == 'dir') { ?>

        <?php } ?> -->
        <?php if (($username == 'admin' && $fname == 'Jawaid Iqbal') or ($username == 'farhan' && $fname == 'Farhan Abid') or $be_depart == 'it' or $be_depart == 'dir' or $fname == 'Mustafa Ahmed Jamal') { ?>
            <li class="mb-1">
                <a href="vehicle_listall.php" style="background-color: #557C56!important; font-size:11px!important;color:white!important;letter-spacing:1px">Vehicle Management</a>
            </li>
        <?php } ?>



        <?php if (($fname == 'Zaighum Hasan') or ($fname == 'Taha Khan') or ($be_depart == 'it') or ($be_depart == 'dir') or ($fname === 'Kaleem Ullah') or ($fname === 'Zeeshan Ahmed') or ($fname == 'Mustafa Ahmed Jamal') or ($be_depart == 'dir')) { ?>
            <li class="mb-1">
                <a href="ecs.php" style="background-color: #98D8EF!important; font-size:11px!important;color:black!important;letter-spacing:1px">Smart Meter Reading
                    <i class="fa-regular fa-star" style="float:right;font-size:15px;color:red!important"></i>
                </a>
            </li>
        <?php } ?>



        <?php if ($be_depart == 'it') { ?>

            <li class="mb-1">
                <a href="lab_req_form_list.php" style="background-color: #EA5455!important; font-size:11px!important;color:white!important;letter-spacing:1px">Labelling Requirement
                    <i class="fa-regular fa-star" style="float:right;font-size:15px;color:white!important"></i>
                </a>
            </li>

        <?php } ?>


        <?php if ($be_depart == 'it' or $be_depart == 'dir' or $sa_user == 'yes' or $be_depart == 'fpaa') { ?>

            <li class="mb-1">
                <a href="sa_forms.php" style="background-color: #B3D8A8!important; font-size:11px!important;color:Black!important;letter-spacing:1px">Staff Allocation
                    <i class="fa-regular fa-star" style="float:right;font-size:15px;color:black!important"></i>
                </a>
            </li>

        <?php } ?>




        <!-- common starts 1-->
        <?php if ($be_depart != 'saleszsm1' &&  $be_depart != 'salesho' &&  $be_depart != 'saleszsm2' &&  $be_depart != 'saleszsm3' &&  $be_depart != 'saleszsm4') { ?>







            <?php if ($be_depart == 'it' or $be_depart == 'dir' or $be_role == 'approver' or $username == 'abrash.khan') { ?>
                <li>
                    <a href="reportingtool.php" style="font-size: 11px!important; background-color:#FFD65A!important;color:black!important;letter-spacing:1px">Reporting Tool</a>
                </li>
            <?php } ?>

            <li>
                <a href="#pageSubmenu0" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">Submit Forms</a>
                <ul class="collapse list-unstyled" id="pageSubmenu0">


                    <li>

                    <li>
                        <a href="workorderForm.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Work Order</a>
                    </li>
                    <li>
                        <a href="erpAccessForm.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ ERP Access</a>
                    </li>
                    <li>
                        <a href="newuserform.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ New User</a>
                    </li>
                    <li>
                        <a href="it_accessories_form.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ IT Accessories</a>
                    </li>
                    <li>
                        <a href="trf.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Travel Request</a>
                    </li>
                    <li>
                        <a href="finance_forms.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Assets Forms</a>
                    </li>
                    <li>
                        <a href="cc_forms.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Change Control Request
                            <i class="fa-regular fa-star" style="float:right;font-size:13px;color:red!important"></i>
                        </a>
                    </li>


                    <li>
                        <a href="appraisal_forms.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Appraisal Forms
                            <i class="fa-regular fa-star" style="float:right;font-size:13px;color:red!important"></i>
                        </a>
                    </li>
                    <li>
                        <a href="ot_form.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Overtime Request
                            <i class="fa-regular fa-star" style="float:right;font-size:13px;color:red!important"></i>
                        </a>
                    </li>





                </ul>
            </li>
            <li class="pb-4">
                <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">View Your Requests</a>
                <ul class="collapse list-unstyled" id="pageSubmenu1">

                    <li>
                        <a href="workorder_userlist.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Work Order</a>
                    </li>
                    <li>
                        <a href="erp_userlist.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ ERP Access</a>
                    </li>
                    <li>
                        <a href="itacc_userlist.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ IT Accessories</a>
                    </li>
                    <li>
                        <a href="finance_userlist.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Assets</a>
                    </li>
                    <li>
                        <a href="qc_ccrf_admin_form_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Change Control Request</a>
                    </li>
                </ul>
            </li>

        <?php } ?>
        <!-- common1 end -->

        <!-- common 2 start  -->
        <?php if (($be_depart == 'saleszsm1' && $be_role == 'user') ||
            ($be_depart == 'saleszsm2' && $be_role == 'user') ||
            ($be_depart == 'saleszsm3' && $be_role == 'user') ||
            ($be_depart == 'saleszsm4' && $be_role == 'user')
        ) { ?>

            <li>
                <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">Bonus Approval</a>
                <ul class="collapse list-unstyled" id="pageSubmenu2">

                    <li>
                        <a href="bonus_form.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Submit Form</a>
                    </li>
                    <li>
                        <a href="bonus_userlist.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Your Data</a>
                    </li>
                    <li>
                        <a href="bonus_user_dashboard.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Dashboard</a>
                    </li>
                    <li>
                        <a href="bonus_invoice_number.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Invoice Number</a>
                    </li>
                </ul>
            </li>


            <li>
                <a href="#pageSubmenu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">Field Visit</a>
                <ul class="collapse list-unstyled" id="pageSubmenu3">

                    <li>
                        <a href="field_visit_form.php" style="font-size: 11px!important;background-color:black!important;letter-spacing:1px">▹ Submit Form</a>
                    </li>
                    <!-- <li>
                    <a href="bonus_userlist.php" style="font-size: 14px!important;background-color:black!important;">▹        Your Data</a>
                </li>
                <li>
                    <a href="bonus_user_dashboard.php" style="font-size: 14px!important;background-color:black!important;">▹        Dashboard</a>
                </li> -->
                </ul>
            </li>

        <?php } ?>
        <!-- common 2 end -->
        <!-- admin starts 1  -->
        <?php if (
            $role == 'CEO' or $role == 'Head of department' or $role == 'Financial Controller' or $role == 'Assistant Manager Production'
            or $role == 'Manager Administration' or $role == 'Assistant Manager Quality Assurance' or $role == 'Quality Assurance Executive'
            or ($be_depart == 'eng' && $be_role == 'user') or $role == 'Senior Executive Production' or $role == 'Head of Human Resources'
            or $role == 'Marketing Manager' or $role == 'Manager Financial Planning and Analysis' or $be_depart == 'dir'
            or $fname == 'super' or $be_depart == 'it' or $fname == 'Taha Ahmed'
            or $role == 'Assistant Manager Human Resource Operations' or $be_depart == 'fpaa' or $be_depart == 'sc' or $username == 'abrash.khan' or ($be_depart == 'qaqc' && $be_role == 'approver'
                or $be_depart == 'finance' or $fname == 'Agha Saif Ullah' or $fname == 'Zeeshan Ahmed Sheikh')
        ) { ?>
            <ul class="list-unstyled CTAs">
                <li>
                    <a href="#" class="" style="background-color: #0D9276!important; white:black!important; font-size:12px!important;border-radius:0px!important;letter-spacing:1px">Admin Options</a>
                </li>
                <!-- <li>
                <a href="reportingtool.php" style="background-color: #BBBFCA!important; font-size:13px!important;color:black!important">Reporting Tool</a>
            </li> -->
                <!-- <li>
                <a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>
                </li> -->
            </ul>
            <li>
                <a href="#pageSubmenu4" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">WorkOrder</a>
                <ul class="collapse list-unstyled" id="pageSubmenu4">

                    <!-- workorder engineering starts -->

                    <?php if ($department == 'Engineering' && $role == 'Head of department' or $be_depart == 'it') { ?>
                        <li>
                            <a href="workorder_engineering_estimatecost.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Cost Evaluation</a>
                        </li>
                        <li>
                            <a href="workorder_engineering_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Cost less than 10,000</a>
                        </li>
                        <li>
                            <a href="workorder_engineering_closeout.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Closeout</a>
                        </li>
                        <li>
                            <a href="workorder_engineeringall_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ All Engineering Workorder</a>
                        </li>
                    <?php } ?>

                    <!-- workorder engineering ends -->

                    <?php if ($be_depart == 'eng' && $be_role == 'user' or $be_depart == 'it') { ?>
                        <li>
                            <a href="workorder_engineering_closeout.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Closeout</a>
                        </li>
                        <li>
                            <a href="workorder_all_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ All Workorder Requests</a>
                        </li>
                    <?php } ?> <!-- workorder engineering ends -->
                    <!-- FC starts -->
                    <?php if ($role == 'Manager Financial Planning and Analysis' or $be_depart == 'it' or ($be_role == 'approver' and $be_depart == 'finance')) { ?>
                        <li>
                            <a href="workorder_finance_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Cost more than 10,000</a>
                        </li>
                        <li>
                            <a href="workorder_all_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ All Workorder Requests</a>
                        </li>
                    <?php } ?>

                    <!-- admin depart workorder starts -->
                    <?php if ($department == 'Administration' && $role == 'Manager Administration' or $username == 'super') { ?>
                        <li>
                            <a href="workorder_admin_estimatecost.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Cost Evaluation</a>
                        </li>
                        <li>
                            <a href="workorder_admin_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Cost less than 10,000</a>
                        </li>
                        <li>
                            <a href="workorder_admin_closeout.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Closeout</a>
                        </li>
                        <li>
                            <a href="workorder_adminall_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ All Admin Workorder</a>
                        </li>
                    <?php } ?>
                    <!-- admin depart workorder ends -->

                    <!-- head of department starts -->

                    <?php if (
                        $role == 'Head of department' or $role == 'Assistant Manager Production' or $role == 'Assistant Manager Quality Assurance'
                        or $role == 'Manager Administration' or $role == 'Senior Executive Production' or $role == 'Head of Human Resources' or $role == 'Marketing Manager' or $username == 'super'
                        or $role == 'Head of Production' or $fname == 'Zeeshan Ahmed Sheikh'
                    ) { ?>
                        <li>
                            <a href="workorder_head_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Head Pending Workorder</a>
                        </li>
                        <li>
                            <a href="workorder_departmenthead_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Department All Workorder</a>
                        </li>
                    <?php } ?>

                    <!-- workorder finance starts -->

                    <?php if ($department == 'Finance' && $role == 'Head of department' or $username == 'demo' or $username == 'super') { ?>
                        <li>
                            <a href="workorder_finance_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">Finance Workorder Requests</a>
                        </li>
                        <li>
                            <a href="workorder_all_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">All Workorder Requests</a>
                        </li>
                    <?php } ?>

                    <!-- workorder finance ends -->

                    <!-- ceo starts -->
                    <?php if ($role == 'CEO' or $username == 'demo' or $be_depart == 'dir' or $username == 'super') { ?>
                        <li>
                            <a href="workorder_ceo_list.php" style="font-size: 10px!important;background-color:black!important;color:White!important;letter-spacing:1px">CEO Workorder Requests</a>
                        </li>
                        <li>
                            <a href="workorder_all_list.php" style="font-size: 10px!important;background-color:black!important;color:White!important;letter-spacing:1px">All Workorder Requests</a>
                        </li>
                    <?php } ?> <!-- ceo ends -->
                </ul>
            </li>
            <!-- workorder admin ends -->
            <!-- erp starts -->
            <li>
                <a href="#pageSubmenu5" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle " style="font-size: 11px!important;color:White!important;letter-spacing:1px">ERP Access</a>
                <ul class="collapse list-unstyled" id="pageSubmenu5">
                    <!-- erp admin starts -->
                    <?php if (
                        $role == 'Head of department' or $role == 'Assistant Manager Treasury' or $role == 'Manager Finance'
                        or $role == 'Manager Financial Planning and Analysis' or $role == 'Digital Marketing Manager'
                        or $role == 'Sr. QA Executive' or $role == 'Sr. QA Executive' or $role == 'Marketing Manager' or $username == 'super' or $role == 'Manager Administration' or $role == 'Assistant Manager Quality Assurance'
                        or $role == 'Head of Production'
                    ) { ?>
                        <li>
                            <a href="erp_departmenthead_list.php" style="font-size: 10px!important;background-color:black!important;color:White!important;letter-spacing:1px">▹ Head Pending Requests</a>
                        </li>
                        <li>
                            <a href="erp_dhead_list.php" style="font-size: 10px!important;background-color:black!important;color:White!important;letter-spacing:1px">▹ Department All Requests</a>
                        </li>
                    <?php } ?>
                    <?php if ($department == 'Information Technology' && $role == 'Head of department') { ?>
                        <li>
                            <a href="erp_ithead_list.php" style="font-size: 10px!important;background-color:#D2DE32!important;color:black!important;letter-spacing:1px">▹ IT Head Pending Requests</a>
                        </li>
                        <!-- <li>
                    <a href="erp_approvedall.php" style="font-size: 15px!important;background-color:black!important;color:White!important">▹        All Approved Requests</a>
                </li>
                <li>
                    <a href="erp_list_all.php" style="font-size: 15px!important;background-color:black!important;color:White!important">▹        All Requests</a>
                </li> -->
                    <?php } ?>
                    <?php if ($role == 'Financial Controller') { ?>
                        <li>
                            <a href="erp_fc_list.php" style="font-size: 10px!important;background-color:black!important;color:White!important;letter-spacing:1px">▹ FC Pending Requests</a>
                        </li>
                        <li>
                            <a href="erp_fc_list_approved.php" style="font-size: 10px!important;background-color:black!important;color:White!important;letter-spacing:1px">▹ FC Approved Requests</a>
                        </li>
                        <li>
                            <a href="erp_fc_list_rejected.php" style="font-size: 10px!important;background-color:black!important;color:White!important;letter-spacing:1px">▹ FC Rejected Requests</a>
                        </li>
                    <?php } ?>
                    <?php if ($role == 'CEO' or $be_depart == 'dir') { ?>
                        <li>
                            <a href="erp_ceo_list.php" style="font-size: 10px!important;background-color:black!important;color:White!important;letter-spacing:1px">▹ CEO ERP Pending Requests</a>
                        </li>
                        <li>
                            <a href="erp_list_all.php" style="font-size: 10px!important;background-color:black!important;color:White!important;letter-spacing:1px">▹ All ERP Requests</a>
                        </li>
                    <?php } ?>
                    <!-- erp admin ends -->
                </ul>


            <li>
                <a href="#pageSubmenu6" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">New User</a>
                <ul class="collapse list-unstyled" id="pageSubmenu6">
                    <?php if ($fname == 'Taha Ahmed') { ?>
                        <li>
                            <a href="newuserhr.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ HR Head Approval</a>
                        </li>
                    <?php } ?>



                    <?php if ($be_depart == 'it') { ?>
                        <li>
                            <a href="newuserit.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ IT Department</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>

            <li>
                <a href="#pageSubmenu7" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">IT Accessories</a>
                <ul class="collapse list-unstyled" id="pageSubmenu7">
                    <?php if ($be_depart == 'it') { ?>
                        <li>
                            <a href="itacc_it.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Pending Requests</a>
                        </li>
                        <li>
                            <a href="itacc_dashboard.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Dashboard</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li>
                <a href="#pageSubmenu151" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">Change Control Request</a>
                <ul class="collapse list-unstyled" id="pageSubmenu151">

                    <?php if ($be_role == 'approver') { ?>

                        <li>
                            <a href="cc_depthead_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Dept Head Approval</a>
                        </li>
                    <?php } ?>


                    <?php if ($username == 'sadia.saeed') { ?>
                        <li>
                            <a href="cc_qchead_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ QC Head Approval</a>
                        </li>
                    <?php } ?>
                    <?php if ($username == 'azeem.hussain') { ?>
                        <li>
                            <a href="qc_ccrf_ceo_approval.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ CEO Approval</a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="cc_dept_input_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Department Input</a>
                    </li>
                    <?php if ($username == 'sadia.saeed' or $be_role == 'approver' or $be_depart == 'it') { ?>
                        <li>
                            <a href="cc_edit_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Edit</a>
                        </li>
                    <?php } ?>


                </ul>
            </li>
            <li>
                <a href="#pageSubmenu99" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">Assets Management</a>
                <ul class="collapse list-unstyled" id="pageSubmenu99">
                    <?php if ($be_depart == 'it' or $be_depart == 'fpaa' or $role == 'Manager Administration') { ?>
                        <li>
                            <a href="asset_receipt_grn_po_list.php" style="font-size: 10px!important;background-color:black!important;color:#FFD35A!important;letter-spacing:1px">▹ Assets Receipt - GRN , PO</a>
                        </li>
                        <li>
                            <a href="asset_receipt_finance_list.php" style="font-size: 10px!important;background-color:black!important;color:#FFD35A!important;letter-spacing:1px">▹ Assets Receipt - FP&A Approval</a>
                        </li>
                        <li>
                            <a href="asset_receipt_finance_edit.php" style="font-size: 10px!important;background-color:black!important;color:#FFD35A!important;letter-spacing:1px">▹ Assets Receipt - FP&A Edit</a>
                        </li>
                        <li>
                            <a href="interCompanyTransfer_finance_list.php" style="font-size: 10px!important;background-color:black!important;color:#5BBCFF!important;letter-spacing:1px">▹ Assets Transfer - FP&A</a>
                        </li>
                    <?php } ?>
                    <?php if ($be_role == 'approver' or $role == 'Manager Administration') { ?>
                        <li>
                            <a href="interCompanyTransfer_receiver.php" style="font-size: 10px!important;background-color:black!important;color:#5BBCFF!important;letter-spacing:1px">▹ Assets Transfer Receiver</a>
                        </li>
                        <li>
                            <a href="assets_departmenthead_data.php" style="font-size: 10px!important;background-color:black!important;">▹ Department Wise Assets</a>
                        </li>
                    <?php } ?>

                    <?php if ($be_depart == 'it' or $be_depart == 'fpaa' or $role == 'Manager Administration') { ?>
                        <li>
                            <a href="fixedAssetsDisposal_add_disposal_jv_no.php" style="font-size: 10px!important;background-color:black!important;color:#88D66C!important;letter-spacing:1px">▹ Assets Disposal - ADD JV</a>
                        </li>
                        <li>
                            <a href="fixedAssetsDisposal_finance_list.php" style="font-size: 10px!important;background-color:black!important;color:#88D66C!important;letter-spacing:1px">▹ Assets Disposal - FP&A</a>
                        </li>

                        <li>
                            <a href="assets_data_dashboard.php" style="font-size: 10px!important;background-color:black!important;">▹ Dashboard</a>
                        </li>
                        <li>
                            <a href="assets_downloads.php" style="font-size: 10px!important;background-color:black!important;">▹ Download</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>

            <li>
                <a href="#pageSubmenu8" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">Travel Request</a>
                <ul class="collapse list-unstyled" id="pageSubmenu8">
                    <?php if ($be_role == 'approver') { ?>
                        <li>
                            <a href="trf_head.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Head Pending Requests</a>
                        </li>
                    <?php } ?>

                    <?php if ($be_depart == 'admin') { ?>
                        <li>
                            <a href="trf_admin.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Admin Requests</a>
                        </li>
                    <?php } ?>

                    <?php if ($be_depart == 'finance' or ($be_depart == 'fpaa' && $be_role == 'approver')) { ?>
                        <li>
                            <a href="trf_finance.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Finance Requests</a>
                        </li>
                    <?php } ?>
                    <?php if ($be_depart == 'fc') { ?>
                        <li>
                            <a href="trf_cfo.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Finance Requests</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>

            <li>
                <a href="#pageSubmenu109" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">Over Time Request</a>
                <ul class="collapse list-unstyled" id="pageSubmenu109">
                    <?php if ($be_depart == 'hr' or $be_depart == 'it') { ?>
                        <li>
                            <a href="ot_hr_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ HR Approval</a>
                        </li>
                    <?php } ?>

                    <?php if ($be_depart == 'fpaa' or $be_depart == 'it') { ?>
                        <li>
                            <a href="ot_fpna_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ FPNA Approval</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>








            <!-- <li>
            <a href="#pageSubmenu8" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 16px!important;">Expense</a>
            <ul class="collapse list-unstyled" id="pageSubmenu8">
            <?php if ($be_depart == 'saleszsm1' && $be_role == 'approver') { ?>
                <li>
                    <a href="expense_zsmasm_list.php" style="font-size: 14px!important;background-color:black!important;">▹        ZSM</a>
                </li>
                <?php } ?>

                <?php if ($be_depart == 'salesho' && $be_role == 'approver') { ?>
                <li>
                    <a href="expense_ho_list.php" style="font-size: 14px!important;background-color:black!important;">▹        HO</a>
                </li>
                <?php } ?>
            </ul>
        </li>  -->
        <?php } ?> <!--admin 1 end-->
        <!-- admin starts 2  -->
        <?php if (($be_depart == 'saleszsm1' && $be_role == 'approver') or
            ($be_depart == 'saleszsm2' && $be_role == 'approver')  or
            ($be_depart == 'saleszsm3' && $be_role == 'approver')  or
            ($be_depart == 'saleszsm4' && $be_role == 'approver') or
            ($be_depart == 'salesho' && $be_role == 'approver') or
            ($be_depart == 'salesho' && $be_role == 'user')
        ) { ?>
            <ul class="list-unstyled CTAs">
                <!-- <li>
                <a href="#" class="" style="background-color: #E5BA73!important; color:black!important; font-size:16px;padding:10px!important" >Admin Options</a>
            </li> -->
            </ul>
            <li>
                <a href="#pageSubmenu9" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">Bonus Approval</a>
                <ul class="collapse list-unstyled" id="pageSubmenu9">
                    <?php if (($be_depart == 'saleszsm1' && $be_role == 'approver') or ($be_depart == 'saleszsm2' && $be_role == 'approver')
                        or ($be_depart == 'saleszsm3' && $be_role == 'approver')  or ($be_depart == 'saleszsm4' && $be_role == 'approver')
                    ) { ?>
                        <li>
                            <a href="bonus_zsm_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ ZSM Approval</a>
                        </li>
                        <li>
                            <a href="bonus_zsm_dashboard.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Dashboard</a>
                        </li>
                    <?php } ?>
                    <?php if ($be_depart == 'salesho' && $be_role == 'approver') { ?>
                        <li>
                            <a href="bonus_ho_list.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ HO Approval</a>
                        </li>
                        <li>
                            <a href="bonus_rp.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Dashboard</a>
                        </li>
                    <?php } ?>
                    <?php if ($be_depart == 'salesho' && $be_role == 'user') { ?>
                        <li>
                            <a href="bonus_rp.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Dashboard</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li>
                <a href="#pageSubmenu10" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">Field Visit</a>
                <ul class="collapse list-unstyled" id="pageSubmenu10">
                    <?php if ($be_depart == 'salesho' && $be_role == 'approver') { ?>

                        <li>
                            <a href="field_visit_search.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Dashboard</a>
                        </li>
                    <?php } ?>
                    <!-- <?php if ($be_depart == 'salesho' && $be_role == 'user') { ?>
                <li>
                <a href="bonus_rp.php" style="font-size: 14px!important;background-color:black!important;">▹        Dashboard</a>
            </li>
                <?php } ?> -->
                </ul>
            </li>
            <li>
                <a href="#pageSubmenu11" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">Joint Visit</a>
                <ul class="collapse list-unstyled" id="pageSubmenu11">
                    <?php if ($be_depart == 'salesho' && $be_role == 'approver') { ?>
                        <li>
                            <a href="joint_visit_form.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹Submit Form</a>
                        </li>
                        <li>
                            <a href="joint_visit_rp.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Dashboard</a>
                        </li>
                    <?php } ?>
                    <!-- <?php if ($be_depart == 'salesho' && $be_role == 'user') { ?>
                <li>
                <a href="bonus_rp.php" style="font-size: 14px!important;background-color:black!important;">▹        Dashboard</a>
            </li>
                <?php } ?> -->
                </ul>
            </li>
            <li>
                <a href="#pageSubmenu12" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 11px!important;letter-spacing:1px">Batch Data</a>
                <ul class="collapse list-unstyled" id="pageSubmenu12">
                    <?php if ($be_depart == 'salesho' && $be_role == 'approver') { ?>
                        <li>
                            <a href="new_batch.php" style="font-size: 10px!important;background-color:black!important;letter-spacing:1px">▹ Batch Data</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?> <!--admin 1 end-->
    </ul>
    <ul class="list-unstyled CTAs">
        <li>
            <a href="logout.php" style="font-size: 11px!important; background-color:#0D9276!important;color:white!important;border-radius:0px!important;letter-spacing:1px">Logout</a>
        </li>
    </ul>
</nav>