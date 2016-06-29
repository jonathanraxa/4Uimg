<!-- EDIT PROFILE PAGE -->
<html>
    <head>
        <title>Edit Profile</title>
    
        <!-- CUSTOM CSS FOR EDIT PROFILE -->
        <style type="text/css">
            .foot {
            background-color: black;
            opacity: 50%;
            bottom: 0;
            position: absolute !important;
            width: 100%;
            }
            label{ padding-right: 50px;}
        </style>

        <?php include 'includes/includes_head.php' ?>
    </head>
    
    
    <body>
        <div class="container">
            <?php include 'includes/header.php' ?>
            <br><br><br><br><br>

            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">

                    <h1> Edit Profile </h1>

                    <!-- Profile form -->
                    <form class="form-inline" role="form">

                        <div class="form-group">
                            <label>First Name:</label>
                            <input class="form-control userSettings"  id="userFirstName" name="userFirstName" style="width:500px" type="text" disabled="disabled" value="Bobby" >
                            <button class="btn btn-default editFirstNameBtn" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
                        </div>

                        <div class="form-group">
                            <br><label>Last Name:</label>
                            <input class="form-control userSettings" id="userLastName" name="userLastName"style="width:500px" type="text" disabled="disabled" value="John">
                            <button class="btn btn-default editLastNameBtn" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
                        </div>

                        <div class="form-group">
                            <br><label style="padding-right: 25px"> Email address:</label>
                            <input class="form-control userSettings" id="userEmail"  name="userEmail" style="width: 500px" type="text" disabled="true" value="bobbyjohn123@gmail.com">
                            <button class="btn btn-default editEmailBtn" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
                        </div>

                        <div class="form-group">
                            <br><label style="padding-right: 51px"> Password:</label>
                            <input class="form-control userSettings" id="userPassword"  name="userPassword" style="width: 505px" type="text" disabled="true" value="************">
                            <button class="btn btn-default editPassword" type="button"><i class="glyphicon glyphicon-pencil"></i></button>
                        </div>
   
                        <br><br><label id="userNewPassLabel" hidden="hidden">Confirm New Password:</label>
                        <br><input class="userSettings" id="userNewPassword"  name="userNewPassword" style="width: 610px" type="text" hidden="hidden" placeholder="Re-enter new password">
                        
                        <div class="text-right">     
                            <br><input id="saveBtn" class="button" type="button" hidden="hidden"  style="background-color: #fed136" value="Save Changes" data-toggle="modal" data-target="#saveModal">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>

        <!-- Script run when user clicks on edit button -->
        <script type="text/javascript">
            $('.editFirstNameBtn').on('click', function(event) {
                $(this).hide();
                if($('#saveBtn').attr('hidden')){
                    $('#saveBtn').removeAttr('hidden');
                }
                if ($('#userFirstName').attr('disabled')){
                    $('#userFirstName').removeAttr('disabled');
                }else{
                    $('#userFirstName').attr('disabled', 'disabled');
                }
            });

            $('.editLastNameBtn').on('click', function(event) {
                $(this).hide();
                if($('#saveBtn').attr('hidden')){
                    $('#saveBtn').removeAttr('hidden');
                }
                if ($('#userLastName').attr('disabled')){
                    $('#userLastName').removeAttr('disabled');
                }else{
                    $('#userLastName').attr('disabled', 'disabled');
                }
            });   

            $('.editEmailBtn').on('click', function(event) {
                $(this).hide();
                if($('#saveBtn').attr('hidden')){
                    $('#saveBtn').removeAttr('hidden');
                }
                if ($('#userEmail').attr('disabled')){
                    $('#userEmail').removeAttr('disabled');
                }else{
                    $('#userEmail').attr('disabled', 'disabled');
                }
            }); 

            $('.editPassword').on('click', function(event) {
                $(this).hide();
                if($('#saveBtn').attr('hidden')){
                    $('#saveBtn').removeAttr('hidden');
                }
                if ($('#userPassword').attr('disabled')){
                    $('#userPassword').removeAttr('disabled');
                }else{
                    $('#userPassword').attr('disabled', 'disabled');
                }
                $('#userNewPassLabel').removeAttr('hidden');
                $('#userNewPassword').removeAttr('hidden');
            }); 
        </script>

        <!-- Modal for successful request submission -->
        <div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="saveSuccess">
                            <p style="font-size: large">  Your changes are successfully saved.  </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" onclick="location.href='index.php'">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER INCLUDED IN ALL FILES -->
        <?php include 'includes/footer.php' ?>

        <!-- BOOTSTRAP JS/CSS -->
        <?php include 'includes/includes_bottom.php' ?>
    </body>
</html>
