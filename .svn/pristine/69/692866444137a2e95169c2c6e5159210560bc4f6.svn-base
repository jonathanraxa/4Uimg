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
<html>
    <head>
        <title>Custom Artwork Requests List</title> 

        <!-- BOOTSTRAP JS/CSS -->
        <?php include 'includes/includes_head.php' ?>

        <!-- CUSTOM CSS -->
        <style id="style-1-cropbar-clipper">

            .en-markup-crop-options {
                top: 18px !important;
                left: 50% !important;
                margin-left: -100px !important;
                width: 200px !important;
                border: 2px rgba(255,255,255,.38) solid !important;
                border-radius: 4px !important;
            }
            .btn:hover{
                background-color: #FED136;
            }
            .navbar-right {
                background-color: #FFA500;
            }
            td {
                padding-bottom: 20px;
            }
            th{
                padding-bottom: 20px;
                font-size: 20px;
                color: #FFA500;
            }
            .foot {
                background-color: black;
                opacity: 50%;
                bottom: 0;
                position: relative;
                width: 100%;
            }
            a#email {
                color: #31708f;
            }

        </style>
    </head>


    <body>

        <!-- NAVIGATION PANEL -->
        <?php
        require 'models/media.php';

        $conn = new mysqli($MYSQL_CREDENTIALS["host"], $MYSQL_CREDENTIALS["username"], $MYSQL_CREDENTIALS["password"], $MYSQL_CREDENTIALS["database"]);
        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        }

        $login = Login::current($conn);
        

        ?>

        <?php include 'includes/header.php'; ?>


        <br />
        <br />
        <br />
        <br />

        <!-- TABLE OF ALL ARTWORK REQUESTED -->
        <div class="container" align="center">
            <div class="row">
                <div class="col-lg-12">
                    <div class="modal-body">
                        <h2 style="padding-bottom: 20px">Custom Artwork Requests</h2>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>License Type</th>
                                    <th>Customer</th>
                                    <th>Min Price</th>
                                    <th>Max Price</th>
                                    <th></th>
                                </tr>
                            </thead>


                            <tbody>
                                <?php
                                include_once 'db/credentials.php';
                                include_once 'models/bounty.php';

                                include_once 'db/credentials.php';
                                include_once 'models/bounty.php';


                                $conn = new mysqli($MYSQL_CREDENTIALS["host"], $MYSQL_CREDENTIALS["username"], $MYSQL_CREDENTIALS["password"], $MYSQL_CREDENTIALS["database"]);
                                if ($conn->connect_error) {
                                    die("Connection Failed: " . $conn->connect_error);
                                }

                                foreach (Bounty::getBounties($conn) as $bounty) {
                                    echo "<div class = \"modal fade\" id=\"mymodal" . $bounty->getID() . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"ModalLabel1\">";
                                    echo "<div class=\"modal-dialog\" role=\"document\">";
                                    echo "<div class=\"modal-content\">";
                                    echo "<div class=\"modal-body\">";
                                    echo "<div id=\"saveSuccess\">";
//                                    echo "<p style=\"font-size: large\"> Thank you for your interest! </p>";
                                    echo "<h2>Thank you for your interest! </h2>";
                                    $customer = $bounty->getCustomer($conn);
                                    if ($user) {
                                        echo " <p style=\"font-size: large\"> Please contact " . $customer->getFirstName() . " " . $customer->getLastName() . " <br> 

                                        Email: <a href=\"mailto:" . $customer->getEmail() . "?Subject=Request%20Accepted%20by%20:%20" . $user->getUsername() . "\">" . $customer->getEmail() . "</a></p>";

                                    } else {
                                        echo " <p style=\"font-size: large\"> Please contact " . $customer->getFirstName() . " " . $customer->getLastName() . " <br> 

                                        Email: <a href=\"mailto:" . $customer->getEmail() . "?Subject=Request%20Accepted%20by%20:%20Guest%20User\">" . $customer->getEmail() . "</a></p>";
                                    }


                                    echo "</div>";
                                    echo "</div>";
                                    echo "<div class='modal-footer'>
                                    <div class=\"text-right\">";
                                    echo "<button type=\"button\" class=\"btn btn-lg btn-primary\" data-dismiss=\"modal\" style=\"
                                        border-radius: 0;
                                        color: rgba(51, 51, 51, 0.88);
                                        \">Got it!</button>";
                                    echo "</div>";
                                    echo "</div>";

                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo"<tr>";
                                    echo"<td>" . $bounty->getTitle() . "</td>";
                                    echo"<td style=\"padding-left 10px; padding-right 10px; \">" . $bounty->getDescription() . "</td>";
                                    echo"<td style=\"padding-left 10px; padding-right 10px; \">" . $bounty->getLicenseType() . "</td>";
                                    echo"<td style=\"padding-left 10px; padding-right 10px; \">" . $bounty->getCustomerUsername() . "</td>";
                                    echo"<td style=\"padding-left 10px; padding-right 10px; \">$" . $bounty->getPricelow() . "</td>";

                                    echo"<td style=\"padding-left 10px; padding-right 10px; \">$" . $bounty->getPricehigh() . "</td>";
                                    echo"<td>";

                                    echo"<button type=\"button\" class=\"btn btn-default\" id = \"detail1\" data-toggle= \"modal\" data-target = \"#mymodal" . $bounty->getID() . "\" style=\"background-color: #fed136;\">View Contact Details</button></td>";
                                    echo"</tr>";
                                }
                                ?>
                            </tbody>

                        </table>

                        <!-- Adding new custom request -->
                        <br><button type="button" class="btn btn-default" id="addNewReq" data-toggle='modal' data-target='#bountyForm' style="background-color: #fed136;"><h4>Add New Custom Request</h4></button>
                    </div>
                </div>
            </div>
        </div>


        <br>
        <br>

    

        <!-- Modal for New Custom Artwork Request -->
        <?php include 'includes/custom_artwork_form.php' ?>

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <script src="js/classie.js"></script>
        <script src="js/cbpAnimatedHeader.js"></script>

        <!-- Contact Form JavaScript -->
        <script src="js/jqBootstrapValidation.js"></script>
        <script src="js/contact_me.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/agency.js"></script>

        <!-- BOTTOM FOOTER INCLUDED IN ALL PAGES -->
        <?php include 'includes/footer.php' ?>
    </body>
</html>
