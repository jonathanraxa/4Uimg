<!-- FORM FOR CUSTOM ARTWORK REQUEST -->
<?php
    include_once 'search.php';
    include_once 'db/credentials.php';
    include_once 'models/login.php';
    include_once 'models/bounty.php';
?>
    <style type="text/css">
            #formBtn, #submitFormBtn{
                
                background-color: #FED136;
                border-color: black;
            }
            #formBtn:hover, #submitFormBtn:hover{
                border-color: #adadad;
            }
            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
                -webkit-appearance: none; 
                 margin: 0; 
            }
        </style>
   <?php

      
        //will add information to the DB once submit request button is clicked 
        if(isset($_POST['submitRequest'])){
            if(isset($_POST['BountyTitle'])){
                $newTitle = $_POST['BountyTitle'];
            } else { $newTitle = null; }
            if(isset($_POST['BountyDescription'])){
                $newDescription = $_POST['BountyDescription'];
            } else { $newDescription = null; }
            if(isset($_POST['BountyPriceMin'])){
                $newPriceMin = $_POST['BountyPriceMin'];
            } else { $newPriceMin = null; }
            if(isset($_POST['BountyPriceMax'])){
                $newPriceMax = $_POST['BountyPriceMax'];
            } else { $newPriceMax = null; }
            if(isset($_POST['BountyLicenseType'])){
                $newLicenseType = $_POST['BountyLicenseType'];
            } else { $newLicenseType = null; }
            
            if (Bounty::requestArtwork($conn, $newTitle, $user->getUsername(), $newLicenseType, $newPriceMin, $newPriceMax, $newDescription)){ 

             echo ("<SCRIPT LANGUAGE='JavaScript'>
                   window.location.href='bountylist.php'
                   </SCRIPT>");
            }              
        }
   ?>
        

<!-- Modal for Custom Artwork Request Form -->
    <div class="modal fade" id="bountyForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                    <h4 style='color: #000'>Custom Artwork Request Form: </h4>
                </div>
                <div class="modal-body">
                        
                    <h4 style='color: #FFA500'>Can't find the perfect artwork for your needs? <br> Request by following these easy steps: </h4>
                        <p style='color: #d58512'> Step1: Enter the information about the artwork that you want using the form below.</p>
                        <p style='color: #d58512'> Step2: Click on the SUBMIT REQUEST button. NOTE: You must be a member to use this feature. </p>
                        <p style='color: #d58512'> Step3: Once your request has been submitted, our artists will contact you via your specified contact information regarding the fulfillment of the project. </p>
                        <h5 style="color: #FF0000"> * required fields</h5>
                        <form  method="post" id = "customRequestForm" name="customRequestForm">
                            
                            <div class="form-group">
                                <label>* Enter Title:</label>
                                <input type="text" class="form-control" name="BountyTitle" placeholder="Enter Title" required="required">
                            </div>

                            <div class="form-group">
                                <label>* Enter Description:</label> 
                                <textarea name="BountyDescription" class="form-control" form="customRequestForm" rows="10" cols="60" required="required" placeholder="Enter Description"></textarea>
                            </div>

                           <div class="form-group">
                                <label>* Enter Incentive Offer:</label>
                                <div class="row">
                                    <div class="col-md-5">
                                        <input name="BountyPriceMin" id="priceMin"  type="number" class="form-control" step="any" placeholder="min" required='required'> 
                                    </div>
                                    <div class="col-md-1">
                                        TO:
                                    </div>
                                    <div class="col-md-5">
                                     <input name="BountyPriceMax" id="priceMax" type="number" class="form-control" step="any" placeholder="max" required='required'>
                                    </div>
                                </div>
                           </div>

                           <div class="form-group">
                                <label>* License Type:</label><a href="" data-toggle='modal' data-target='#license_types'> What's This? </a>
                                <br><input type="radio" name="BountyLicenseType" value="Unlimited" required='required'> Unlimited
                                <input type="radio" name="BountyLicenseType" value="Web"> Web
                                <input type="radio" name="BountyLicenseType" value="Print"> Print
                            </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-left"><input id = "formBtn" type="button" class="btn btn-default" value='Cancel' data-dismiss="modal" ></div>
                        </div>
                        <div class="col-md-6">
                            
                        <?php 
                            if ($user != null)
                            {
                                echo "<button type=\"button\" onclick=\"checkVal();\" data-toggle=\"modal\"
                                data-target=\"#success_modal\" class=\"btn btn-primary\" >Submit Request</button>";
                            }
                            else
                            {
                                echo "<button type=\"button\" data-toggle=\"modal\"
                                data-target=\"#guest_submit\" class=\"btn btn-primary\" >Submit Request</button>";
                            }
                        ?>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

<div class="modal" id="success_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
            </div>
            <div class="modal-body">
                <p style="font-size: large"> Thank you. Your request is successfully submitted!. </p>
            </div>
            <div class="modal-footer">
                 <input type="submit" id="submitFormBtn" class="btn btn-default" value ="Ok" name="submitRequest" form="customRequestForm">
            </div>
        </div>
    </div>
</div>


<!-- MODAL FOR WHEN A GUEST IS PURCHASING AN IMAGE -->
<div class="modal" id="guest_submit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <span style="
                     font-size: 20px;
                     font-weight: bold;
                     ">Submitting an Artwork Request</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>

      </div>
      <div class="modal-body">
        <p>
          Thank you for your interest, to submit a custom artwork request: <br>
          Please <strong>Register/Login</strong>.
        </p>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-6">
            <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
          </div>
          <div class="col-md-6">
            <button type="button" class="btn btn-primary confirm_close2">Register/Login</button>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ERROR FOR WHEN A USER DID NOT FILL OUT EVERYTHING -->
<div class="modal" id="error_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
            </div>
            <div class="modal-body">
                <p style="font-size: large">Opps, looks like you're missing something. Please fill out entire form. </p>
            </div>
            <div class="modal-footer">
                 <button type="button" data-dismiss="modal" class="btn btn-default" >Ok</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    // CHECK IF EACH OF THE FIELDS ARE FILLED OUT, IF IT IS
    // OPEN UP THE ERROR MODAL 
    function checkVal()
    {
        if (!document.customRequestForm.BountyLicenseType[0].checked &&
            !document.customRequestForm.BountyLicenseType[1].checked &&
            !document.customRequestForm.BountyLicenseType[2].checked ||
            document.customRequestForm.BountyTitle.value == '' ||
            document.customRequestForm.BountyDescription.value == '' ||
            document.customRequestForm.priceMin.value == '' ||
            document.customRequestForm.priceMax.value == '') {

            $('#error_modal').modal('show');
        } 
        else {
            return 
        }
    }

     // HIDES THE MODAL AND OPENS ANOTHER
     $(".confirm_close2").click(function(){
          $('.modal').modal('hide');
          $('#myModal3').modal('show');
           
        });

    // HIDES BOTH GUEST AND BOUNTY FORM
    function openLogin()
    {
        $('#guest_submit').modal('hide');
        $('#bountyForm').modal('hide');

    }

    // OPENS UP THE GUEST SUBMIT MODAL
    function checkUser(){
            $('#guest_submit').modal('show');
    }
</script>
