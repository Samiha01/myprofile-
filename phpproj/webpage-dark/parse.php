
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Parse</title>
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

    <body class="index-parse">
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
                                    <li><a class="dropdown-item" href="report.php">Report</a></li>
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
                <!-- Parse Form - Details -->
                <div class="parse-form-details section">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-8 offset-lg-2">
                            <form action="" method="POST" class="parse-data-form">
                                <div class="formFeilds parse-form form-vertical bg-block mb-4 mb-md-0">
                                    <div class="section-header text-center mb-4">
                                        <h2>Parse form</h2>                                    
                                    </div>

                                    <?php
                                        if($_POST["parse"])
                                        {
                                            require_once("dbcon.php");

                                            $text = file_get_contents($_POST["sourceurl"]);
                                            $text = preg_replace('/[^a-z0-9]+/i', ' ', $text);
                                            $words = explode(" " , $text);
                                            $wordarray = [];
                                        
                                            foreach($words as $word)
                                            {
                                                $word = strtoupper($word);
                                                array_push($wordarray, $word);
                                            }
                                        
                                            $totalwords = count($wordarray);
                                        
                                            $insert = $db->prepare("INSERT INTO source(source_name , source_url , source_begin , source_end , total_words) VALUES(? , ? , ? , ? , ?)");
                                            $insert->bind_param("ssssi" , $_POST["sourcename"] , $_POST["sourceurl"] , $_POST["sourcebegin"] , $_POST["sourceend"] , $totalwords);
                                        
                                            $insert->execute();
                                            $sourceid = $insert->insert_id;
                                        
                                            if($_POST["sourcebegin"] == "" && $_POST["sourceend"] == "")
                                            {
                                                foreach($words as $word)
                                                {
                                                    $frequency[$word] = 0;
                                                }
                                        
                                                foreach($wordarray as $word)
                                                {
                                                    $frequency[$word]++;
                                                }
                                        
                                                $insert = $db->prepare("INSERT INTO occurrence(source_id , word , freq) VALUES(? , ? , ?)");
                                                foreach($frequency as $key=>$value)
                                                {
                                                    $insert->bind_param("isi" , $sourceid , $key , $value);
                                                    $insert->execute();
                                                }
                                            }
                                            
                                            if($_POST["sourcebegin"] != "" && $_POST["sourceend"] != "")
                                            {
                                                $beginindex = array_search(strtoupper($_POST["sourcebegin"]) , $wordarray);
                                                $endindex = $totalwords - (array_search(strtoupper($_POST["sourceend"]) , array_reverse($wordarray))) - 1;
                                                $totalwords = $endindex + 1 - $beginindex;
                                        
                                                $update = "UPDATE source SET total_words = {$totalwords} WHERE source_id = {$sourceid}";
                                                $db->query($update);
                                        
                                                for($i=$beginindex; $i<=$endindex; $i++)
                                                {
                                                    $frequency[$wordarray[$i]] = 0;
                                                }
                                        
                                                for($i=$beginindex; $i<=$endindex; $i++)
                                                {
                                                    $frequency[$wordarray[$i]]++;
                                                }
                                        
                                                $insert = $db->prepare("INSERT INTO occurrence(source_id , word , freq) VALUES(? , ? , ?)");
                                                foreach($frequency as $key=>$value)
                                                {
                                                    $insert->bind_param("isi" , $sourceid , $key , $value);
                                                    $insert->execute();
                                                }
                                            }
                                        ?>
                                        <!--Alert msg-->
                                        <div class="alert alert-success py-2 mb-4 alert-dismissible fade show cart-alert" role="alert">
                                            Your form was successfully submitted! 
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <!--End Alert msg-->
                                        <?php
                                        }
                                    ?>

                                    <div class="form-row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="sourcename" class="form-label">Source Name</label>
                                                <input type="text" id="sourcename" name="sourcename" class="form-control" placeholder="" required="required"/>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="sourceurl" class="form-label">Source URL</label>
                                                <input type="url" id="sourceurl" name="sourceurl" class="form-control" placeholder="https://example.com" required="required"/>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="sourcebegin" class="form-label">Source Begin</label>
                                                <input type="text" id="sourcebegin" name="sourcebegin" class="form-control" placeholder="" />
                                            </div>
                                        </div>  

                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="sourceend" class="form-label">Source End</label>
                                                <input type="text" id="sourceend" name="sourceend" class="form-control" placeholder="" />
                                            </div>
                                        </div>  

                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group parse-form-btn mb-0 w-100 text-center">	
                                                <input class="btn btn-primary btn-lg" type="submit" id="parse_sendmessage" name="parse" value="Parse" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>                        
                    </div>
                </div>
                <!-- End Parse Form - Details -->
            </div>
        </main>
        <!--End Main Content-->

        <!-- Bootstrap JS -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Custom JS -->
        <script src="js/main.js"></script>
        <script>
            document.getElementById("parse").addEventListener("click" , function(event)
            {
                var sourceurl = document.getElementById("sourceurl");
                var extension = sourceurl.value.split(".").pop();
                if(extension != "txt" && extension != "TXT")
                {
                    alert("Source URL is not a text file");
                    event.preventDefault();
                    return;
                }
            });            
        </script>
    </body>
</html>