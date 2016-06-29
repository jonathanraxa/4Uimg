<?php
    require 'search.php';
    require 'models/login.php';
    require 'db/credentials.php';
    include 'models/bounty.php';

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

        <title>4UImg</title>

        <!-- ALL THE BOOTSTRAP CSS/JS -->
        <?php include 'includes/includes_head.php' ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link href="css/stylish-portfolio.css" rel="stylesheet">

        <!-- INDEX CSS-->
        <?php echo '<link href="css/index.css" rel="stylesheet">'; ?>

    </head>

<body id="page-top" class="index">

    <!-- SPECIFIC HEADER FILE FOR INDEX/RESULTS PAGE -->
    <?php include 'includes/index_header.php' ?>


<header style="
        background-image: url(images/header-bg.jpg);

">
        
<div class="container">
    <div class="intro-text">
        <div class="intro-lead-in" style="
                                    margin-top: -10%;
                                    padding-bottom: 5%;
                                    ">
    <span class="section-heading" style="
                                     font-family: Nevis;
                                     font-size: 100px;
                                     color: #fed136;
                                     font-weight: bold;
                                     : 0.01px
                                     -webkit-text-stroke-color: black;
                                     color: #fed136;
                                     text-shadow:    -1px -1px 0 #000,       1px -1px 0 #000,     -1px 1px 0 #000,      1px 1px 0 #000;
                                     ">4Uimg</span>

    <h3 class="section-subheading text-muted" style="
                                     color: white;
                                     Kaushan Script&amp;quot;,&amp;
                                     quot;
                                     Helvetica Neue&amp;quot;,
                                     Helvetica,Arial,cursive;
                                     font-size: 21px;
                                     margin-top: 3%;
                                     color: white;
                                     text-shadow:    -1px -1px 0 #000,       1px -1px 0 #000,     -1px 1px 0 #000,      1px 1px 0 #000;
                                     ">Go ahead, search 
      <mark style="
                   background-color: rgba(254, 209, 54, 0.77);
                   color: rgb(0, 0, 0);
                   text-shadow: -1px -1px 0 white,       1px -1px 0 white,     -1px 1px 0 white,      1px 1px 0 white;
                   ">anything</mark>
    </h3>
  </div>




  <div class="intro-heading">
    <form action="results.php" method="post">
      <input type="text" class="form-control inputBox center-block" id="name" placeholder="Search artwork here..." name="name" style="width: 60%;margin-bottom: 5%;">



      <div class="row">
        <div class="col-md-5">
          <input type="submit" class="page-scroll btn btn-xl" value="Search for Artwork" id="name-submit" name="submit" style="
                                                                                                                               ">
        </div>
        <div class="intro-heading col-md-2" style="
                                                   color: #fed136;
                                                   -webkit-text-stroke-width: 2.01px;
                                                   -webkit-text-stroke-color: black;
                                                   font-size: 37px;
                                                   ">OR</div>
        <div class="col-md-5">
          <input type="button" class="page-scroll btn btn-xl" value="Request Custom Artwork" data-toggle="modal" data-target="#bountyForm">
          <script src="js/global.js"></script>
        </div>
      </div>

    </form>

  </div>


</div>


        </div>
    </header>



    <!-- MIDDLE PORTION FOR THE QUOTE -->
    <div class="callout">
        <div class="vert-text">
            <h1><i>The aim of art is to represent not the outward appearance of things, but their inward significance.</i></h1>
                <h2>&nbsp;&nbsp;&nbsp;&nbsp;-Aristotle</h2>
        </div>
    </div>

    <!-- FEATURED ARTWORK SECTION -->
    <section id="portfolio" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center" id="featured_head">
                    <h2 class="section-heading" >Featured Artwork</h2>
                    <h3 class="section-subheading text-muted">View artwork from various artists.</h3>
                </div>
            </div>


    <!-- ALL THE FEATURED IMAGES -->
    <div class="row">
        <?php 

       
            require 'thumbnail.php';
            require 'models/media.php';

            function write_thumbnail($media) {
                echo "<img src=\"" . thumbnail("images/original/" . $media->getID() . "." . $media->getExtension(), 360, 270) . "\" class='img-responsive' />";
            }

            $connection = new mysqli($MYSQL_CREDENTIALS["host"],
                                     $MYSQL_CREDENTIALS["username"],
                                     $MYSQL_CREDENTIALS["password"],
                                     $MYSQL_CREDENTIALS["database"]);

          
            $results = Media::getFeatured($connection);
            foreach ($results as $images) {

                $title = preg_replace('/\s+/', '', $images->getTitle());
                $artist = $images->getArtistUsername();
                $unlimited = $images->getUnlimitedPrice();
                $web = $images->getWebPrice();
                $print = $images->getPrintPrice();
                $description = $images->getDescription();
                $id = $images->getID();
                $extension = $images->getExtension();
             
                if ($user != null) {
                 echo "<div style=\"display: none;\" id='user-$id'>" . $user->getUsername() . "</div>";
                }

                echo " <div class=\"col-md-4 portfolio-item\">\n";
                echo "<a href=\"#portfolioModal". $title . "\" class=\"portfolio-link\" data-toggle=\"modal\">";
                echo "         <div class=\"portfolio-hover\">\n";
                echo "            <div class=\"portfolio-hover-content\">\n";
                echo "                <i class=\"fa fa-camera-retro fa-3x\">
                                        <span class=\"click_purchase\" style=\"font-size: 45px;\">
                                          View Details
                                        </span>
                                      </i>\n";
                echo "            </div>\n";
                echo "        </div>\n";
                echo "        <div class=\"panel-heading\">\n";
                echo "            Photo by\n";
                echo "            <h3 class=\"panel-title\">" . $images->getArtistUsername() . "</h3>\n";
                echo "        </div>\n";
                write_thumbnail($images);
                echo "    </a>\n";
                echo "\n";
                echo "    </div>";
                            


}


        ?>
            </div>
        </div>
    </section>


    <!-- ABOUT THE PRODUCT SECTION-->
    <section id="about">
        <div class="content-section-a">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center" id="about_head">
                      <h2 class="section-heading">Artwork for you!</h2>
                      <h3 class="section-subheading text-muted">For Artist, For Art Lovers, For Everyone!</h3>
                    </div>
                    <div class="col-lg-5 col-sm-6">
                        <hr class="section-heading-spacer">
                        <div class="clearfix"></div>
                         <h2 class="section-heading"> Request Custom Artwork </h2>
                        <p class="lead">Can't seem to find what you're looking for? Customers can request for an image by placing a description, set a bid, and wait for the perfect photo of your own request. </p>
                    </div>
                    <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                        <img class="img-responsive" src="images/sc3.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>


        <br>


        <div class="content-section-b">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
                        <hr class="section-heading-spacer">
                        <div class="clearfix"></div>
                        <h2 class="section-heading">For Artists</h2>
                        <p class="lead">Our system puts the artist first allowing an easy upload of their images and videos allowing the artist to put in the time for what is more important, the art. </p>
                        
                    </div>
                    <div class="col-lg-5 col-sm-pull-6  col-sm-6">
                        <img class="img-responsive" src="images/sc2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>


        <br>


        <div class="content-section-c">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-sm-6">
                        <hr class="section-heading-spacer">
                        <div class="clearfix"></div>
                       <h2 class="section-heading">And Customers</h2>
                        <p class="lead">Buyers interested in any artwork could purchase right from their search from our hassle free purchasing system. Look for any image and find what you need today!</p>
                    </div>
                    <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                        <img class="img-responsive" src="images/sc1.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

<style type="text/css">

</style>
    <!-- PRICING SECTION -->
<section id="portfolio" class="bg-white">
    <div class="row white">
        <div class="row">
            <div class="col-lg-12 text-center" id="featured_head">
                <h2 class="section-heading">Licenses Options</h2>
                <h3 class="section-subheading text-muted">Purchase/Sell from three license types!</h3>
            </div>
        </div>
        <div class="block">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <ul class="pricing p-green" style="
                                           ">
                    <li>
                        <i class="fa fa-camera-retro fa-3x"></i>
                        <big>Unlimited</big>
                    </li>
                    <li>Artwork licensed under an Unlimited license can be used in print form and in the Internet (World Wide Web).</li>

                    <li>
                        <button data-toggle="modal" data-target="#myModal3">Join Now</button>
                    </li>
                </ul>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4" style="
                                                      ">
                <ul class="pricing p-yel">
                    <li>
                        <i class="fa fa-camera-retro fa-3x"></i>
                        <big>Web</big>
                    </li>
                    <li>Web license can only be used in the Internet (World Wide Web). It may not be used in print form</li>

                    <li>
                        <button data-toggle="modal" data-target="#myModal3">Join Now</button>
                    </li>
                </ul>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">
                <ul class="pricing p-red">
                    <li>
                        <i class="fa fa-camera-retro fa-3x"></i>
                        <big>Print</big>
                    </li>
                    <li>Print license can only be used in the print form. It may not be used in electronic form, such as on the Internet (World Wide Web)</li>
                    <li>
                      <button data-toggle="modal" data-target="#myModal3">Join Now</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    </section>


<!-- THE TEAM SECTION -->
<section id="team">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center" id="team_header">
                <h2 class="section-heading">The 4Uimg Team</h2>
                <h3 class="section-subheading text-muted">The team dedicated to greatness, for you.</h3>
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="images/original/1.jpg" class="img-responsive img-circle" alt="">
                        <h4>David Hoff</h4>
                        <p class="text-muted">Developer</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="images/original/4.jpg" class="img-responsive img-circle" alt="">
                        <h4>Daniel Roberts</h4>
                        <p class="text-muted">Developer</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="images/original/3.jpg" class="img-responsive img-circle" alt="">
                        <h4>Dolly Ramos</h4>
                        <p class="text-muted">Developer</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="images/original/1.jpg" class="img-responsive img-circle" alt="">
                        <h4>Kenneth Shen</h4>
                        <p class="text-muted">Developer</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="images/original/4.jpg" class="img-responsive img-circle" alt="">
                        <h4>Xinya Li</h4>
                        <p class="text-muted">Developer</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="images/original/3.jpg" class="img-responsive img-circle" alt="">
                        <h4>Jonathan Raxa</h4>
                        <p class="text-muted">Developer</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <p class="large text-muted">The 4Uimg team is dedicated to no less than the best to give you the most efficient and pleasant user experience!</p>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- FOOTER INCLUDED IN ALL PAGES -->
    <?php include 'includes/footer_index.php' ?>


    <!-- DETAILS MODAL FOR EACH FEATURED IMAGE -->
    <?php 

            foreach ($results as $featured) {

                $title = preg_replace('/\s+/', '', $featured->getTitle());
                $artist = $featured->getArtistUsername();
                $unlimited = $featured->getUnlimitedPrice();
                $web = $featured->getWebPrice();
                $print = $featured->getPrintPrice();
                $description = $featured->getDescription();
                $id = $featured->getID();
                $extension = $featured->getExtension();

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
                                echo "    <img class=\"img-responsive\" id=\"image\" src=\"" . thumbnail('images/original/' . $id . "." . $extension, 500, 400) . "\">\n";
                echo "                    </div>\n";
                echo "                    <div class=\"col-md-6\">\n";
                echo "                        <div class=\"image_data\">\n";
                echo "                            <h2 id='title-$id'>Title: " . $featured->getTitle() . " </h2>\n";
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
                </form>";


              if ($user != null) {
                echo "<p>\n";   
                echo "  <button data-target=\"#confirm_purchase" . $title . "\" role=\"button\" class=\"btn btn-primary\" id=\"purchase" . $id . "\" data-toggle=\"modal\" style=\"\n";
                echo "                                                                                                                                               width: 100%;\n";
                echo "                                                                                                                                               height: 13%;\n";
                echo "                                                                                                                                               font-size: 25px;\n";
                echo "                                                                                                                                               \" onclick=\"submitPurchase($id)\" disabled>Purchase Image</button>";
                echo "  </p>";
              } 

              else {
                echo "<p>\n";   
                echo "  <button data-target=\"#guest_purchase" . $title . "\" role=\"button\" class=\"btn btn-primary\" id=\"purchase" . $id . "\" data-toggle=\"modal\" style=\"\n";
                echo "                                                                                                                                               width: 100%;\n";
                echo "                                                                                                                                               height: 13%;\n";
                echo "                                                                                                                                               font-size: 25px;\n";
                echo "                                                                                                                                               \" disabled>Purchase Image</button>";
                echo "  </p>";

              }



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
    foreach ($results as $featured) {

                $title = preg_replace('/\s+/', '', $featured->getTitle());
                $artist = $featured->getArtistUsername();
                $unlimited = $featured->getUnlimitedPrice();
                $web = $featured->getWebPrice();
                $print = $featured->getPrintPrice();
                $description = $featured->getDescription();
                $id = $featured->getID();
                $extension = $featured->getExtension();

                echo "<div class=\"modal\" id=\"confirm_purchase" . $title . "\">\n";
                echo "    <div class=\"modal-dialog\">\n";
                echo "        <div class=\"modal-content\">\n";
                echo "\n";
                echo "            <div class=\"modal-body\">\n";
                echo "            <button type=\"button\" class=\"close confirm_close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">X</span></button>\n";
                echo "                <p><strong>Purchased:</strong> " . $title . "\n";
                echo "                <br>    \n";
                echo "                <strong>ID: </strong> " . $id . "\n";
                echo "                <br>    \n";
                echo "                <strong>License Type: </strong><span id='license-type-$id'></span></p>\n";
                echo "        
                <hr>
                <br>
                <p>Thank you for purchasing this artwork.
                <br>The invoice has been sent and the artwork has now been added to your account.

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
      
    ?>


    <!-- GUEST PURCHASE -->
    <?php include "includes/guest_purchase.php" ?>

    <!-- MODAL FOR TERMS AND CONDITIONS -->
    <?php include "includes/terms_and_conditions.php" ?>

    <!-- MODAL FOR PRIVACY POLICY -->
    <?php include 'includes/privacy_policy.php' ?>

    <!-- MODALS FOR MORE INFORMATION ON PRICING -->
    <?php include 'includes/more_info.php' ?>

    <!-- DISPLAYS THE SPECIFIC IMAGE LICENSES -->
    <?php include 'includes/license_types.php' ?>

    <!-- BOOTSTRAP JS/CSS -->
    <?php include 'includes/includes_bottom.php' ?>
    
    <!-- Modal for New Custom Artwork Request -->
    <?php include 'includes/custom_artwork_form.php';?>

    <?php include 'includes/instructions.php'?>

    <script type="text/javascript">

        $(".confirm_close").click(function(){
          $('.modal').modal('hide');
        });

    </script>


</body>
</html>


                         

