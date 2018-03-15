
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->


              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Add Vechicle
                          </header>
                          <div class="panel-body">
                              <div class="form align">
                                  <form class="cmxform form-horizontal tasi-form type_box_lab"  id="signupForm" enctype="multipart/form-data" method="post" action="<?php echo base_url("Dashboard/addedvechicle")?>">
                                      <div class="form-group ">
                                          <label for="firstname" class="control-label col-lg-2">Name</label>
                                              <input class=" form-control" id="name" name="name" type="text" placeholder="Vechicle Name" required="" />
                                      </div>
                                      <div class="form-group ">
                                          <label for="lastname" class="control-label col-lg-2">Icon</label>
                                              <input class=" form-control" id="icon" name="icon" type="file" required="" />
                                      </div>
                                      <div class="form-group ">
                                          <label for="username" class="control-label col-lg-2">Height</label>
                                              <input class="form-control number" id="height" name="height" type="text" placeholder="Height" required=""  />
                                      </div>
                                        <div class="form-group ">
                                          <label for="username" class="control-label col-lg-2">Length</label>
                                              <input class="form-control number" id="length" name="length" type="text" placeholder="Length" required=""  />
                                      </div>
                                       <div class="form-group ">
                                          <label for="username" class="control-label col-lg-2">Width</label>
                                              <input class="form-control number" id="width" name="width" type="text" placeholder="Width" required=""  />
                                      </div>
                                        <div class="form-group ">
                                          <label for="username" class="control-label col-lg-2">Weight</label>
                                              <input class="form-control number" id="weight" name="weight" type="text" placeholder="Weight" required="" />
                                      </div>
                                        <div class="form-group "  >

                                          <label for="username" class="control-label col-lg-2">1 Mover Charges($ per minute)</label>
                                              <input class="form-control number"  name="movers_charges1" type="text" placeholder="1 Mover Charges" required="" />
                                      </div>



                                        <div class="form-group "  >

                                          <label for="username" class="control-label col-lg-2">2 Mover Charges($ per minute)</label>
                                              <input class="form-control number"  name="movers_charges2" type="text" placeholder="2 Mover Charges" required="" />
                                      </div>



                                        <div class="form-group" >
                                          <label for="username" class="control-label col-lg-2">Km Charges($ per km)</label>
                                              <input class="form-control number"  name="kmcharges"  type="text" onkeypress='return validateQty(event);' placeholder="Km Charges" required="" />
                                      </div>


                                         <div class="form-group" >


                                          <label for="username" class="control-label col-lg-2">Min Minutes(Load/Unload Min Estimate)</label>
                                              <input class="form-control number"  name="min_minutes"  type="text" onkeypress='return validateQty(event);' placeholder="Min Minutes(Load/Unload Min Estimate)" required="" />
                                      </div>

                                         <div class="form-group" >
                                          <label for="username" class="control-label col-lg-2">Max Minutes(Load/Unload Max Estimate)</label>
                                              <input class="form-control number"  name="max_minutes"  type="text" onkeypress='return validateQty(event);' placeholder="Max Minutes(Load/Unload Max Estimate)" required="" />
                                      </div>

                                      <div class="form-group" >
                                          <label for="username" class="control-label col-lg-2">Minimum Fare($)</label>
                                              <input class="form-control number"  name="min_fare"  type="text" onkeypress='return validateQty(event);' placeholder="Minimum Fare" required="" />
                                      </div>
                                      <div class="form-group" >
                                          <label for="username" class="control-label col-lg-2">Description</label>
                                              <input class="form-control number"  name="description"  type="text"  placeholder="Description" required="" />
                                      </div>







                               <img src="<?php echo base_url("public/img/favicon.ico")?>" id="gif" style="display: block; margin: 0 auto; width: 100px; visibility: hidden;">

                                      <div class="form-group">
                                              <button class="btn btn-success submit load_button" type="submit">Submit</button>

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
<!-- <script type="text/javascript">
 $('.number').keypress(function(eve) {
  if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0) ) {
    eve.preventDefault();
  }

// this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
 $('.number').keyup(function(eve) {
  if($(this).val().indexOf('.') == 0) {    $(this).val($(this).val().substring(1));
  }
 });
});
</script> -->

<!--   <script type="text/javascript">
    // $('.load_button').submit(function() {
    //     $('#gif').show();
    //     return true;
    // });
    $('#login_form').submit(function() {
    $('#gif').css('visibility', 'visible');
});
</script>
 -->
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
