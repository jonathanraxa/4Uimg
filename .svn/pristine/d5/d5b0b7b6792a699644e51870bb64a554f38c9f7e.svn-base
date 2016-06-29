<!-- CONTACT 4UIMG WEBSITE FOR ALL USERS -->
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

        <style type="text/css">
            .foot {
                background-color: black;
                opacity: 50%;
                bottom: 0;
                position: relative !important;
                width: 100%;
            }

        </style>

    </head>

<body id="page-top" class="index">

    <!-- SPECIFIC HEADER FILE FOR INDEX/RESULTS PAGE -->
    <?php include 'includes/header.php' ?>

<div class="row">

  <br>
  <br>
  <br>
  
  <div class="col-lg-12 text-center" style="margin-top: 27px;padding: 20px;">
    <h2 class="section-heading">Contact Us</h2>
    <h3 class="section-subheading text-muted">Forgot your password? Any questions or concerns? Please feel free to contact us!</h3>
  </div>
</div>

<hr>
      <div class="row" style="padding-bottom: 3%;padding-top: 3%;">
        <div class="col-lg-12 text-center">
          <h2>Phone: <span style="font-size: 35px;font-weight: normal;color: #777;">(415)555-5555</span></h2>
          
         <div style="font-size: 35px;font-weight: bold;">OR</div>

           <h2>Email: <span style="font-size: 35px;font-weight: normal;color: #777;"><a href="mailto:4uimg@cii.com?Subject=4UImg%20SupportTicket" target="_top">4uimg@cii.com</a></span></h2>

        </div>
      </div>

      <br>
      <br>


    <!-- FOOTER INCLUDED IN ALL PAGES -->
    <?php include 'includes/footer.php' ?>    

    <!-- OPENS WHEN USER CLICKS "PURCHASE" -->
    <?php include 'includes/confirm_purchase.php' ?>

    <!-- MODALS FOR MORE INFORMATION ON PRICING -->
    <?php include 'includes/more_info.php' ?>

    <!-- DISPLAYS THE SPECIFIC IMAGE LICENSES -->
    <?php include 'includes/license_types.php' ?>

    <!-- BOOTSTRAP JS/CSS -->
    <?php include 'includes/includes_bottom.php' ?>
    
    <!-- Modal for New Custom Artwork Request -->
    <?php include 'includes/custom_artwork_form.php'?>

</body>
</html>


