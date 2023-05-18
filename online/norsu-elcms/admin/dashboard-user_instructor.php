<?php require_once('../path.php');?>
<?php include(ROOT_PATH . '/app/config/dbConPDO.php'); ?>
<?php 
    include(ROOT_PATH . '/app/helpers/middleware.php'); 
    adminOnly();

    $s_aid = $_SESSION['norsu-elcms-sid'];
    include(ROOT_PATH . '/app/controllers/query/getSessionUser.php'); 
?>

<?php 
    $title = $page = $head_title = 'User - Instructors';
    $pagehas = array('datatables');
?>

<?php include ROOT_PATH . '/app/includes/head.php'?>


<body class="container-fluid bg-primary">
    <?php include ROOT_PATH . '/app/includes/'.$s_directory.'/aside.php'?>

    <main id="dashboard" class="dashboard max">
        <?php include ROOT_PATH . '/app/includes/'.$s_directory.'/header.php'?>

        <div class="content bg-gray-200 p-3">
            <h3 class="text-uppercase fw-500"><?php echo $head_title ?></h3>


            <div class="card mt-3 p-3 shadow-sm">

                <div class="data-table table-responsive hasNoAddButton">
                    <table id="InstructorsTable" class="display table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID #</th>
                                <th>COLLEGE</th>
                                <th>DEPARTMENT</th>
                                <th>FULLNAME</th>
                                <th>CONTACT #</th>
                                <th># of CLASSES</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <?php include ROOT_PATH . '/app/includes/footer.php'?>
    </main>

    <?php include ROOT_PATH . '/app/includes/script.php'?>
    <script>
    $(document).ready(function() {
        fetchAllInstructors(0, 10000000);
        // FETCH ALL MajorS
        function fetchAllInstructors(start, limit) {
            $.ajax({
                url: baseUrl + '/app/controllers/query/fetchDataTables.php',
                method: 'POST',
                dataType: 'text',
                data: {
                    fetchAllInstructors: 'fetchAllInstructors',
                    start: start,
                    limit: limit
                },
                success: function(response) {
                    if (response != "reachedMax") {
                        $('tbody').append(response);
                        start += limit;
                        fetchAllInstructors(start, limit);
                    } else {
                        $("#InstructorsTable").DataTable({
                            "columnDefs": [{
                                "targets": [6],
                                "orderable": false
                            }, ],
                            dom: 'Blfrtip',
                            buttons: [{
                                className: 'btn btn-secondary my-2',
                                text: '<i class="fa-solid fa-download"></i><span class="ms-1">Generate Report</span>',
                                orientation: 'portrait',
                                pageSize: 'A4',
                                extend: 'pdfHtml5',
                                // download: 'open',
                                title: 'All Instructors',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5]
                                }
                            }],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                [10, 25, 50, "All"]
                            ]

                        });
                    }
                }
            });
        }
    });
    </script>
</body>

</html>
