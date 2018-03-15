
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Time List of <?php echo $dayname; ?> 
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


<a class="btn btn-info" href="<?php echo base_url('Dashboard/view_timemanagement');?>"  type="submit">Back</a>
<a class="btn btn-info" href="<?php echo base_url('Dashboard/time_management/').$dayid;?>"  type="submit">Add Time Slots</a>







                                                   <div class="adv-table">
                                    <table  class="display table table-bordered table-striped example" id="example">
                                      <thead>
                                      <tr>
                                          <th>Sr.No.</th>
                                          <th>Start Time</th>
                                           <th>End Time</th>
                                    
                                          <th>Action</th>
                                      </tr>
                                      </thead>
                                      <tbody>


                                
                            <?php
                                       $i=1;
                                       foreach ($time as $key => $value) {
                             
                          

                                       
                                        ?>
                                        <tr id ='hello<?php echo $value->id; ?>'> 
                                        <td>
                                          <?php echo $i; ?>
                                        </td>
                                    
                                           <td>
                                          <?php 
                                           if (!empty($value->start_time)) {
                                          echo   date("h:iA", strtotime($value->start_time));
                                          // echo $value->start_time; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                            <td>
                                          <?php 
                                           if (!empty($value->end_time)) {
                                          // echo $value->end_time; 
                                          echo   date("h:iA", strtotime($value->end_time));
                                          
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                
                                       
                              
                        
                                        
                                    
                                        <td>                 
                                  
                                          <button type="button" class="delete btn btn-danger responsive wiDTH_delete" id="<?php echo $value->id;?>" >Delete</button>
                                         
                                           
                                         </td>
                                        </tr>

                                      <?php 
                                        $i++;
                                        }
                                        // die;
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
        var result = confirm("Are you sure to delete?");
        if (result) {

         var id = $(this).attr("id");  

         $.ajax({
          type: "POST",
          url: "<?php echo base_url("Dashboard/deletetime")?>",
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
