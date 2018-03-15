<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Page-Enter" content="blendTrans(Duration=1.0)">
  <meta http-equiv="Page-Exit" content="blendTrans(Duration=1.0)">
  <meta http-equiv="Site-Enter" content="blendTrans(Duration=1.0)">
  <meta http-equiv="Site-Exit" content="blendTrans(Duration=1.0)">

  
  <title>Become a Mover</title>

  <link href="<?php echo base_url("public/newcss/new.css")?>" rel="stylesheet">  
     <link href="<?php echo base_url("public/css/bootstrap.min.css")?>" rel="stylesheet">  



<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>



  <!-- fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,200i,300,400,500,500i,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
  <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.11.1/validate.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>  
 <script src="<?php echo base_url("public/js/bootstrap.min.js")?>"></script> 





  <style type="text/css">
.form-group.mobile-field > select{margin:11px 0px 0px; }
.multiselect.dropdown-toggle.btn.btn-default {background: #ffffff none repeat scroll 0 0; box-shadow: none; height: 45px; overflow-x: scroll !important; width: 100%; }
.multiselect-container.dropdown-menu .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"], .radio input[type="radio"], .radio-inline input[type="radio"] {
  margin-left: 55px;
  margin-top: 10px;
  position: absolute;
}
.multiselect-container.dropdown-menu {
  padding: 0 0 0 10px;
}

</style>
</head>

<body>
  <section class="banner banner-book-mover">
    <header>
      <div class="container-fluid">
        <div class="ADd_padding">
          <div class="col-md-12 col-sm-12">
            <div class="navigation">
              <div class="navbar-header">


                <button aria-controls="bs-navbar" aria-expanded="false" class="collapsed navbar-toggle" data-target="#bs-navbar" data-toggle="collapse" type="button">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>


                <a href="../" class="navbar-brand"><img src="<?php echo base_url("public/images/logo.png")?>" alt="#" class="img-responsive"></a>
              </div>


              <nav class="collapse navbar-collapse" id="bs-navbar">
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">About</a></li>
                  <li><a href="#">Services</a></li>
                  <li><a href="#">Contact Us</a></li>
                  <li>
                    <a href="#">
                      <button type="button">Become a Mover</button>
                    </a>
                  </li>
                </ul>
              </nav>



            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="header-caption-bm"> <div class="container-fluid">
      <div class="ADd_padding">
        <h1>Become  <b>a Mover</b></h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris ni</p>




      <h2 align="center" style="color: red"><?php echo $this->session->flashdata('signup'); ?></h2>
      <h2 align="center" style="color: red"><?php echo $this->session->flashdata('no'); ?></h2>
      <h2 align="center" style="color: red"><?php echo $this->session->flashdata('already'); ?></h2>  
            <h2 align="center" style="color: red"><?php echo $this->session->flashdata('msg1'); ?></h2>  

      </div></div></div>

    </section>



    <div class="bm-steps-section">
      <div class="container-fluid">
        <div class="ADd_padding">

          <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
              <div class="bmss-inner-wrap">


                <ul class="nav nav-tabs " role="tablist" id="myTab">
                  <li class="nav-item ">
                    <a class="nav-link active" id="tab1"  role="tab"><h1>Step <span class="NUmber_Font">1</span></h1><p> <b>Personal Details</b> </p></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link"  id="tab2"  role="tab"><h1>Step <span class="NUmber_Font">2</span></h1><p><b>Account Details</b></p></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link " id="tab3"  role="tab"><h1>Step <span class="NUmber_Font">3</span></h1><p><b>Vehicle Details</b></p></a>
                  </li>

                </ul>



                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="home" role="tabpanel">
                    <div class="EDit_Inputs_wrap">
                     <form class="EDit_Inputs" id="default" enctype="multipart/form-data" method="post" action="<?php echo base_url("Driver/signup")?>">
                      <div class="form-group">
                       <label class="required">Profile Image </label>


                      <div class="upload-pic-wrap"> 
                      <div class="upload-pic" id="aaa">
                        <img id="default-img" src="<?php echo base_url();?>/public/images/upload-pics-book-mover.png" class="img-responsive-bm">
                         <img id="blah1" class="blah1" src="#" alt="your image" style="display:none" />
                        <div class="upload-btn-wrap">
                          <div class="upload-btn">
                            <input type="file" id="profile_pic"  name="profile_pic" onchange="readURL(this,'blah1','default-img');" required="" >
                            <img src="<?php echo base_url();?>/public/images/book-mover-upload.png" class="img-responsive ">
                          
                          </div>
                        </div>
                        <p id="profile_pic1" class="error-message" style="display: none;">This field is required.</p>
                      </div>
                      </div>
           
                   


                    <div class="form-group">
                      <label for="full_name" class="required">First Name </label>
                      <input class="form-control required fname" id="fname" placeholder="Full Name" name="fname" type="text" onclick="onPressBackspace()" onKeyPress="return ValidateAlpha(event);" required maxlength="25" onkeyup="this.value = minmax(this.value,0,20)"  >
<!-- 

                      <p id="fname12" class="error-message" style="display: none;">Only Character Allowed.</p> -->

                      
                      <p id="fname1" class="error-message" style="display: none;">This field is required.</p>
                    </div>








                    <div class="form-group">
                      <label>Last Name </label>
                      <input class="form-control"  placeholder="Last Name" name="lname" type="text" id="lname" onclick="onPressBackspace()" onKeyPress="return ValidateAlpha(event);">
             
                    </div>

                    <div class="form-group">
                      <label class="required">Email Address </label>
                      <input class="form-control" id="email" placeholder="Email Address" name="email" type="text" required="" >
       
                      <p id="errorMessage" class="error-message" style="display: none;">Please Enter a Valid Email.</p>
                      <p id="email1" class="error-message" style="display: none;">This field is required.</p>

                    </div>
                    <div class="form-group mobile-field">
                      <label class="required">Mobile Number </label>
              <!--         <input class="form-control country_code number" id="country_code" placeholder="+61" name="country_code" type="text" required="" required maxlength="3" onkeyup="this.value = minmax(this.value)" > -->

          
                     <div class="country-code-wrap selectdiv">
                         <select name="country_code" id="country_code" required=""> 
                           <option value="">Choose</option>
                           <?php foreach($code as $key => $value){ ?>
                           <option value="<?php echo $value->country_code; ?>"><?php echo $value->country_code; ?></option> 
                           <?php } ?>
                         </select>
                        
                       <input class="form-control number phone"  placeholder="Mobile Number" id="phone" name="phone" type="text" required="" required maxlength="12" onkeyup="this.value = minmax(this.value)">
              </div>
                      <p id="phone1" class="error-message" style="display: none;">This field is required.</p>
                      <p id="country_code1" class="error-message" style="display: none;">This field is required.</p>
                    </div>


                    <div class="form-group">
                      <label class="required">Select Country</label>
      
                      <div class="selectdiv">
                  
                         <select name="pty_select" id="pty_select" required=""> 
                           <option value="">Choose</option>
                           <?php 

                           foreach($country as $key => $value){
                   
                            ?>
                           <option value="<?php echo $value->country_name; ?>"><?php echo $value->country_name; ?></option> 
                           <?php } ?>
                         </select>
                 
                       </div></div>
                         
        <div style="display: none" id='selectcity' class="">
         <label class="required">Select City</label>
       <div class="selectdiv"> <select name="cityselect[]" id="cityselect" multiple="multiple">
            <option value="">Choose</option>
        </select>
        </div> </div>




                       <p id="pty_select1" class="error-message" style="display: none;">This field is required.</p>
                     </label>
                   </div>

                   <div class="form-group">
                    <label class="required">License Number </label>
                    <input type="text" name="license_no" id="license_no12" class="form-control"  placeholder="License No"  required maxlength="25" onkeyup="this.value = minmax(this.value)"  required="">
          
                    <p id="license_no1" class="error-message" style="display: none;">This field is required.</p>

                    
                  </div>











                    <div class="form-group">
                    <label class="required">License Image </label>
                    <div class="upload-pic-wrap"> 

                    <div class="upload-pic" >
                    <img  id="ccc" src="<?php echo base_url();?>/public/images/upload-pics-book-mover.png" class="img-responsive-bm">
                    <img id="blah2" class="blah2" src="#" alt="your image" style="display:none" />
                    <div class="upload-btn-wrap">
                    <div class="upload-btn">
                    <input type="file"  name="license_image_front" id="license_image_front" required="" onchange="readURL(this,'blah2','ccc');">

                    <img  src="<?php echo base_url();?>/public/images/book-mover-upload.png" class="img-responsive">
                    </div>
                    </div>
                    <p id="license_image_front1" class="error-message" style="display: none;">This field is required.</p>
                    </div>


                   
                    <div class="upload-pic">
                    <img  id="bbb" src="<?php echo base_url();?>/public/images/upload-pics-book-mover.png" class="img-responsive-bm">
                      <img id="blah3" class="blah3" src="#" alt="your image" style="display:none" />
                    <div class="upload-btn-wrap">
                    <div class="upload-btn">
                    <input type="file"  name="license_image_back" id="license_image_back"  onchange="readURL(this,'blah3','bbb');" required="">
                    <img src="<?php echo base_url();?>/public/images/book-mover-upload.png" class="img-responsive">
                    </div>
                    </div>
                    <p id="license_image_back1" class="error-message" style="display: none;">This field is required.</p>
                    </div>
                    </div>




                    </div>






                  <div class="SAve">
                    <button type="submit" data-toggle="tab" id="nect" href="#profile">Next</button>
                  </div>





            </div>

                </div>
              <!-- </div> -->

              <div class="tab-pane" id="profile" role="tabpanel">
              <div class="EDit_Inputs_wrap">
                <div class="EDit_Inputs">

                  <div class="form-group">
                    <label class="required">Bank Name </label>
                    <input class="form-control"  placeholder="Bank Name" type="text" name="bank_name" id="bank_name"  onclick="onPressBackspace()" onKeyPress="return ValidateAlpha(event);" required maxlength="25" onkeyup="this.value = minmax(this.value,5,20)" required="">
                    <p id="bank_name1" class="error-message" style="display: none;">This field is required.</p>
                  </div>

                  <div class="form-group">
                    <label class="required">Account Name  </label>
                    <input class="form-control " placeholder="Account Name" type="text" name="account_name" id="account_name"  required maxlength="25"  onclick="onPressBackspace()" onKeyPress="return ValidateAlpha(event);" required maxlength="25" onkeyup="this.value = minmax(this.value)" required="">
                    <p id="account_name1" class="error-message" style="display: none;">This field is required.</p>
                  </div>
                  <div class="form-group">
                    <label class="required">Account Number </label>
                    <input class="form-control number"  placeholder="Account Number" type="text" name="account_number" id="account_number" required=""  onclick="onPressBackspace()"  required maxlength="25" onkeyup="this.value = minmax(this.value)" >
                    <p id="account_number1" class="error-message" style="display: none;">This field is required.</p>
                  </div>
                  <div class="form-group">    
                    <label class="required">Account BSB </label>               
                    <input class="form-control"  placeholder="Account BSB" type="text" name="account_bsb" id="account_bsb" required=""  onclick="onPressBackspace()" onKeyPress="return ValidateAlpha(event);" required maxlength="25" onkeyup="this.value = minmax(this.value)">
                    <p id="account_bsb1" class="error-message" style="display: none;">This field is required.</p>
                  </div>


                  <div class="SAve">
                    <button type="button" id="nect1" data-toggle="tab" href="#messages" >Next</button>
                  </div> 

                  <div class="SAve">
                    <button type="button" id="back2" data-toggle="tab" href="#home" >Previous</button>
                  </div> 
                   </div>
                </div>
              </div>

              <div class="tab-pane" id="messages" role="tabpanel"><div class="EDit_Inputs_wrap"><div class="EDit_Inputs">
                <div class="form-group">
                  <label class="required">Vehicle Name </label>
                  <input class="form-control"  placeholder="Vehicle Name" type="text" name="vehicle"  id="vehicle" required="" required maxlength="25" onclick="onPressBackspace()" onKeyPress="return ValidateAlpha(event);" required maxlength="25" onkeyup="this.value = minmax(this.value)">
                  <p id="vehicle1" class="error-message" style="display: none;">This field is required.</p>
                </div>


                <div class="form-group">
                  <label class="required">Vehicle Type </label>
                  <div class="selectdiv"><label> 
                    <select name="vehicle_id" id="vehicle_id" class="form-control" required=""> 
                     <option value="">Choose</option>
                     <?php foreach($vehicletype as $key => $value){ ?>
                     <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option> 
                     <?php } ?>
                   </select>
                 </label>
                 <p id="vehicle_id1" class="error-message" style="display: none;">This field is required.</p>
                 <!-- <img src="<?php echo base_url();?>/public/images/dropdown-arrow.png"/></div> -->
               </div>


               <div class="form-group">
                <label class="required">Vehicle Number </label>
                <input class="form-control"  placeholder="Vehicle Number" type="text" name="vehicle_no" id="vehicle_no" required="" onclick="onPressBackspace()" required maxlength="25" onkeyup="this.value = minmax(this.value)">
                <p id="vehicle_no1" class="error-message" style="display: none;">This field is required.</p>
              </div>

              <div class="form-group">
                <label class="required">Vehicle RC </label>
                <div class="upload-pic" >
                  <img id="ddd" src="<?php echo base_url();?>/public/images/upload-pics-book-mover.png" class="img-responsive-bm">
                    <img id="blah4" class="blah4" src="#" alt="your image" style="display:none" />
                  <div class="upload-btn-wrap">
                    <div class="upload-btn">
                      <input type="file" hidden="" name="rc_image_front" id="rc_image_front" required="" onchange="readURL(this,'blah4','ddd');">
                      <img src="<?php echo base_url();?>/public/images/book-mover-upload.png" class="img-responsive">
                    </div>
                  </div>
                  <p id="rc_image_front1" class="error-message" style="display: none;">This field is required.</p>
                </div>
<!-- 
                <div class="img-uploaded-wrap">
                   <div class="upload-btn-wrap">
                          <div class="upload-btn">
                           <input type="file" hidden="" name="rc_image_front" id="rc_image_front" required="" onchange="readURL(this,'blah4','ddd');">
                            <img src="<?php echo base_url();?>/public/images/book-mover-upload.png" class="img-responsive ">
                          </div>
                        </div>
                     <div class="img-uploaded"> 
                <img id="blah4" class="blah4" src="#" alt="your image" style="display:none" /></div></div> -->


                <div class="upload-pic" >
                  <img id="eee" src="<?php echo base_url();?>/public/images/upload-pics-book-mover.png" class="img-responsive-bm">
                     <img id="blah5" class="blah5" src="#" alt="your image" style="display:none" />
                  <div class="upload-btn-wrap">
                    <div class="upload-btn">
                      <input required="" type="file" hidden="" name="rc_image_back" id="rc_image_back" onchange="readURL(this,'blah5','eee');">
                      <img src="<?php echo base_url();?>/public/images/book-mover-upload.png" class="img-responsive">
                    </div>
                  </div>
                  <p id="rc_image_back1" class="error-message" style="display: none;">This field is required.</p>
                </div>
              </div>

              <div class="form-group">
                <label class="required">Vehicle Insurance </label>
                <div class="upload-pic" >
                  <img id="fff" src="<?php echo base_url();?>/public/images/upload-pics-book-mover.png" class="img-responsive-bm">
                   <img id="blah6" class="blah6" src="#" alt="your image" style="display:none" />
                  <div class="upload-btn-wrap">
                    <div class="upload-btn">
                      <input type="file" hidden="" name="insurance_image_front" id="insurance_image_front" required="" onchange="readURL(this,'blah6','fff');">
                      <img src="<?php echo base_url();?>/public/images/book-mover-upload.png" class="img-responsive">
                    </div>
                  </div>
                  <p id="insurance_image_front1" class="error-message" style="display: none;">This field is required.</p>
                </div>


                <div class="upload-pic" >
                  <img id="ggg" src="<?php echo base_url();?>/public/images/upload-pics-book-mover.png" class="img-responsive-bm">
                     <img id="blah7" class="blah7" src="#" alt="your image" style="display:none" />
                  <div class="upload-btn-wrap">
                    <div class="upload-btn">
                      <input required="" type="file" hidden="" name="insurance_image_back" id="insurance_image_back" onchange="readURL(this,'blah7','ggg');">
                      <img src="<?php echo base_url();?>/public/images/book-mover-upload.png" class="img-responsive">
                    </div>
                  </div>
                  <p id="insurance_image_back1" class="error-message" style="display: none;">This field is required.</p>
                </div>
              </div>

              <div class="form-group">
                <label class="required">Vehicle Image </label>
                <div class="upload-pic">
                  <img  id="hhh" src="<?php echo base_url();?>/public/images/upload-pics-book-mover.png" class="img-responsive-bm">
                         <img id="blah8" class="blah8" src="#" alt="your image" style="display:none" />
                  <div class="upload-btn-wrap"><div class="upload-btn">
                    <input type="file" hidden="" name="vehicle_image_front" id="vehicle_image_front" required="" onchange="readURL(this,'blah8','hhh');">
                    <img src="<?php echo base_url();?>/public/images/book-mover-upload.png" class="img-responsive">
                  </div>
                </div>
                <p id="vehicle_image_front1" class="error-message" style="display: none;">This field is required.</p>
              </div>


              <div class="upload-pic" >
                <img id="iii" src="<?php echo base_url();?>/public/images/upload-pics-book-mover.png" class="img-responsive-bm">
                 <img id="blah9" class="blah9" src="#" alt="your image" style="display:none" />
                <div class="upload-btn-wrap">
                  <div class="upload-btn">
                    <input required="" type="file" hidden="" name="vehicle_image_back" id="vehicle_image_back" onchange="readURL(this,'blah9','iii');">
                    <img src="<?php echo base_url();?>/public/images/book-mover-upload.png" class="img-responsive">
                  </div>
                </div>
                <p id="vehicle_image_back1" class="error-message" style="display: none;">This field is required.</p>
              </div>
            </div> 

            <div class="SAve">
              <button type="submit" id="nect2" name="submit" >Submit</button>
            </div>

            <div class="SAve">
              <button type="button" data-toggle="tab" id="back1"  href="#profile" >Previous</button>
            </div> 
          </form>
        </div>
      </div></div>

    </div>
  </div>
</div>
</div>
</div>
</div>
</div>


<script type="text/javascript">

 function readURL(input,a,aaa) {

  $('.'+a).show();
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#"+aaa).hide();   
      $('#'+a)
      .attr('src', e.target.result)
      .width(281)
      .height(250);
    };

    reader.readAsDataURL(input.files[0]);
  }
}
</script>

<script type="text/javascript">
  

       
    function ValidateAlpha(evt)
    {
        var keyCode = (evt.which) ? evt.which : evt.keyCode
     
     if(keyCode==8) {

        return true;
      }
         else if (( keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) ){
        $("#fname12").html("Only Character Allowed").show().fadeOut("slow");

        return false;

      }

      return true;

    }


</script>




<script type="text/javascript">
function minmax(value, min, max) 
{
    if(parseInt(value) < min || isNaN(parseInt(value))) 
    else if(parseInt(value) > max) 
        return 100; 
      else return true;
}
</script>





<script type="text/javascript">

  $(document).ready(function () {
    $(".number").keypress(function (e) {
 
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57 )) {
    
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
        return false;
      }
    });

  });
</script>
<script type="text/javascript">
  // $(document).ready(function() {

    $('#nect').click(function() {
      var profile_pic = $("#profile_pic").val();
      var name = $("#fname").val();
      var email= $("#email").val();

      var phone= $("#phone").val();
      var pty = $("#pty_select");
      var city = $("#cityselect");

      // alert(city.val());


     var country_code = $("#country_code");
      var license_no = $("#license_no12").val();
      var license_image_front = $("#license_image_front").val();
      var license_image_back = $("#license_image_back").val();


        if (profile_pic && name && email && phone && pty.val() && city.val() && country_code.val() && license_no && license_image_front && license_image_back) {
        jQuery('#tab1').removeClass('active');
        jQuery('#tab2').addClass('active');
        }
      if (profile_pic == "" ) {
        $("#profile_pic1").show();
        return false;
      }
      if (name == "" ) {
        $("#fname1").show();
        return false;
       }



    
       if (pty.val() == "") {
        $("#pty_select1").show();
         return false;
       }
           if (city.val() == "") {
        $("#pty_select1").show();
         return false;
       }
                if (city.val() == null) {
        $("#pty_select1").show();
         return false;
       }
                 if (city2 == null) {
        $("#pty_select1").show();
         return false;
       }
      if (phone == "" ) {
        $("#phone1").show();
        return false;
      }
         if (country_code.val() == "" ) {
        $("#country_code1").show();
        return false;
      }


      if (license_no == "" ) {
        $("#license_no1").show();
        return false;
      }

      if (license_image_front == "" ) {
        $("#license_image_front1").show();
        return false;
      }
      if (license_image_back == "" ) {
        $("#license_image_back1").show();
        return false;
      }







    });


    $("#fname").on("keyup" ,function(){
      $("#fname1").hide();
    });



        $("#country_code").bind("change keyup", function(event){
       $("#country_code1").hide();
     });



    $("#phone").on("keyup" ,function(){
      $("#phone1").hide();
    });
      $("#country_code").on("keyup" ,function(){
      $("#country_code1").hide();
    });


    $("#license_no").on("keyup" ,function(){
      $("#license_no1").hide();
    });

    $("#profile_pic").on("keyup" ,function(){
      $("#profile_pic1").hide();
    });

    $("#license_image_front").on("keyup" ,function(){
      $("#license_image_front1").hide();
    } );

    $("#license_image_back").on("keyup" ,function(){
      $("#license_image_back1").hide();
    } );




    $('#nect1').click(function() {

      var bank_name = $("#bank_name").val();
      var account_name = $("#account_name").val();
      var account_number = $("#account_number").val();
      var account_bsb = $("#account_bsb").val();

      if (bank_name && account_name && account_number && account_bsb) {
      jQuery('#tab2').removeClass('active');
      jQuery('#tab3').addClass('active');
      }
      if (bank_name == "" ) {
        $("#bank_name1").show();
        return false;
      }
      if (account_name == "" ) {
        $("#account_name1").show();
        return false;
      }
      if (account_number == "" ) {
        $("#account_number1").show();
        return false;
      }
      if (account_bsb == "" ) {
        $("#account_bsb1").show();
        return false;
      }
    });


    $("#bank_name").on("keyup" ,function(){
      $("#bank_name1").hide();
    } );

    $("#account_name").on("keyup" ,function(){
      $("#account_name1").hide();
    } );
    $("#account_bsb").on("keyup" ,function(){
      $("#account_bsb1").hide();
    } );
    $("#account_number").on("keyup" ,function(){
      $("#account_number1").hide();
    } );






    $('#nect2').click(function() {
      var vehicle = $("#vehicle").val();
      var id = $("#vehicle_id");
      //var vehicle_id = $("#vehicle_id").val();
      var vehicle_no = $("#vehicle_no").val();
      var vehicle_image_back = $("#vehicle_image_back").val();
      var vehicle_image_front = $("#vehicle_image_front").val();
      var insurance_image_back = $("#insurance_image_back").val();
      var insurance_image_front = $("#insurance_image_front").val();
      var rc_image_back = $("#rc_image_back").val();
      var rc_image_front = $("#rc_image_front").val();


      if (vehicle == "" ) {
        $("#vehicle1").show();
        return false;
      }
      if (id.val() == "") {
        $("#vehicle_id1").show();
         return false;
       }

      if (vehicle_no == "" ) {
        $("#vehicle_no1").show();
        return false;
      }
      if (rc_image_back == "" ) {
        $("#rc_image_back1").show();
        return false;
      }

      if (rc_image_front == "" ) {
        $("#rc_image_front1").show();
        return false;
      }
      if (insurance_image_back == "" ) {
        $("#insurance_image_back1").show();
        return false;
      }
      if (insurance_image_front == "" ) {
        $("#insurance_image_front1").show();
        return false;
      }
      if (vehicle_image_back == "" ) {
        $("#vehicle_image_back1").show();
        return false;
      }

      if (vehicle_image_front == "" ) {
        $("#vehicle_image_front1").show();
        return false;
      }


    });


    $("#vehicle").on("keyup" ,function(){
      $("#vehicle1").hide();
    } );

    $("#vehicle_id").bind("change keyup", function(event){
       $("#vehicle_id1").hide();
     });

    // $("#vehicle_id").on("keyup" ,function(){
    //   $("#vehicle_id1").hide();
    // } );
    $("#vehicle_no").on("keyup" ,function(){
      $("#vehicle_no1").hide();
    } );
    $("#vehicle_image_back").on("keyup" ,function(){
      $("#vehicle_image_back1").hide();
    } );


    $("#vehicle_image_front").on("keyup" ,function(){
      $("#vehicle_image_front1").hide();
    } );

    $("#insurance_image_back").on("keyup" ,function(){
      $("#insurance_image_back1").hide();
    } );
    $("#insurance_image_front").on("keyup" ,function(){
      $("#insurance_image_front1").hide();
    } );
    $("#rc_image_back").on("keyup" ,function(){
      $("#rc_image_back1").hide();
    } );

    $("#rc_image_front").on("keyup" ,function(){
      $("#rc_image_front1").hide();
    } );

  $('#back1').click(function() {
        jQuery('#tab3').removeClass('active');
        jQuery('#tab2').addClass('active');
  });


    $('#back2').click(function() {
    jQuery('#tab2').removeClass('active');
    jQuery('#tab1').addClass('active');

});

  // });


</script>

</script>
<script type="text/javascript">
  var validateEmail = function(elementValue) {
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(elementValue);
  }

$('#nect').click(function() {
    var value = $('#email').val();
    var valid = validateEmail(value);
    if (!valid) {
        $("#errorMessage").show(); 
        return false;
    }
    else{
       $("#errorMessage").hide(); 
    }
});
</script>



</body>

</html>



<link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
    rel="stylesheet" type="text/css" />
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
    type="text/javascript"></script>



        <script type="text/javascript">

            $('#pty_select').on('change', function() {

       

               $('#cityselect').empty();

$("#cityselect").multiselect('destroy');


          $("#pty_select1").hide();
             var pty = $("#pty_select").val();

              $.ajax({type: "POST",url:"<?php echo base_url("Driver/getspecific")?>",data:{country:pty}}).done(function(data){
                var abc=JSON.parse(data);
                    $("#selectcity").show();
                    $('#cityselect').empty();
                       $.each(abc,function(item,i){
                        $("#cityselect").append('<option value='+i.id+'>'+i.city_name+'</option>');
                        }); 
                   
                           $("#cityselect").multiselect({ 
                            numberDisplayed: 20,
                              })
                    });




       
     });
    </script>