
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Move Type List
                              <a class="btn btn-info add_move" role="button" href="<?php echo base_url("Dashboard/addmove")?>">Add Move </a>

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
                                          <th>Title</th>
                                          <th style="width:230px;">Icon</th>
                                          <th>Type</th>
                                          <th>Date Created</th>
                                          <th>Action</th>
                                      </tr>
                                      </thead>
                                       <?php
                                       $i=1;
                                       foreach ($move as $key => $value) {

                                        ?>

                                        <tr id ='hello<?php echo $value->id; ?>'>
                                        <td>

                                          <?php echo $i; ?>
                                        </td>
                                        <td>
                                        <input type="hidden" name="name" data-id="<?php echo $value->title ; ?>" >
                                          <?php

                                           if (isset($value->title)) {
                                          echo $value->title;
                                           }
                                           else{
                                            echo "N\A";
                                           }  ?>
                                        </td>
                                        <td class="image_setting">
                                       <input type="hidden" name="hint" data-id="<?php echo $value->icon ; ?>" >
                                         <img src="<?php echo  $value->icon; ?>">
                                        </td>
                                           <td>
                                            <input type="hidden" name="description" data-id="<?php echo $value->type ; ?>" >
                                          <?php
                                           if (!empty($value->type)) {
                                         if ($value->type==1) {
                                           echo "Order";
                                         }
                                         else{
                                          echo "Moving";
                                         }
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
                                          <button type="button" class="btn btn-info deleteAction responsive_btn responsive" data-toggle="modal" data-target="#myModal" data-id="<?php echo $value->id; ?>" data-title="<?php echo $value->title; ?>" data-icon="<?php echo $value->icon; ?>" data-type="<?php echo $value->type; ?>" >Edit</button>
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
                    <form class="form-horizontal" id="default" method="POST" action="<?php echo base_url("Dashboard/editmovelist")?>" enctype="multipart/form-data">
                        <div class="top_image ">

                         <label>Icon: </label>
                         <img  id="icon"   src="" >
                        </div>
                          <div class="form-group type_box">

                        <div class="col-lg-12">
                        <label> Title: </label>
                         <input type="text"  class="form-control" id="title"  name="title" value="" >
                        </div>
                        <div class="col-lg-12">
                          <label>Icon:</label> <input type="file"  class="form-control"   name="icon" >
                        </div>

                         <div class="col-lg-12">
                           <label>Type:</label>

                            <select name="type" required id="type" >
                                          <option value="1">Order</option>
                                          <option value="2">Moving</option>
                                            </select>
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

  </body>
</html>

<script type="text/javascript">
      $(document).ready(function() {
        $('#myModal').on('show.bs.modal', function(e) {
        var userid = $(e.relatedTarget).data('id');
        var title = $(e.relatedTarget).data('title');
        var icon = $(e.relatedTarget).data('icon');
        var type = $(e.relatedTarget).data('type');
        document.getElementById('hiddid').value = userid;
        document.getElementById('title').value = title;
        document.getElementById('icon').src = icon;
        document.getElementById('type').value = type;
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
          url: "<?php echo base_url("Dashboard/deletemove")?>",
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
