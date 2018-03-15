
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Drivers List
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
                          <div class="panel-body">
                                <div class="adv-table">
                                    <table  class="display table table-bordered table-striped example" id="example">
                                      <thead>
                                      <tr>
                                          <th>Sr.No.</th>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Phone</th>
                                           <th>City Selcted</th>
                                          <th>Vehicle Name</th>
                                          <th style="width:230px;">Vehicle Image</th>
                               
                                 
                                          <th>Date Created</th>
                                          <th>Action</th>
                                      </tr>
                                      </thead>
                                       <?php
                                       $i=1;
                                       foreach ($drivers as $key => $value) {
                                        // $abc= ($value->located_at); 
                                        //   print_r(unserialize($abc));
                                        // print_r($value);
                                    
                                        ?>
                                        <tr id ='hello<?php echo $value->id; ?>'> 
                                        <td>
                                          <?php echo $i; ?>
                                        </td>
                                        <td>
                                          <?php 
                                           if (isset($value->fname)) {
                                          echo $value->fname." ". $value->lname; 
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                        <td>
                                          <?php echo  $value->email; ?>
                                        </td>
                                           <td>
                                          <?php 
                                           if (!empty($value->phone)) {
                                          echo $value->country_code." ". $value->phone; 
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>

                                       <td>
                                         
                                          <?php 
                                     
                                          $abc= unserialize($value->located_at); 
                                          // print_r(($abc));
                                          // die;
                                          $aa=array();
                                          foreach ($abc as $key => $value1) {
                                            // print_r($value1);
                                            $as=$this->db->query("SELECT * from tbl_cities where id='".$value1."'")->row();
                                            // print_r($as);
                                            $aa[]=$as->city_name;
                                          }
                                          // print_r($aa);
                                          echo(implode(',',$aa));


                                         ?>

                                       </td>


                                          <td>
                                         
                                          <?php 
                                           if (!empty($value->name)) {
                                          echo $value->name; 
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>

                                       </td>


                                           <td class="image_setting" >
                                      
                                      <img src="<?php echo $value->icon;?>">
                                        </td>




                                        
                                        <td>
                                                <?php $date= $value->date_created;
                                          echo date("F d, Y", strtotime($date));?>
                                        </td>
                                        <td>                 
                                         <button type="button" class="btn btn-info deleteAction responsive" data-toggle="modal" data-target="#myModal" data-id="<?php echo $value->id; ?>" data-fname="<?php echo $value->fname; ?>" data-lname="<?php echo $value->lname; ?>" >Edit</button>
                                          <button type="button" class="delete btn btn-danger responsive" id="<?php echo $value->id;?>" >Delete</button>

                                          <a class="btn btn-warning responsive" href="<?php echo base_url("Dashboard/listdriverDetail/").$value->id; ?>">Detail</a>

                                          <?php if (empty($value->password)){?>                                          
                                              <button type="button" class="activatefirst btn btn-info responsive" id="<?php echo $value->id;?>" >Activate Driver</button>
                                               <?php } 
                                        else{ ?>

                                          <button type="button" class=" btn btn-info responsive" id="<?php echo $value->id;?>" >Activated Driver</button>
                                          <?php } ?>


                                      <?php if ($value->is_suspend==0) { ?>
                                           <button type="button" class="deactivate btn btn-success responsive" id="<?php echo $value->id;?>" >Deactivate</button>
                                      <?php }
                                        else{ ?>

                                          <button type="button" class="activate btn btn-success responsive" id="<?php echo $value->id;?>" >Activate</button>



                                      <?php   }  ?>
                                    
                                  
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
                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!-- popup start-->
        <div class="panel-body">
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Update Your Detail Here</h4>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" id="default" method="POST" action="<?php echo base_url("Dashboard/driver_list")?>">
                      <div class="form-group type_box lables">
                       
                        <div class="col-lg-12">
                        <label>First Name:</label>
                          <input type="text"  class="form-control" id="fname"  name="fname" value="" >
                        </div>
                         <div class="col-lg-12">
                         
                         <label>Last Name:</label> <input type="text"  class="form-control" id="lname"  name="lname" value="" >
                        </div>
               

                      </div>
                   
                      <input type="hidden" name= "submitid" id='hiddid' value=""/>
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


    <!-- js placed at the end of the document so the pages load faster -->
    <!--<script src="js/jquery.js"></script>-->
<!--     <script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script> -->

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
          url: "<?php echo base_url("Dashboard/deleteuser")?>",
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




      $(".activatefirst").click(function(event){
        var result = confirm("Are you sure to Activate?");
        if (result) {

         var id = $(this).attr("id");  

         $.ajax({
          type: "POST",
          url: "<?php echo base_url("Dashboard/activateuser")?>",
          data: {id:id},
          success: function(response) {

                  if (response == true)
                  {
                    // $("#hello"+id).slideUp(100, function() {
                    //   $(this).remove();
                    // });
                    window.location.href = '<?php echo base_url("Dashboard/driver_list")?>';

                  }
                  else if(response == false)
                  {
                    alert("Error");
                  } else{
                    alert('cannot activate this user');
                  }
       

           }
         });

         event.preventDefault();
       }
       else{

       }
       })



            $(".activate").click(function(event){
        var result = confirm("Are you sure to Activate?");
        if (result) {

         var id = $(this).attr("id");  

         $.ajax({
          type: "POST",
          url: "<?php echo base_url("Dashboard/activeuser")?>",
          data: {id:id},
          success: function(response) {

                  if (response == true)
                  {
                    // $("#hello"+id).slideUp(100, function() {
                    //   $(this).remove();
                    // });
                    window.location.href = '<?php echo base_url("Dashboard/driver_list")?>';

                  }
                  else if(response == false)
                  {
                    alert("Error");
                  } else{
                    alert('cannot activate this user');
                  }
       

           }
         });

         event.preventDefault();
       }
       else{

       }
       })

        $(".deactivate").click(function(event){
        var result = confirm("Are you sure to Deactivate?");
        if (result) {

         var id = $(this).attr("id");  

         $.ajax({
          type: "POST",
          url: "<?php echo base_url("Dashboard/deactiveuser")?>",
          data: {id:id},
          success: function(response) {

                  if (response == true)
                  {
                    // $("#hello"+id).slideUp(100, function() {
                    //   $(this).remove();
                    // });
                    window.location.href = '<?php echo base_url("Dashboard/driver_list")?>';

                  }
                  else if(response == false)
                  {
                    alert("Error");
                  } else{
                    alert('cannot activate this user');
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
