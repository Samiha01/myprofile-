
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Source Report</title>
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
        <!--Header section-->
        <header class="site-header py-lg-0">
            <nav class="navbar navbar-light navbar-expand-lg py-0" aria-label="navbar">
                <div class="container">
                    <a class="navbar-brand py-0" href="index.html">
                        <img src="images/bootstrap-logo.svg" alt="" width="40" height="30">
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars0" aria-controls="navbars0" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-lg-center" id="navbars0">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="index.html">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Course</a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown01">
                                    <li><a class="dropdown-item" href="https://www.zybooks.com/" target="_blank">ZyBooks</a></li>
                                    <li><a class="dropdown-item" href="https://tophat.com/" target="_blank">TopHat</a></li>
                                    <li><a class="dropdown-item" href="https://drive.google.com/open?id=1AsHhIFfQ3yNE_m2z4wswRfKh77K0UH9w" target="_blank">Course Google Drive</a></li>
                                    <li><a class="dropdown-item" href="https://www.w3schools.com/" target="_blank">W3Schools</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-bs-toggle="dropdown" aria-expanded="false">About</a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown02">
                                    <li><a class="dropdown-item" href="developer.html">About The Developer</a></li>
                                    <li><a class="dropdown-item" href="contact.html">Contact</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="browser.html" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">Browser</a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown03">
                                    <li><a class="dropdown-item" href="browser.html#navigator">Navigator</a></li>
                                    <li><a class="dropdown-item" href="browser.html#window">Window</a></li>
                                    <li><a class="dropdown-item" href="browser.html#screen">Screen</a></li>
                                    <li><a class="dropdown-item" href="browser.html#geolocation">Location</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-bs-toggle="dropdown" aria-expanded="false">Search</a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown04">
                                    <li><a class="dropdown-item" href="fromFile.html">From File</a></li>
                                    <li><a class="dropdown-item" href="googleAPI.html">Google API</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown05" data-bs-toggle="dropdown" aria-expanded="false">Project</a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown05">
                                    <li><a class="dropdown-item" href="parse.php">Parse</a></li>
                                    <li><a class="dropdown-item" href="report.html">Report</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <!--End Header section-->

        <!--Main Content-->
        <main class="main-content mt-4 mt-lg-5"> 
            <div class="container">
                <!-- Report table -->
                <div class="contact-form-details section">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="section-header text-center mb-4 mb-lg-5">
                                <h2>Source Report</h2>                                    
                            </div>

                            <div class="table-responsive">
                                <table class="data-table table table-hover table-dark table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">source_id</th>
                                            <th scope="col">source_name</th>
                                            <th scope="col">source_url</th>
                                            <th scope="col">source_begin</th>
                                            <th scope="col">source_end</th>
                                            <th scope="col">parsed_dtm</th>
                                            <th scope="col">words</th>
                                        </tr>
                                    </thead>
                                    <?php
                                        require_once("dbcon.php");

                                        $select = $db->prepare("SELECT * FROM source");
                                        $select->execute();
                                        $result = $select->get_result();
                                    ?>
                                    <tbody>
                                        <?php
                                            while($row = $result->fetch_assoc())
                                            {
                                                echo "<tr>";
                                                    echo "<th scope='row'>{$row["source_id"]}</th>";
                                                    echo "<td>{$row["source_name"]}</td>";
                                                    echo "<td><a href='{$row["source_url"]}' target='_blank'>{$row["source_url"]}</a></td>";
                                                    echo "<td>{$row["source_begin"]}</td>";
                                                    echo "<td>{$row["source_end"]}</td>";
                                                    echo "<td>{$row["parsed_dtm"]}</td>";
                                                    echo "<td><a href='frequency.php?sourceid={$row["source_id"]}' target='_blank'>words</a></td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Report table  -->
            </div>
        </main>
        <!--End Main Content-->

        <!-- Bootstrap JS -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Custom JS -->
        <script src="js/main.js"></script>
    </body>
</html>