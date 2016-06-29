<!-- HANDLES THE SIGNUP WITHIN THE SIGNUP MODAL -->
<?php
require_once 'models/login.php';
require_once 'models/media.php';
require_once 'db/credentials.php';
require_once 'search.php';

$connection = new mysqli($MYSQL_CREDENTIALS["host"], $MYSQL_CREDENTIALS["username"], $MYSQL_CREDENTIALS["password"], $MYSQL_CREDENTIALS["database"]);
$login = Login::current($connection);

$registerError = "";

// CREATE A LOGIN INSTANCE UPON SIGNUP
$success = false;
if ($login == null) {
    if (isset($_POST['submit']) && $_POST['submit'] == 'signup') {
        $username = $_POST["signup_username"];
        //echo $username;
        $password = $_POST["user_password"];
        $password1 = $_POST["user_password2"];
        $firstname = $_POST["signup_firstname"];
        $lastname = $_POST["signup_lastname"];
        $email = $_POST["signup_email"];
        $type = "customer";
        if ($username != null && $password == $password1) {
            //echo "before" . $username . "after";
            Login::signup($connection, $username, $email, $firstname, $lastname, $type, $password);
            $success = true;
        } else {
            $registerError = "Failed to register";
        }
    }
} else {
    $error = "You are already logged in";
}
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


<header>
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

</div>


        </div>
    </header>


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

    <?php if ($registerError) { ?>
    <div class="modal fade in" id="registerErrorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="font-size: large">Failed to register</p>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-primary" onclick="$('#registerErrorModal').modal('hide');">OK</button>
                </div>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <div class="modal fade in" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                        <p style="font-size: large">Successfully registered</p>
                </div>
                <div class="text-right">
                    <a href="index.php" class="btn btn-primary" >OK</a>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <script type="text/javascript">
        $('#successModal').modal('show');
        $('#registerErrorModal').modal('show');
        $("#myModal3").modal("show");
    </script>
</body>
</html>


