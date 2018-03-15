
<style type="text/css">
.btn-primaryi {
  background-color: #41cac0!important;
  border-color: #41cac0!important;
  color: #ffffff!important;
}

</style>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
  <section class="wrapper site-min-height">
    <!-- page start-->
    <div class="row">
      <div class="col-lg-12">
        <section class="panel">
          <header class="panel-heading">
           Booking List
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
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Pending Booking</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Active Booking</a></li>
              <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Completed Booking</a></li>
              <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Cancelled Booking</a></li>
            </ul>
            <!-- Tab panes -->
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
                    <th>Vechicle Name</th>
                    <th>Move Name</th>
                    <th>Receipt Number</th>
                    <th>Pick Up Location</th>
                    <th>Destination Location</th>
                    <th>Estimated Price</th>
     
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
                      <?php echo $value->booked_id; ?>
                    </td>


                    <td>
                      <?php 
                      if (isset($value->fname)) {
                                           
                        echo $value->fname." ".$value->lname; 
                      }
                      else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php echo  $value->vehiclename; ?>
                    </td>
                    <td>
                      <?php 
                      if (!empty($value->title)) {
                        echo $value->title; 
                      }
                      else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php 
                      if (!empty($value->receipt_number)) {
                        echo $value->receipt_number; 
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
       
          
                    <a href="<?php echo base_url("Dashboard/booking_detail/$value->booked_id")?>">
                    <input type="submit" value="Details" class="btn btn-primary prim blok_btn responsive" id="<?php echo $value->booked_id;?>"></input>

                    </a>


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
                    <th>Vechicle Name</th>
                    <th>Move Name</th>
                    <th>Receipt Number</th>
                    <th>Pick Up Location</th>
                    <th>Destination Location</th>
                    <th>Estimated Price</th>
             
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                foreach ($started_booking_list as $key => $value) {
                  

                  ?>
                  <tr id ='hello<?php echo $value->booked_id; ?>'> 
                    <td>
                      <?php echo $i; ?>
                    </td>


                            <td>
                      <?php echo $value->booked_id; ?>
                    </td>



                    <td>
                      <?php 
                      if (isset($value->fname)) {
                                            // $name=$this->db->query()
                        echo $value->fname." ".$value->lname; 
                      }
                      else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php echo  $value->vehiclename; ?>
                    </td>
                    <td>
                      <?php 
                      if (!empty($value->title)) {
                        echo $value->title; 
                      }
                      else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php 
                      if (!empty($value->receipt_number)) {
                        echo $value->receipt_number; 
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
                 
          
                    <a href="<?php echo base_url("Dashboard/booking_detail/$value->booked_id")?>">
                    <input type="submit" value="Details" class="btn btn-primary prim blok_btn responsive" id="<?php echo $value->booked_id;?>"></input>
                    </a>
                      


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
                    <th>Vechicle Name</th>
                    <th>Move Name</th>
                    <th>Receipt Number</th>
                    <th>Pick Up Location</th>
                    <th>Destination Location</th>
                    <th>Estimated Price</th>
              
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                foreach ($completed_booking_list as $key => $value) {
   

                  ?>
                  <tr id ='hello<?php echo $value->booked_id; ?>'> 
                    <td>
                      <?php echo $i; ?>
                    </td>


                    <td>
                      <?php echo $value->booked_id; ?>
                    </td>



                    <td>
                      <?php 
                      if (isset($value->fname)) {
                                           
                        echo $value->fname." ".$value->lname; 
                      }
                      else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php echo  $value->vehiclename; ?>
                    </td>
                    <td>
                      <?php 
                      if (!empty($value->title)) {
                        echo $value->title; 
                      }
                      else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php 
                      if (!empty($value->receipt_number)) {
                        echo $value->receipt_number; 
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
              
          
                    <a href="<?php echo base_url("Dashboard/booking_detail/$value->booked_id")?>">
                    <input type="submit" value="Details" class="btn btn-primary prim blok_btn responsive" id="<?php echo $value->booked_id;?>"></input>
                    </a>


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
              <div role="tabpanel" class="tab-pane" id="settings">    <div class="panel-body">
          <div class="adv-table">
            <div class="table-responsive">
              <table  class="display table table-bordered table-striped example" id="example">
                <thead>
                  <tr>
                    <th>Sr.No.</th>
                          <th>Trip Id</th>
                    <th>User Name</th>
                    <th>Vechicle Name</th>
                    <th>Move Name</th>
                    <th>Receipt Number</th>
                    <th>Pick Up Location</th>
                    <th>Destination Location</th>
                    <th>Estimated Price</th>
          
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                foreach ($cancelled_booking_list as $key => $value) {
               

                  ?>
                  <tr id ='hello<?php echo $value->booked_id; ?>'> 
                    <td>
                      <?php echo $i; ?>
                    </td>


                      <td>
                      <?php echo $value->booked_id; ?>
                    </td>



                    <td>
                      <?php 
                      if (isset($value->fname)) {
                                     
                        echo $value->fname." ".$value->lname; 
                      }
                      else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php echo  $value->vehiclename; ?>
                    </td>
                    <td>
                      <?php 
                      if (!empty($value->title)) {
                        echo $value->title; 
                      }
                      else{
                        echo "N\A";
                      }  ?>
                    </td>
                    <td>
                      <?php 
                      if (!empty($value->receipt_number)) {
                        echo $value->receipt_number; 
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
  
          
                    <a href="<?php echo base_url("Dashboard/booking_detail/$value->booked_id")?>">
                    <input type="submit" value="Details" class="btn btn-primary prim blok_btn responsive" id="<?php echo $value->booked_id;?>"></input>
                    </a>


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
                            <form role="form" name="assignProvider" method="POST" action="serviceRequest" enctype="multipart/form-data">
                                <div id="assignProvider"></div>
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
   $('#myModal').on('show.bs.modal', function(e) {
    var userid = $(e.relatedTarget).data('id');
    var fname = $(e.relatedTarget).data('fname');
    var lname = $(e.relatedTarget).data('lname');

    document.getElementById('hiddid').value = userid;
    document.getElementById('fname').value = fname;
    document.getElementById('lname').value = lname;

    


  });

 });
 
</script>
<script> 
 $(document).ready(function(){

   $(".delete").click(function(event){
    var result = confirm("Are you Sure to delete?");
    if (result) {

     var id = $(this).attr("id");  

     $.ajax({
      type: "POST",
      url: "<?php echo base_url("Dashboard/deletebooking")?>",
      data: {id:id},
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
                    alert('cannot delete the id');
                  }


                }
              });

     event.preventDefault();
   }
   else{

   }
 })


     $(".end").click(function(event){
    var result = confirm("Are you sure to end this Booking ?");
    if (result) {

     var id = $(this).attr("id");  

     $.ajax({
      type: "POST",
      url: "<?php echo base_url("Dashboard/end")?>",
      data: {id:id},
      success: function(response) {
                   // console.log(response);return false;
                   if (response == true)
                   {
                    alert("Sucessfully ended booking");
                    // $("#hello"+id).slideUp(100, function() {
                    //   $(this).remove();
                    // });

                     window.setTimeout(function(){
                     window.location.href = "http://movers.com.au/Admin/Dashboard/booking_list";
                      }, 3000);




                  }
                  else if(response == false)
                  {
                    alert("Error");
                  } 
                  else{
                    alert('Cannot End the Booking ');
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
  function MoveListing(type,id){
  var page = 1;
$.ajax({
        method:'POST',
        url: 'http://movers.com.au/Admin/api/User/yourMoveList',
        data:'user_id='+id+'&type='+type+'&page='+page,
        dataType: 'json',
        success:function(result){   
      $data = result;
        //alert(result.ResponseCode);return false;  
      if(result.ResponseCode == true){
        $.ajax({
          method:'POST',
          url: $base_url+'/App/yourMoveListData',
          data:'data='+JSON.stringify(result)+'&mytype='+type,
          //dataType: 'json',
          success:function(result){ 
          $('#myTable tbody').html(result);   
          }
          });
  
          }else
             {  //alert(result.ResponseCode);
        $('#myTable tbody').html('No Data Found In The Table');
          }
                    }
               });
  
}
</script>
