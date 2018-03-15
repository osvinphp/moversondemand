
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Vechicle List
                            <a class="btn btn-info add_move" role="button" href="<?php echo base_url("Dashboard/addvechicle")?>">Add Vechicle </a>

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
                                 <?php if ($this->session->flashdata('msg5')!='') { ?>
                                <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php
                                echo $this->session->flashdata('msg5');
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
                                          <th style="width:230px;">Icon</th>
                                          <th>Height</th>
                                          <th>Length</th>
                                          <th>Width</th>
                                          <th>Weight</th>
                                          <th>1 Movers Charges</th>
                                          <th>2 Movers Charges</th>
                                          <th>Min Minutes</th>
                                          <th>Max Minutes</th>
                                          <th>KM Charges</th>
                                           <th>Minimum Fare($)</th>
                                           <th>Description</th>


                                          <th>Date Created</th>
                                          <th>Action</th>
                                      </tr>
                                      </thead>
                                       <?php
                                       $i=1;
                                       foreach ($vechicle as $key => $value) {

                                        ?>

                                        <tr id ='hello<?php echo $value->id; ?>'>
                                        <td>

                                          <?php echo $value->sequence; ?>
                                        </td>
                                        <td>

                                          <?php

                                           if (isset($value->name)) {
                                          echo $value->name;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                        <td class="image_setting" >
                                      <img src=" <?php echo  $value->icon; ?>">
                                        </td>
                                           <td>

                                          <?php
                                           if (!empty($value->height)) {
                                          echo $value->height;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                              <td>

                                          <?php
                                           if (!empty($value->length)) {
                                          echo $value->length;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                                <td>

                                          <?php
                                           if (!empty($value->width)) {
                                          echo $value->width;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                              <td>

                                          <?php
                                           if (!empty($value->weight)) {
                                          echo $value->weight;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                              <td>

                                          <?php
                                           if (!empty($value->movers_charges1)) {
                                          echo $value->movers_charges1;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>

                                            <td>

                                          <?php
                                           if (!empty($value->movers_charges2)) {
                                          echo $value->movers_charges2;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>


                                            <td>

                                          <?php
                                           if (!empty($value->min_minutes)) {
                                          echo $value->min_minutes;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>

                                            <td>

                                          <?php
                                           if (!empty($value->max_minutes)) {
                                          echo $value->max_minutes;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                              <td>

                                          <?php
                                           if (!empty($value->km_charges)) {
                                          echo $value->km_charges;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>

                                        <td>

                                        <?php

                                        echo $value->min_fare;

                                        ?>
                                        </td>
                                        <td>

                                        <?php

                                        echo $value->description;

                                        ?>
                                        </td>


                                        <td>
                                          <?php $date= $value->creation_date;
                                          echo date("F d, Y", strtotime($date));
                                           ?>
                                        </td>
                                          <td>
                                          <button type="button" class="btn btn-info deleteAction responsive" data-toggle="modal" data-target="#myModal" data-id="<?php echo $value->id; ?>" data-name="<?php echo $value->name; ?>" data-icon="<?php echo $value->icon; ?>" data-height="<?php echo $value->height; ?>" data-length="<?php echo $value->length; ?>" data-width="<?php echo $value->width; ?>" data-weight="<?php echo $value->weight; ?>" data-movers_charges2="<?php echo $value->movers_charges2; ?>" data-movers_charges1="<?php echo $value->movers_charges1; ?>"

                                          data-min_minutes="<?php echo $value->min_minutes; ?>"
                                          data-max_minutes="<?php echo $value->max_minutes; ?>"
                                          data-min_fare="<?php echo $value->min_fare; ?>"
                                          data-order="<?php echo $value->sequence; ?>"
                                          data-description="<?php echo $value->description; ?>"

                                           data-km_charges="<?php echo $value->km_charges; ?>" >Edit</button>
                                          <button type="button" class="delete btn btn-danger responsive" id="<?php echo $value->id;?>" >Delete</button>

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
                    <form class="form-horizontal" id="default" method="POST" action="<?php echo base_url("Dashboard/editvechiclelist")?>" enctype="multipart/form-data">
                        <div class="top_image ">
                         <label>Icon:</label> <img  id="icon"   src="" >
                        </div>
                      <div class="form-group type_box">

                        <div class="col-lg-12">
                          <label>Name:</label>
                           <input type="text"  class="form-control" id="name"  name="name" value="" >
                        </div>



                           <div class="col-lg-12">
                          <label>Order:</label>

                          <select id="order" name="order" value="" >
                          <?php
                          $abc=$this->db->query("SELECT * from tbl_vechicleType ")->result();
                          foreach ($abc as $key => $value) {
                          echo "<option value='".$value->sequence."'>".$value->sequence."</option>";
                          }
                          ?>
                          </select>

                        </div>



                         <div class="col-lg-12">
                         <label>Icon:</label>
                          <input type="file"  class="form-control"   name="icon" >
                        </div>
                         <div class="col-lg-12">
                        <label> Height: </label>
                        <input type="text"  class="form-control number"  id="height"  name="height" value="">
                        </div>
                         <div class="col-lg-12">
                         <label>Length : </label>
                         <input type="text"  class="form-control number" id="length"  name="length" value="" >
                        </div>
                         <div class="col-lg-12">
                         <label>Width : </label>
                         <input type="text"  class="form-control number" id="width"  name="width" value="" >
                        </div>
                         <div class="col-lg-12">
                         <label>Weight : </label>
                         <input type="text"  class="form-control number" id="weight"  name="weight" value="" >
                        </div>
                         <div class="col-lg-12">
                         <label>1 Movers Charges : </label>
                         <input type="text"  class="form-control number" id="movers_charges1"  name="movers_charges1" value="" >
                        </div>


                           <div class="col-lg-12">
                         <label>2 Movers Charges : </label>
                         <input type="text"  class="form-control number" id="movers_charges2"  name="movers_charges2" value="" >
                        </div>


                           <div class="col-lg-12">
                         <label>Mix Minutes(Load/Unload Min Estimate) : </label>
                         <input type="text"  class="form-control number" id="min_minutes"  name="min_minutes" value="" >
                        </div>


                           <div class="col-lg-12">
                         <label>Max Minutes(Load/Unload Max Estimate) : </label>
                         <input type="text"  class="form-control number" id="max_minutes"  name="max_minutes" value="" >
                        </div>




                         <div class="col-lg-12">
                         <label>Km Charges:</label>
                          <input type="text"  class="form-control number"  id="km_charges"  name="km_charges" value="">
                        </div>

                          <div class="col-lg-12">
                         <label>Minimum Fare($)</label>
                          <input type="text"  class="form-control number"  id="min_fare23"  name="min_fare" value="">
                        </div>

                        <div class="col-lg-12">
                       <label>Description</label>
                        <input type="text"  class="form-control"  id="description"  name="description" value="">
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
      <!--footer start-->
        <?php
        $this->load->view('templete/footer');
        ?>
      <!--footer end-->



    <!--script for this page only-->

  </body>
</html>

<script type="text/javascript">

       $(document).ready(function() {
       $('#myModal').on('show.bs.modal', function(e) {
    var userid = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    var icon = $(e.relatedTarget).data('icon');
    var height = $(e.relatedTarget).data('height');
    var weight = $(e.relatedTarget).data('weight');
    var length = $(e.relatedTarget).data('length');
    var width = $(e.relatedTarget).data('width');
    var movers_charges1 = $(e.relatedTarget).data('movers_charges1');
    var movers_charges2 = $(e.relatedTarget).data('movers_charges2');


    var min_minutes = $(e.relatedTarget).data('min_minutes');
    var max_minutes = $(e.relatedTarget).data('max_minutes');
    var min_fare = $(e.relatedTarget).data('min_fare');

     var order = $(e.relatedTarget).data('order');


    var km_charges = $(e.relatedTarget).data('km_charges');
        var description = $(e.relatedTarget).data('description');


    document.getElementById('hiddid').value = userid;
    document.getElementById('name').value = name;
    document.getElementById('icon').src = icon;
    document.getElementById('height').value = height;
    document.getElementById('weight').value = weight;
    document.getElementById('length').value = length;
    document.getElementById('width').value = width;

    document.getElementById('movers_charges1').value = movers_charges1;
    document.getElementById('movers_charges2').value = movers_charges2;
    document.getElementById('min_minutes').value = min_minutes;
    document.getElementById('max_minutes').value = max_minutes;

    document.getElementById('km_charges').value = km_charges;
    document.getElementById('min_fare23').value = min_fare;

     document.getElementById('order').value = order;
     document.getElementById('description').value = description;



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
          url: "<?php echo base_url("Dashboard/deletevechicle")?>",
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
<script>
$(function() {
  $('.panel-body').on('keydown', '.number', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
})
</script>
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
