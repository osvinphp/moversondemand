
 <!--sidebar end-->
 <!--main content start-->

 <section id="main-content">
 	<section class="wrapper site-min-height">
 		<!-- page start-->
 		<div class="row">
 			<div class="col-lg-12">
 				<section class="panel">
 					<header class="panel-heading">
 						User Detail
 						<div class="floating">
 							<a href="<?php echo base_url("Dashboard/user_list")?>" type="button" class="btn btn-primary " align="right" >Back</a></div>

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
                                                <td class="weight_bold">Company Name</td>
                                                <td>
                                                <?php echo  $users[0]->company_name; ?>
                                                </td>
                                                </tr>


                                                <tr> 
                                                <td class="weight_bold">Refer Code</td>
                                                <td>
                                                <?php echo  $users[0]->refercode; ?>
                                                </td>
                                                </tr>


                                                



    <tr>
    	<td class="weight_bold">Type</td>
    	<td>
    		<?php 
  
    			if($users[0]->is_commercial==1){
                        echo "Commercial";
                
                }
                else{
                        echo "Non-Commercial";
                
                }


    			 ?>
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
