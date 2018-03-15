
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->


              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Add Promo Code
                          </header>
                          <div class="panel-body">
                              <div class="form align">
                                  <form class="cmxform form-horizontal tasi-form type_box_lab" id="signupForm" method="post" action="<?php echo base_url("Dashboard/promocode_list")?>" enctype="multipart/form-data" >
                                      <div class="form-group ">
                                            <label for="firstname" class="control-label">Name</label>
                                              <input class=" form-control" id="Name" name="name" type="text" placeholder="Enter Promocode Name" required="" />
                                      </div>
                                      <div class="form-group ">
                                            <label for="firstname" class="control-label">Value</label>
                                              <input class=" form-control number" id="Value" name="value" type="number" placeholder="Enter Promocode Value" required="" />
                                      </div>




                                            <div class="form-group ">
                                            <label for="firstname" class="control-label">Max Amount</label>
                                              <input class=" form-control number" id="maxamount" name="maxamount" type="number" placeholder="Enter Promocode Max Amount" required="" />
                                      </div>



                                      <div class="form-group ">
                                            <label for="firstname" class="control-label">Per User Max Usage</label>
                                              <input class=" form-control number" id="maxusage" name="perusermaxusage" type="number" placeholder="Enter Per User Max Usage" required="" />
                                      </div>


                                      <div class="form-group ">
                                      <label>Expiry Date </label>
                                      <div id="datepicker" class="input-group date " data-date-format="yyyy-mm-dd">
                                      <input class="form-control number" type="text" name="date" value="" readonly placeholder="Select Expiry Date" />
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                      </div>
                                      </div>

                                      <div class="form-group">
                                              <button class="btn btn-success submit" name="addpromo" type="submit">Submit</button>

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
 <!-- <script src="<?php echo base_url("public/js/form-validation-script.js")?>"></script>   -->


  </body>
</html>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
      $(function () {
      $("#datepicker").datepicker({
      autoclose: true,
      todayHighlight: true,
      });
      });
    </script>
    <script>
    $(function() {
      $('.panel-body').on('keydown', '.number', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    })
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
