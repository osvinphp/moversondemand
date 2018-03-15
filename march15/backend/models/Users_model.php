<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_model extends CI_Model{
public function __construct() {
parent::__construct();
$this->load->database();
$this->load->helper('url');

}
public function sign_up($data,$loginParams,$type,$refercode,$user_refercode){
/*mannual signup start*/
if ($type == 1) {

$data['manual_signUp'] = 1;
$data['user_Type']=1;
$data['refercode']=$refercode;
// $data['used_refercode']=$user_refercode;

$var = $this->db->select('*')
->from('tbl_users')
->where('email',$data['email'])
->get()->result();
	if(empty($var)){	

				$this->db->insert('tbl_users', $data);
				$insertId = $this->db->insert_id();
		
				$loginParams['user_id'] = $insertId;
				$this->db->insert('tbl_login', $loginParams);
				$getRes = $this->User_model->select_data('*','tbl_users',array('id'=>$insertId));
				return $getRes;			
	}
	else{

		return 0;
	}
}
/*mannual signup end*/
/*fb signup start*/
elseif($type == 2) { 
	$data['fb_signUp'] = 1;
	$data['user_Type'] =1;
	$data['refercode'] =$refercode;
	// $data['used_refercode']=$user_refercode;
	$query = $this->db->select('*')
	->from('tbl_users');
	if($data['fb_id']){$query->where('fb_id',$data['fb_id']);}
	if($data['email']){$query->or_where('email',$data['email']);}
		$var= $query->get()->result();
		if(empty($var)){								
			$this->db->insert('tbl_users', $data);
			$insertId = $this->db->insert_id();
			
			$loginParams['user_id'] = $insertId;
			$this->db->insert('tbl_login', $loginParams);
			$getRes = $this->User_model->select_data('*','tbl_users',array('id'=>$insertId));
			return $getRes;
		}
		else{
				return 0;
		}
}
/*fb signup end*/
/*google signup start*/
elseif($type == 3) { 
	$data['google_signUp'] = 1;
	$data['user_Type'] = 1 ;
	$data['refercode']=$refercode;
	// $data['used_refercode']=$user_refercode;
	$query = $this->db->select('*')
	->from('tbl_users');
	if($data['google_id']){$query->where('google_id',$data['google_id']);}
	if($data['email']){$query->or_where('email',$data['email']);}
	$var= $query->get()->result();
		if(empty($var)){	
			$this->db->insert('tbl_users', $data);
			$insertId = $this->db->insert_id();
		
			$loginParams['user_id'] = $insertId;
			$this->db->insert('tbl_login', $loginParams);
			$getRes = $this->User_model->select_data('*','tbl_users',array('id'=>$insertId));
			return $getRes;
		}else{
			return 0;
		}	
} 
/*google signup end*/
}
public function login($data,$loginParams,$type,$user_type){


	// print_r($user_type);die();
/*mannual login start*/
	if ($type == 1) {
		$selectData = $this->db->select('*')
		->from('tbl_users')
		->where('email',$data['email'])
		->where('password',$data['password'])

		->get()->result();

			if(empty($selectData)){		     
			return 0;
			}
			else
			{
				if ($selectData[0]->is_suspend==1) {
					return 6;
				}
				else{

					
 				$typer=$selectData[0]->user_Type;
 				/*checking of type in case customer app or driver app*/
					$loginParams['user_id'] = $selectData[0]->id;
					if ($user_type==$typer) {
						
				if ($user_type==1) {
				
					$this->db->insert('tbl_login', $loginParams);
					$getRes = $this->User_model->select_data('*','tbl_users',array('email'=>$data['email']));
				
					return $getRes;
				}


				elseif ($user_type==2) {
					$getlogin = $this->User_model->select_data('*','tbl_login',array('user_id'=>$loginParams['user_id'],'status'=>1));
						   $pushData['message'] = "You have been logout";
                          $pushData['action'] = "Logout";
                          $pushData['booking_id'] = " ";
                          $pushData['Utype'] = 1;
                          $pushData['iosType'] = 15;/*for new book*/
					foreach ($getlogin as $key => $value) {

						     $pushData['token'] = $value->token_id;
                                    
                                if($value->device_id == 1){

                                 $this->iosPush($pushData);

                                }else if($value->device_id == 0){

                                 $this->androidPush($pushData);
                                }
					}
					$loginParams['user_id'] = $selectData[0]->id;
				  $this->update_data('tbl_login',array('status'=>0),array('user_id'=>$loginParams['user_id']));
					$this->db->insert('tbl_login', $loginParams);
					$getRes = $this->User_model->select_data('*','tbl_users',array('email'=>$data['email']));
					return $getRes;
				}
			}
				else{
					return 1;
				}



			}
		    }
	}
	/*mannual login end*/



	/*fb login start*/
	else if ($type == 2){
		$selectsocial = $this->db->select('*')
		->from('tbl_users')
		->where('fb_id',$data['fb_id'])
		->get()->row();
		/*if fb id doesnot exists start*/
			if(empty($selectsocial)){
				if(!empty($data['email'])){
				$selectemail = $this->db->select('*')
				->from('tbl_users')
				->where('email',$data['email'])
		
				->get()->row();
				/*if email exist and id doesnot exist start*/
					if (!empty($selectemail)){

						if ($selectemail->is_suspend==0) {
							

				       $typer=$selectemail->user_Type;
						/*checking of type in case customer app or driver app*/
						if ($user_type==$typer) {
							$data['fb_signUp']=1;
							$filterdata=array_filter($data);
							$data['user_Type']=$user_type;
							$this->db->where('email', $data['email']);
							$this->db->update('tbl_users', $filterdata); 


							$getdata=$this->User_model->select_data('*','tbl_users',array('email'=>$data['email']));


							
							return $getdata;
						}
						else{
							return 1;
						}
					}
					else{
						return 6;
					}
					}
					else{
						return 0;
					}
				}
				/*if email exist and id doesnot exist end*/
				else{
					return 0;
				}
			}
			/*if fb id doesnot exists end*/



			else
			{

				if ($selectsocial->is_suspend==1) {
					return  6;
				}
				else{
			    $typer=$selectsocial->user_Type;
			    /*checking of type in case customer app or driver app*/
				if ($user_type==$typer) {
					$loginParams['user_id'] = $selectsocial->id;
					$this->db->insert('tbl_login', $loginParams);
					$getRes = $this->User_model->select_data('*','tbl_users',array('fb_id'=>$data['fb_id']));
					return $getRes;
				} 
				else{
					return 1;
				}
			}
			}
	}


	/*fb login end*/


	
	/*google login start*/
	else if ($type == 3){
		$selectsocial = $this->db->select('*')
		->from('tbl_users')
		->where('google_id',$data['google_id'])
		->get()->row();
		/*if google id doesnot exists start*/
			if(empty($selectsocial)){
				if(!empty($data['email'])){
				$selectemail = $this->db->select('*')
				->from('tbl_users')
				->where('email',$data['email'])
				->get()->row();
				/*if email exist and id doesnot exist start*/
					if (!empty($selectemail)){
						if ($selectemail->is_suspend==1) {
							return 6;
						}
						else{
				       $typer=$selectemail->user_Type;
				       /*checking of type in case customer app or driver app*/
						if ($user_type==$typer) {

							$data['google_signUp']=1;
							$filterdata=array_filter($data);
							$data['user_Type']=$user_type;
							$this->db->where('email', $data['email']);
							$this->db->update('tbl_users', $filterdata); 
							$getdata=$this->User_model->select_data('*','tbl_users',array('email'=>$data['email']));


							return $getdata;
						}
						else{
							return 1;
						}
					}
				}
					/*if email exist and id doesnot exist end*/
					else{
						return 0;
					}
				}
				else{
					return 0;
				}
			}
			/*if google id doesnot exists end*/
			else
			{

			$typer=$selectsocial->user_Type;
			/*checking of type in case customer app or driver app*/

			if ($selectsocial->is_suspend==1) {
							return 6;
						}
						else{

				if ($user_type==$typer) {
					$loginParams['user_id'] = $selectsocial->id;
					$this->db->insert('tbl_login', $loginParams);
					$getRes = $this->User_model->select_data('*','tbl_users',array('google_id'=>$data['google_id']));
					return $getRes;
				} 
				else{
					return 1;
				}
			}
		}

	}
	/*google login end*/


}

	public function log_out($unique_deviceId,$user_id){

		$selectdata=$this->db->select('*')
		->from('tbl_login')
		->where('user_id',$user_id)
		->get()->result();
		if (!empty($selectdata)) {
			$data = array('status' => '0');
			$this->db->where('unique_deviceId',$unique_deviceId);
			$this->db->where('user_id',$user_id);
			$qu= $this->db->update('tbl_login',$data);
			return $qu;
		}
		else{
			return 0;
		}
	}
	public function getone($id){
		$result=$this->User_model->select_data('*','tbl_users',array('id'=>$id));
		return $result;

	}
	public function getalldata(){
		$getdata=    $this->db->select('*')->from('tbl_users')->get()->result();
		return $getdata;

	}
	public function getallvechicle(){
		$getdata=    $this->db->select('*')->from('tbl_vechicleType')->get()->result();
		return $getdata;

	}
	public function getallmove(){
		$getdata=    $this->db->select('*')->from('tbl_moveType')->get()->result();
		return $getdata;

	}
	public function movetype($data){
		$result = $this->db->insert('tbl_moveType',$data);
		$insertId = $this->db->insert_id();   
		$getdata=    $this->db->select('*')->from('tbl_moveType')->where('id', $insertId)->get()->row();
		return $getdata;
	}
	public function vechicletype($data){
		$result = $this->db->insert('tbl_vechicleType',$data);
		$insertId = $this->db->insert_id();   
		$getdata=    $this->db->select('*')->from('tbl_vechicleType')->where('id', $insertId)->get()->row();
		return $getdata;
	}

	public function insert_data($tbl_name,$data)                                         /* Data insert */
	{
	  	$this->db->insert($tbl_name, $data);
	   	$insert_id = $this->db->insert_id();
	    return $insert_id;

	}
// public function twillio($number,$msg)
// { 
// 	$this->load->library('twilio');
// 	// $from = '+15512727143';
// 	$from = '+15005550006';
// 	$response = $this->twilio->sms($from, $number, $msg);

// 	if($response->IsError)
// 		// echo 'Error: ' . $response->ErrorMessage;
// 		return 2;
// 	else
// 		return 1;
// }
public function bookmove($data){
	
	$gettime= $this->db->query("select buffer_time from tbl_setting")->row();
	$getcity= $this->db->query("SELECT * from tbl_cities where id='".$data['city_id']."'")->result();
	// print_r($getcity);
	$getvehicle= $this->db->query("SELECT * from tbl_vechicleType where id='".$data['vehicle_id']."'")->result();
	// print_r($getvehicle);



	$time=$gettime->buffer_time;
	$getdata= $this->db->query("SELECT a.id,a.email,b.token_id,b.device_id,(select buffer_time from tbl_setting) as timed, ( 3959 * acos( cos( radians('".$data['pickup_latitude']."') ) * cos( radians( latitude ) ) * cos( radians(longitude) - radians('".$data['pickup_longitude']."') ) + sin( radians('".$data['pickup_latitude']."') ) * sin( radians( latitude ) ) ) ) as distance FROM`tbl_users` AS a JOIN tbl_login AS b ON a.id = b.user_id WHERE   a.user_Type = 2 AND a.id IN(SELECT driver_id from tbl_driverDetail where located_at='".$getcity[0]->id."' AND vehicle_id='".$getvehicle[0]->id."') AND  a.id NOT IN ( SELECT '*'  FROM `tbl_booking`  WHERE 'is_accepeted'=1 or 'is_started'=1 and 'is_completed'=0 and 'is_cancelled'=0  and CONCAT('".$data['booking_date']."', ' ', '".$data['booking_time']."') BETWEEN CONCAT(booking_date, ' ', booking_time) AND DATE_ADD(CONCAT(booking_date, ' ', booking_time) , INTERVAL ('".round($data['time_duration']/60)."' + (('".$time."')*2)) MINUTE) OR DATE_ADD(CONCAT('".$data['booking_date']."', ' ', '".$data['booking_time']."'), INTERVAL('".round($data['time_duration']/60)."' + (('".$time."')*2)) MINUTE) BETWEEN CONCAT(booking_date, ' ', booking_time) AND DATE_ADD(CONCAT(booking_date, ' ', booking_time) , INTERVAL ('".round($data['time_duration']/60)."' + (('".$time."')*2)) MINUTE))")->result();






		
		return $getdata;
}
public function customerRating($data){
	$array = $this->db->insert('tbl_customerRating',$data);
		$insertId = $this->db->insert_id();   
		$getdata=    $this->db->select('*')->from('tbl_customerRating')->where('id', $insertId)->get()->row();
		return $getdata;

}
 public function applypromo($message,$promocode){

 	$data['promo'] = $this->User_model->select_data('*','tbl_promocode',array('id'=>$message['promo_id']));
 	$data['refer'] = $this->User_model->select_data('*','tbl_users',array('refercode'=>$message['promo_id']));


            if (empty($data)) {
                return 0;/*code doesnt exist*/
            }
            /*promo code case start*/
            elseif (!empty($data['promo'])) {
					$arr=$this->db->where('user_to_id',$message['user_id'])->where('promo_id',$message['promo_id'])->from("tbl_promousersData")->count_all_results();
					/*check how many time user apply this code*/
					if ($data['promo'][0]->user_max_usage > $arr) {
					/*first we check expiry date*/
					$promodata['promocode']=$this->db->query("SELECT * FROM tbl_promocode WHERE id= '".$message['promo_id']."' and  expiry_date >= CURDATE()")->result();
						if (empty($promodata['promocode'])) {
							return 1;/*expired*/
						}
						else{
					
								/*insert in promousersdata*/
								$addBal = $this->User_model->insert_data('tbl_promousersData',array('status'=>0,'promo_id'=>$message['promo_id'],'user_to_id'=>$message['user_id'],'type'=>1));
								$promodata['promodata']=$this->db->query("SELECT * FROM tbl_promousersData WHERE id= '".$addBal."'")->result();
								return $promodata;
								/*applied sucessfully*/        
						}
					}
					else{
						return 8;/*if more then max user usage*/
					}
    	}
    	elseif(!empty($promocode)){

         $cc['promo'] = $this->User_model->select_data('*','tbl_promocode',array('promo_code'=>$promocode));
 	     $cc['refer'] = $this->User_model->select_data('*','tbl_users',array('refercode'=>$promocode));
 	        if (empty($cc)) {
                return 0;/*code doesnt exist*/
            }
            /*promo code case start*/
            elseif (!empty($cc['promo'])) {
		
    				$arr=$this->db->where('user_to_id',$message['user_id'])->where('promo_id',$cc['promo'][0]->id)->from("tbl_promousersData")->count_all_results();
    		

					/*check how many time user apply this code*/
				
				
					if ($cc['promo'][0]->user_max_usage > $arr) {
					/*first we check expiry date*/
					$promodata['promocode']=$this->db->query("SELECT * FROM tbl_promocode WHERE promo_code= '".$promocode."' and  expiry_date >= CURDATE()")->result();
						if (empty($promodata['promocode'])) {
							return 1;/*expired*/
						}
						else{
					
								/*insert in promousersdata*/
								$addBal = $this->User_model->insert_data('tbl_promousersData',array('status'=>0,'promo_id'=>$cc['promo'][0]->id,'user_to_id'=>$message['user_id'],'type'=>1));
								$promodata['promodata']=$this->db->query("SELECT * FROM tbl_promousersData WHERE id= '".$addBal."'")->result();
								return $promodata;
								/*applied sucessfully*/        
						}
					}
					else{
						return 8;/*if more then max user usage*/
					}
				
    		}
       /*refer code case start*/
         elseif (!empty($cc['refer']) && $cc['refer'][0]->id != $message['user_id']) {	
      
         $refer = $this->User_model->select_data('*','tbl_promousersData',array('user_to_id'=>$message['user_id'],'type'=>2 ));
         $promodata['promocode'] = $this->User_model->select_data('referal_amount,referal_percentage','tbl_setting');
         /*check that user has never used refercode*/
             if (empty($refer)) {
             /*checking of current promo amount from admin panel*/ 
                 $addBal = $this->User_model->insert_data('tbl_promousersData',array('status'=>0,'promo_id'=>$promocode,'user_to_id'=>$message['user_id'],'user_refer_id'=>$cc['refer'][0]->id,'type'=>2));
                  $promodata['promodata']=$this->db->query("SELECT * FROM tbl_promousersData WHERE id= '".$addBal."'")->result();
                 return $promodata; ////////sucessfully used refercode
             }
                else{
                 return 5;///////already used refercode 	
             	}
          
         }


			
    	}
        /*promo code case end*/


        /*refer code case start*/
         elseif (!empty($data['refer']) && $data['refer'][0]->id != $message['user_id']) {	
      
         $refer = $this->User_model->select_data('*','tbl_promousersData',array('user_to_id'=>$message['user_id'],'type'=>2 ));
         $promodata['promocode'] = $this->User_model->select_data('referal_amount,referal_percentage','tbl_setting');
         /*check that user has never used refercode*/
             if (empty($refer)) {
             /*checking of current promo amount from admin panel*/ 
                 $addBal = $this->User_model->insert_data('tbl_promousersData',array('status'=>0,'promo_id'=>$message['promo_id'],'user_to_id'=>$message['user_id'],'user_refer_id'=>$data['refer'][0]->id,'type'=>2));
                  $promodata['promodata']=$this->db->query("SELECT * FROM tbl_promousersData WHERE id= '".$addBal."'")->result();
                 return $promodata; ////////sucessfully used refercode
             }
                else{
                 return 5;///////already used refercode 	
             	}
          
         }
         /*refer code case end*/
}
           
public function addcard($data){
		$getdata = $this->db->select('*')->from('tbl_cardDetail')->where('card_no', $data['card_no'])->get()->row();
		if (empty($getdata)) {
			$array = $this->db->insert('tbl_cardDetail',$data);
			$insertId = $this->db->insert_id();
			$getdata=    $this->db->select('*')->from('tbl_cardDetail')->where('id', $insertId)->get()->row();  
			    return $getdata;
		}
		else{
			return 0;
		}

}
public function cardlist($user_id){
    $getdata = $this->User_model->select_data('*','tbl_cardDetail',array('user_id'=>$user_id));
    return $getdata;
}
public function transactionListing($user_id,$items_per_page,$offset){
	      $getdata['countdata']=$this->db->query("SELECT COUNT(id) as totalcount FROM tbl_transactions WHERE user_id = ".$user_id." ")->row();  
        $getdata['transactionListing'] = $this->db->get_where('tbl_transactions', array('user_id' => $user_id), $items_per_page, $offset)->result();



    // $getdata['transactionListing'] = $this->User_model->select_data('*','tbl_transactions',array('user_id'=>$user_id));
    // $getdata['walletdata'] = $this->User_model->select_data('*','tbl_wallet',array('user_id'=>$user_id));
    return $getdata;
}
public function moveDetailHistory($message){


    $getdata['booking_data'] = $this->User_model->select_data('*','tbl_booking',array('id'=>$message['move_id']));
    $getdata['move_data'] = $this->User_model->select_data('*','tbl_moveHistory',array('booking_id'=>$message['move_id']));

    if (!empty($getdata['booking_data'][0]->promoid)) {


    	 $getdata['promodata'] =$this->db->query("SELECT tbl_promousersData.id,tbl_promocode.value,tbl_promocode.max_amount,tbl_promocode.user_max_usage,tbl_promocode.expiry_date,tbl_promocode.promo_code from tbl_promousersData RIGHT Join tbl_promocode on  tbl_promousersData.promo_id=tbl_promocode.id  where tbl_promousersData.id='".$getdata['booking_data'][0]->promoid."' ")->result();

    	 $getdata['referdata'] =$this->db->query("SELECT *  from tbl_promousersData where id='".$getdata['booking_data'][0]->promoid."' ")->result();


    }
    else{
    	$getdata['promodata']=array();
    	$getdata['referdata'] =array();
    }

    $getdata['vehicleDetail']=	 $this->User_model->select_data('*','tbl_vechicleType',array('id'=>$getdata['booking_data'][0]->vehicle_id));

      $getdata['moveDetail']=	 $this->User_model->select_data('*','tbl_moveType',array('id'=>$getdata['booking_data'][0]->moveType_id));


    $getdata['vehicledata'] = $this->User_model->select_data('vehicle_id,vehicle_no','tbl_driverDetail',array('driver_id'=>$getdata['booking_data'][0]->driver_id));


    if ($message['user_Type']==1) {




$getdata['usersDetail'] = $this->User_model->select_data('fname,lname,country_code,phone,profile_pic','tbl_users',array('id'=>$getdata['booking_data'][0]->driver_id));

$getdata['vehiclename'] = $this->User_model->select_data('name','tbl_vechicleType',array('id'=>$getdata['vehicledata'][0]->vehicle_id));


$rating = $this->User_model->select_data('rating','tbl_customerRating',array('move_id'=>$message['move_id']));


$getdata['rating']= $this->User_model->select_data('rating','tbl_customerRating',array('move_id'=>$message['move_id']));


if (!empty($getdata['booking_data'][0]->driver_id)) {
$getdata['avgrating']= $this->User_model->select_data('round(AVG(rating)) as driverrating','tbl_customerRating',array('driver_id'=>$getdata['booking_data'][0]->driver_id));
}
else{
$getdata['avgrating']=array();
}
    }
    else{

$getdata['usersDetail'] = $this->User_model->select_data('fname,lname,country_code,phone,profile_pic','tbl_users',array('id'=>$getdata['booking_data'][0]->user_id));


$getdata['rating']= $this->User_model->select_data('rating','tbl_customerRating',array('move_id'=>$message['move_id']));


if (!empty($getdata['booking_data'][0]->driver_id)) {
$getdata['avgrating']= $this->User_model->select_data('round(AVG(rating)) as driverrating','tbl_customerRating',array('driver_id'=>$getdata['booking_data'][0]->driver_id));
}
else{
$getdata['avgrating']=array();
}
    }
    return $getdata;
}
public function deletecard($message){
	$this->db->where('id', $message['card_id']);
    $getdata= $this->db->delete('tbl_cardDetail');
    return $getdata; 
}
public function deletebraintree($check_cardDetail){
	// print_r($check_cardDetail);die();
	$this->db->where('user_id', $check_cardDetail[0]->user_id);
	$this->db->where('card_no', $check_cardDetail[0]->card_no);
    $getdata= $this->db->delete('tbl_braintreeUsersDetail');
    return $getdata; 
}
public function selectmoney_data($message){
     $getmoney = $this->db->select('*')
                         ->from('tbl_stripeUsersDetail')
                         ->where('card_no',$message['card_no'])
                         ->where('user_id',$message['user_id'])
                         ->get()->result();
                         // print_r($getmoney);die();

    return $getmoney;

}
public function update_data($tbl_name,$data,$where){                                 /* Update data */

  $this->db->where($where);
  $result=$this->db->update($tbl_name,$data);
return $result;

}

public function select_data($selection,$tbl_name,$where=null,$order=null)                   /* Select data with condition*/
    {
      if (empty($where)&&empty($order)) {
      $data_response = $this->db->select($selection)
           ->from($tbl_name)
           ->get()->result();
    }
    elseif(empty($order)){
    $data_response =
    $this->db->select($selection)
           ->from($tbl_name)
           ->where($where)
           ->get()->result();

    }else{
    $data_response =
    $this->db->select($selection)
           ->from($tbl_name)
           ->where($where)
           ->order_by($order)
           ->get()->result();
    }
return $data_response;

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

public function forgotpassword($email)
{
$select_user = $this->db->select('*')->from('tbl_users')->where('email', $email)->get()->row();
if (empty($select_user->id))
{
return 0;
}
else
{
$static_key = "afvsdsdjkldfoiuy4uiskahkhsajbjksasdasdgf43gdsddsf";
$id = $select_user->id . "_" . $static_key;
$result['b_id'] = base64_encode($id);
// $result['decb']=base64_decode($result['b_id']);
$result['user_id'] = $select_user->id;
$result['fname'] = $select_user->fname;
$time=date('Y-m-d H:i:s');
$getforgot = $this->db->select('*')->from('tbl_forgotPassword')->where('user_id', $select_user->id)->get()->result();

if (empty($getforgot)) {
	 $addtransArray = array(
              'user_id'=>$select_user->id,
              'time'=>date('Y-m-d H:i:s'),
              'status' => 1
              );
              $addtrans = $this->insert_data('tbl_forgotPassword',$addtransArray);
}
else{
	  $uptBal = $this->update_data('tbl_forgotPassword',array('status'=>1,' time'=>date('Y-m-d H:i:s')),array('user_id'=>$select_user->id));
}
}
return $result;	
}
	public function updateNewpassword($message){
		$getforgot = $this->db->select('*')->from('tbl_forgotPassword')->where('user_id', $message['id'])->get()->result();
		$sendtime=$getforgot[0]->time;
		$time=date('Y-m-d H:i:s');
		$det= date('Y-m-d H:i:s', strtotime("$sendtime  +30 minutes"));
		/*checking that user can update password only in 30 minute*/
		if ($time <= $det && $getforgot[0]->status==1) {
		$update_pwd = $this->db->where('id', $message['id']);
		$this->db->update("tbl_users", array(
		'password' => md5($message['password']))
		);
		$update_pwd2 = $this->db->where('user_id', $message['id']);
		$this->db->update("tbl_forgotPassword", array(
		'status' => 0)
		);
		if ($update_pwd)
		$this->session->set_flashdata('msg', '<span style="color:green">Password Changed Successfully</span>');
		redirect("api/User/newpassword?id=" . $message['base64id']);
		}
		else{
		$this->session->set_flashdata('msg', '<span style="color:red">Your Reset Password Link has been Expired</span>');
		redirect("api/User/newpassword?id=" . $message['base64id']);
		}
	}
	   public function customChat_list($message){
      			$chatList = $this->db->select('*')
                           ->from('tbl_chat')
                           ->group_start()
                           ->where('move_id',$message['move_id'])
                           ->where('from_id',$message['from_id'])
                           ->where('to_id',$message['to_id'])
                           ->group_end()
                           ->or_group_start()
                           ->where('move_id',$message['move_id'])
                           ->where('from_id',$message['to_id'])
                           ->where('to_id',$message['from_id'])
                           ->group_end()
                           ->get()->result();

     // print_r($this->db->last_query());

     return $chatList;
    }
       public function selectLogin($id){
      $selLogin = $this->db->select('*')
                           ->from('tbl_login')
                           ->where('user_id',$id)
                           ->where('status',1)
                           ->get()->result();

    return $selLogin;
    }





}
