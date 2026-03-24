<?php 
session_start (); 

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Your WorkOrder Requests</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png"/>


    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <style>
        th{
            font-size: 14px!important;
        }
        td{
            font-size: 13px!important;
        }
    </style>
    <link rel="stylesheet" href="assets/css/style.css">

<style>
    /* Define styles for anchor tags within the table for printing */
    @media print {
        #dataTableCont tbody tr a {
            color: black !important; /* Set the color to black */
            text-decoration: none !important; /* Remove underline */
        }
    }
</style>
</style>


    <style>
    /* Define a class to hide elements when printing */
    @media print {
      body * {
        visibility: hidden;
      }

      #dataTableCont, #dataTableCont * {
        visibility: visible;
      }

  </style>

  <script>
        function getPrint() {
        // Hide the "Get Print" button before printing
        var printBtn = document.getElementById('print1');
        if (printBtn) {
            printBtn.style.display = 'none';
        }

        // Hide specific columns (Status and Downloads) in the table for printing
        var statusColumn = document.querySelectorAll('#dataTableCont th:nth-child(9), #dataTableCont td:nth-child(9)');
        var downloadsColumn = document.querySelectorAll('#dataTableCont th:nth-child(10), #dataTableCont td:nth-child(10)');

        statusColumn.forEach(function(col) {
            col.style.display = 'none';
        });

        downloadsColumn.forEach(function(col) {
            col.style.display = 'none';
        });

        // Trigger printing
        window.print();

        // Show the "Get Print" button after printing is done (when returning from print preview)
        if (printBtn) {
            printBtn.style.display = 'block';
        }

        // Show specific columns after printing
        statusColumn.forEach(function(col) {
            col.style.display = ''; // Revert to the default display style
        });

        downloadsColumn.forEach(function(col) {
            col.style.display = ''; // Revert to the default display style
        });
    }
    </script>






<script>
  function printRow(rowId) {
    var row = document.getElementById('row_' + rowId);
  
    var printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write('<html><head><title>Print Preview</title>');
    printWindow.document.write('<style>table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid #000; padding: 8px; }</style>'); // Add table styles
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h2>Specific Data:</h2>');
  
    var tableStart = '<table>';
    var tableEnd = '</table>';
    var content = '';
  
    var id = '';
    var name = '';
  
    Array.from(row.children).forEach(function(cell, index) {
      if (index < row.children.length - 2) { // Exclude the last two columns
        var header = cell.parentElement.parentElement.parentElement.querySelector('thead th:nth-child(' + (cell.cellIndex + 1) + ')').innerText;
        var data = cell.innerHTML;
        if (header === 'Id') {
          id = data;
        } else if (header === 'Name') {
          name = data;
        } else {
          content += '<tr>';
          content += '<th>' + header + '</th>';
          content += '<td>' + data + '</td>';
          content += '</tr>';
        }
      }
    });
  
    content = '<tr><th style="width: 20%;">Id</th><td style="width: 30%;">' + id + '</td><th style="width: 20%;">Name</th><td style="width: 30%;">' + name + '</td></tr>' + content;
  
    printWindow.document.write(tableStart + content + tableEnd); // Writing the table with adjusted content
  
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
  }
</script>

   
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">

    <?php
            include 'sidebar.php';
        ?>


        <!-- Page Content  -->
        <div id="content">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>

                </div>
            </nav>

             <h3 class="text-center" style="font-size:25px;">Users</h3>
             <a href="add_user.php"><button id="" type="button" class="btn btn-primary btn-sm">Add</button></a>
             <button id="print1" type="button" class="btn btn-danger btn-sm" onclick="getPrint()">PDF</button>
             <button id="excel" class="btn btn-success btn-sm dataExport" data-type="excel">Excel</button>
             <input id="filter" type="text" class="form-control w-25" placeholder="Search here..." style="height: 30px; display:inline;">

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

                $select = "SELECT * FROM users";
                $select_q = mysqli_query($conn,$select);
                $data = mysqli_num_rows($select_q);
                   ?>
                
               <div id="dataTableCont">
                    <table  class="table table-bordered mt-1" id="myTable">
                  <thead class="thead-dark">
                    <tr id="row_<?php echo $row['id']; ?>">
                      <!-- <th scope="col">id</th> -->
                      <!-- <th scope="col">EmpId</th> -->
                      <th scope="col">Full&nbsp;name</th>
                      <th scope="col">Department</th>
                      <th scope="col">Role</th>
                      <th colspan="1">Head&nbsp;name</th>
                      <th scope="col">User&nbsp;name</th>
                      <th scope="col">Password</th>
                      <th scope="col">Email</th>
                      <!-- <th scope="col">Gender</th> -->
                      <!-- <th colspan="1">AddedDate</th> -->
                      <!-- <th colspan="1">Head&nbspEmail</th> -->
                    </tr>
                  </thead>
              
                  <?php 
                  if($data){
                    while ($row=mysqli_fetch_array($select_q)) {
                      ?>
                      <tbody class="searchable">
                        <tr id="row_<?php echo $row['id']; ?>">
                          <!-- <td><?php echo $row['id']?>  </td> -->
                          <!-- <td><?php echo $row['emp_id']?></td> -->
                          <td><?php echo $row['fullname']?></td>
                          <td><?php echo $row['department']?></td>
                          <td><?php echo $row['role']?></td>
                          <td><?php echo $row['head_name']?></td>
                          <td><?php echo $row['username']?></td>
                          <td><?php echo $row['password']?></td>
                          <td><?php echo $row['email']?></td>
                          <!-- <td><?php echo $row['gender']?></td> -->
                          <!-- <td><?php echo $row['added_date']?></td> -->
                          <!-- <td><?php echo $row['head_email']?></td> -->
     
                      </tr>
                      </tbody>

                      <?php
                    }
                  }
                  else{
                    echo "No record found!";
                  }
                  ?>
                </table>
               </div>
          </div>
            <!--ander ka kaam khatam-->
       
        </div> <!--page content-->
    </div> <!--wrapper-->

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript" src="libs/js-xlsx/xlsx.core.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
        $('#example').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable search box
            // More options can be added as needed
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
            $(document).ready(function() {
        $('#excel').click(function() {
            $('#myTable').tableExport({ type: 'excel',ignoreColumn: [8,9] });
            //$('#table_report').tableExport({ type: 'excel',escape:'false',ignoreColumn: [15]});
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