
      <!--sidebar end-->
      <!--main content start-->

      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Promocode List
                              <a class="btn btn-info add_move" role="button" href="<?php echo base_url("Dashboard/addpromocode")?>">Add Promocode</a>

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
                                          <th>Promocode Name</th>
                                          <th>Value</th>

                                          <th>Max Amount</th>

                                        <!--   <th>Maximum Usage</th> -->
                                           <th>Maximum Usage Per User</th>

                                          <th>Expiry Date</th>
                                           <th>Date Created</th>
                                          <th>Action</th>
                                      </tr>
                                      </thead>
                                       <?php
                                       $i=1;
                                       foreach ($promocode as $key => $value) {
                                        ?>

                                        <tr id ='hello<?php echo $value->id; ?>'>
                                        <td>

                                          <?php echo $i; ?>
                                        </td>
                                        <td>

                                          <?php

                                           if (isset($value->promo_code)) {
                                          echo $value->promo_code;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                        <td>
                                           <?php

                                           if (isset($value->value)) {
                                          echo $value->value.' %';
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>

                                        </td>

                                           <td>
                                           <?php

                                           if (isset($value->max_amount)) {
                                          echo $value->max_amount;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>

                                        </td>

                                          <td>
                                          <?php

                                           if (isset($value->user_max_usage)) {
                                          echo $value->user_max_usage;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>



                                        </td>

                                               <td>
                                          <?php

                                           if (isset($value->expiry_date)) {
                                          echo $value->expiry_date;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>



                                        </td>
                                        <td>
                                          <?php $date= $value->date_created;
                                          echo date("F d, Y", strtotime($date));
                                           ?>
                                        </td>
                                          <td>
                                         <button type="button" class="btn btn-info deleteAction responsive_btn responsive" data-toggle="modal" data-target="#myModal" data-promoid="<?php echo $value->id; ?>" data-promo="<?php echo $value->promo_code; ?>" data-promovalue="<?php echo $value->value; ?>"    data-expiry="<?php echo $value->expiry_date; ?>" data-usermaxusage="<?php echo $value->user_max_usage; ?>" data-maxamount="<?php echo $value->max_amount; ?>" >Edit</button>
                                          <button type="button" class="delete btn btn-danger responsive_btn responsive" id="<?php echo $value->id;?>" >Delete</button>

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
      <!--popup start-->
        <div class="panel-body">
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Update Your Detail Here</h4>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" id="default" method="POST" action="<?php echo base_url("Dashboard/promocode_list")?>">

                          <div class="form-group type_box">

                        <div class="col-lg-12">
                        <label> Promo: </label>
                         <input type="text"  class="form-control" id="promo"  name="promo" value="" >
                        </div>
                             <div class="col-lg-12">
                        <label> Value: </label>
                         <input type="text"  class="form-control number" id="promovalue"  name="value" value="" >
                        </div>

                         <div class="col-lg-12">
                        <label> Max Amount: </label>
                         <input type="number"  class="form-control number" id="maxamount"  name="maxamount" value="" >
                        </div>


                        <div class="col-lg-12">
                        <label> Maxusage Per User: </label>
                         <input type="number"  class="form-control number" id="maxusageperuser"  name="maxusageperuser" value="" >
                        </div>

                         <div class="">
                        <label> Expiry Date: </label>
                          <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
                          <input class="form-control " type="date" name="date" id="expiry" value="" readonly />
                          <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                          </div>
                        </div>



                      </div>

                      <input type="hidden" name= "edit" id='hiddid' value=""/>
                      <button  type="submit" class="btn btn-info editdata submit" name="editpromo"  >Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
           <!--popup end-->
      <!--footer start-->


<?php
 $this->load->view('templete/footer');
?>

      <!--footer end-->

  </body>
</html>


<script type="text/javascript">
   // var jq =$.noConflict();
    $(function () {
    $("#datepicker").datepicker({
    autoclose: true,
    todayHighlight: true
    }).datepicker('update', new Date());
    });
</script>
   <!-- <script type="text/javascript">
      $.noConflict();
    </script> -->

 <script>
 $(document).ready(function(){

   $(".delete").click(function(event){
        var result = confirm("Are you Sure to delete?");
        if (result) {

         var id = $(this).attr("id");

         $.ajax({
          type: "POST",
          url: "<?php echo base_url("Dashboard/deletepromo")?>",
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

   <script type="text/javascript">
          // $.noConflict();
        jQuery(document).ready(function($) {
        jQuery('#myModal').on('show.bs.modal', function(e) {
        console.log(e.namespace);
        if(e.namespace == 'bs.modal'){
          var promoid = $(e.relatedTarget).data('promoid');
          var promo = $(e.relatedTarget).data('promo');
          var promovalue = $(e.relatedTarget).data('promovalue');
          var maxamount = $(e.relatedTarget).data('maxamount');

          var perusermaxusage =$(e.relatedTarget).data('usermaxusage');

          var expiry = $(e.relatedTarget).data('expiry');
          document.getElementById('hiddid').value = promoid;
          document.getElementById('promo').value = promo;
          document.getElementById('promovalue').value = promovalue;
          document.getElementById('maxamount').value = maxamount;

          document.getElementById('maxusageperuser').value = perusermaxusage;

          document.getElementById('expiry').value = expiry;
        }
       });

     });

   </script>
       <!-- <script src="<?php echo base_url("public/js/jquery.js")?>"></script> -->
  <!--  <script type="text/javascript" src="<?php echo base_url("public/js/jquery-ui-1.9.2.custom.min.js")?>"></script> -->
<!--   <script src="<?php echo base_url("public/assets/fullcalendar/fullcalendar/fullcalendar.min.js")?>"></script> -->
  <!-- <script src="js/bootstrap.min.js"></script> -->
  <!-- <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script> -->
  <!-- <script src="js/jquery.scrollTo.min.js"></script> -->
  <!-- <script src="js/jquery.nicescroll.js" type="text/javascript"></script> -->
  <!-- <script src="js/respond.min.js" ></script> -->

    <!--common script for all pages-->
    <!-- <script src="<?php echo base_url("public/js/common-scripts.js")?>"></script>  -->

    <!--script for this page only-->
    <!-- <script src="<?php echo base_url("public/js/external-dragging-calendar.js")?>"></script> -->


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
    <script>
    $(function() {
      $('.panel-body').on('keydown', '.number', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    })
    </script>




    <!--common script for all pages-->
