
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             City List
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
                                          <th>City</th>
                                          <th>State</th>
                                          <th>Country</th>
                                          
                                          <th>Date Created</th>
                                          <th>Action</th>
                                      </tr>
                                      </thead>
                                       <?php
                                       $i=1;
                                       foreach ($city as $key => $value) {
                          

                                       
                                        ?>
                                        <tr id ='hello<?php echo $value->id; ?>'> 
                                        <td>
                                          <?php echo $i; ?>
                                        </td>
                                        <td>
                                          <?php 
                                           if (isset($value->city_name)) {
                                          echo $value->city_name; 
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                           <td>
                                          <?php 
                                           if (!empty($value->state_code)) {
                                          echo $value->state_code; 
                                           }
                                           else{
                                            echo "N/A";
                                           }  ?>
                                        </td>
                                            <td>
                                          <?php 
                                           if (!empty($value->country_name)) {
                                          echo $value->country_name; 
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
                                  
                                          <button type="button" class="delete btn btn-danger responsive wiDTH_delete" id="<?php echo $value->id;?>" >Delete</button>
                                         
                                           
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
          url: "<?php echo base_url("Dashboard/deletecity")?>",
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
