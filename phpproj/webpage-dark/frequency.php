
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Frequency</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="" />

        <!-- Favicon -->
        <link rel="shortcut icon" href="images/favicon.png" />

        <!-- Bootstrap Style -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <!-- Awesome Icon -->
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

        <!-- Style -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

    <body class="index-report">

        <!--Main Content-->
        <main class="main-content mt-4 mt-lg-5"> 
            <div class="container">
                <!-- Frequency table -->
                <div class="contact-form-details section">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-10 offset-lg-1">
                            <div class="section-header text-center mb-4 mb-lg-5">
                                <h2>Frequency list</h2>                                    
                            </div>

                            <div class="table-responsive">
                                <table class="data-table table table-hover table-dark table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">Word</th>
                                            <th scope="col">Frequency</th>
                                            <th scope="col">Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            require_once "dbcon.php";
                                            $select = "SELECT * FROM occurrence o INNER JOIN source s ON o.source_id = s.source_id WHERE o.source_id = {$_GET["sourceid"]} ORDER BY freq DESC";
                                            $result = $db->query($select);
                                            while($row = $result->fetch_assoc())
                                            {
                                                echo "<tr>";
                                                    echo "<td>{$row["word"]}</td>";
                                                    echo "<td>{$row["freq"]}</td>";
                                                    echo "<td>".number_format((($row["freq"] / $row["total_words"]) * 100) , 2)."%</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Frequency table  -->
            </div>
        </main>
        <!--End Main Content-->

        <!-- Bootstrap JS -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Custom JS -->
        <script src="js/main.js"></script>

    </body>
</html>