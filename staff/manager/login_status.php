<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');

// Checking if the user is logged in
if (isset($_SESSION['staff_id'])) {
    // User is logged in, proceed with displaying the page content
    check_login();
    $staff_id = $_SESSION['staff_id'];
?>
    <!-- Log on to codeastro.com for more projects! -->
    <!DOCTYPE html>
    <html>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include("dist/_partials/head.php"); ?>

    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <?php include("dist/_partials/nav.php"); ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <?php include("dist/_partials/manager.php"); ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>iBanking Advanced Login : All Data</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_financial_reporting_loans.php">Advanced Reporting</a></li>
                                    <li class="breadcrumb-item active">Loans</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <!-- <h4>All Transactions Under Loans Category</h4> -->
                                </div>
                                <div class="card-body">
                                    <table id="export" class="table table-hover table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Timestamp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Get latest loan transactions
                                            $ret = "SELECT * FROM login_data ";
                                            $stmt = $mysqli->prepare($ret);
                                            if ($stmt === false) {
                                                echo "Error in preparing statement: " . $mysqli->error;
                                            } else {
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                if ($res === false) {
                                                    echo "Error in getting result: " . $stmt->error;
                                                } else {
                                                    $cnt = 1;
                                                    while ($row = $res->fetch_object()) {
                                                       
                                            ?>

                                                        <tr>
                                                            <td><?php echo $cnt; ?></td>
                                                            <td><?php echo $row->login_id; ?></a></td>
                                                            <td><?php echo $row->name; ?></td>
                                                            <td>$ <?php echo $row->role; ?></td>
                                                            <td><?php echo $row->datetime; ?></td>
                                                        </tr>
                                            <?php
                                                        $cnt++;
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php include("dist/_partials/footer.php"); ?>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- DataTables -->
        <script src="plugins/datatables/jquery.dataTables.js"></script>
        <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
        <!-- page script -->
        <script src="plugins/datatable/button-ext/dataTables.buttons.min.js"></script>
        <script src="plugins/datatable/button-ext/jszip.min.js"></script>
        <script src="plugins/datatable/button-ext/buttons.html5.min.js"></script>
        <script src="plugins/datatable/button-ext/buttons.print.min.js"></script>
        <script>
            $('#export').DataTable({
                dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                buttons: {
                    buttons: [{
                            extend: 'copy',
                            className: 'btn'
                        },
                        {
                            extend: 'csv',
                            className: 'btn'
                        },
                        {
                            extend: 'excel',
                            className: 'btn'
                        },
                        {
                            extend: 'print',
                            className: 'btn'
                        }
                    ]
                },
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [7, 10, 20, 50],
                "pageLength": 7
            });
        </script>
    </body>

    </html>

<?php
} else {
    // If user is not logged in, redirect to login page or perform other actions
    header("Location: login.php");
    exit();
}
?>
