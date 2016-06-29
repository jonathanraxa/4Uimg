<!-- CUSTOMER PROFILE PAGE - YOU CAN ALSO DOWNLOAD PURCHASED IMAGES HERE -->
<?php
    require_once 'search.php';
    require 'models/login.php';
    require_once 'models/media.php';
    require_once 'models/purchase.php';
    require_once 'db/credentials.php';

    $connection = new mysqli($MYSQL_CREDENTIALS["host"],
                             $MYSQL_CREDENTIALS["username"],
                             $MYSQL_CREDENTIALS["password"],
                             $MYSQL_CREDENTIALS["database"]);

    $user = Login::current($connection);

    if ($user == null) {
        // FIXME: graceful
        die("Not logged in");
    }
?>
<html>
    <head>

       <title>Customers Profile</title> 
       
      <!-- JQuery -->
    <script src="http://code.jquery.com/jquery-2.2.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


    <?php include 'includes/includes_head.php' ?>

        <!-- CUSTOM CSS -->
        <style type="text/css">
            a#purchase {
                color: #fff;
                background-color: #fed136;
                border-color: #f5f5f5;
                width: 200px;
                height: 40px;
                padding-top: 9px;
            }
        </style>
    </head>


<body>

    <!-- HEADER NAVIGATION -->
    <?php include 'includes/header.php' ?>


    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>

    

    <div class="container">   

        <h1>Customer Profile&nbsp;&nbsp;&nbsp;<u><a href="#images">View Purchases</a></u></h1>
        <hr>
        <br>

        <?php
        function postFieldSet($name) {
            return isset($_POST[$name]) && $_POST[$name];
        }
        $currentPassErr = $newPassErr = $passError = "";
        if(isset($_POST["saveChanges"])){
            $success = true;
            
            $userChanged = false;
            if(isset($_POST['userFirstName'])){
                $newFirstName = $_POST['userFirstName'];
                $userChanged |= $user->setFirstName($newFirstName);
            }
            if(isset($_POST['userLastName'])){
                $newLastName = $_POST['userLastName'];
                $userChanged |= $user->setLastName($newLastName);
            }
            if(isset($_POST['userEmail'])){
                $newEmail = $_POST['userEmail'];
                $userChanged |= $user->setEmail($newEmail);
            }
            $pwSet = postFieldSet('userCurrentPassword') + postFieldSet('userNewPassword') + postFieldSet('userConfirmPassword');
            if($pwSet == 3){
                $userCurrentPassword = $_POST['userCurrentPassword'];
                $userNewPassword = $_POST['userNewPassword'];
                $userConfirmPassword = $_POST['userConfirmPassword'];

                // FIXME: gross
                if ($userNewPassword == $userConfirmPassword) {
                    if ($user->changePassword($connection, $userCurrentPassword, $userNewPassword)) {
                        $passError = ""; // XXX: redundant...
                    } else {
                        $passError = "Failed to change password, did you enter your current password correctly?";
                    }
                } else {
                    $passError = "Password and confirm password do not match";
                }
            } else if ($pwSet != 0) {
                // FIXME: better error
                $passError = "Please provide current password and repeat new password twice";
            }

            if ($userChanged) {
                $update_success = $user->update($connection);
            } else {
                $update_success = true;
            }
           if (($passError == "") && $update_success) {
        ?>
        <div class="modal fade in" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="saveSuccess">
                            <p style="font-size: large">Your changes are successfully saved.</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" onclick="$('#saveModal').modal('hide');">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="modal fade in" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="saveSuccess">
                            <p style="font-size: large">There was an error applying your changes</p>
                            <p><?php
                                if ($passError != "") {
                                    echo $passError;
                                }
                            ?></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" onclick="$('#errorModal').modal('hide');">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        }
        ?>   
        <!-- Personal Information Section -->
        <div class="row">
            <div class="col-md-6">
                   <form class="form-inline" role="form" method="post">
                       <h3> Personal Information: </h3>
                        <div class="form-group">
                            <label style="padding-right: 50px">First Name:</label>
                            <input class="form-control userSettings"  id="userFirstName" name="userFirstName" style="width:310px" type="text" disabled="disabled" value="<?php echo $user->getFirstName(); ?>" >
                            <button class="btn btn-default editFirstNameBtn" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
                        </div>

                        <div class="form-group">
                            <br><label style="padding-right: 50px">Last Name:</label>
                            <input class="form-control userSettings" id="userLastName" name="userLastName"style="width:310px" type="text" disabled="disabled" value="<?php echo $user->getLastName(); ?>">
                            <button class="btn btn-default editLastNameBtn" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
                        </div>

                        <div class="form-group">
                            <br><label style="padding-right: 25px"> Email address:</label>
                            <input class="form-control userSettings" id="userEmail"  name="userEmail" style="width: 310px" type="text" disabled="true" value="<?php echo $user->getEmail(); ?>">
                            <button class="btn btn-default editEmailBtn" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
                        </div>
                       <br>
                       <br>
                       <div class="text-center"> 
                        <button id="editPassword" class="btn btn-default button" name = "editPassword" type="button"> Edit Password </button>
                    </div>
                    <div class="form-group" id="userPassword" style="visibility: hidden">
                        
                        <label class="control-label col-md-3" style="text-align: left;" id="userCurrentPassLabel">Enter Current Password:</label> 
                        <input class="form-control userSettings" id="userCurrentPassword"  name="userCurrentPassword" style="width: 330px" type="password" placeholder="Type in current password"> 
                        <br><br>
                        <label class="control-label col-md-3" style="text-align: left;" id="userNewPassLabel">Enter New Password:</label>
                        <input class="form-control userSettings" id="userNewPassword"  name="userNewPassword" style="width: 330px" type="password" placeholder="Enter new password">
                        <br><br><label class="control-label col-md-3" style="text-align: left;" id="userConfirmPassLabel" >Confirm New Password:</label> <span class="error"> 
                        <input class="form-control userSettings" id="userConfirmPassword"  name="userConfirmPassword" style="width: 330px" type="password"  placeholder="Re-enter new password">
                    </div>
                    <div class="text-center">
                       <input id="saveBtn" class="btn btn-default button" type="submit" name="saveChanges"  hidden="hidden" value="SAVE CHANGES" data-toggle="" data-target=""> 
                    </div>
                 </form>
            </div>
        </div>
        <script type="text/javascript">
            $('#saveBtn').css('display', 'none');
            function displaySaveButton() {
                    $('#saveBtn').css('display', '');
                    $('#saveBtn').removeAttr('hidden');
            }
            function editClick(enableSelector) {
                function editClickHandler() {
                    $(this).hide();
                    if($('#saveBtn').attr('hidden')){
                        displaySaveButton();
                    }
                    if ($(enableSelector).attr('disabled')){
                        $(enableSelector).removeAttr('disabled');
                    }
                }
                return editClickHandler;
            }
            $('.editFirstNameBtn').on('click', editClick('#userFirstName'));

            $('.editLastNameBtn').on('click', editClick('#userLastName'));

            $('.editEmailBtn').on('click', editClick('#userEmail'));

            $('#editPassword').on('click', function(event) {
                $(this).hide();
                if($('#saveBtn').attr('hidden')) {
                    displaySaveButton();
                }
                document.getElementById('userPassword').style.visibility = 'visible'; 
            }); 
               
        </script>
        <hr>
        <h2 align="center">Purchase History</h2><a name="images"></a>

        <br>
        <br>


        <?php 
            require_once 'thumbnail.php';

            function write_thumbnail($media) {
                global $connection;
                $display = $media->getDisplayImage($connection);
                echo "<img src=\"" . thumbnail("images/original/" . $display->getID() . "." . $display->getExtension(), 500, 400) . "\" class='img-responsive' />";
            }

            $purchase = $user->getPurchases($connection);

            for($i = count($purchase)-1; $i>= 0; $i--){
                $media = $purchase[$i]->getMedia();
                $title = $media->getTitle();
                $artist = $media->getArtistUsername();
                $license = $purchase[$i]->getLicenseType();
                $description = $media->getDescription();
                $id = $media->getID();
                $filename = $title . "." . $media->getExtension();

                echo "<div class=\"row\">\n";
                echo "    <div class=\"col-lg-12\">\n";
                echo "        <div class=\"modal-body\">\n";
                echo "            <div class=\"col-md-6\">\n";
                write_thumbnail($media);
                echo "            </div>\n";
                echo "            <div class=\"col-md-6\">\n";
                echo "                <div class=\"image_data\">\n";
                echo "                    <h2>" . $title . "</h2>\n";
                echo "                    <p>\n";
                echo "                        <strong>Description:</strong> <span class=\"text-muted\" style=\"font-size:20px;\">" . $description . "</span>\n";
                echo "                        <br>\n";
                echo "                        <strong>Artist:</strong> <span class=\"text-muted\" style=\"font-size:20px;\">" . $artist . "</span>\n";
                echo "                        <br>\n";
                echo "                        <strong>License:</strong> <span class=\"text-muted\" style=\"font-size:20px;\">" . $license ."</span>\n";
                echo "                    </p>\n";
                echo "                </div>\n";
                echo "\n";
                // FIXME: not compatible with video
                echo "               <a href=\"images/original/" . $media->getID() . '.' . $media->getExtension() . "\" download=\"" . $filename . "\" role=\"button\" class=\"btn btn-primary profile_button\"  >Click to DOWNLOAD</a>\n";
                echo "\n";
                echo "            </div>\n";
                echo "        </div>\n";
                echo "    </div>\n";
                echo "</div>\n";
                echo "<br><br>";
            }
        ?>


    </div> 

    <!-- FOOTER INCLUDED IN ALL PAGES -->
    <?php include "includes/footer.php" ?>

   

    <?php include "includes/includes_bottom.php" ?>
    <script type="text/javascript">
        $('#saveModal').modal('show');
        $('#errorModal').modal('show');
    </script>

</body>
</html>
