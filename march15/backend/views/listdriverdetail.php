
 <!--sidebar end-->
 <!--main content start-->

 <section id="main-content">
 	<section class="wrapper site-min-height">
 		<!-- page start-->
 		<div class="row">
 			<div class="col-lg-12">
 				<section class="panel">
 					<header class="panel-heading">
 						Driver Detail
 						<div class="floating">
 							<a href="<?php echo base_url("Dashboard/driver_list")?>" type="button" class="btn btn-primary " align="right" >Back</a></div>

 						</header>
 						<div class="panel-body">
 							<div class="adv-table">
 								<div class="table-responsive">
 									<table  class="display table table-bordered table-striped example" id="example">
 										<thead>
 											<tbody> 
<!-- <?php echo "<prE>"; print_r($users); ?> -->
 												<tr>
 													<td class="weight_bold">User Name</td>
 													<td>
 														<?php 
 														if (isset($users[0]->fname)) {
 															echo $users[0]->fname." ".$users[0]->lname; 
 														}
 														else{
 															echo "N\A";
 														}  ?>
 													</td>
 												</tr>

 												<tr> 
 													<td class="weight_bold">Email</td>
 													<td>
 														<?php echo  $users[0]->email; ?>
 													</td>
 												</tr>

 												<tr>
 													<td class="weight_bold">Phone Number</td>
 													<td>
 														<?php 
 														if (isset($users[0]->country_code)) {
 															echo $users[0]->country_code." -".$users[0]->phone; 
 														}
 														else{
 															echo "N\A";
 														}  ?>

 													</td>
 												</tr>
    
       
        <tr>
        	<td class="weight_bold">Profile Image</td>
        	<td>
        		<?php 
        		if (!empty($users[0]->profile_pic)) { ?>

        		<img height="100px" width="200px" src="<?php echo $users[0]->profile_pic;?>">

        		<?php  } 
        		else{ ?>
        		<img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
        		<?php
        	}  ?>
        </td>
    </tr>

        
    	<tr>
    		<td class="weight_bold">Status</td>
    		<td>
    			<?php 
    			if ($users[0]->is_suspend==0) {
    				echo "Activated";}
    				else{
    					echo "Suspended";
    				}  ?>
    			</td>
    		</tr>



<tr>
            <td class="weight_bold">Located AT</td>
          <td>
<?php 
$abc= unserialize($users[0]->located_at); 
$aa=array();
foreach ($abc as $key => $value1) {
$as=$this->db->query("SELECT * from tbl_cities where id='".$value1."'")->row();
$aa[]=$as->city_name;
}
echo(implode(',',$aa));
?>
</td>
            </tr>



                                                <tr> 
                                                    <td class="weight_bold">Vehicle Name</td>
                                                    <td>
                                                        <?php echo  $users[0]->name; ?>
                                                    </td>
                                                </tr>




        <tr>
            <td class="weight_bold">Vehicle Image</td>
            <td>
                <?php 
                if (!empty($users[0]->icon)) { ?>

                <img height="100px" width="200px" src="<?php echo $users[0]->icon;?>">

                <?php  } 
                else{ ?>
                <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                <?php
            }  ?>
        </td>
    </tr>



                                                <tr> 
                                                    <td class="weight_bold">Licence no</td>
                                                    <td>
                                                        <?php echo  $users[0]->license_no; ?>
                                                    </td>
                                                </tr>


                                                <tr> 
                                                    <td class="weight_bold">RC No</td>
                                                    <td>
                                                        <?php echo  $users[0]->rc_no; ?>
                                                    </td>
                                                </tr>


                                                 <tr> 
                                                    <td class="weight_bold">Insurance No</td>
                                                    <td>
                                                        <?php echo  $users[0]->insurance_no; ?>
                                                    </td>
                                                </tr>


                                                 <tr> 
                                                    <td class="weight_bold">Vehicle No</td>
                                                    <td>
                                                        <?php echo  $users[0]->vehicle_no; ?>
                                                    </td>
                                                </tr>


         <tr>
            <td class="weight_bold">Vehicle Front Image</td>
            <td>
                <?php 
                if (!empty($users[0]->vehicle_image_front)) { ?>

                <img height="100px" width="200px" src="<?php echo $users[0]->vehicle_image_front;?>">

                <?php  } 
                else{ ?>
                <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                <?php
            }  ?>
        </td>
    </tr>


            <tr>
            <td class="weight_bold">Vehicle Back Image</td>
            <td>
                <?php 
                if (!empty($users[0]->vehicle_image_back)) { ?>

                <img height="100px" width="200px" src="<?php echo $users[0]->vehicle_image_back;?>">

                <?php  } 
                else{ ?>
                <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                <?php
            }  ?>
             </td>
            </tr>
 <tr>
            <td class="weight_bold">Licence Front Image</td>
            <td>
                <?php 
                if (!empty($users[0]->license_image_front)) { ?>

                <img height="100px" width="200px" src="<?php echo $users[0]->license_image_front;?>">

                <?php  } 
                else{ ?>
                <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                <?php
            }  ?>
        </td>
    </tr>


            <tr>
            <td class="weight_bold">Licence Back Image</td>
            <td>
                <?php 
                if (!empty($users[0]->license_image_back)) { ?>

                <img height="100px" width="200px" src="<?php echo $users[0]->license_image_back;?>">

                <?php  } 
                else{ ?>
                <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                <?php
            }  ?>
             </td>
            </tr>


            <tr>
            <td class="weight_bold">RC Front Image</td>
            <td>
                <?php 
                if (!empty($users[0]->rc_image_front)) { ?>

                <img height="100px" width="200px" src="<?php echo $users[0]->rc_image_front;?>">

                <?php  } 
                else{ ?>
                <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                <?php
             }  ?>
             </td>
            </tr>


            <tr>
            <td class="weight_bold">RC Back Image</td>
            <td>
                <?php 
                if (!empty($users[0]->rc_image_back)) { ?>

                <img height="100px" width="200px" src="<?php echo $users[0]->rc_image_back;?>">

                <?php  } 
                else{ ?>
                <img height="100px" width="200px" src=" <?php echo  base_url("public/img/demo.png"); ?>">
                <?php
            }  ?>
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
