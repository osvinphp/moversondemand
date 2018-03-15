<style type="text/css">
.btn-primaryi {
  background-color: #41cac0!important;
  border-color: #41cac0!important;
  color: #ffffff!important;
}

</style>

<section id="main-content">
  <section class="wrapper site-min-height">
    <!-- page start-->
    <div class="row">
      <div class="col-lg-12">
        <section class="panel">
          <header class="panel-heading">
           Dispatch Management
         </header>
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

          <div class="row CUSTOM_TAB">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Pending Booking</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Late Booking</a></li>
              <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Delayed Booking</a></li>

            </ul>

            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="home">
        <div class="panel-body">
          <div class="adv-table">
            <div class="table-responsive">
              <table  class="display table table-bordered table-striped example" id="example">
                <thead>
                  <tr>

                    <th>Sr.No.</th>
                    <th>Trip Id</th>
                    <th>User Name</th>
                    <th>Pick Up Location</th>
                    <th>Destination Location</th>
                    <th>Estimate Price</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                foreach ($pending_booking_list as $key => $value) {
                  ?>
                  <tr id ='hello<?php echo $value->booked_id; ?>'>
                    <td>
                      <?php echo $i; ?>
                    </td>

                    <td>
                    <?php
                           echo $value->booked_id;
                           ?>
                    </td>


                    <td>


                    <a href=" <?php echo base_url('Dashboard/userDetail').'/'.$value->user_id; ?>">


                      <?php
                      if (isset($value->fname)) {

                        echo $value->fname." ".$value->lname;
                      }
                      else{
                        echo "N\A";
                      }  ?>
                    </td>


                    <td>
                      <?php
                      if (!empty($value->pickup_loc)) {
                       echo $value->pickup_loc;}
                       else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php
                      if (!empty($value->destination_loc)) {
                       echo $value->destination_loc;}
                       else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php
                      if (!empty($value->estimate_price)) {
                       echo $value->estimate_price;}
                       else{
                        echo "N\A";
                      }  ?>
                    </td>

                  <td>

          <!-- <a href="#assignModal" data-toggle="modal" class="btn freeProviders responsive btn-primaryi " reqid="<?php echo $value->booked_id; ?>" userId="<?php echo $value->user_id; ?>">Assign</a> -->

           <a href="<?php echo base_url("Dashboard/dispatchbooking_detail/$value->booked_id")?>">
                    <input type="submit" value="Details" class="btn btn-primary prim blok_btn responsive" id="<?php echo $value->booked_id;?>"></input>
                    </a>


           <button type="button" class="cancel btn btn-danger responsive" id="<?php echo $value->booked_id;?>" >Cancel & Refund</button>

                  </td>
                </tr>


                <?php
                $i++;
              }
              ?>
            </tbody>

          </table>
        </div>
        </div>
        </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="profile">    <div class="panel-body">
          <div class="adv-table">
            <div class="table-responsive">
              <table  class="display table table-bordered table-striped example" id="example">
                <thead>
                  <tr>
                    <th>Sr.No.</th>
                           <th>Trip Id</th>
                    <th>User Name</th>
                    <th>Driver Name</th>


                    <th>Pick Up Location</th>
                    <th>Destination Location</th>
                    <th>Estimate Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                foreach ($late_booking_list as $key => $value) {
                   // echo "<pre>"; print_r($late_booking_list);die();

                  ?>
                  <tr id ='hello<?php echo $value->booked_id; ?>'>
                    <td>
                      <?php echo $i; ?>
                    </td>


                      <td>
                    <?php
                           echo $value->booked_id;
                           ?>
                    </td>



                    <td>

                     <a href=" <?php echo base_url('Dashboard/userDetail').'/'.$value->user_id; ?>">
                      <?php
                      if (isset($value->fname)) {

                        echo $value->fname." ".$value->lname;
                      }
                      else{
                        echo "N\A";
                      }  ?>
                      </a>
                    </td>


                       <td>


                      <?php
                        $query=$this->db->query("SELECT * from tbl_users where id='".$value->driver_id."'")->result();
                        ?>

                       <a href=" <?php echo base_url('Dashboard/driverDetail').'/'.$query[0]->id; ?>">
                                  <?php         echo $query[0]->fname." ".$query[0]->lname;
                      ?>
                      </a>
                    </td>



                    <td>
                      <?php
                      if (!empty($value->pickup_loc)) {
                       echo $value->pickup_loc;}
                       else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php
                      if (!empty($value->destination_loc)) {
                       echo $value->destination_loc;}
                       else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php
                      if (!empty($value->estimate_price)) {
                       echo $value->estimate_price;}
                       else{
                        echo "N\A";
                      }  ?>
                    </td>


                  <td>

                      <!-- <button type="button" class="end btn btn-primaryi responsive" id="<?php echo $value->booked_id;?>" >End</button> -->


                  <a href="<?php echo base_url("Dashboard/dispatchbooking_detail/$value->booked_id")?>">
                    <input type="submit" value="Details" class="btn btn-primary prim blok_btn responsive" id="<?php echo $value->booked_id;?>"></input>
                    </a>
  <button type="button" class="cancel btn btn-danger responsive" id="<?php echo $value->booked_id;?>" >Cancel & Refund</button>

              <button type="button" class="btn btn-info responsive" data-toggle="modal" data-target="#trackModal" data-userno="<?php echo $value->userno[0]->userno;?>" data-useremail="<?php echo $value->userno[0]->useremail;?>" data-driverno="<?php echo $value->driverno[0]->driverno;?>" data-driveremail="<?php echo $value->driverno[0]->driveremail;?>" >Contact Driver & Customer</button>


                  </td>
                </tr>

                <?php
                $i++;
              }
              ?>
            </tbody>

          </table>
        </div>
        </div>
        </div></div>
              <div role="tabpanel" class="tab-pane" id="messages">    <div class="panel-body">
          <div class="adv-table">
            <div class="table-responsive">
              <table  class="display table table-bordered table-striped example" id="example">
                <thead>
                  <tr>
                    <th>Sr.No.</th>

                           <th>Trip Id</th>
                    <th>User Name</th>
                    <th>Driver Name</th>
                    <th>Pick Up Location</th>
                    <th>Destination Location</th>
                    <th>Estimate Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                foreach ($delayed_booking_list as $key => $value) {
                  // echo "<pre>";  print_r($delayed_booking_list);die();

                  ?>
                  <tr id ='hello<?php echo $value->booked_id; ?>'>
                    <td>
                      <?php echo $i; ?>
                    </td>


                      <td>
                    <?php
                           echo $value->booked_id;
                           ?>
                    </td>



                  <td>

                     <a href=" <?php echo base_url('Dashboard/userDetail').'/'.$value->user_id; ?>">
                      <?php
                      if (isset($value->fname)) {
                                            // $name=$this->db->query()
                        echo $value->fname." ".$value->lname;
                      }
                      else{
                        echo "N\A";
                      }  ?>
                      </a>
                    </td>


                       <td>
                      <?php
                        $query=$this->db->query("select * from tbl_users where id=".$value->driver_id)->result();
                        ?>
                       <a href=" <?php echo base_url('Dashboard/driverDetail').'/'.$query[0]->id; ?>">
                                  <?php echo $query[0]->fname." ".$query[0]->lname;
                      ?>
                      </a>
                    </td>



                    <td>
                      <?php
                      if (!empty($value->pickup_loc)) {
                       echo $value->pickup_loc;}
                       else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php
                      if (!empty($value->destination_loc)) {
                       echo $value->destination_loc;}
                       else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php
                      if (!empty($value->estimate_price)) {
                       echo $value->estimate_price;}
                       else{
                        echo "N\A";
                      }  ?>
                    </td>


                  <td>


                    <button type="button" class="end btn btn-primaryi responsive end" id="<?php echo $value->booked_id;?>" >End move</button>


                  <!--     <button type="button" class="btn btn-success responsive" data-toggle="modal" data-target="#endmodal" data-userid="<?php echo $value->user_id;?>" data-estimatefare="<?php echo $value->estimated_price;?>" data-bookid="<?php echo $value->booked_id;?>" data-driverid="<?php echo $value->driver_id;?>" >End Move</button> -->



                     <a href="<?php echo base_url("Dashboard/dispatchbooking_detail/$value->booked_id")?>">
                    <input type="submit" value="Details" class="btn btn-primary prim blok_btn responsive" id="<?php echo $value->booked_id;?>"></input>
                    </a>


                         <button type="button" class="btn btn-info responsive" data-toggle="modal" data-target="#trackModal" data-userno="<?php echo $value->userno[0]->userno;?>" data-useremail="<?php echo $value->userno[0]->useremail;?>" data-driverno="<?php echo $value->driverno[0]->driverno;?>" data-driveremail="<?php echo $value->driverno[0]->driveremail;?>" >Contact Driver & Customer</button>



                  </td>
                </tr>

                <?php
                $i++;
              }
              ?>
            </tbody>

          </table>
        </div>
        </div>
        </div></div>

        </div>
        </div></div>
            </div>
          </div>



      </div>
    </div>
  </section>
</div>
</div>
<!-- page end-->
</section>
</section>
<!-- popup start-->
      <div class="panel-body">
            <div aria-hidden="true" aria-labelledby="assignModalLabel" role="dialog" tabindex="-1" id="assignModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Assign Provider</h4>
                        </div>



                        <div class="modal-body">
                            <form role="form" name="assignProvider" method="POST" action="serviceRequest2" enctype="multipart/form-data">
                                <div id="assignProvider"></div>
                            </form>
                        </div>



                    </div>
                </div>
            </div>
        </div>
<!--popup end-->

<!-- popup start-->
      <div class="panel-body">
            <div aria-hidden="true" aria-labelledby="trackModalLabel" role="dialog" tabindex="-1" id="trackModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Contact Detail</h4>
                        </div>
                        <div class="modal-body">
                          <div class="form-group type_box lables">

                        <div class="col-lg-12">
                        <label>User Contact No</label>
                        <input type="text"  class="form-control" id="hiddid"  name="fname" value="" readonly>
                        </div>


                         <div class="col-lg-12">

                         <label>User Email</label>


                          <input  class="form-control" id="fname" type="text"  name="lname" value="" readonly >
                          <button class="senduser btn-info">Send Mail</button>

                        </div>

                        <div class="col-lg-12">

                         <label>Driver Contact No</label>
                          <input  class="form-control" id="lname"  name="lname" value="" readonly >

                        </div>

                         <div class="col-lg-12">

                         <label>Driver Email</label>
                        <input  class="form-control" id="driveremail"  type="text" name="lname" value=''  readonly >

                        <button class="senddriver btn-info">Send Mail</button>
                        </div>


                      </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--popup end-->


<!-- popup start-->
      <div class="panel-body">
            <div aria-hidden="true" aria-labelledby="trackModalLabel" role="dialog" tabindex="-1" id="endmodal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">Contact Detail</h4>
                        </div>
                        <div class="modal-body">

                        <form class="form-horizontal" id="default" method="POST" action="<?php echo base_url("Dashboard/end")?>" enctype="multipart/form-data">
                          <div class="form-group type_box lables">



                         <div class="col-lg-12">
                         <label>Estimated Fare</label>
                        <input type="text" class="form-control" id="endestimatedfare"  name="estfare" value="" >
                        </div>

                        <div class="col-lg-12">
                         <label>Extra Fare</label>
                        <input type="text"  class="form-control" id="extrafare"  name="extrafare" value="" >
                        </div>


                      </div>


                        <input type="hidden" name= "submitid" id='endbookingid' value=""/>

                        <input type="hidden" name= "enddriverid" id='enddriverid' value=""/>

                        <input type="hidden" name= "enduserid" id='enduserid' value=""/>


                      <button  type="submit" class="btn btn-info editdata submit"  >Submit</button>
                    </form>



                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--popup end-->
<!--main content end-->
<!--footer start-->
<?php
$this->load->view('templete/footer');
?>
<!--footer end-->

<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>public/img/demo_wait.gif' width="64" height="64" />
    <br>Processing...</div>

</body>
</html>

<script type="text/javascript">
 $(document).ready(function() {
   $('#trackModal').on('show.bs.modal', function(e) {
    var userid = $(e.relatedTarget).data('userno');
    var fname = $(e.relatedTarget).data('useremail');
    var lname = $(e.relatedTarget).data('driverno');
    var driveremail = $(e.relatedTarget).data('driveremail');
    document.getElementById('hiddid').value = userid;
    document.getElementById('fname').value = fname;
    document.getElementById('lname').value = lname;
      document.getElementById('driveremail').value = driveremail;

  });
 });
</script>


<script type="text/javascript">
 $(document).ready(function() {
   $('#endmodal').on('show.bs.modal', function(e) {
    var userid = $(e.relatedTarget).data('userid');
    var estimatedfare = $(e.relatedTarget).data('estimatefare');
    var driverid = $(e.relatedTarget).data('driverid');
    var bookid = $(e.relatedTarget).data('bookid');
    document.getElementById('enduserid').value = userid;
    document.getElementById('enddriverid').value = driverid;
    document.getElementById('endbookingid').value = bookid;
      document.getElementById('endestimatedfare').value = estimatedfare;
  });
 });
</script>



<script>
 $(document).ready(function(){

/* js for Track button */
  $(".track").click(function(event){
    var result = confirm("are you sure you want to Track");
    if (result) {

     var id = $(this).attr("id");

     $.ajax({
      type: "POST",
      url: "<?php echo base_url("Dashboard/track")?>",
      data: {id:id},
      success: function(response) {
                   // console.log(response);return false;
                   if (response == true)
                   {
                    alert('done');

                  }
                  else if(response == false)
                  {
                    alert("Error");
                  }
                  else{
                    alert('could not track');
                  }


                }
              });

     event.preventDefault();
   }
   else{

   }
 })

  /* for contact driver and contact customer */
 //  $(".contact").click(function(event){
 //    var result = confirm("are you sure you want to contact");
 //    if (result) {

 //     var id = $(this).attr("id");

 //     $.ajax({
 //      type: "POST",
 //      url: "<?php echo base_url("Dashboard/contact_driver_customer")?>",
 //      data: {id:id},
 //      success: function(response) {
 //        // alert(response);
 //                   // console.log(response);return false;
 //                   if (response == true)
 //                   {
 //                    alert('done');

 //                  }
 //                  else if(response == false)
 //                  {
 //                    alert("Error");
 //                  }
 //                  else{
 //                    alert('cannot contact');
 //                  }


 //                }
 //              });

 //     event.preventDefault();
 //   }
 //   else{

 //   }
 // })

    /* js for Cancel and Refund button */
  $(".cancel").click(function(event){
    var result = confirm("are you sure you want to cancel");
    if (result) {
     var id = $(this).attr("id");
     $.ajax({
      type: "POST",
      url: "<?php echo base_url("Dashboard/cancel_refund")?>",
      data: {id:id},
      success: function(response) {
                   // console.log(response);return false;
                   if (response == true)
                   {
                    window.location.href = '<?php echo base_url("Dashboard/dispatch_management")?>';

                  }
                  else if(response == false)
                  {
                    alert("Error");
                  }
                  else{
                    alert('cannot cancel');
                  }


                }
              });

     event.preventDefault();
   }
   else{

   }
 })

/* js for Delete button*/
   $(".delete").click(function(event){
    var result = confirm("Are you Sure to delete?");
    if (result) {

     var id = $(this).attr("id");

     $.ajax({
      type: "POST",
      url: "<?php echo base_url("Dashboard/deletebooking")?>",
      data: {
        id:id,
      },
      success: function(response) {
                   // console.log(response);return false;
                   if (response == true)
                   {
                    $("#hello"+id).slideUp(100, function() {
                      $(this).remove();
                    });

                  }
                  else if(response == false)
                  {
                    alert("Error");
                  }
                  else{
                    alert('cannot delete the booking');
                  }


                }
              });

     event.preventDefault();
   }
   else{

   }
 })

/* for End button */
     $(".end").click(function(event){
    var result = confirm("Are you sure to end this Booking ?");
    if (result) {
     var id = $(this).attr("id");
     $.ajax({
      type: "POST",
      url: "<?php echo base_url("Dashboard/end")?>",
      data: {id:id},
      success: function(response) {
                   console.log(response);return false;
                   if (response == true)
                   {
                     window.location.href = '<?php echo base_url("Dashboard/dispatch_management")?>';
                  }
                  else if(response == false)
                  {
                    alert("Error");
                  }
                  else{
                    alert('cannot end the booking');
                  }

                }
              });

     event.preventDefault();
   }
   else{

   }
 })


       $("body").delegate(".freeProviders", "click", function() {
        var reqid = $(this).attr('reqid');
        var userId = $(this).attr('userId');
        // console.log(reqid);
        $.ajax({
            type: 'post',
            url: 'assign',
            dataType: 'json',
            data: {
                reqid: reqid,
                userId: userId
            },
            cache: false,
            beforeSend: function() {
                $("#wait").css("display", "none");
                $("#wait").css("display", "block");
                $(document.body).css({
                    'cursor': 'wait'
                });

                $("#assignProvider").empty();
                $("#assignProvider").append("Loading...");
            },
            success: function(data) {
                // console.log(data);
                $("#assignProvider").empty();
                $("#assignProvider").append(data);
            },
            complete: function() {
                $("#wait").css("display", "none");
                $(document.body).css({
                    'cursor': 'default'
                });
            },
            error: function(request, status, error) {}
        });

    });

 });





</script>
<script type="text/javascript">


$('.senduser').click(function() {
var email= $("#fname").val();

    var mailto_link = 'mailto:' + email ;

    win = window.open(mailto_link, 'emailWindow');
    if (win && win.open && !win.closed) win.close();

});

$('.senddriver').click(function() {
var email= $("#driveremail").val();

    var mailto_link = 'mailto:' + email ;

    win = window.open(mailto_link, 'emailWindow');
    if (win && win.open && !win.closed) win.close();

});
</script>
