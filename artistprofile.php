        
<!-- Creating a login object for profiles-->        
<?php

    require 'db/credentials.php';

    include 'search.php';

    include 'models/login.php';

    include 'models/media.php';

    include 'thumbnail.php';

$connection = new mysqli($MYSQL_CREDENTIALS["host"], $MYSQL_CREDENTIALS["username"], $MYSQL_CREDENTIALS["password"], $MYSQL_CREDENTIALS["database"]);

$user = Login::current($connection);

    if ($user != null)
        {
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $email = $user->getUsername();
        }
      else
        {
        header("Location: login_required.php?redirect=" . urlencode($_SERVER["REQUEST_URI"]));
        exit();
        }
?>


<html>
    <!-- ARTIST PROFILE PAGE -->
    <head>
        <title>Artist Profile</title>

        <!-- BOOTSTRAP JS/CSS -->
        <?php include 'includes/includes_head.php' ?>

        <!-- CUSTOM CSS -->
        <style type="text/css">
          
            header {
                width: 100%;
                height: 200px;
            }
            h1, h2{
                text-align: center;
            }
            button.confirm {
                float: right;
            }
            h4{
                text-transform: none;
            }
            .modal-body.confirm:after {
                content: ' ';
                display: block;
                clear: both;
            }
            input[type=number]{ width: 80px;}
            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
                -webkit-appearance: none; 
                 margin: 0; 
            }
            button{
                background-color: #fed136;
            }
            .button{
                background-color: #fed136;
            }
            #artworkPricePrint, #artworkPriceWeb, #artworkPriceUnli{
                font-size: 20px; 
                padding-left: 5px;
                padding-right: 10px;
                
            }
            .error {
                background: red;
            }
            .success {
                background: green;
            }
           
        </style>
    </head>

<body>

    <!-- HEADER NAVIGATION -->
    <?php

include 'includes/header.php' ?>
<br />
<br />
<br />
<br />

<div class="container">
        <h1>Artist Profile</h1>
        <hr>
        <br />

        <?php

function postFieldSet($name)
    {
    return isset($_POST[$name]) && $_POST[$name];
    }
$currentPassErr = $newPassErr = $passError = "";
if (isset($_POST["saveChanges"]))
    {
    
    $success = true;
    $userChanged = false;

    if (isset($_POST['userFirstName']))
        {
        $newFirstName = $_POST['userFirstName'];
        $userChanged|= $user->setFirstName($newFirstName);
        }
    if (isset($_POST['userLastName']))
        {
        $newLastName = $_POST['userLastName'];
        $userChanged|= $user->setLastName($newLastName);
        }
    if (isset($_POST['userEmail']))
        {
        $newEmail = $_POST['userEmail'];
        $userChanged|= $user->setEmail($newEmail);
        }
    $pwSet = postFieldSet('userCurrentPassword') + postFieldSet('userNewPassword') + postFieldSet('userConfirmPassword');
    if ($pwSet == 3)
        {
        $userCurrentPassword = $_POST['userCurrentPassword'];
        $userNewPassword = $_POST['userNewPassword'];
        $userConfirmPassword = $_POST['userConfirmPassword'];
        // FIXME: gross
        if ($userNewPassword == $userConfirmPassword)
            {
            if ($user->changePassword($connection, $userCurrentPassword, $userNewPassword))
                {
                $passError = ""; // XXX: redundant...
                }
              else
                {
                $passError = "Failed to change password, did you enter your current password correctly?";
                }
            }
          else
            {
            $passError = "Password and confirm password do not match";
            }
        }
      else if ($pwSet != 0)
        {
        // FIXME: better error
        $passError = "Please provide current password and repeat new password twice";
        }
    if ($userChanged)
        {
        $update_success = $user->update($connection);
        }
      else
        {
        $update_success = true;
        }
    if (($passError == "") && $update_success)
        {
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
        <?php
        }
      else
        { ?>
        <div class="modal fade in" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="saveSuccess">
                            <p style="font-size: large">There was an error applying your changes</p>
                            <p><?php
        if ($passError != "")
            {
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
                            <input class="form-control userSettings"  id="userFirstName" name="userFirstName" style="width:310px" type="text" disabled="disabled" value="<?php
echo $user->getFirstName(); ?>" >
                            <button class="btn btn-default editFirstNameBtn" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
                        </div>

                        <div class="form-group">
                            <br /><label style="padding-right: 50px">Last Name:</label>
                            <input class="form-control userSettings" id="userLastName" name="userLastName"style="width:310px" type="text" disabled="disabled" value="<?php
echo $user->getLastName(); ?>">
                            <button class="btn btn-default editLastNameBtn" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
                        </div>

                        <div class="form-group">
                            <br /><label style="padding-right: 25px"> Email address:</label>
                            <input class="form-control userSettings" id="userEmail"  name="userEmail" style="width: 310px" type="text" disabled="true" value="<?php
echo $user->getEmail(); ?>">
                            <button class="btn btn-default editEmailBtn" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
                        </div>
                       <br />
                       <br />
                       <div class="text-center"> 
                        <button id="editPassword" class="btn btn-default button" name = "editPassword" type="button"> Edit Password </button>
                    </div>
                    <div class="form-group" id="userPassword" style="visibility: hidden">
                        
                        <label class="control-label col-md-3" style="text-align: left;" id="userCurrentPassLabel">Enter Current Password:</label> 
                        <input class="form-control userSettings" id="userCurrentPassword"  name="userCurrentPassword" style="width: 330px" type="password" placeholder="Type in current password"> 
                        <br /><br />
                        <label class="control-label col-md-3" style="text-align: left;" id="userNewPassLabel">Enter New Password:</label>
                        <input class="form-control userSettings" id="userNewPassword"  name="userNewPassword" style="width: 330px" type="password" placeholder="Enter new password">
                        <br /><br /><label class="control-label col-md-3" style="text-align: left;" id="userConfirmPassLabel" >Confirm New Password:</label> <span class="error"> 
                        <input class="form-control userSettings" id="userConfirmPassword"  name="userConfirmPassword" style="width: 330px" type="password"  placeholder="Re-enter new password">
                    </div>
                    <div class="text-center">
                       <input id="saveBtn" class="btn btn-default button" type="submit" name="saveChanges"  hidden="hidden" value="SAVE CHANGES" data-toggle="" data-target=""> 
                    </div>
                 </form>
            </div>
            
          <!-- Image upload handler -->  
          <?php
if (isset($_POST["upload"]) && isset($_FILES["image"]))
    {
    $upload = $_FILES["image"];
    $preview = null;
    if (isset($_FILES['preview_image']) && isset($_FILES['preview_image']['tmp_name']) && $_FILES['preview_image']['tmp_name'] != "")
        {
        $media = Media::uploadVideo($connection, $upload, $_FILES['preview_image'], $_POST["title"], $_POST["unlimited_price"], $_POST["web_price"], $_POST["print_price"], $_POST["description"]);
        }
      else
        {
        $media = Media::uploadImage($connection, $upload, $_POST["title"], $_POST["unlimited_price"], $_POST["web_price"], $_POST["print_price"], $_POST["description"]);
        }
    if ($media != null)
        {
?>
           
        <div class="modal fade in" id="uploadSuccessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                            <p style="font-size: large">Successfully uploaded media</p>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" onclick="$('#uploadSuccessModal').modal('hide');">OK</button>
                    </div>
                </div>
            </div>
        </div>
          <?php
        }
      else
        {
?>
        <div class="modal fade in" id="uploadErrorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p style="font-size: large">Failed to upload media</p>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" onclick="$('#uploadErrorModal').modal('hide');">OK</button>
                    </div>
                </div>
            </div>
        </div>
          <?php
        }
    if ($media != null && isset($_POST["keywords"]))
        {
        $keywords = explode(" ", $_POST["keywords"]);
        $media->setKeywords($connection, $keywords);
        }
    }
?>
         
        <!-- NEW IMAGE UPLOADING AREA -->    
            <div class="col-md-5">  
                <form method="post" enctype="multipart/form-data">                                         
                    <h4>Select artwork to upload:</h4>                                        
                    <input type="file" name="image" id="image" required="required">
                    <h4 id="preview_image_label">Select video preview image:</h4>                                        
                    <input type="file" name="preview_image" id="preview_image">
                  
                    <h5>Enter Title:</h5>

                    <input class="form-control" type="text" size="40" name="title" placeholder=" 40 char max" style="width: 47%;" required="required">

                    <h5>Enter Description:</h5>

                    <textarea class="form-control" rows="2" style="width: 400px; padding: 2px;" cols="50" name="description" placeholder="Type in description" required="required"></textarea>
                    <br />
                    <h5>Enter search keywords separated by spaces:</h5>

<!-- TODO -->
                    <textarea class="form-control" rows="2" style="width: 400px; padding: 2px; margin-bottom: 10px;" cols="40" name="keywords" placeholder="" required="required"></textarea>
                    <br />
                    <h5>License types</h5>
                    <div>
                        <label  for="printu">Unlimited: </label>
                        <input type="number" min="0" max="10000" name="unlimited_price" id="printu" placeholder="$0.00" > 
                        <label for="printw" style="padding-left: 5px">Web: </label>
                        <input type="number" min="0" max="10000" name="web_price" id="printw" placeholder="$0.00" >
                        <label for="pricep" style="padding-left: 5px">Print:</label>
                        <input type="number" min="0" max="10000" name="print_price" id="pricep" placeholder="$0.00" >
                    </div>
                    <br />
                    <div class="text-center">
                        <input  type="submit" id="uploadBtn" class="btn btn-default" name="upload" style="width: 100px" value="Upload">
                    </div>
                </form>
            </div>
            
        </div>

        <!-- script to run when Upload button is clicked -->
       
            
            
            
        <hr>
         <br />
         <h1 class='text-center'> Portfolio </h1>
         
          
    <!-- DISPLAY OF UPLOADED IMAGES -->
    <?php
        $uploads = $user->getUploads($connection);
        for ($i = count($uploads) - 1; $i >= 0; $i-= 1)
            {
            $upload = $uploads[$i];
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="modal-body">
                <div class="col-md-6">
                    <img src="<?php
                        $display = $upload->getDisplayImage($connection);
                        echo thumbnail('images/original/' . $display->getID() . '.' . $display->getExtension() , 500, 400);
                    ?>" class="img-responsive">
                </div>

                <div class="col-md-6">
                    <h2 class="<?php
                    echo "class" . $i; ?>" id="<?php
                    echo "artworkTitle" . $i; ?>" name="artworkTitle" contenteditable="false">
                <?php
                    echo $upload->getTitle(); ?></h2>
                    <p>
                        <strong>Description:</strong>
                        <span  class="<?php
                        echo "class" . $i; ?>"  id="<?php
                        echo "artworkDescription" . $i; ?>" name="artworkDescription" contenteditable="false">
                <?php
                    echo $upload->getDescription(); ?> </span> 
                    </p>
                    <p>    
                    <strong> Search Keywords:</strong>
                        <span class="<?php
                            echo "class" . $i; ?>"  id="<?php
                            echo "artworkTags" . $i; ?>" name="artworkTags" contenteditable="false">
                    <?php
                        foreach($upload->getKeywords($connection) as $keyword)
                    {
                        echo $keyword . " ";
                    }
                    ?>
                        </span> 
                    </p>
                <p>
                    <strong> License Types and Prices: </strong>
                <br />
                &bull;Print: <span class="<?php
                echo "class" . $i; ?>"  id="<?php
                echo "artworkPricePrint" . $i; ?>" name="artworkPricePrint" contenteditable="false">
                <?php
                    echo $upload->getPrintPrice(); 
                ?> 
                </span> 
                &bull;Web: <span class="<?php
                    echo "class" . $i; ?>"  id="<?php
                    echo "artworkPriceWeb" . $i; ?>" name="artworkPriceWeb" contenteditable="false">
                <?php
                    echo $upload->getWebPrice(); ?> </span>
                    &bull;Unlimited: <span class="<?php
                    echo "class" . $i; ?>"  id="<?php
                    echo "artworkPriceUnli" . $i; ?>" name="artworkPriceUnli" contenteditable="false">
                <?php
                    echo $upload->getUnlimitedPrice(); ?> </span>
                </h4>   
                </p>
                <h5 style='font-style: italic; color: red; text-align: center;' id="<?php
                echo "instruction" . $i; ?>" hidden='hidden'> Click on any fields to edit.</h5>
                <div class="text-center">
                <a href="edit_media.php?id=<?php
                echo $upload->getID(); ?>" id="editArtworkDetailsBtn" class="button btn btn-primary" >Edit Artwork Details</a>
                </div> 
                </div>
            </div>
        </div>
    </div>
                
            
        <?php
    } ?>
       
 <!-- Script when artist edits the details about his artwork -->
            <script type="text/javascript">
                
                function editScript(editBtn, i){
                    // if editBtn is labeled for Edititng
                    if($(editBtn).val()== "Edit Artwork Details"){
                        editDetails(editBtn, i);   
                    }
                    // if editBtn is labeled for saving changes
                      else if($(editBtn).val()== "Save Changes"){
                        saveChanges(editBtn, i);
                    }
                }
                
                function editDetails(editBtn, i){
                    $(editBtn).val('Save Changes');
                    var className = ".class" + i;
                    var instruction = "#instruction"+i;
                    $(instruction).removeAttr('hidden');
                    $(className).attr('contenteditable','true');
                }
                function saveChanges(editBtn, i){
                    var className = ".class" + i;
                    var newTitle = "artworkTitle"+i;
                    newTitle = document.getElementById(newTitle).innerText;
                    var newDesc = "artworkDescription"+i;
                    newDesc = document.getElementById(newDesc).innerText;
                    var newSearchWords = "artworkTags"+i;
                    newSearchWords = document.getElementById(newSearchWords).innerText;
                    var newPrint = "artworkPricePrint"+i;
                    newPrint = document.getElementById(newPrint).innerText;
                    var newWeb = "artworkPriceWeb"+i;
                    newWeb= document.getElementById(newWeb).innerText;
                    var newUnli = "artworkPriceUnli"+i;
                    newUnli = document.getElementById(newUnli).innerText;
                    $(editBtn).val('To be implemented'); 
                    $(className).attr('contenteditable','false');
                }
            </script>
            
    
 <div class="modal fade modal-sm" id="uploadModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none; margin-left: auto; margin-right: auto; margin-top: 15%;">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl"></div>
                </div>
            </div>
            <div class="modal-body confirm">
                <p>Your image has been uploaded and added to your portfolio.</p>
                
                <button type="button" class="btn btn-primary confirm" id="close" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>

</div>

 <br />
 <br />

   <!-- FOOTER INCLUDED IN ALL THE FILES -->
    <?php
include 'includes/footer.php' ?>

    <!-- BOOTSTRAP JS/CSS -->
    <?php

include 'includes/includes_bottom.php' ?>
    
    <!-- Script run when user clicks on edit button -->
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
           
        $('#saveModal').modal('show');
        $('#errorModal').modal('show');
        $('#uploadSuccessModal').modal('show');
        $('#uploadErrorModal').modal('show');
        $("#preview_image_label").hide();

        $("#preview_image").hide();
        var videoExtensions = [".mp4", ".mpg", ".mkv", ".flv", ".avi", ".webm", ".ogv", ".ogg", ".mov"];
        $("#image").change(function (ev) {
            for (var i = 0; i < videoExtensions.length; i++) {
                if (this.value.endsWith(videoExtensions[i])) {
                    $("#preview_image").show();
                    $("#preview_image_label").show();
                    return;
                }
            } 
            $("#preview_image").hide();
            $("#preview_image_label").hide();
            $("#preview_image").value("");
        });
    </script>

</body>
</html>