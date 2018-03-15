<?php
error_reporting(E_ALL);
ini_set('display_error', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardnew extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Admin_modelnew','',TRUE);
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library("braintree_lib");
		  date_default_timezone_set('Asia/Kolkata');
		
		$session_data = $this->session->userdata('logged_in');
		if(!$session_data){
			redirect('Login');
		}
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	/*home page view*/
	public function index()
	{
		$num['totalusers']= $this->db->count_all_results('tbl_users');
		$loginuserscount=$this->db->query("SELECT COUNT(DISTINCT user_id) as loginusers FROM tbl_login where status=1")->row();
		$num['loginusers']=$loginuserscount->loginusers;
		$num['totalmoves']= $this->db->count_all_results('tbl_moveType');
		$num['totalvechicle']= $this->db->count_all_results('tbl_vechicleType');
		$this->template();
		$this->load->view('home',$num);

	}


	/*sidebar,header,headerpage loaded for all view common*/
	public function template($data=null)
	{
		$session_data = $this->session->userdata('logged_in');
		$data['name']=$session_data['fullname'];
		$this->load->view('templete/header');
		$this->load->view('templete/headerpage',$data);
		$this->load->view('templete/sidebar');
        // Footer is loaded in view for js flexibility
	}


    /*user list*/
	public function user_list()
	{
		$data['users']=$this->Admin_modelnew->user_list();
		$this->template();
		$this->load->view('users_list',$data);
	}



	/*driver list*/
	public function driver_list()
	{
		/*update driver list*/
		if (isset($_POST['submitid'])) {
			if (empty($_POST['fname']|| $_POST['lname']   )) {
				$this->session->set_flashdata('msg1', 'Please fill valid fields');
				redirect(base_url()."Dashboard/driver_list");
			}

			$id=$_POST['submitid'];
			$edge = array('fname' => $_POST['fname'], 'lname' => $_POST['lname']);
			$users=array_filter($edge);
			$this->db->where('id', $id);
			$result= $this->db->update('tbl_users', $users);
			if ($result) {
				$this->session->set_flashdata('msg2', 'Driver Updated Sucessfully');
				redirect(base_url()."Dashboard/driver_list");
			}
			else {
				$this->session->set_flashdata('msg3', 'Something Went Wrong');
				redirect(base_url()."Dashboard/driver_list");
			}

		}
		$data['drivers']=$this->Admin_modelnew->driver_list();
		$this->template();
		$this->load->view('driver_list',$data);
	}
	/*booking list*/
	public function booking_list()
	{
		$data['pending_booking_list']=$this->Admin_modelnew->pending_booking_list();
		$data['started_booking_list']=$this->Admin_modelnew->started_booking_list();
		$data['completed_booking_list']=$this->Admin_modelnew->completed_booking_list();
		$data['cancelled_booking_list']=$this->Admin_modelnew->cancelled_booking_list();
		//echo"<pre>";print_r($data);die;

		$this->template();
		$this->load->view('booking_list',$data);
	}


	/*booking list users detail per user id*/
	public function booking_detail($id)
	{		 date_default_timezone_set('Asia/Kolkata');
		$data['booking']=$this->Admin_modelnew->booking_detail($id);
		$this->template();	
		$this->load->view('booking_detail.php',$data);
	}

		/*booking list users detail per user id*/
	public function dispatchbooking_detail($id){
		// print_r($id);
		
		$data['booking']=$this->Admin_modelnew->booking_detail($id);
		$this->template();	
		$this->load->view('dispatchbookingDetail',$data);
	}
	

	
		/* list users detail per user id*/
	public function userDetail($id){
		// print_r($id);die();
		
		$data['users']=$this->Admin_modelnew->users_detail($id);
		$this->template();	
		$this->load->view('usersDetail.php',$data);
	}
			/* list users detail per user id*/
	public function driverDetail($id){

		
		$data['users']=$this->Admin_modelnew->driverdetail($id);
		$this->template();	
		$this->load->view('driverdetail',$data);
	}

	public function dispatch_management()
	{
		// date_default_timezone_set('Asia/Kolkata');
		$data['pending_booking_list']=$this->Admin_modelnew->onpending_booking_list();
		$data['late_booking_list']=$this->Admin_modelnew->late_booking_list();
		// print_r($data['late_booking_list']);die();
		$data['delayed_booking_list']=$this->Admin_modelnew->delayed_booking_list();

		$this->template();
		$this->load->view('dispatchmanagement',$data);
	}



	/*edit users and driver list*/
	public function edituserlist(){
		if (isset($_POST)) {

			if (empty($_POST['fname']|| $_POST['lname']   )) {
				$this->session->set_flashdata('msg1', 'Please fill valid fields');
				redirect(base_url()."Dashboard/user_list");
			}

			$id=$_POST['submitid'];
			$edge = array('fname' => $_POST['fname'], 'lname' => $_POST['lname']);
			$users=array_filter($edge);
			$this->db->where('id', $id);
			$result= $this->db->update('tbl_users', $users);
			if ($result) {
				$this->session->set_flashdata('msg2', 'Users Updated Sucessfully');
				redirect(base_url()."Dashboard/user_list");
			}
			else {
				$this->session->set_flashdata('msg3', 'Something Went Wrong');
				redirect(base_url()."Dashboard/user_list");
			}

		}

	}
	/*move list*/
	public function move_list()
	{
		$data['move']=$this->Admin_modelnew->move_list();
		$this->template();
		$this->load->view('movelist',$data);
	}
	/*view for add move*/
	public function addmove(){
		$this->template();
		$this->load->view('addmove');
	}
	/* move adding*/
	public function addedmove(){
		if (isset($_POST)) {
			if (empty($_POST['title'] && $_POST['type'])) {
				echo "please fill all fields";
			}
			else{
				$data = array(
					'title' => $_POST['title'] ,
					'type' => $_POST['type'] ,

					);


			$image='icon';
            $upload_path='public/movetypeicon';
            $imagename=$this->file_upload($upload_path,$image);
            $data['icon']=$imagename;

	


				// print_r($data);die();
				$result = $this->db->insert('tbl_moveType', $data);
				if ($result) {
					$this->session->set_flashdata('msg4', 'Move Added Sucessfully');
					redirect('Dashboard/move_list');
				}
			}
		}

	}
	/*edit move list*/
	public function editmovelist(){
		if (isset($_POST)) {


			if (empty($_POST['title']|| $_POST['type']  )) {
				$this->session->set_flashdata('msg1', 'Please fill valid fields');
				redirect(base_url()."Dashboard/move_list");
			}

			$id=$_POST['submitid'];





			$image='icon';
            $upload_path='public/movetypeicon';
            $imagename=$this->file_upload($upload_path,$image);
     




			$edge = array('title' => $_POST['title'], 'type' => $_POST['type'],'icon'=>$imagename);
			$plans=array_filter($edge);
			$this->db->where('id', $id);
			$result= $this->db->update('tbl_moveType', $plans);
			if ($result) {
				$this->session->set_flashdata('msg2', 'Move Updated Sucessfully');
				redirect(base_url()."Dashboard/move_list");
			}
			else {
				$this->session->set_flashdata('msg3', 'Something Went Wrong');
				redirect(base_url()."Dashboard/move_list");
			}

		}

	}

    /*delete movetype*/
	public function deletemove(){
		$id=$_POST['id'];
		$table='tbl_moveType';
		$result=$this->Admin_modelnew->delete($id,$table);
		if ($result) {
			echo true;
		}
		else{
			echo false;
		}
	}

	/*delete booking*/
	public function deletebooking(){
		$id=$_POST['id'];
		$table='tbl_booking';
		$result=$this->Admin_modelnew->delete($id,$table);
		if ($result) {
			echo true;
		}
		else{
			echo false;
		}
	}
	/*vechicle type list*/
	public function vechicle_list()
	{
		$data['vechicle']=$this->Admin_modelnew->vechicle_list();
		$this->template();
		$this->load->view('vechiclelist',$data);

	}
	/*view for addvechicle*/
	public function addvechicle(){
		$this->template();
		$this->load->view('addvechicle');
	}
	/*add vechicle*/
	public function addedvechicle(){
		if (isset($_POST)) {
			if (empty($_POST['name'] && $_POST['height'] && $_POST['length'] && $_POST['width'] && $_POST['weight']) ) {
				echo "please fill all fields";
			}
			elseif (($_POST['hourcharges'] != 0 || $_POST['kmcharges'] != 0) ) {
				$data = array(
					'name' => $_POST['name'] ,
					'height' => $_POST['height'] ,
					'length' => $_POST['length'],
					'width' => $_POST['width'],
					'weight' => $_POST['weight'],
					'hours_charges' => $_POST['hourcharges'],
					'km_charges' => $_POST['kmcharges'],	
					);
		
				


					$image='icon';
                    $upload_path='public/vechicletypeicon';
                    $imagename=$this->file_upload($upload_path,$image);



				$data['icon']=$imagename;



				$result = $this->db->insert('tbl_vechicleType', $data);



				if ($result) {
					$this->session->set_flashdata('msg4', 'Vechicle Added Sucessfully');
					redirect('Dashboard/vechicle_list');
				}
			}
			else{

				$this->session->set_flashdata('msg5', 'Pease enter more then 0 value for KM charges or Hours charges ');
				redirect('Dashboard/vechicle_list');
			}
		}

	}
	/*edit vechicle list*/
	public function editvechiclelist(){
		if (isset($_POST)) {
			if(($_POST['hours_charges'] != 0 || $_POST['km_charges'] != 0) ) {




				$image='icon';
                $upload_path='public/vechicletypeicon';
                $imagename=$this->file_upload($upload_path,$image);
				

				$id=$_POST['submitid'];

				$edge = array('name' => $_POST['name'], 'height' => $_POST['height'],'length' => $_POST['length'],'width' => $_POST['width'],'weight' => $_POST['weight'],'hours_charges' => $_POST['hours_charges'],'km_charges' => $_POST['km_charges'],'icon' => $imagename);
				$plans=array_filter($edge);
				$this->db->where('id', $id);
				$result= $this->db->update('tbl_vechicleType', $plans);
				if ($result) {
					$this->session->set_flashdata('msg2', 'vechicle Updated Sucessfully');
					redirect(base_url()."Dashboard/vechicle_list");
				}
				else {
					$this->session->set_flashdata('msg3', 'Something Went Wrong');
					redirect(base_url()."Dashboard/vechicle_list");
				}

			}
			else {
				$this->session->set_flashdata('msg5', 'Please enter more then 0 value for KM charges or Hours charges ');
				redirect('Dashboard/vechicle_list');
			}
		}

	}
    /*delete vechicletype*/
	public function deletevechicle(){
		$id=$_POST['id'];
		$table='tbl_vechicleType';
		$result=$this->Admin_modelnew->delete($id,$table);
		if ($result) {
			echo true;
		}
		else{
			echo false;
		}
	}
	/*delete transaction*/
	public function deletetxn(){
		$id=$_POST['id'];
		$table='tbl_transactions';
		$result=$this->Admin_modelnew->delete($id,$table);
		if ($result) {
			echo true;
		}
		else{
			echo false;
		}
	}
	/*delete user*/
	public function deleteuser(){
		$id=$_POST['id'];
		$table='tbl_users';
		$result=$this->Admin_modelnew->delete($id,$table);
		if ($result) {
			echo true;
		}
		else{
			echo false;
		}
	}
	/*make user commercial*/
	public function usercommercial(){
		$id=$_POST['id'];
		$result=$this->Admin_modelnew->usercommercial($id);
		if ($result) {
			echo true;
		}
		else{
			echo false;
		}
	}
	/*make user commercial*/
	public function usernormal(){
		$id=$_POST['id'];
		$result=$this->Admin_modelnew->usernormal($id);
		if ($result) {
			echo true;
		}
		else{
			echo false;
		}
	}
	/*booking end*/
	public function end(){

		$bookidid=$_POST['id'];
		// $deductprice=$_POST['estfare']+$_POST['estfare'];

			$array = $this->User_model->select_data('*','tbl_booking',array('id'=>$bookidid));
		    $bookingUserDetails = $this->User_model->select_data('*','tbl_users',array('id'=>$array[0]->user_id));
            $bookingDriverDetails = $this->User_model->select_data('*','tbl_login',array('user_id'=>$array[0]->driver_id));




           	$getCardDetail=$this->db->query("SELECT * from tbl_cardDetail  where id='".$array[0]->card_id."'")->result();
              foreach ($getCardDetail as $key => $value) {
                $getCardDetail[$key]->cutomerid=$this->db->query("SELECT * from tbl_braintreeUsersDetail where user_id='".$array[0]->user_id."' and card_no='".$value->card_no."' ")->result();
                
              }
    

                  $totalPrice=$array[0]->estimated_price;

              if (!empty($array[0]->promoid)) {

                $promoDetail=$this->db->query("select * from tbl_promousersData where id='".$array[0]->promoid."'")->result();


                $promoCodeDetail=$this->db->query("select * from tbl_promocode where id='".$promoDetail[0]->promo_id."'")->result();
                if (!empty($promoCodeDetail)) {
            
                $promopercentage=$promoCodeDetail[0]->percentage;
                $promomaxAmount=$promoCodeDetail[0]->max_amount;
                $totalpercent=$totalPrice*($promopercentage/100);
                $roundTotal=($totalpercent);
                if ($roundTotal>$promomaxAmount) {
                    $price=$totalPrice-$promomaxAmount;
                }
                else{
                  $price=$totalPrice-$roundTotal;
                }
                if ($promoDetail[0]->status=1) { 
                $updatePromodata = $this->User_model->update_data('tbl_promousersData',array('status'=>2),array('id'=>$array[0]->promoid));
               }
               else{
                   $updatePromodata = $this->User_model->update_data('tbl_promousersData',array('status'=>3),array('id'=>$array[0]->promoid));
               }

              }

              else{


                 $ReferDetails = $this->User_model->select_data('referal_amount,referal_percentage','tbl_setting');
                 $promopercentage=$ReferDetails[0]->referal_percentage;
                $promomaxAmount=$ReferDetails[0]->referal_amount;
                $totalpercent=$totalPrice*($promopercentage/100);
                $roundTotal=($totalpercent);
                if ($roundTotal>$promomaxAmount) {
                    $price=$totalPrice-$promomaxAmount;
                }
                else{
                  $price=$totalPrice-$roundTotal;
                }
                $updateReferdata = $this->User_model->update_data('tbl_promousersData',array('status'=>2),array('id'=>$array[0]->promoid));
              }
              }
              else{
                $price=$totalPrice;
              }



              
      
              $cusId=$getCardDetail[0]->cutomerid[0]->customer_id;
    

                        $trasactdata = Braintree_Transaction::sale([
                        'amount' => ($price),
                        'customerId' => $cusId
                      
                        ]);
              $msg=$trasactdata->message;
              $txnid=$trasactdata->transaction->id;
             

            if($trasactdata->success==1){
              /*if user balence more then deduct balence start*/

                       $transArray = array(
                                'amount_debited'=>$price,
                                'user_id'=>$array[0]->user_id,
                                'txn_id'=>$txnid,
                                'card_id'=>$array[0]->card_id,
                                'move_id'=>$array[0]->id,
                                'type'=>'1',
                                'date_created'=>date('Y-m-d H:i:s')
                                );
                 $transResponse = $this->User_model->insert_data('tbl_transactions',$transArray);


                   $bookDetails = $this->User_model->select_data('*','tbl_booking',array('id'=>$array[0]->id));
                   if ($bookDetails[0]->is_started==0) {
                   	$bookingdata = $this->User_model->update_data('tbl_booking',array('is_started'=>1,'is_completed'=>1),array('id'=>$array[0]->id));    	
                   }
                
                   else{
                $bookingdata = $this->User_model->update_data('tbl_booking',array('is_completed'=>1),array('id'=>$array[0]->id));
                 }
         
                $moveData = array(
                "driver_id"=>$array[0]->driver_id,
                "status"=>3,
                'completed_time'=>date('Y-m-d H:i:s')
                );

                $insertMove_history = $this->User_model->update_data('tbl_moveHistory',$moveData,array("booking_id"=>$array[0]->id));
                $bookinguserDetails = $this->User_model->select_data('*','tbl_users',array('id'=>$array[0]->user_id));
                $action = "Move completed";

                $bookingdriverDetails = $this->User_model->select_data('*','tbl_users',array('id'=>$array[0]->driver_id));
                $bookingloginuserDetails = $this->User_model->select_data('*','tbl_login',array('user_id'=>$array[0]->user_id,'status'=>1));
                $get_percentage = $this->User_model->select_data('*','tbl_setting');
                $percentage = $get_percentage[0]->min_booking_charge;


                /*update in driver fund table start*/
                $getDriverBalance = $this->User_model->select_data('*','tbl_driversFund',array('driver_id'=>$bookingdriverDetails[0]->id));

                $getDriverWallet = $this->User_model->select_data('*','tbl_wallet',array('user_id'=>$bookingdriverDetails[0]->driver_id));


                 // print_r($getDriverBalance);die();


                 $getAdminpercent=$totalPrice*($array[0]->admin_percentage/100);
                 $Driverbalance=$totalPrice-$getAdminpercent;

                $updatedriveramount=$getDriverBalance[0]->outstanding_amount+$Driverbalance;
                $uptdriverDAta = $this->User_model->update_data('tbl_driversFund',array('outstanding_amount'=>$updatedriveramount,'date_modified'=>date('Y-m-d H:i:s')),array('driver_id'=>$bookingdriverDetails[0]->id));

                $newDriverbalance=$getDriverWallet[0]->balence+$Driverbalance;
                $uptwalletdriverDAta = $this->User_model->update_data('tbl_wallet',array('balence'=>$newDriverbalance,'date_modified'=>date('Y-m-d H:i:s')),array('user_id'=>$bookingdriverDetails[0]->id));




                $transUserArray = array(
                'amount_credited'=>$Driverbalance,
                'user_id'=>$array[0]->user_id,
                'move_id'=>$array[0]->id,
                'txn_id'=>'on_wallet',
                'type'=>'1',
                'date_created'=>date('Y-m-d H:i:s')
                );
                $transResponse = $this->User_model->insert_data('tbl_transactions',$transUserArray);
                /*update in driver fund table end*/
                /*driver pay end*/
                /*send push message start*/
                $pushData['message'] = "Your task with ".$bookingdriverDetails[0]->fname.' '.$bookingdriverDetails[0]->lname." has completed";
                $pushData['action'] = "Move completed";
                $pushData['booking_id'] = $array[0]->id;
                $pushData['Utype'] = 2;
                $pushData['iosType'] = 6;/*completed */
                foreach ($bookingloginuserDetails as $key => $value) {
                $pushData['token'] = $value->token_id;
                if($value->device_id == 1){
                $this->User_model->iosPush($pushData);
                }else if($value->device_id == 0){
                $this->User_model->androidPush($pushData);
                }
                }
                /*send push message end*/


                          /**/
                         }
            /*end push by admin type 6*/
		



		if ($transResponse) {
			echo true;
		}
		else{
			echo false;
		}
	}
	public function deactiveuser(){


		$id=$_POST['id'];

			$this->db->select('*');
				$this->db->from('tbl_users');
				$this->db->join('tbl_login', 'tbl_login.user_id = tbl_users.id');
				$this->db->where('tbl_users.id', $id);
				$this->db->where('tbl_login.status', 1);
				$data = $this->db->get()->result();
			
			
			foreach ($data as $key => $value) {
			

				
				$pushData['message']="your account has been suspended";
				$pushData['iosType']=14;/*account suspendationend*/	
                $pushData['action'] = "account suspended";
                $pushData['booking_id'] = "";
				$pushData['token'] = $value->token_id;
				if ($value->device_id==0) {
					$push=$this->androidPush($pushData);
				
				}
				else{
					if ($value->user_Type==1) {
							$pushData['Utype']=2;
						$push=$this->iosPush($pushData);
					}
					else{
						$pushData['Utype']=1;
						$push=$this->iosPush($pushData);
					}

				}
			}
		
	

		$result=$this->Admin_modelnew->update_data('tbl_users',array('is_suspend'=>1),array('id'=>$id));
		$result12=$this->Admin_modelnew->update_data('tbl_login',array('status'=>0),array('user_id'=>$id));
		if ($result) {
			echo true;
		}
		else{
			echo false;
		}
     }


     	public function activeuser(){
		$id=$_POST['id'];
		$result=$this->Admin_modelnew->update_data('tbl_users',array('is_suspend'=>0),array('id'=>$id));
		if ($result) {
			echo true;
		}
		else{
			echo false;
		}
     }

	/*activate driver*/
	public function activateuser(){


		$id=$_POST['id'];
		$result=$this->Admin_modelnew->update_data('tbl_users',array('is_activate'=>1),array('id'=>$id));
		$selectusers = $this->Admin_modelnew->select_data('*','tbl_users',array('id'=>$id));

			$this->load->helper('string');
     	 	$password= random_string('alnum',8);
     	 	$md5password=md5($password);
     	 	$email=$selectusers[0]->email;
     	 	$result12=$this->Admin_modelnew->update_data('tbl_users',array('password'=>$md5password),array('id'=>$id));


		$body = "<!DOCTYPE html>
        <head>
        <meta content=text/html; charset=utf-8 http-equiv=Content-Type />
        <title>Feedback</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
        </head>
        <body>
        <table style='background:rgba(28, 182, 140, 0.8) none repeat scroll 0 0; border: 3px solid #1cb68c;' width=60% border=0 bgcolor=#53CBE6 style=margin:0 auto; float:none;font-family: 'Open Sans', sans-serif; padding:0 0 10px 0; >
        <tr>
        <th width=20px></th>
        <th width=20px  style='padding-top:30px;padding-bottom:30px;'><img src='http://movers.com.au/Admin/public/img/changepassword/ic_van-logo.png' style='width: 40%;'></th>
        <th width=20px></th>
        </tr>
        <tr>
        <td width=20px></td>
        <td bgcolor=#fff style=border-radius:10px;padding:20px;>
        <table width=100%;>
        <tr>
        <th style=font-size:20px; font-weight:bolder; text-align:right;padding-bottom:10px;border-bottom:solid 1px #ddd;> Hello " . $selectusers[0]->fname . "</th>
        </tr>

        <tr>
        <td style=font-size:16px;>
        <p> You have requested a password generation for your Movers account at Movers.This is Your temporary password and you can this by login in app.</p>
         
        <p>This is Your Password ".$password."</p>
        </td>
        </tr>


        <tr>
        <td style=text-align:center; padding:20px;>
        <h2 style=margin-top:50px; font-size:29px;>Best Regards,</h2>
        <h3 style=margin:0; font-weight:100;>Customer Support</h3>
   
        </td>
        </tr>
        </table>
        </td>
        <td width=20px></td>
        </tr>
        <tr>
        <td width=20px></td>
        <td style='text-align:center; color:#fff; padding:10px;'> Copyright © Movers All Rights Reserved</td>
        <td width=20px></td>
        </tr>
        </table>
        </body>";

          $this->load->library('email');
         
          $this->email->set_newline("\r\n");
          $this->email->to($email);
          $this->email->from('moverOndemand@gmail.com', 'MOVERS');
          $this->email->subject('First Time Login');
          $this->email->message($body);
          $mail = $this->email->send();
		
		if ($result12) {
			echo true;
		}
		else{
			echo false;
		}
	}
	/*promocodes list*/
	public function promocode_list()
	{
		/*edit promo list*/
		if (isset($_POST['editpromo'])) {
			$id=$_POST['edit'];	    
			$edge = array('promo_code' => $_POST['promo'], 'value' => $_POST['value'],'max_amount' => $_POST['maxamount'],'expiry_date' => $_POST['date'],'user_max_usage'=> $_POST['maxusageperuser']);
			$plans=array_filter($edge);
			$this->db->where('id', $id);
			$result= $this->db->update('tbl_promocode', $plans);
			if ($result) {
				$this->session->set_flashdata('msg4', 'Promo Code Updated Sucessfully');
				redirect(base_url()."Dashboard/promocode_list");
			}
			else {
				$this->session->set_flashdata('msg3', 'Something Went Wrong');
				redirect(base_url()."Dashboard/promocode_list");
			}

		}
		/*add new promo in the list*/
		elseif (isset($_POST['addpromo'])) {
			// print_r($_POST);die();
			if (empty($_POST['name']|| $_POST['value']  || $_POST['promo_usage'] ||$_POST['date']  )) {
				$this->session->set_flashdata('msg1', 'Please fill valid fields');
				redirect(base_url()."Dashboard/promo_list");
			}
			$data = array('promo_code' => $_POST['name'], 'value' => $_POST['value'],'max_amount' => $_POST['maxamount'],  'user_max_usage' => $_POST['perusermaxusage'], 'expiry_date' => $_POST['date']);	
			$result = $this->db->insert('tbl_promocode', $data);
			if ($result) {
				$this->session->set_flashdata('msg2', 'Promo Code Added Sucessfully');
				redirect(base_url()."Dashboard/promocode_list");
			}
			else {
				$this->session->set_flashdata('msg3', 'Something Went Wrong');
				redirect(base_url()."Dashboard/promocode_list");
			}


		}

		$data['promocode']=$this->Admin_modelnew->promocode_list();
		$this->template();
		$this->load->view('promocode_list',$data);
	}
	/*add promocodes list*/
	public function addpromocode()
	{
		$this->template();
		$this->load->view('addpromo',$data);

	}
	/*add cities list*/
	public function addcities()
	{
		$this->template();
		$this->load->view('addcities',$data);

	}
	public function addcity(){
		if (isset($_POST)) {

			$city=$_POST['title'];
			$add= explode(",",$city);
			$citi=$add[0];
			$city_code=$add[1];
			$country=$add[2];
			if (!empty($citi) && !empty($city_code) && !empty($country) ) {
		

			$data=array('city_name'=>$citi,'city_code'=>$city_code,'country_name'=>$country );
			$result = $this->db->insert('tbl_cities', $data);
				if ($result) {
					$this->session->set_flashdata('msg4', 'City Added Sucessfully');
					redirect('Dashboard/addcities');
				}
			}
			else{

				$this->session->set_flashdata('msg2', 'please fill valid filled');
				redirect('Dashboard/addcities');

			}
		}
	}
	public function cityview(){
		$this->template();
		$data['city']=$this->Admin_modelnew->city_list();
		// print_r($data);

		$this->load->view('cityview',$data);
	}
	/*	delete promo code*/
	public function deletepromo(){
		$id=$_POST['id'];
		$table='tbl_promocode';
		$result=$this->Admin_modelnew->delete($id,$table);
		if ($result) {
			echo true;
		}
		else{
			echo false;
		}
	}
	public function deletecity(){
		$id=$_POST['id'];
		$table='tbl_cities';
		$result=$this->Admin_modelnew->delete($id,$table);
		if ($result) {
			echo true;
		}
		else{
			echo false;
		}
	}

  /*common upload function start*/
        public function file_upload($upload_path, $image) {  
            $baseurl = base_url();
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '5000';
            $config['max_width'] = '5024';
            $config['max_height'] = '5068';      

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($image))
            {
                $error = array(
                    'error' => $this->upload->display_errors()
                    );

                return $imagename = "";
            }
            else
            {
                $detail = $this->upload->data(); 
                return $imagename = $baseurl . $upload_path .'/'. $detail['file_name'];
            }
        }
	public function addsetting()
	{
		if (isset($_POST['setting'])) {
			// print_r($_POST);die();
			$settingid=$_POST['settingid'];

			$edge = array('min_booking_charge' => $_POST['title'],'buffer_time' => $_POST['time'],'referal_amount'=>$_POST['refrralamount'],'loading_rate'=>$_POST['loadingtime'],'unloading_rate'=>$_POST['unloadingtime'],'flight_charges'=>$_POST['flightcharges'],'movers_charges'=>$_POST['moverscharges'],'referal_percentage'=>$_POST['refrralpercent'],'admin_percentage'=>$_POST['adminpercentage'],'move_complete_buffer_time'=>$_POST['move_complete_buffer_time']);
			// $plans=array_filter($edge);
			$this->db->where('id', $settingid);
			$result= $this->db->update('tbl_setting', $edge);
			if($result){
				$this->session->set_flashdata('msg4', 'Data Updated Sucessfully');
				redirect(base_url()."Dashboard/addsetting");
			}
			else {
				$this->session->set_flashdata('msg3', 'Something Went Wrong');
				redirect(base_url()."Dashboard/addsetting");
			}

		}

		$data['setting']=$this->Admin_modelnew->setting_list();
		$this->template();
		$this->load->view('addsetting',$data);
	}
	public function transaction_list(){
		$data['transaction']=$this->Admin_modelnew->transaction_list();
		$this->template();
		$this->load->view('transaction',$data);
	}
	public function wallet_list(){
		$data['wallet_customerlist']=$this->Admin_modelnew->wallet_customerlist();
		$data['wallet_driverlist']=$this->Admin_modelnew->wallet_driverlist();
		$this->template();
		$this->load->view('wallet',$data);
	}
	/*pay to driver from admin panel outstanding amount*/


			/*on construction process*/


			
	public function payamount(){
		if (isset($_POST)) {

			
			$amount=$_POST['amnt'];
			$id=$_POST['submitid'];
			$newAmt=$_POST['amount'];
			$card=$_POST['cardnumber'];
			$expiry=$_POST['expirydate'];
			


			/*braintree transaction process start*/
			// $result = Braintree_Transaction::sale(array(
			// 	'amount' => $amount,
			// 	'creditCard' => array(
			// 		'number' => $card,
			// 		'expirationDate' => $expiry
			// 		)
			// 	));
			/*braintree transaction process end*/

			if ($result->success==1) {


				     $addtransArray = array(
                      'amount_debited'=>$amount,
                      'user_id'=>$id,
                      'txn_id'=>$result->transaction->id,
                      'type'=>"4",
                      'date_created'=>date('Y-m-d H:i:s')
                      );
                      $addtrans = $this->User_model->insert_data('tbl_transactions',$addtransArray);


				$getdata = $this->Admin_modelnew->select_data('*','tbl_wallet',array('user_id'=>$id));
				$get_amount = $this->Admin_modelnew->select_data('*','tbl_driversFund',array('driver_id'=>$id));
				$oldAmt=$get_amount[0]->outstanding_amount;
				$oldpaid_Amt=$get_amount[0]->paid_amount;
				$old=$getdata[0]->balence;


				$newAmount=$old+$amount;


				$newOutStanding_amnt= $oldAmt-$amount;

				$uptDAta = $this->Admin_modelnew->update_data('tbl_wallet',array('balence'=>$newAmount,'date_modified'=>date('Y-m-d H:i:s')),array('user_id'=>$id));
				$newpaid_amnt=$oldpaid_Amt+$amount;
				$this->Admin_modelnew->update_data('tbl_driversFund',array('outstanding_amount'=>$newOutStanding_amnt,'paid_amount'=>$newpaid_amnt),array('driver_id'=>$id));
				// echo true;


				$this->session->set_flashdata('msg1', 'Amount Paid sucessfully');
				redirect(base_url()."Dashboard/wallet_list");

			}
			else if ($result->transaction) {
				$this->session->set_flashdata('msg2', 'Something Went wrong');
				redirect(base_url()."Dashboard/wallet_list");
				echo false;
			} else {
				$this->session->set_flashdata('msg2', 'Something Went wrong');
				redirect(base_url()."Dashboard/wallet_list");
				echo false;
			}
			
		}
	}	
	
	public function push_notification(){
		if (!empty($_POST['message'])) {
			$email=$_POST['email'];
			if (($_POST['fooby']==1 || $_POST['fooby']==2)) {
				$type=$_POST['fooby'];
				$this->db->select('*');
				$this->db->from('tbl_users');
				$this->db->join('tbl_login', 'tbl_login.user_id = tbl_users.id');
				$this->db->where('tbl_login.status', 1);
				$this->db->where('tbl_users.user_Type', $type);
				$data = $this->db->get()->result();
			}elseif(!empty($email)){
				$this->db->select('*');
				$this->db->from('tbl_users');
				$this->db->join('tbl_login', 'tbl_login.user_id = tbl_users.id');
				$this->db->where('tbl_login.status', 1);
				$this->db->where('tbl_users.email',$email);
				$data = $this->db->get()->result();
			//	echo"<pre>";print_r($data);die;
			}
			else{
				$this->db->select('*');
				$this->db->from('tbl_users');
				$this->db->join('tbl_login', 'tbl_login.user_id = tbl_users.id');
				$this->db->where('tbl_login.status', 1);
				$data = $this->db->get()->result();
			}
			foreach ($data as $key => $value) {

		
		

				$pushData['message']=$_POST['message'];
				$pushData['action']="Broadcast message";
				$pushData['booking_id']=" ";

				$pushData['iosType']=12;/*braodcast msg*/
				$pushData['token']=$value->token_id;		
				
				if ($value->device_id==0) {
						
						$push=$this->androidPush($pushData);
					
				}
				else{
					if ($value->user_Type==1) {
						$pushData['Utype']=1;
						$push=$this->iosPush($pushData);
					}
					else{
						$pushData['Utype']=2;
						$push=$this->iosPush($pushData);
					}

				}
			}

			if ($data) {
				$this->session->set_flashdata('msg1', 'Broadcast message has been sent sucessfully');
				redirect(base_url()."Dashboard/push_notification");
			}
			else{
				$this->session->set_flashdata('msg2', 'Something Went wrong');
				redirect(base_url()."Dashboard/push_notification");
			}
		}
		$this->template();
		$this->load->view('push');
	}
		public function serviceRequest(){
		if (isset($_POST)) {
			// $uptbookDAta = $this->Admin_modelnew->update_data('tbl_booking',array('is_accepted'=>1,'driver_id'=>$_POST['serviceProvider']),array('id'=>$_POST['reqid'],'user_id'=>$_POST['userId']));
			// $uptbookDAta = $this->Admin_modelnew->update_data('tbl_moveHistory',array('status'=>1,'driver_id'=>$_POST['serviceProvider'],'accepted_time'=>date('Y-m-d H:i:s')),array('id'=>$_POST['reqid']));
			$selectusers = $this->Admin_modelnew->select_data('*','tbl_users',array('id'=>$_POST['userId']));
			$selectusers = $this->Admin_modelnew->select_data('*','tbl_users',array('id'=>$_POST['serviceProvider']));
			$selectuserlogin=$this->Admin_modelnew->select_data('*','tbl_login',array('user_id'=>$_POST['userId'],'status'=>1));
				print_r($selectuserlogin);
			$selectdriverlogin=$this->Admin_modelnew->select_data('*','tbl_login',array('user_id'=>$_POST['serviceProvider'],'status'=>1));
			// $selectdriverlogin=$this->Admin_modelnew->select_data('*','tbl_login',array('user_id'=>$_POST['serviceProvider'],'status'=>1));
			print_r($selectdriverlogin);
			die();

						$pushData['Utype'] = 2;
		        		$pushData['action'] = "driver accepted your job";
		                $pushData['iosType'] = 4;/*forcefully assign*/  
                    foreach ($selectuserlogin as $key => $value) {
                    
                      $pushData['token'] = $value->token_id;
                      if($value->device_id == 1){
                        $this->iosPush($pushData);
                      }else if($value->device_id == 0){
                        $this->androidPush($pushData);
                      }
                    }
 				       $pushData['Utype'] = 1;
 				       $pushData['iosType'] = 13;/*forcefully assign*/
                 $pushData['action'] = "admin assigned forcefully task";
      
                    foreach ($selectdriverlogin as $key => $value) {
                    
                      $pushData['token'] = $value->token_id;
                      if($value->device_id == 1){
                        $this->iosPush($pushData);
                      }else if($value->device_id == 0){
                        $this->androidPush($pushData);
                      }
                    }
                $this->session->set_flashdata('msg1', 'You have assigned driver forecefully');
				redirect(base_url()."Dashboard/booking_list");
			
		}
	}
	public function feedback(){
	    $data['feedback']=$query = $this->db->get('tbl_feedback')->result();
		$this->template();
		$this->load->view('feedback',$data);
	}
	public function serviceRequest2(){
		if (isset($_POST)) {
			$uptbookDAta = $this->Admin_modelnew->update_data('tbl_booking',array('is_accepted'=>1,'driver_id'=>$_POST['serviceProvider']),array('id'=>$_POST['reqid'],'user_id'=>$_POST['userId']));
			$uptbookDAta = $this->Admin_modelnew->update_data('tbl_moveHistory',array('status'=>1,'driver_id'=>$_POST['serviceProvider'],'accepted_time'=>date('Y-m-d H:i:s')),array('id'=>$_POST['reqid']));
			$selectusers = $this->Admin_modelnew->select_data('*','tbl_users',array('id'=>$_POST['userId']));
			$selectusers = $this->Admin_modelnew->select_data('*','tbl_users',array('id'=>$_POST['serviceProvider']));
			$selectuserlogin=$this->Admin_modelnew->select_data('*','tbl_login',array('user_id'=>$_POST['userId'],'status'=>1));

			// print_r($selectuserlogin);
			$selectdriverlogin=$this->Admin_modelnew->select_data('*','tbl_login',array('user_id'=>$_POST['serviceProvider'],'status'=>1));
			// print_r($selectdriverlogin);
	
		        $pushData['action'] = "driver accepted your job";
		         $pushData['Utype'] = 2;
		              $pushData['iosType'] = 4;/*accepted by driver*/
      
                    foreach ($selectuserlogin as $key => $value) {
                    
                      $pushData['token'] = $value->token_id;
                      if($value->device_id == 1){
                        $this->iosPush($pushData);
                      }else if($value->device_id == 0){
                        $this->androidPush($pushData);
                      }
                    }

                  $pushData['Utype'] = 1;
                       $pushData['iosType'] = 13;/*forcefully assign*/
                 $pushData['action'] = "admin assigned forcefully task";
      
                    foreach ($selectdriverlogin as $key => $value) {
                    
                      $pushData['token'] = $value->token_id;
                      if($value->device_id == 1){
                        $this->iosPush($pushData);
                      }else if($value->device_id == 0){
                        $this->androidPush($pushData);
                      }
                    }
                    		// die();
                $this->session->set_flashdata('msg1', 'You have assigned driver forecefully');
				redirect(base_url()."Dashboard/dispatch_management");
			
		}
	}
	/*push notification for android common function*/
    public function androidPush($pushData=null){
 
	    $mytime = date("Y-m-d H:i:s");
	     $api_key = "AAAANVzzBLc:APA91bHbiNHUFrqMisFYeCXmk11hnwNCG9WfzuiRoHGiiQD0wL9Quv4SlEaNgd6pQdqObnL7eetzJ5MSk1Pq0agkPwiOh_J5M9sxcS9HlchG5g90yxcIh4-AGXIbCTYiZ0vg6bSKu1wR";  //for user app
	    $fcm_url = 'https://fcm.googleapis.com/fcm/send';
	 	$fields = array(
      		'registration_ids' => array(
        	$pushData['token']
      		) ,
	     	 'data' => array(
	     	 	"spMessage"=>$pushData['spMessage'],
				"from_name"=>$pushData['from_name'],
				"profile_pic"=>$pushData['profile_pic'],
				"from_id"=>$pushData['from_id'],
	      	  "message" =>$pushData['message'] ,
	      	  "name" =>$pushData['name'] ,
	      	  "action" => $pushData['action'],
	      	  'booking_id' => $pushData['booking_id'],
	      	  'profile_pic' => $pushData['profile_pic'],
	      	  "avgrating" => $pushData['avgrating'],
	      	  "vehicleName" => $pushData['vehicleName'],
	      	  'vehicleNumber' => $pushData['vehicleNumber'],
	       	  "time" => $mytime
	      ) ,
	    );
	    $headers = array(
	      'Authorization: key=' . $api_key,
	      'Content-Type: application/json'
	    );
	    $curl_handle = curl_init();
	    // set CURL options
	    curl_setopt($curl_handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	    curl_setopt($curl_handle, CURLOPT_URL, $fcm_url);
	    curl_setopt($curl_handle, CURLOPT_POST, true);
	    curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode($fields));
	    $response = curl_exec($curl_handle);
	   // print_r($response);
	    curl_close($curl_handle);
  	}


	/*push notification for ios common function*/
	public function iosPush($pushData=null) {
	  		// print_r($pushData);die(); 0dc917431df2e0438acd600ee33abb388e01f4e1ce0f3fae503ed69b404617c3
		    $deviceToken = $pushData['token'];
		   	$mytime = date("Y-m-d H:i:s");
	
		// $deviceToken = "0dc917431df2e0438acd600ee33abb388e01f4e1ce0f3fae503ed69b404617c3";
		    $passphrase = '';
		    $ctx = stream_context_create();
		    if($pushData['Utype'] == 1){/*for driver push*/
		    stream_context_set_option($ctx, 'ssl', 'local_cert', './certs/MoversProvider.pem');
		    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase); 
		    }elseif ($pushData['Utype'] == 2) {
		    stream_context_set_option($ctx, 'ssl', 'local_cert', './certs/MoversOnDemand.pem');
		    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
		    }
		    // Open a connection to the APNS server
		    $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
		   // if (!$fp) exit("Failed to connect: $err $errstr" . PHP_EOL);
			 $body['aps'] = array(
		         	 	"spMessage"=>$pushData['spMessage'],
						"from_name"=>$pushData['from_name'],
						"pic"=>$pushData['profile_pic'],
						  'alert' => array(
					           'title' => $pushData['name'],
					           'body' =>$pushData['message']
					       ),
					  "from_id"=>$pushData['from_id'],
			      	  "message" =>$pushData['message'] ,
			      	  "name" =>$pushData['name'] ,
			      	  "iosType"=>$pushData['iosType'] ,
			      	  "action" => $pushData['action'],
			      	  'date_created' => $mytime,
			      	  'booking_id' => $pushData['booking_id'],
			      	  'profile_pic' => $pushData['profile_pic'],
			      	  "avgrating" => $pushData['avgrating'],
			      	  "vehicleName" => $pushData['vehicleName'],
			      	  'vehicleNumber' => $pushData['vehicleNumber'],
		              'sound' => 'default'
		    		);


		      // $body['aps'] = array(
		      //               'from_id' => $from_id,
		      //               'from_name' => $name,
		      //               'pic' => $profile_pic,
		      //               // 'alert' => $name,
		      //               // 'body' => $mess,
		      //               'alert' => array(
					   //         'title' => $name,
					   //         'body' =>$mess
					   //      ),
		               
		      //               'action' => $action,
		      //               'created_date' => $date,
		      //               'sound' => 'default',
		      //               "count" => $count,
		      //               "message" => $orMessage,
		      //               "badge" => intval($count_query)
		      //           );
		       


		    // Encode the payload as JSON
		    $payload = json_encode($body);
		    // Build the binary notification
		    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		    $result = fwrite($fp, $msg, strlen($msg)); 
		    // print_r($result);

		    fclose($fp);
  		}
		public function assign(){

		$id=$_POST['reqid'];
		$serviceTime = $this->Admin_modelnew->select_data('*','tbl_booking',array('id'=>$id));
		$list = $this->Admin_modelnew->freeServiceProviders($serviceTime);

		if (!empty($list)) {
			$arr = '';
			foreach ($list as $key => $value) {
				$arr .= "<option value=$value->id> #$value->id | $value->email | $value->fname $value->lname </option>";
			}
			$a = '<div class="form-group">
			<label for="selectbox">Assign Service Provider</label>
			<select class="form-control" id="serviceProvider" name = "serviceProvider">
			<option disabled>Select Driver </option>'.$arr.'
			</select>
			<input type="hidden" name="reqid" value="'.$_POST["reqid"].'">
			<input type="hidden" name="userId" value="'.$_POST["userId"].'">
			</div><button type="submit" name = "assignServiceProvider" value="1" class="btn btn-default">Submit</button>';
			echo json_encode($a);
		} else {
			echo json_encode("No Driver Free for this Booking Time");
		}
	}

	/* cancel and refund button in pending booking list */
	public function cancel_refund(){
		$id=$_POST['id'];


            $bookingDetails = $this->User_model->select_data('*','tbl_booking',array('id'=>$id));
		  
              $txndetail=$this->db->query("SELECT * FROM tbl_transactions where user_id='".$bookingDetails[0]->user_id."' AND move_id='".$id."' ORDER BY date_created DESC Limit 1")->result();
  						$result12 = Braintree_Transaction::submitForSettlement($txndetail[0]->txn_id);
                        $result = Braintree_Transaction::refund($txndetail[0]->txn_id);

                      // print_r($result);die();


                        $txnid=$result->transaction->id;
                        $amount=$result->transaction->amount;                                         
                       $transArray = array(
                                'amount_credited'=>$amount,
                                'user_id'=>$txndetail[0]->user_id,
                                'txn_id'=>$txnid,
                                'card_id'=>'',
                                'move_id'=>$id,
                                'type'=>'refund for cancellation of booking',
                                'date_created'=>date('Y-m-d H:i:s')
                                );
                 $transResponse = $this->Admin_modelnew->insert_data('tbl_transactions',$transArray);



                   $bookingdata = $this->User_model->update_data('tbl_booking',array('is_cancelled'=>1),array('id'=>$id));
              
                $updateMove_history = $this->User_model->update_data('tbl_moveHistory',array('status'=>4,'cancelled_time'=>date('Y-m-d H:i:s'),'cancelled_by'=>3),array('booking_id'=>$id));

                $bookingDetails = $this->User_model->select_data('*','tbl_booking',array('id'=>$id));

                $bookinguserDetails = $this->User_model->select_data('*','tbl_users',array('id'=>$bookingDetails[0]->user_id));
          
                $bookingloginuserDetails = $this->User_model->select_data('*','tbl_login',array('user_id'=>$bookingDetails[0]->user_id,'status'=>1));
                /*push message start*/
                $pushData['message'] = "Admin  has cancelled your task request and refunded you";
                $pushData['action'] = "Move cancelled";
                $pushData['booking_id'] = $bookingDetails[0]->id;
                $pushData['Utype'] = 1;
                 $pushData['iosType'] = 12;/*cancel by admin*/
                

                foreach ($bookingloginuserDetails as $key => $value) {

                  $pushData['token'] = $value->token_id;
                  if($value->device_id == 1){
                    $this->User_model->iosPush($pushData);
                  }else if($value->device_id == 0){
                    $this->User_model->androidPush($pushData);
                  }
                }




		if (!empty($transResponse)) {
			echo true;
		}
		else{
			echo false;
		}
	}

	/* contact driver and contact customer button in late booking list */
	public function contact_driver_customer(){
		$id=$_POST['id'];
		$bookingDetail = $this->Admin_modelnew->select_data('*','tbl_booking',array('id'=>$id));
		$bookeduserDetail = $this->Admin_modelnew->select_data('*','tbl_users',array('id'=>$bookingDetail[0]->user_id));
		$driverDetail = $this->Admin_modelnew->select_data('*','tbl_users',array('id'=>$bookingDetail[0]->driver_id));

		if ($id) {
			echo true;

			
		}
		else{
			echo false;
		}
	}
	/* tracking button in delayed booking list */
	public function track(){
		$id=$_POST['id'];
		//$var= $this->db->select_data('*','tbl_users',array('id'=>$id));
		if ($id) {
			echo true;
		}
		else{
			echo false;
		}
	}



}


