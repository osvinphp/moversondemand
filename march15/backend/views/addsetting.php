<style type="text/css">
.highlight {
border: 1px solid #dfdfdf;
border-radius: 3px;
padding: 10px 10px;
background: #f9f9f9;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<section id="main-content">
<section class="wrapper site-min-height">
<!-- page start-->


<div class="row">
<div class="col-lg-12">
<section class="panel">
<header class="panel-heading">
Setting
</header>
<?php
$chargetype=$setting[0]->type;
?>
         <?php if ($this->session->flashdata('msg1')!='') { ?>
<div class="alert alert-danger alert-dismissable">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php
echo $this->session->flashdata('msg1');
?>
</div>
<?php } ?>
       <?php if ($this->session->flashdata('msg2')!='') { ?>
<div class="alert alert-danger alert-dismissable">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php
echo $this->session->flashdata('msg2');
?>
</div>
<?php } ?>
 <?php if ($this->session->flashdata('msg3')!='') { ?>
<div class="alert alert-danger alert-dismissable">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php
echo $this->session->flashdata('msg3');
?>
</div>
<?php } ?>
      <?php if ($this->session->flashdata('msg4')!='') { ?>
<div class="alert alert-danger alert-dismissable">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php
echo $this->session->flashdata('msg4');
?>
</div>
<?php } ?>

<div class="panel-body">
<div class="form align">
  <form class="cmxform form-horizontal tasi-form type_box_lab" id="signupForm" method="post" action="<?php echo base_url("Dashboard/addsetting")?>" enctype="multipart/form-data" >
      <div class="form-group ">
            <label for="firstname" class="control-label">Min booking charges (%)</label>
              <input class=" form-control number" id="title" name="title" type="text" placeholder="Enter Minimum Booking charges" value="<?php echo $setting[0]->min_booking_charge ?>" required="" />
      </div>








      <div class="form-group ">
      <label for="firstname" class="control-label">Set Buffer Time (in minutes)</label>
      <input class=" form-control number" id="title" name="time" type="text" placeholder="Set Minimum Buffer Time" value="<?php echo $setting[0]->buffer_time ?>" required="" />
      </div>

       <div class="form-group ">
      <label for="firstname" class="control-label">Referral Percentage(%)</label>
      <input class=" form-control number" id="refrralamount" name="refrralpercent" type="text" placeholder="Set Minimum Buffer Time" value="<?php echo $setting[0]->referal_percentage ?>" required="" />
      </div>


       <div class="form-group ">
      <label for="firstname" class="control-label">Referral Max Amount ($)</label>
      <input class=" form-control number" id="refrralamount" name="refrralamount" type="text" placeholder="Set Minimum Buffer Time" value="<?php echo $setting[0]->referal_amount ?>" required="" />
      </div>






<!--            <div class="form-group ">
      <label for="firstname" class="control-label">Loading Rate (per minutes)</label>
      <input class=" form-control number" id="loadingtime" name="loadingtime" type="text" placeholder="Set Minimum Buffer Time" value="<?php echo $setting[0]->loading_rate ?>" required="" />
      </div>

       <div class="form-group ">
      <label for="firstname" class="control-label">UnLoading Rate (per minutes)</label>
      <input class=" form-control number" id="unloadingtime" name="unloadingtime" type="text" placeholder="Set Minimum Buffer Time" value="<?php echo $setting[0]->unloading_rate ?>" required="" />
      </div>

       <div class="form-group ">
      <label for="firstname" class="control-label">Flight Charges</label>
      <input class=" form-control number" id="flightcharges" name="flightcharges" type="text" placeholder="Set Minimum Buffer Time" value="<?php echo $setting[0]->flight_charges ?>" required="" />
      </div>



       <div class="form-group ">
      <label for="firstname" class="control-label">Movers Charges</label>
      <input class=" form-control number" id="moverscharges" name="moverscharges" type="text" placeholder="Set Minimum Buffer Time" value="<?php echo $setting[0]->movers_charges ?>" required="" />
      </div> -->


         <div class="form-group ">
      <label for="firstname" class="control-label">GST Percentage</label>
      <input class=" form-control number" id="gst_percentage" name="gst_percentage" type="text" placeholder="Set GST percentage" value="<?php echo $setting[0]->gst_percentage ?>" required="" />
      </div>




       <div class="form-group ">
      <label for="firstname" class="control-label">Admin Percentage On Booking</label>
      <input class=" form-control number" id="adminpercentage" name="adminpercentage" type="text" placeholder="Set Admin Percentage" value="<?php echo $setting[0]->admin_percentage ?>" required="" />
      </div>



    <div class="form-group ">
    <label for="firstname" class="control-label">Ride Complete Buffer Time</label>
    <input class=" form-control number" id="move_complete_buffer_time" name="move_complete_buffer_time" type="text" placeholder="Set Ride completion Buffer Time" value="<?php echo $setting[0]->move_complete_buffer_time ?>" required="" />
    </div>


    <div class="highlight">

      <div class="form-group">
      <label for="firstname" class="control-label">Advance Booking Option</label>
      <br>







      <label>
    <input type="radio" class="radio" value="0" <?php if($setting[0]->type ==0){echo 'checked="checked"';}?> name="type" onclick="within1hour()" id="within1hour1"  />Within 1 Hour</label>


      <label>
      <input type="radio" class="radio" value="1" <?php if($setting[0]->type ==1){echo 'checked="checked"';}?>  name="type" onclick="withincurrentday()" id="withincurrentday1"  />Current Day</label>


      <label>
      <input type="radio" class="radio" value="2" <?php if($setting[0]->type !=0 && $setting[0]->type !=1){echo 'checked="checked"';}?> name="type" min="2" onclick="allcheck()"  id="allcheck12" />No. of Days
      </label>



      <!-- <div  <?php if($char[0]['is_exclusive']=="0") echo "style='display:none'"; ?> class="form-group users box-top" id="plantype12"> -->

      <div <?php if($setting[0]->type=='0' || $setting[0]->type=='1') echo "style='display:none'"; ?> class="form-group" id="abcdef">
      <label for="lastname" class="control-label">Enter Days</label>
      <input type="text" class='number' name="no_of_days" id="no_of_days" value="<?php
      if($setting[0]->type!=0 && $setting[0]->type!=1){
      echo $setting[0]->type;   } ?>">
      <p id="va" style="display: none">Please enter more then 1.</p>
      </div>



      </div>


    <div class="form-group">
      <label> Advance Booking Current Status</label>

        <?php if($setting[0]->type!=0 && $setting[0]->type!=1){
      ?>
      <br>


          <p> <?php echo $setting[0]->type ?> days Selected</p>


       <?php } ?>

           <?php if($setting[0]->type==1){
      ?>
      <br>

         <p>Current Day</p>


       <?php } ?>

       <?php if($setting[0]->type==0){
      ?>
      <br>

        <p>With in Hour </p>


       <?php } ?>

       </div>
       </div>







      <input type="hidden" value="<?php echo  $setting[0]->id; ?>" name="settingid" >

      <div class="form-group">
              <button class="btn btn-success submit" name="setting"  type="submit">Update</button>

      </div>
  </form>
</div>
</div>
</section>
</div>
</div>
<!-- page end-->
</section>
</section>
<!--main content end-->
<!--footer start-->
<?php
$this->load->view('templete/footer');
?>
<!--footer end-->


<!-- js placed at the end of the document so the pages load faster -->


<!--script for this page-->
<script src="<?php echo base_url("public/js/form-validation-script.js")?>"></script>


</body>
</html>
<script>
$(function() {
  $('.panel-body').on('keydown', '.number', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
})
</script>

<script type="text/javascript">
// $("#abcdef").hide();
</script>
<script type="text/javascript">
function withincurrentday() {
document.getElementById("withincurrentday1").checked = true;
$("#abcdef").hide();
$("#daysoption").hide();
$("#timeslots").hide();
}
function within1hour() {
document.getElementById("within1hour1").checked = true;
$("#abcdef").hide();
$("#daysoption").hide();
$("#timeslots").hide();
}
function allcheck() {
document.getElementById("allcheck12").checked = true;
$("#abcdef").show();

}
</script>
<script type="text/javascript">
$('.submit').click(function () {
var self = $('input[type="radio"]:checked');
var selValue = $('input[name=type]:checked').val();
// console.log(selValue);
// console.log(self);
// return false;
if (selValue==2) {
var abc=$('#no_of_days').val();
// alert(abc);
// return false;

if (abc<2) {
$("#va").show();
return false;
}
}
});
</script>
<script>

jQuery(document).ready(function($) {
    var max = 4;
    $('.number').keypress(function(e) {
        if (e.which < 0x20) {
            // e.which < 0x20, then it's not a printable character
            // e.which === 0 - Not a character
            return;     // Do nothing
        }
        if (this.value.length == max) {
            e.preventDefault();
        } else if (this.value.length > max) {
            // Maximum exceeded
            this.value = this.value.substring(0, max);
        }
    });
}); //end if ready(fn)
</script>
