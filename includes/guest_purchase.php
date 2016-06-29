<style type="text/css">
    
    p{
        font-size: 17px;
    }
</style>
<!-- MODAL THAT CONFIRMS USER PURCHASING OF ARTWORK -->

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
    
                echo "<div class=\"modal confirm_close\" id=\"guest_purchase" . $title . "\">\n";
                echo "    <div class=\"modal-dialog\">\n";
                echo "        <div class=\"modal-content\">\n";
                echo "\n";
                echo "        <div class=\"modal-header\">\n";
                echo "\n";
                echo "        <span style=\"\n";
                echo "    font-size: 20px;\n";
                echo "    font-weight: bold;\n";
                echo "\">Title: " . $images->getTitle() . "</span>\n";
                echo "                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">X</span></button>\n";
                echo "\n";
                echo "\n";
                echo "        </div>\n";
                echo "\n";
                echo "            <div class=\"modal-body\">\n";
                echo "                   \n";
                echo "\n";
                echo "                    <p>\n";
                echo "                     Thank you for your interest, to purchase this image: <br>\n";
                echo "                     Please <strong>Register/Login</strong> or call <strong>1-800-ARTWORKNOW</strong>.\n";
                echo "                    </p>\n";
                echo "                    \n";
                echo "            </div>\n";
                echo "\n";
                echo "        <div class=\"modal-footer\">\n";
                echo "            <div class=\"row\">\n";
                echo "              <div class=\"col-md-6\">\n";
                echo "                <button type=\"button\" class=\"btn btn-default cancel\" data-dismiss=\"modal\" style=\"margin-left: 12px;\">Cancel</button>\n";
                echo "              </div>\n";
                echo "              <div class=\"col-md-6\">\n";
                echo "                <button type=\"button\"  data-toggle=\"modal\" data-dismiss=\"modal\" data-target=\"#myModal3\" class=\"btn btn-primary\">Register/Login</button>\n";
                echo "              </div>\n";
                echo "            </div>\n";
                echo "        </div>\n";
                echo "        </div>\n";
                echo "    </div>\n";
                echo "</div>\n";
              
                      }
            }

?>




