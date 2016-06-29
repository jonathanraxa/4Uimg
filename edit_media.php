<!-- Creating a login object for profiles -->        
<?php
    require 'db/credentials.php';    
    include 'search.php';
    include 'models/login.php';
    include 'models/media.php'; 
   $connection = new mysqli($MYSQL_CREDENTIALS["host"],
                             $MYSQL_CREDENTIALS["username"],
                             $MYSQL_CREDENTIALS["password"],
                             $MYSQL_CREDENTIALS["database"]);
    $user = Login::current($connection);
    if ($user == null) {
        header("Location: login_required.php?redirect=" . urlencode($_POST["QUERYSTRING"]));
        exit();
    }

    $firstName = $user->getFirstName();
    $lastName = $user->getLastName();
    $email = $user->getUsername();

    if (isset($_GET['id'])) {
        $media = Media::getByID($connection, $_GET['id']);

        if ($media == null) {
            die("invalid media id");
        }
        if ($media->getArtistUsername() != $user->getUsername()) {
            die("You don't own this media!");
        }
    } else {
        die("Need media id");
    }

    if (isset($_POST['submit'])) {
        if (isset($_POST['title'])) {
            $media->setTitle($_POST['title']);
        }
        if (isset($_POST['description'])) {
            $media->setDescription($_POST['description']);
        }
        if (isset($_POST['unlimited_price'])) {
            $media->setUnlimitedPrice($_POST['unlimited_price']);
        }
        if (isset($_POST['web_price'])) {
            $media->setWebPrice($_POST['web_price']);
        }
        if (isset($_POST['print_price'])) {
            $media->setPrintPrice($_POST['print_price']);
        }

        $media->update($connection);
        // NOTE: this code is high so we can redirect
        
        if ($media != null && isset($_POST["keywords"])) {
            $keywords = explode(" ", $_POST["keywords"]);
            $media->setKeywords($connection, $keywords);
        }
        
        // XXX: hardcoded and gross
        header("Location: artistprofile.php");
        exit();
    }
?>
<html>
    <!-- ARTIST PROFILE PAGE -->
    <head>
        <title>Edit Media: <?php echo $media->getTitle(); ?></title>

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
           
        </style>
    </head>

<body id="page-top" class="index">

    <!-- HEADER NAVIGATION -->
    <?php include 'includes/header.php' ?>
<br>
<br>
<br>
<br>
    <div class="container">

        <h1 class="text-left">Edit Media: <?php echo $media->getTitle(); ?></h1>
        <hr>
            
        <!-- NEW IMAGE UPLOADING AREA -->    
            <div class="col-md-5">  
                <form method="post">
                    <h5>Title:</h5>
                    <input class="form-control" type="text" size="40" name="title" placeholder=" 40 char max" style="width: 47%;" required="required" value="<?php echo $media->getTitle(); ?>"></input>

                    <h5>Description:</h5>
                    <textarea class="form-control" rows="2" style="width: 400px; padding: 2px;" cols="50" name="description" placeholder="Type in description" required="required"><?php echo $media->getDescription(); ?></textarea>
                    
                    <br>

                    <h5>Keywords:</h5>
                <!-- FIXME -->
                    <textarea class="form-control" rows="2" style="width: 400px; padding: 2px; margin-bottom: 10px;" cols="40" name="keywords" placeholder="" required="required"><?php
                foreach ($media->getKeywords($connection) as $keyword) {
                    echo $keyword . " ";
                }
 
    ?></textarea>
                   <br>
                    <h5>License types</h5>
                    <div>
                        <label  for="printu">Unlimited: </label>
                        <input type="number" min="0" max="10000" name="unlimited_price" id="printu" placeholder="$0.00" value="<?php echo $media->getUnlimitedPrice(); ?>"></input>  

                        <label for="printw" style="padding-left: 5px">Web: </label>
                        <input type="number" min="0" max="10000" name="web_price" id="printw" placeholder="$0.00" value="<?php echo $media->getWebPrice(); ?>"></input>

                        <label for="pricep" style="padding-left: 5px">Print:</label>
                        <input type="number" min="0" max="10000" name="print_price" id="pricep" placeholder="$0.00" value="<?php echo $media->getPrintPrice(); ?>"></input>
                    </div>
                    <br>
                    <div class="text-center">
                        <input  type="submit" id="uploadBtn" class="btn btn-default" name="submit" style="width: 100px" value="Save">
      
                    </div>
                </form>
            </div>
            
        </div>

         <hr>
         <br>
            </div>
        </div>
     
     <br>
     <br>

    <!-- BOOTSTRAP JS/CSS -->
    <?php include 'includes/includes_bottom.php' ?>
    
    <!-- FOOTER INCLUDED IN ALL THE FILES -->
    <?php include 'includes/footer.php' ?>

</body>
</html>

