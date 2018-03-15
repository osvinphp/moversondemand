
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
               Trips List
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
              <li role="presentation" class="active">
              <a href="#home" aria-controls="home" role="tab" data-toggle="tab" >Daily Trips</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" >Weekly Trips</a>
              </li>
              <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab" >Monthly Trips</a></li>
               <li role="presentation"><a href="#all" aria-controls="all" role="tab" data-toggle="tab" >All Trips</a></li>
            
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
                                          <th>User ID</th>
                                              <th>Trip Id</th>
                                          <th>Amount</th>
                                          <th>Pick Up Location</th>
                                          <th>Drop off Location</th>
                                          <th>Date Created</th>
                                          <th>Action</th>
                                      </tr>
                                      </thead>
                                       <?php
                                       $i=1;
                                       foreach ($dailytrips as $key => $value) {
                                        // print_r($value);
                            
                                        ?>
                                        <tr id ='hello<?php echo $value->deleteid; ?>'> 
                                        <td>
                                          <?php echo $i; ?>
                                        </td>
                                        <td>
                                          <?php 
                                           if (isset($value->user_id)) {
                                          echo $value->user_id; 
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                
                                           <td>
                                          <?php 
                                           if (!empty($value->id)) {
                                          echo $value->id; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                           <td>
                                          <?php 
                                           if (!empty($value->estimate_price)) {
                                          echo $value->estimate_price; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                               <td>
                                          <?php 
                                           if (!empty($value->pickup_loc)) {
                                          echo $value->pickup_loc; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                                     <td>
                                          <?php 
                                           if (!empty($value->destination_loc)) {
                                          echo $value->destination_loc; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                        
                                        
                                        <td>
                                                <?php $date= $value->date_created;
                                          echo date("F d, Y", strtotime($date));?>
                                        </td>
                                    <td>                 
                    <a href="<?php echo base_url("Dashboard/tripdetail/$value->id")?>">
                    <input type="submit" value="Details" class="btn btn-primary prim blok_btn responsive" id="<?php echo $value->id;?>"></input>
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
                                          <th>User ID</th>
                                             <th>Trip Id</th>
                                          <th>Amount</th>
                                          <th>Pick Up Location</th>
                                          <th>Drop off Location</th>
                                          <th>Date Created</th>
                                          <th>Action</th>
                                      </tr>
                                      </thead>
                                       <?php
                                       $i=1;
                                       foreach ($weektrips as $key => $value) {
                                        // print_r($value);die();
                                        ?>
                                                       <tr id ='hello<?php echo $value->deleteid; ?>'> 
                                        <td>
                                          <?php echo $i; ?>
                                        </td>
                                        <td>
                                          <?php 
                                           if (isset($value->user_id)) {
                                          echo $value->user_id; 
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                
                                           <td>
                                          <?php 
                                           if (!empty($value->id)) {
                                          echo $value->id; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                           <td>
                                          <?php 
                                           if (!empty($value->estimate_price)) {
                                          echo $value->estimate_price; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                               <td>
                                          <?php 
                                           if (!empty($value->pickup_loc)) {
                                          echo $value->pickup_loc; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                                     <td>
                                          <?php 
                                           if (!empty($value->destination_loc)) {
                                          echo $value->destination_loc; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                        
                                        
                                        <td>
                                                <?php $date= $value->date_created;
                                          echo date("F d, Y", strtotime($date));?>
                                        </td>
                                         <td>                 
                    <a href="<?php echo base_url("Dashboard/tripdetail/$value->id")?>">
                    <input type="submit" value="Details" class="btn btn-primary prim blok_btn responsive" id="<?php echo $value->id;?>"></input>
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
                                          <th>User ID</th>
                                            <th>Trip Id</th>
                                          <th>Amount</th>
                                          <th>Pick Up Location</th>
                                          <th>Drop off Location</th>
                                          <th>Date Created</th>
                                          <th>Action</th>
                                      </tr>
                                      </thead>
                                       <?php
                                       $i=1;
                                       foreach ($monthtrips as $key => $value) {
                                        // print_r($value);die();
                                        ?>
      <tr id ='hello<?php echo $value->deleteid; ?>'> 
                                        <td>
                                          <?php echo $i; ?>
                                        </td>
                                        <td>
                                          <?php 
                                           if (isset($value->user_id)) {
                                          echo $value->user_id; 
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                
                                           <td>
                                          <?php 
                                           if (!empty($value->id)) {
                                          echo $value->id; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                           <td>
                                          <?php 
                                           if (!empty($value->estimate_price)) {
                                          echo $value->estimate_price; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                               <td>
                                          <?php 
                                           if (!empty($value->pickup_loc)) {
                                          echo $value->pickup_loc; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                                     <td>
                                          <?php 
                                           if (!empty($value->destination_loc)) {
                                          echo $value->destination_loc; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                        
                                        
                                        <td>
                                                <?php $date= $value->date_created;
                                          echo date("F d, Y", strtotime($date));?>
                                        </td>
                                          <td>                 
                    <a href="<?php echo base_url("Dashboard/tripdetail/$value->id")?>">
                    <input type="submit" value="Details" class="btn btn-primary prim blok_btn responsive" id="<?php echo $value->id;?>"></input>
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
              <div role="tabpanel" class="tab-pane" id="all">    <div class="panel-body">
          <div class="adv-table">
            <div class="table-responsive">
              <table  class="display table table-bordered table-striped example" id="example">
                                      <thead>
                                      <tr>
                                                                      <th>Sr.No.</th>
                                          <th>User ID</th>
                                           <th>Trip Id</th>
                                          <th>Amount</th>
                                          <th>Pick Up Location</th>
                                          <th>Drop off Location</th>
                                          <th>Date Created</th>
                                          <th>Action</th>
                                      </tr>
                                      </thead>
                                       <?php
                                       $i=1;
                                       foreach ($alltrips as $key => $value) {
                                        // print_r($value);die();
                                        ?>
                                             <tr id ='hello<?php echo $value->deleteid; ?>'> 
                                        <td>
                                          <?php echo $i; ?>
                                        </td>
                                        <td>
                                          <?php 
                                           if (isset($value->user_id)) {
                                          echo $value->user_id; 
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                
                                           <td>
                                          <?php 
                                           if (!empty($value->id)) {
                                          echo $value->id; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                           <td>
                                          <?php 
                                           if (!empty($value->estimate_price)) {
                                          echo $value->estimate_price; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                               <td>
                                          <?php 
                                           if (!empty($value->pickup_loc)) {
                                          echo $value->pickup_loc; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                                     <td>
                                          <?php 
                                           if (!empty($value->destination_loc)) {
                                          echo $value->destination_loc; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                        
                                        
                                        <td>
                                                <?php $date= $value->date_created;
                                          echo date("F d, Y", strtotime($date));?>
                                        </td>
                       <td>                 
                    <a href="<?php echo base_url("Dashboard/tripdetail/$value->id")?>">
                    <input type="submit" value="Details" class="btn btn-primary prim blok_btn responsive" id="<?php echo $value->id;?>"></input>
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
    </div>
  </section>
</div>
</div>
<!-- page end-->
</section>
</section>
<!-- popup start-->

<!--popup end-->
<!--main content end-->
<!--footer start-->
<?php 
$this->load->view('templete/footer');
?>
<!--footer end-->


</body>
</html>

 <script> 
 $(document).ready(function(){

   $(".delete").click(function(event){
        var result = confirm("Are you Sure to delete?");
        if (result) {

         var id = $(this).attr("id");  

         $.ajax({
          type: "POST",
          url: "<?php echo base_url("Dashboard/deletetxn")?>",
          data: {id:id},
          success: function(response) {
                  if (response == true)
                  {
                    $("#hello"+id).slideUp(100, function() {
                      $(this).remove();
                    });

                  }
                  else if(response == false)
                  {
                    alert("Error");
                  } else{
                    alert('cannot delete the id');
                  }
      
           }
         });

         event.preventDefault();
       }
       else{

       }
       })
 });
</script>


  