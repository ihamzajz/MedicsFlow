<!-- Sidebar  -->
<nav id="sidebar" style="background-color:#0D9276!important;">
    <div class="sidebar-header" style="background-color:#0D9276!important;">
        <h3>Medics Laboratories</h3>
        <p  style="font-size: 18px!important;font-weight:400;color: white;">Reporting Tool</p>
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
        
        $be_depart = $_SESSION['be_depart'];
        $be_role = $_SESSION['be_role'];
        ?>
    <ul class="list-unstyled components">
    
 
        <!-- <li>
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 16px!important;">Dashboards</a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="requisitionForm.php" style="font-size: 14px!important;background-color:#0D9276!important;">○ Engineering Workorder</a>
                </li>
                <li>
                    <a href="workorderForm.php" style="font-size: 14px!important;background-color:#0D9276!important;">○ Admin Workorder</a>
                </li>
                <li>
                    <a href="erpAccessForm.php" style="font-size: 14px!important;background-color:#0D9276!important;">○ ERP Access</a>
                </li>
                <li>
                    <a href="trf.php" style="font-size: 14px!important;background-color:#0D9276!important;">○ Travel Request</a>
                </li>
                <li>
                    <a href="trf.php" style="font-size: 14px!important;background-color:#0D9276!important;">○ Requsition</a>
                </li>
            </ul>
        </li> -->

        <li>
            <a href="eng_workorder_rp" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 16px!important;">Engineering Workorder</a>
        </li>

        <li>
            <a href="#" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 16px!important;">Admin Workorder</a>
        </li>
        <li>
            <a href="#" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 16px!important;">ERP Access</a>
        </li>
        <li>
            <a href="#" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 16px!important;">Travel Request</a>
        </li>
        <li>
            <a href="#" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle headings-main" style="font-size: 16px!important;">Requisition</a>
        </li>
   




    </ul>
    <ul class="list-unstyled CTAs">
        <li>
            <a href="logout.php" style="font-size: 15px!important; background-color: #E5BA73!important;color:black!important">Logout</a>
        </li>
    </ul>
</nav>