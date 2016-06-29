 
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
                                    <input type="text" class="form-control inputBox" id="name" placeholder="Search here..." name="name" value="">
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

                require 'db/credentials.php';
                require 'search.php';
                require 'thumbnail.php';

                function get_keywords() {
                    if (isset($_POST["name"])) {
                        return $_POST["name"];
                    } else {
                        return "";
                    }
                }

                $keywords = explode(" ", get_keywords());

                $search = false;
                $search2 = false;
                $search3 = false; 

                if (count($keywords) > 0 && $keywords[0] != "") {
                    $connection = new mysqli($MYSQL_CREDENTIALS["host"],
                    $MYSQL_CREDENTIALS["username"],
                    $MYSQL_CREDENTIALS["password"],
                    $MYSQL_CREDENTIALS["database"]);

                    $search = new ImageSearch();
                    $search2 = new ImageSearch();
                    $search3 = new ImageSearch();

                foreach ($keywords as $keyword) {
                    $search->addCriteria(keywordClause($keyword));
                    $search2->addCriteria(keywordClause($keyword));
                    $search3->addCriteria(keywordClause($keyword));

                    }   
                }
            }
        ?>

        <!-- DISPLAYS TOTAL RESULTS RETURNED-->
        <?php

            if(!(isset($search3)))
            {

                echo "<div class=\"text-center\"><span class=\"results_total\"><strong>Results Total: 0</strong></span></div>";

            }
            else if ($search3) {

                $statement = $search3->prepare($connection);
                $statement->execute();
                $result3 = new ResultSet($statement);
                $total = 0;

                while ($row = $result3->fetch_assoc()) {$total++;}

                echo "<div class=\"text-center\"><span class=\"results_total\"><strong>Results Total:</strong>&nbsp;" . $total . "</span></div>";
            }     

        ?>

                <br>
                

        <div class="row">

        <!-- PANEL DISPLAY MODAL FOR SEARCHED IAMGES-->
        <?php

            if (!(isset($search))) {

                echo "<h2><i>Type in a keyword above to search for images</i></h2>";

            } else if ($search) {

                $statement = $search->prepare($connection);
                $statement->execute();

                // We can't use $statement->get_result() because this server doesn't
                // use the right mysql driver :-(
                $result = new ResultSet($statement);    

                while ($row = $result->fetch_assoc()) {

                $title       = preg_replace('/\s+/', '', $row["title"]);
                $artist      = $row["uploader"];
                $unlimited   = $row["unlimited_price"];
                $web         = $row["web_price"];
                $print       = $row["print_price"];
                $description = $row["description"];
                $id          = $row["id"];

                echo "<div class=\"col-md-4 col-sm-6 portfolio-item\">
                <a href=\"#portfolioModal" . $title . "\" class=\"portfolio-link\" data-toggle=\"modal\"><div class=\"portfolio-hover\">
                <div class=\"portfolio-hover-content\">
                <i class=\"fa fa-camera-retro fa-3x\"> View Details</i></div></div><img src=\"" . thumbnail('images/original/' . $id . '.jpg', 360, 270) . "\" class=\"img-responsive\"></a><div class=\"portfolio-caption\">
<a href=\"#\" data-target=\"#guest_purchase\"role=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" style=\"border-color: #C3B78D;\">Purchase</a>

                <h3><a href=\"#portfolioModal" . $title . "\" data-toggle=\"modal\" style=\"color: #31310B;\">" . $title . "</a></h3>\n";

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
            if (!(isset($search2))) {
                // SHOW NOTHING!

            } else if ($search2) {

                $statement = $search2->prepare($connection);
                $statement->execute();

                // We can't use $statement->get_result() because this server doesn't
                // use the right mysql driver :-(
                $result2 = new ResultSet($statement);

            while ($row = $result2->fetch_assoc()) {

                $title       = preg_replace('/\s+/', '', $row["title"]);
                $artist      = $row["uploader"];
                $unlimited   = $row["unlimited_price"];
                $web         = $row["web_price"];
                $print       = $row["print_price"];
                $description = $row["description"];
                $id          = $row["id"];

echo " <div class=\"modal fade\" id=\"portfolioModal" . $title . "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"largeModal\" aria-hidden=\"true\">\n";
echo "    <div class=\"modal-dialog modal-lg\">\n";
echo "        <div class=\"modal-content\">\n";
echo "\n";
echo "\n";
echo "            <div class=\"modal-header\">\n";
 echo "  <div class=\"close-modal\" data-dismiss=\"modal\">\n";
                echo "    <div class=\"lr\">\n";
                echo "      <div class=\"rl\">\n";
                echo "      </div>\n";
                echo "    </div>\n";
                echo "  </div>                \n";
echo "                <h2 class=\"modal-title text-center\" id=\"myModalLabel\">Artwork Details</h2>\n";
echo "            </div>\n";
echo "\n";
echo "\n";
echo "            <div class=\"modal-body\">\n";
echo "                <div class=\"col-lg-12\">\n";
echo "                    <br><br>\n";
echo "                    <div class=\"col-md-6\">\n";
                echo "    <img class=\"img-responsive\" id=\"image\" src=\"" . thumbnail('images/original/' . $row["id"] . "." . $row["extension"], 500, 400) . "\">\n";
echo "                    </div>\n";
echo "                    <div class=\"col-md-6\">\n";
echo "                        <div class=\"image_data\">\n";
echo "                            <h2>Title: " . $title . " </h2>\n";
echo "                            <p>\n";
echo "                                <strong>ID:</strong> <span class=\"text-muted\" style=\"font-size:20px;\">" . $id . "</span><br>\n";
echo "                                <strong>Description:</strong> <span class=\"text-muted\" style=\"font-size:20px;\">" . $description . "</span><br>\n";
echo "                                <strong>Artist:</strong> <span class=\"text-muted\" style=\"font-size:20px;\">" . $artist . "</span><br><br>\n";
echo "                            </p>\n";
echo "                            <div class=\"radio\">\n";
echo "                                <h4>Pricing options\n";
echo "                        <span id=\"whats_this\">\n";
echo "                            <a href=\"\" data-toggle=\"modal\" data-target=\"#license_types\">what's this?</a>\n";
echo "                        </span>\n";
echo "                        <br>\n";
echo "                    </h4>\n";
echo "\n";
echo "                                <label>\n";
echo "                        <input type=\"radio\" name=\"identity\">\n";
echo "                        <span class=\"text-muted\" style=\"font-size:17px;\">\n";
echo "                            <strong>Unlimited:</strong>\n";
echo "                        </span>\n";
echo "                    </label>\n";
echo "\n";
echo "                                <label>\n";
echo "                        <input type=\"radio\" name=\"identity\">\n";
echo "                        <span class=\"text-muted\" style=\"font-size:17px;\">\n";
echo "                            <strong>Web:</strong>\n";
echo "                        </span>\n";
echo "                    </label>\n";
echo "\n";
echo "                                <label>\n";
echo "                        <input type=\"radio\" name=\"identity\">\n";
echo "                        <span class=\"text-muted\" style=\"font-size:17px;\">\n";
echo "                            <strong>Print:</strong>\n";
echo "                        </span>\n";
echo "                    </label>\n";
echo "\n";
echo "                            </div>\n";
echo "                            <br>\n";
echo "                        </div>\n";
echo "                        <i>\n";
echo "                <p class=\"info\">Selecting \n";
echo "                <strong>purchase image</strong> will notifiy the seller about the purchase and a confirmation email will be sent back to you with a download link\n";
echo "                </p>\n";
echo "            </i>\n";
echo "\n";
echo "                        <p>\n";
echo "                            <a href=\"mailto:email@example.com?subject=Hello\" data-target=\"#confirm_purchase\" role=\"button\" class=\"btn btn-primary\" id=\"purchase\" data-toggle=\"modal\" style=\"\n";
echo "                width: 100%;\n";
echo "            \">Purchase Image</a> By purchasing, you agree to our\n";
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
            } else {   
                die();
            }
        ?>


    


