<?php
    require 'search.php';
    require 'models/login.php';
    require 'db/credentials.php';

    $conn = new mysqli($MYSQL_CREDENTIALS["host"], $MYSQL_CREDENTIALS["username"], $MYSQL_CREDENTIALS["password"], $MYSQL_CREDENTIALS["database"]);
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }
    $user = Login::current($conn);
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>4UImg Image Search</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/agency.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- CUSTOM CSS FOR THIS SPECIFIC PAGE -->
    <?php echo '<link href="css/results.css" rel="stylesheet">'; ?>

</head>

    <body id="page-top" class="index">

        <!-- HEADER SPECIFIC TO RESULTS PAGE (NO SEARCH IN HEADER) -->
        <?php include 'includes/index_header.php' ?>


        <!-- INPUT SEARCH FORM -->
        <div class="items">
            <section id="portfolio">
                <div class="container bg-light-gray">
           <div class="row" style="
    margin-top: -30px;
">
                 <div class="col-lg-12 text-center">
                            <h2 class="section-heading">Search Results</h2>
                            <h3 class="section-subheading text-muted" style="
    margin-top: -10px;
    margin-bottom: 50px;
">Go ahead, search anything</h3>
                            <div class="col-md-5">
                            <form method="POST">
                                <div class="input-group">
                                <input type="text" class="form-control inputBox" id="name" placeholder="Search here..." name="name" value="<?php echo $_POST["name"]; ?>">
                                    <br>
                                    <span class="input-group-btn">
                                        <input type="submit" class="page-scroll btn btn-md" value="Search" id="name-submit">
                                    </span>
                                </div>
                            </form>
                            </div>
                   <div class="col-md-2">
                    <span class="text-muted" style="font-size: 33px;">OR</span>

</div>
<div class="col-md-5">
             <input type="submit" class="page-scroll btn btn-md" value="REQUEST CUSTOM ARTWORK" data-toggle="modal" data-target="#bountyForm" style="
                margin-top: -3px;
                color: #fff;
                background-color: #fed136;
                border-color: #C7C3B5;
                font-family: Montserrat, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;
                text-transform: uppercase;
                font-size: 20px;
                width: 75%;
                ">
                </div>
                        </div>
                    </div>



        <script src="js/global.js"></script>

        <br>  
       

        <!-- SCRIPT TO ACCESS THE DB AND RETURN IMAGES -->
        <?php  
            if (isset($_POST['name']) === true && empty($_POST['name']) === false){

          
                require 'thumbnail.php';
                require 'models/media.php';
                require 'models/bounty.php';

                function get_keywords() {
                    if (isset($_POST["name"])) {
                        return $_POST["name"];
                    } else {
                        return "";
                    }
                }

                $keywords = explode(" ", get_keywords());

   
            $connection = new mysqli($MYSQL_CREDENTIALS["host"],
                                     $MYSQL_CREDENTIALS["username"],
                                     $MYSQL_CREDENTIALS["password"],
                                     $MYSQL_CREDENTIALS["database"]);

          
            $results = Media::search($connection,$keywords);
            }
      
        ?>

        <!-- DISPLAYS TOTAL RESULTS RETURNED-->
        <?php

            if(!(isset($results)))
            {

                echo "<div class=\"text-center\"><span class=\"results_total\"><strong>Results Total: 0</strong></span></div>";

            }
            else if ($results) {

                $total = count($results);
                
                echo "<div class=\"text-center\"><span class=\"results_total\"><strong>Results Total:</strong>&nbsp;" . $total . "</span></div>";
           }

        ?>

                <br>
                

        <div class="row">

        <!-- PANEL DISPLAY MODAL FOR SEARCHED IAMGES-->
        <?php

            if (!(isset($results))) {

                echo "<h2><i>Type in a keyword above to search for images</i></h2>";

            } else if ($results) {
   

            foreach ($results as $images) {


             
                $title       = preg_replace('/\s+/', '', $images->getTitle());
                $artist      = $images->getArtistUsername();
                $unlimited   = $images->getUnlimitedPrice();
                $web         = $images->getWebPrice();
                $print       = $images->getPrintPrice();
                $description = $images->getDescription();
                $id          = $images->getID();
                $extension   = $images->getExtension();

                $display = $images->getDisplayImage($connection);
             

                echo "<div class=\"col-md-4 col-sm-6 portfolio-item\">
                <a href=\"#portfolioModal" . $title . "\" class=\"portfolio-link\" data-toggle=\"modal\"><div class=\"portfolio-hover\">
                <div class=\"portfolio-hover-content\">
                <i class=\"fa fa-camera-retro fa-3x\">    <span class=\"click_purchase\" style=\"font-size: 45px;\">
                                          View Details
                                        </span></i></div></div><img src=\"" . thumbnail('images/original/' . $display->getID() . '.' . $display->getExtension(), 360, 270) . "\" class=\"img-responsive\"></a><div class=\"portfolio-caption\">";

  if ($user != null) {

    echo "<div style=\"display: none;\" id='user-$id'>" . $user->getUsername() . "</div>";

     echo "<a href=\"#\" data-target=\"#purchase_image" . $title . "\" role=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" style=\"border-color: #C3B78D;\">Purchase</a>";

    } else {
        // FIXME: then we need to login
       echo "<a href=\"#\" data-target=\"#guest_purchase" . $title ."\"role=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" style=\"border-color: #C3B78D;\">Purchase</a>";

    }

                echo "<h3><a href=\"#portfolioModal" . $title . "\" data-toggle=\"modal\" style=\"color: #31310B;\">" . $images->getTitle();
                if ($images->isVideo()) {
                    echo " (video)";
                }
                echo "</a></h3>\n";
                echo "<p class=\"text-muted\"><a href=\"#portfolioModal" . $title . "\" class=\"des\" data-toggle=\"modal\">" . $description . "</a></p>\n";
                echo "  \n";
                echo "<a href=\"#portfolioModal" . $title . "\" class=\"des\" data-toggle=\"modal\">";
                echo "<p><strong>Unlimited: </strong>$" . $unlimited . "</p><p><strong>Web: </strong>$" . $web . "</p><p><strong>Print: </strong>$" . $print . "</p><p></p>";
                echo "</a>";
                echo "\n";
                echo "<br>\n";
                echo "  \n";
                
                echo "</div></div>";
            }
                echo "<div class=\"col-lg-12 text-center\" id=\"bounty\">\n";
                echo "<span class=\"text-muted\" style=\"font-size:40px;\">Can't find what you're looking for?</span><br>\n";
                echo "        <br><input type=\"submit\" class=\"page-scroll btn btn-xl\" value=\"Request Custom Artwork\" id=\"name-submit\" data-toggle=\"modal\" data-target=\"#bountyForm\">\n";
                echo "</div>";   
             }
        ?>


                    </div>
                </div>
            </section>


            
        <!-- IMAGE PURCHASING/DETAILS MODALS-->
         <?php
            if (!(isset($results))) {
                // SHOW NOTHING!

            } else if ($results) {


         foreach ($results as $images) {

             
                $title       = preg_replace('/\s+/', '', $images->getTitle());
                $artist      = $images->getArtistUsername();
                $unlimited   = $images->getUnlimitedPrice();
                $web         = $images->getWebPrice();
                $print       = $images->getPrintPrice();
                $description = $images->getDescription();
                $id          = $images->getID();
                $extension   = $images->getExtension();
		$display = $images->getDisplayImage($connection);


                echo " <div class=\"modal fade\" id=\"portfolioModal" . $title . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"largeModal\" aria-hidden=\"true\">\n";
                echo "    <div class=\"modal-dialog modal-lg\">\n";
                echo "        <div class=\"modal-content\">\n";
                echo "\n";
                echo "\n";
                echo "            <div class=\"modal-header\">\n";
                echo "<button type=\"button\" data-dismiss=\"modal\" aria-hidden=\"true\" class=\"close\">\n";
                echo "<i class=\"fa fa-times fa-2x\" aria-hidden=\"true\"></i>\n";
                echo "</button>";

                echo "                <h2 class=\"modal-title text-center\" id=\"myModalLabel\">Artwork Details</h2>\n";
                echo "            </div>\n";
                echo "\n";
                echo "\n";
                echo "            <div class=\"modal-body\">\n";
                echo "                <div class=\"col-lg-12\">\n";
                echo "                    <br><br>\n";
                echo "                    <div class=\"col-md-6\">\n";
                                echo "    <img class=\"img-responsive\" id=\"image\" src=\"" . thumbnail('images/original/' . $display->getID() . "." . $display->getExtension(), 500, 400) . "\">\n";
                echo "                    </div>\n";
                echo "                    <div class=\"col-md-6\">\n";
                echo "                        <div class=\"image_data\">\n";
                echo "                            <h2 id='title-$id'>Title: " . $images->getTitle();
                if ($images->isVideo()) {
                    echo " (video)";
                }
                echo " </h2>\n";
                echo "                            <p>\n";
                echo "                                <strong>ID:</strong> <span class=\"text-muted\" style=\"font-size:20px;\">" . $id . "</span><br>\n";
                echo "                                <strong>Description:</strong> <span id='description-$id' class=\"text-muted\" style=\"font-size:20px;\">" . $description . "</span><br>\n";
                echo "                                <strong>Artist:</strong> <span id='artist-$id' class=\"text-muted\" style=\"font-size:20px;\">" . $artist . "</span><br><br>\n";
                echo "                            </p>\n";

                echo "<form>\n";
echo "  <div class=\"radio\">\n";
echo "<h4>Pricing options\n";
echo "  <span id=\"whats_this\" style=\"\n";
echo "                               font-size: 16px;\n";
echo "                               margin-left: 13%;\n";
echo "                               \">\n";
echo "    <a href=\"\" id=\"radio1\" data-toggle=\"modal\" data-target=\"#license_types\">what's this?</a>\n";
echo "  </span><br><span style=\"\n";
echo "    font-size: 12px;\n";
echo "    \"><i>(select one to continue purchase)</i></span>      \n";
echo "  <br>\n";
echo "</h4>";

echo "\n";
echo "    <label>\n";
echo "      <input class='pricing-option-$id' type=\"radio\" name=\"identity\" value='unlimited:$unlimited' onclick=\"$('#purchase" . $id . "').prop('disabled',false);\">\n";
echo "      <span class=\"text-muted\" style=\"font-size:17px;\">\n";
echo "        <strong>Unlimited:&nbsp;</strong>" . $unlimited . "\n";
echo "      </span>\n";
echo "    </label>\n";
echo "\n<br>";
echo "    <label>\n";
echo "      <input class='pricing-option-$id' type=\"radio\" name=\"identity\" value='web:$web' onclick=\"$('#purchase" . $id . "').prop('disabled',false);\">\n";
echo "      <span class=\"text-muted\" style=\"font-size:17px;\">\n";
echo "        <strong>Web:&nbsp;</strong>" . $web . "<br>\n";
echo "      </span>\n";
echo "    </label>\n";
echo "\n<br>";
echo "    <label>\n";
echo "      <input class='pricing-option-$id' type=\"radio\" name=\"identity\" value='print:$print' onclick=\"$('#purchase" . $id . "').prop('disabled',false);\">\n";
echo "      <span class=\"text-muted\" style=\"font-size:17px;\">\n";
echo "        <strong>Print:&nbsp;</strong>" . $print . "\n";
echo "      </span>\n";
echo "    </label>\n";
echo "\n";
echo "  </div>\n";
echo "  <p class=\"info\">Selecting \n";
echo "    <strong>purchase image</strong> will send you a confirmation email and update be avaliable for download in your profile \n";
echo "  </p>
</form>
        <p>\n";

    if ($user != null) 
    {

    echo "  <button data-target=\"#confirm_purchase" . $title . "\" role=\"button\" class=\"btn btn-primary\" id=\"purchase" . $id . "\" data-toggle=\"modal\" style=\"\n";
    echo "                                                                                                                                               width: 100%;\n";
    echo "                                                                                                                                               height: 13%;\n";
    echo "                                                                                                                                               font-size: 25px;\n";
    echo "                                                                                                                                               \" onclick=\"submitPurchase($id)\" disabled>Purchase Image</button>";

    } 

    else 
    
    {
        echo "  <button data-target=\"#guest_purchase" . $title . "\" role=\"button\" class=\"btn btn-primary\" id=\"purchase" . $id . "\" data-toggle=\"modal\" style=\"\n";
        echo "                                                                                                                                               width: 100%;\n";
        echo "                                                                                                                                               height: 13%;\n";
        echo "                                                                                                                                               font-size: 25px;\n";
        echo "                                                                                                                                               \" onclick=\"submitPurchase($id)\" disabled>Purchase Image</button>";

    }





echo "  </p>";
echo "</div>";

  
                echo "                        <p>\n";
                 echo" By purchasing, you agree to our\n";
                echo "                            <a href=\"\" data-toggle=\"modal\" data-target=\"#terms_of_use\">Terms</a> and that you have read our\n";
                echo "                            <a href=\"\" data-toggle=\"modal\" data-target=\"#privacy_policy\">\n";
                echo "                    Priacy Policy\n";
                echo "                    </a>\n";
                echo "                        </p>\n";
                echo "                    </div>\n";
                echo "                </div>\n";
                echo "            </div>\n";
                echo "            <div class=\"row text-center\">\n";
                echo "                <button type=\"button\" class=\"btn btn-primary\" id=\"close\" data-dismiss=\"modal\" style=\"\n";
                echo "     margin-bottom: 40px;\n";
                echo "     margin-top: 30px;\n";
                echo "     \">OK</button>\n";
                echo "            </div>\n";
                echo "        </div>\n";
                echo "    </div>\n";
                echo "</div>\n";

            
        }
          
        ?>
        <!-- PURCHASE MODAL right from panel -->
        <?php 
             if (!(isset($results))) {

            // SHOW NOTHING!
            
            } else if ($results) {
   

        foreach ($results as $images) {

                $title = preg_replace('/\s+/', '', $images->getTitle());
                $artist = $images->getArtistUsername();
                $unlimited = $images->getUnlimitedPrice();
                $web = $images->getWebPrice();
                $print = $images->getPrintPrice();
                $description = $images->getDescription();
                $id = $images->getID();
                $extension = $images->getExtension();

            echo "<div class=\"modal fade\" id=\"purchase_image" . $title . "\" role=\"dialog\">\n";
            echo "        <div class=\"modal-dialog\">\n";
            echo "            <div class=\"modal-content\">\n";
            echo "                <div class=\"modal-header\">\n";
                 echo "<button type=\"button\" data-dismiss=\"modal\" aria-hidden=\"true\" class=\"close\">\n";
                echo "<i class=\"fa fa-times fa-2x\" aria-hidden=\"true\"></i>\n";
                echo "</button>";
            echo "                    <h2 style=\"margin-top: 1%;\">Title: " . $images->getTitle() . "</h2>";
            echo "                </div>\n";
            echo "                <div class=\"modal-body\" id=\"radio\" style=\"margin-bottom: 57%;\">";
            echo "                    <div class=\"radio\">\n";
            echo "                        <h3>Choose a pricing option <span id=\n";
            echo "                        \"whats_this_2\"><a data-target=\"#license_types\"\n";
            echo "                        data-toggle=\"modal\" href=\"\">what's\n";
            echo "                        this?</a></span></h3>\n";
            echo "                        <hr>\n";
            echo "                        <br>\n";


            echo "                        <div class=\"col-md-4 text-center\">\n";
            echo "                            <label class=\"text-muted pricing_opts\">
           <input class='pricing-option-$id' type=\"radio\" name=\"identity\" value='unlimited:$unlimited' onclick=\"$('#purchase" . $id . "_2').prop('disabled',false);\">\n";

           echo " <span class=\n";
            echo "                            \"text-muted\" style=\n";
            echo "                            \"font-size:17px;\"><strong><u>Unlimited</u></strong>\n";
            echo "                            $" . $unlimited ."</span></label>\n";
            echo "                            <p class=\"text-center\"><i>Artwork licensed under an\n";
            echo "                            Unlimited license can be used in print form and in\n";
            echo "                            the Internet (World Wide Web).</i></p>\n";
            echo "                        </div>\n";


            echo "                        <div class=\"col-md-4 text-center\">\n";
              echo "                            <label class=\"text-muted pricing_opts\">
           <input class='pricing-option-$id' type=\"radio\" name=\"identity\" value='web:$web' onclick=\"$('#purchase" . $id . "_2').prop('disabled',false);\">\n";

            echo "<span class=\"text-muted\" style=\n";

            echo "                            \"font-size:17px;\"><strong><u>Web</u></strong><br>\n";
            echo "                            $" . $web . "</span></label>\n";
            echo "                            <p class=\"text-center\"><i>Artwork licensed under a\n";
            echo "                            Web license can only be used in the Internet (World\n";
            echo "                            Wide Web). It may not be used in print\n";
            echo "                            form.</i></p>\n";
            echo "                        </div>\n";


            echo "                        <div class=\"col-md-4 text-center\">\n";
          echo "                            <label class=\"text-muted pricing_opts\">
           <input class='pricing-option-$id' type=\"radio\" name=\"identity\" value='print:$print' onclick=\"$('#purchase" . $id . "_2').prop('disabled',false);\">\n";

           echo "<span class=\"text-muted\"\n";
            echo "                            style=\n";
            echo "                            \"font-size:17px;\"><strong><u>Print</u></strong><br>\n";
            echo "                            $" . $print . "</span></label>\n";
            echo "                            <p class=\"text-center\"><i>Artwork licensed under a\n";
            echo "                            Print license can only be used in the print form.\n";
            echo "                            It may not be used in electronic form, such as on\n";
            echo "                            the Internet (World Wide Web).</i></p>\n";
            echo "                        </div>\n";


            echo "                    </div>\n";
            echo "                </div>\n";
            echo "                <div class=\"modal-footer\">\n";
            echo "                    <div class=\"col-md-6\">\n";
            echo "                        <button class=\"btn btn-default cancel\" data-dismiss=\n";
            echo "                        \"modal\" type=\"button\">Cancel</button>\n";
            echo "                    </div>\n";
            echo "                    <div class=\"col-md-6\">\n";

            echo "  <button data-target=\"#confirm_purchase" . $title . "\" role=\"button\" class=\"btn btn-primary\" id=\"purchase" . $id . "_2\" data-toggle=\"modal\"  onclick=\"submitPurchase($id)\" disabled>Purchase Image</button>";
       
            echo "                    </div>\n";
            echo "                </div>\n";
            echo "            </div>\n";
            echo "        </div>\n";
            echo "    </div>";
            
            }
        }

 ?>

<!-- PURCHASE CONFIRMATION -->
    <?php

         foreach ($results as $images) {

                $title = preg_replace('/\s+/', '', $images->getTitle());
                $artist = $images->getArtistUsername();
                $unlimited = $images->getUnlimitedPrice();
                $web = $images->getWebPrice();
                $print = $images->getPrintPrice();
                $description = $images->getDescription();
                $id = $images->getID();
                $extension = $images->getExtension();
                $display = $images->getDisplayImage($connection);

                echo "<div class=\"modal\" id=\"confirm_purchase" . $title . "\">\n";
                echo "    <div class=\"modal-dialog\">\n";
                echo "        <div class=\"modal-content\">\n";
                echo "\n";
                echo "            <div class=\"modal-body\">\n";
                echo "            <button type=\"button\" class=\"close confirm_close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">X</span></button>\n";
                echo "                <p><strong>Purchased:</strong> " . $images->getTitle() . "\n";
                if ($images->isVideo()) {
                    echo " (video)";
                }
                echo "                <br>    \n";
                echo "                <strong>ID: </strong> " . $id . "\n";
                echo "                <br>    \n";
                echo "                <strong>License Type: </strong><span id='license-type-$id'></span></p>\n";
              echo "         <hr>
                    <br>
                    <p>Thank you for purchasing this artwork.
                    <br> The invoice has been sent and the artwork has now been added to your account.

                    <br>To View/Download your image, go to your <a href=\"customerprofile.php#images\" style=\"
    color: #337ab7;
    text-decoration: underline;
\">profile page</a></p> ";
                echo "                    \n";
                echo "            </div>\n";
                echo "\n";
                echo "        <div class=\"modal-footer\">\n";
                echo "        <button type=\"button\" class=\"btn btn-primary pull-right confirm_close\" data-dismiss=\"modal\">OK</button>\n";
                echo "        </div>\n";
                echo "        </div>\n";
                echo "    </div>\n";
                echo "</div>";
                }
            } else {   
                die();
            }


    ?>

 

        </div> <!-- END ITEMS -->
           





            <!-- jQuery -->
            <script src="js/jquery.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="js/bootstrap.min.js"></script>

            <!-- Plugin JavaScript -->
            <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        
            <!-- Contact Form JavaScript -->
            <script src="js/jqBootstrapValidation.js"></script>
            <script src="js/contact_me.js"></script>

            <!-- Custom Theme JavaScript -->
            <script src="js/agency.js"></script>

            <!-- GUEST USER PURCHASING -->
            <?php include 'includes/guest_purchase.php' ?>

            <!-- CUSTOM ARTWORK REQUEST MODAL -->
            <?php include 'includes/custom_artwork_form.php' ?>

            <!-- CONFIRMATION MESSAGE UPON PURCHASE -->
            <?php //include 'includes/confirm_purchase.php' ?>

            <!-- MODAL FOR LICENSE TYPES -->
            <?php include "includes/license_types.php" ?>

            <!-- MODAL FOR TERMS AND CONDITIONS -->
            <?php include "includes/terms_and_conditions.php" ?>

            <!-- MODAL FOR PRIVACY POLICY -->
            <?php include 'includes/privacy_policy.php' ?>

            <!-- FOOTER -->
            <?php include "includes/footer.php" ?>

    
    <script type="text/javascript">
       

        $(".confirm_close").click(function(){
         $('.modal').modal('hide');
        });

    </script>

    </body>

</html>
