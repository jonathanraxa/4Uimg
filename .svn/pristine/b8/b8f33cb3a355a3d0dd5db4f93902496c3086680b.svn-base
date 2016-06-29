
<!-- SPECIFIC HEADER CSS -->
<?php echo '<link href="css/header.css" rel="stylesheet">'; ?>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="index.php">4Uimg</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <!-- SEARCH BAR GOING TO RESULTS -->
            <?php include 'header_search_bar.php' ?>

            <ul class="nav navbar-nav navbar-right">

                <li class="">
                    <a class="page-scroll" href="bountylist.php">View Artwork Requests</a>
                </li>

                <li class="">
                    <a class="page-scroll" href="index.php#about">Services</a>
                </li>

                <li class="">
                    <a class="page-scroll" href="browse.php">Browse</a>
                </li>


               <?php

                if ($user == null) {
                ?>
                    <li id="login">
                        <a href="" data-toggle="modal" data-target="#myModal3">
                            Login/Register
                        </a>
                    </li>
                <?php } else { ?>
               
                     <li class="user">
                     <a href="#" data-toggle="dropdown" class="dropdown-toggle"> Welcome, <?php echo $user->getFirstName(); ?> 
                        <b class="caret"></b>
                        </a>
            
                        <ul class="dropdown-menu">
            
                        <?php if ($user->getType() == "customer") { ?>
                        <li>
                            <a class="page-scroll" href="customerprofile.php">Customer Profile</a>
                        </li>
                        <?php } else if ($user->getType() == "artist") { ?>
                        <li>
                            <a class="page-scroll" href="artistprofile.php">Artist Profile</a>
                        </li>
                        <?php } ?>
            
                        <li role="separator" class="divider"></li>
            
                        <li>
                        <a class="page-scroll" href="handle_login.php">Log Out</a>
                        </li>
                    </ul> 
                    </li>
                <?php } ?>


            </ul>
        </div>
    </div>
</nav>


<!-- SIGNUP AND LOGIN MODAL -->
<?php include "signup_login_modal.php" ?>

<!-- MODAL FOR ARTISTS/CUSTOMER/BOTH -->
<?php include 'instructions.php' ?>






