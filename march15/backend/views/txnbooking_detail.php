 <?php 
 $data=unserialize($booking[0]->item_image);
 $image1=$data[0];
 $image2=$data[1];
 $image3=$data[2];
 $image4=$data[3];


 // date_default_timezone_set('Asia/Kolkata');
// echo"<pre>";print_r($image1);die;
 ?>  
 <!--sidebar end-->
 <!--main content start-->
 <section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Booking detail
                        <div class="floating">
                            <a href="<?php echo base_url("Dashboard/transaction_list")?>" type="button" class="btn btn-primary " align="right" >Back</a></div>

                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div class="table-responsive">
                                    <table  class="display table table-bordered table-striped example" id="example">
                                        <thead>
                                            <tbody> 

                                                <tr>
                                                    <td class="weight_bold">User Name</td>
                                                    <td>
                                                        <?php 
                                                        if (isset($booking[0]->fname)) {
                                                            echo $booking[0]->fname." ".$booking[0]->lname; 
                                                        }
                                                        else{
                                                            echo "N\A";
                                                        }  ?>
                                                    </td>
                                                </tr>

                                                <tr> 
                                                    <td class="weight_bold">Email</td>
                                                    <td>
                                                        <?php echo  $booking[0]->email; ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="weight_bold">Phone Number</td>
                                                    <td>
                                                        <?php 
                                                        if (isset($booking[0]->country_code)) {
                                                            echo $booking[0]->country_code." -".$booking[0]->phone; 
                                                        }
                                                        else{
                                                            echo "N\A";
                                                        }  ?>

                                                    </td>
                                                </tr>


<tr>
<td class="weight_bold">Company Name</td>
<td>
<?php 
if (!empty($booking[0]->company_name)) {
echo $booking[0]->company_name;}
else{
echo "N\A";
}  ?>
</td>
</tr>




      
        <tr>
            <td class="weight_bold">Vechicle Name</td>
            <td>
                <?php echo  $booking[0]->name; ?>
            </td>
        </tr>
        <tr>
            <td class="weight_bold">Vehicle Image</td>
            <td>
                <?php 
                if (!empty($booking[0]->vehicleimage)) { ?>

                <img height="100px" width="200px" src="<?php echo $booking[0]->vehicleimage;?>">

                <?php  } 
                else{ ?>
                <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                <?php
            }  ?>
        </td>
    </tr>
    
        <tr> 
            <td class="weight_bold">MoveType Name</td>
            <td>
                <?php 
                if (!empty($booking[0]->title)) {
                    echo $booking[0]->title; 
                }
                else{
                    echo "N\A";
                }  ?>
            </td>
        </tr>
        <tr> 
            <td class="weight_bold">MoveType Image</td>
            <td>
                <?php 
                if (!empty($booking[0]->title)) { ?>
                <img height="100px" width="200px" src="<?php echo $booking[0]->icon;?>">
                <?php  }
                else{ ?>
                <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                <?php }  ?>
            </td>
        </tr>
        

        <tr>
            <td class="weight_bold">Receipt Number</td>
            <td>
                <?php 
                if (!empty($booking[0]->receipt_number)) {
                    echo $booking[0]->receipt_number; 
                }
                else{
                    echo "N\A";
                }  ?>
            </td>
        </tr>
        <tr>
            <td class="weight_bold">Receipt Image</td>
            <td>
                <?php 
                if (!empty($booking[0]->receipt_image)) { ?>

                <img height="100px" width="200px" src="<?php echo $booking[0]->receipt_image;?>">

                <?php  } 
                else{ ?>
                <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                <?php
            }  ?>
        </td>
    </tr>
    <tr>
        <td class="weight_bold">Pick Up Location</td>
        <td>
            <?php 
            if (!empty($booking[0]->pickup_loc)) {
                echo $booking[0]->pickup_loc;}
                else{
                    echo "N\A";
                }  ?>
            </td>
        </tr>
        <tr>
            <td class="weight_bold">Destination Location</td>
            <td>
                <?php 
                if (!empty($booking[0]->destination_loc)) {
                    echo $booking[0]->destination_loc;}
                    else{
                        echo "N\A";
                    }  ?>
                </td>
            </tr>
            <tr>
                <td class="weight_bold">Booking Date</td>
                <td>
                    <?php
                  echo  $booking[0]->booking_date; 
                 
                      ?>
                </td>
            </tr>
            <tr>
                <td class="weight_bold">Booking Time</td>
                <td>
                <?php
                        $date=  $booking[0]->slot_starttime; 
                     // date_default_timezone_set('Asia/Kolkata');
                     $date112 = date ('H:i:s',$date);
                     echo $date112;?>
                </td>
            </tr>
<tr>
<td class="weight_bold">Estimated Price</td>
<td>
<?php 
if (!empty($booking[0]->estimate_price)) {
echo $booking[0]->estimate_price;}
else{
echo "N\A";
}  ?>
</td>
</tr>



<tr>
<td class="weight_bold">GST Price</td>
<td>
<?php 
if (!empty($booking[0]->gst_price)) {
echo $booking[0]->gst_price;}
else{
echo "N\A";
}  ?>
</td>
</tr>



<tr>
<td class="weight_bold">Admin Percentage</td>
<td>
<?php 
if (!empty($booking[0]->admin_percentage)) {
echo $booking[0]->admin_percentage;}
else{
echo "N\A";
}  ?>
</td>
</tr>


<tr>
<td class="weight_bold">Extra Fare</td>
<td>
<?php 
if (!empty($booking[0]->extra_fare)) {
echo $booking[0]->extra_fare;}
else{
echo "N\A";
}  ?>
</td>
</tr>















                <tr>
                    <td class="weight_bold">Total Price</td>
                    <td>
                        <?php 
                        if (!empty($booking[0]->total_price)) {
                            echo $booking[0]->total_price;}
                            else{
                                echo "N\A";
                            }  ?>
                        </td>
                    </tr> 
                



                     <?php  if ($booking[0]->type==1) { ?>
                        <tr>
                        <td class="weight_bold">Pre Booking Txn ID</td>
                        <td>
                            <?php
                            if (!empty($booking[0]->txn_id)) {
                                echo  $booking[0]->txn_id;
                                
                            }
                            else{
                                echo "N/A";
                            }


                              ?>
                        </td>
                    </tr>
                     <?php  } ?>


                        <?php  if ($booking[1]->type==1) { ?>
                                
                        <tr>
                        <td class="weight_bold">On completeion Txn ID</td>
                        <td>
                            <?php 
                            if (!empty($booking[1]->txn_id)) {
                            echo  $booking[1]->txn_id; 
                            }
                            else{
                                echo "N/A";
                            }
                            ?>

                        </td>
                    </tr>
                      <?php  } ?>



                            <?php  if ($booking[1]->type==2) { ?>
                                
                        <tr>
                        <td class="weight_bold">Refund Txn ID</td>
                        <td>
                            <?php 
                            if (!empty($booking[1]->txn_id)) {
                            echo  $booking[1]->txn_id; 
                            }
                            else{
                                echo "N/A";
                            }
                            ?>

                        </td>
                    </tr>
                      <?php  } ?>










                    <tr>
                        <td class="weight_bold">Item Image1</td>
                        <td>
                            <?php 
                            if (!empty($image1)) { ?>
                            <img height="100px" width="200px" src="<?php echo  $image1; ?>">                
                            <?php  } 
                            else{ ?>
                            <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="weight_bold">Item Image2</td>
                        <td>
                            <?php 
                            if (!empty($image2)) { ?>
                            <img height="100px" width="200px" src="<?php echo  $image2; ?>">
                            <?php  } 
                            else{ ?>
                            <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="weight_bold">Item Image3</td>
                        <td>
                            <?php 
                            if (!empty($image3)) { ?>
                            <img height="100px" width="200px" src="<?php echo  $image3; ?>">
                            <?php  } 
                            else{ ?>
                            <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="weight_bold">Item Image4</td>
                        <td>
                            <?php 
                            if (!empty($image4)) { ?>
                            <img height="100px" width="200px" src="<?php echo  $image4; ?>">
                            <?php  } 
                            else{ ?>
                            <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                            <?php } ?>
                        </td>
                    </tr>
                

                </tbody>
            </table>
        </div>
    </div>
</div>
</section>
</div>
</div>
</section>
</section>
<?php 
$this->load->view('templete/footer');
?>
<!--footer end-->



</body>
</html>
