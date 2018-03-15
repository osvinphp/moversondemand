
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Time List
                          </header>
                                        <div class="panel-body">
                                                   <div class="adv-table">
                                    <table  class="display table table-bordered table-striped example" id="example">
                                      <thead>
                                      <tr>
                                          <th>Sr.No.</th>
                                          <th>Day</th>
                                    
                                          <th>Action</th>
                                      </tr>
                                      </thead>
                                      <tbody>


                                      <tr>
                                      <td>1</td>
                                        <td>Monday</td>
                                        <?php $day='1'; ?>
                                        <td> <a class="btn btn-info" href="<?php echo base_url('Dashboard/daywisedata/').$day ;?>"  type="submit">Detail</a></td>
                                      </tr>
                                      <tr>
                                      <td>2</td>
                                        <td>Tuesday</td>
                                         <?php $day='2'; ?>
                                        <td><a class="btn btn-info" href="<?php echo base_url('Dashboard/daywisedata/').$day ;?>"  type="submit">Detail</a></td>
                                      </tr>
                                      <tr>
                                      <td>3</td>
                                        <td>Wednesday</td> <?php $day='3'; ?>
                                        <td> <a class="btn btn-info" href="<?php echo base_url('Dashboard/daywisedata/').$day ;?>"  type="submit">Detail</a></td>
                                      </tr>
                                      <tr>
                                      <td>4</td>
                                        <td>Thursday</td> <?php $day='4'; ?>
                                        <td> <a class="btn btn-info" href="<?php echo base_url('Dashboard/daywisedata/').$day ;?>"  type="submit">Detail</a></td>
                                      </tr>
                                      <tr>
                                      <td>5</td>
                                        <td>Friday</td> <?php $day='5'; ?>
                                        <td> <a class="btn btn-info" href="<?php echo base_url('Dashboard/daywisedata/').$day ;?>"  type="submit">Detail</a></td>
                                      </tr>
                                      <tr>
                                      <td>6</td>
                                        <td>Saturday</td> <?php $day='6'; ?>
                                        <td> <a class="btn btn-info" href="<?php echo base_url('Dashboard/daywisedata/').$day ;?>"  type="submit">Detail</a></td>
                                      </tr>
                                      <tr>
                                      <td>7</td>
                                        <td>Sunday</td> <?php $day='7'; ?>
                                        <td> <a class="btn btn-info" href="<?php echo base_url('Dashboard/daywisedata/').$day ;?>"  type="submit">Detail</a></td>
                                      </tr>
                                    
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
  <!--  <script> 
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
</script> -->
