      <?php

      defined('BASEPATH') OR exit('No direct script access allowed');

      // This can be removed if you use __autoload() in config.php OR use Modular Extensions
      /** @noinspection PhpIncludeInspection */
      require APPPATH . '/libraries/REST_Controller.php';
      require(APPPATH.'/libraries/stripe.php');
      /*require(APPPATH.'/libraries/Twilio.php');
      require(APPPATH.'/libraries/Twilio/autoload.php');*/

      // use Twilio\Jwt\ClientToken;
      //  use Twilio\Twiml;
      // Twilio/Jwt


      // use Twilio\Rest\Client;

      /**
      * This is an example of a few basic user interaction methods you could use
      * all done with a hardcoded array
      *
      * @package         CodeIgniter
      * @subpackage      Rest Server
      * @category        Controller
      * @author          Phil Sturgeon, Chris Kacerguis
      * @license         MIT
      * @link            https://github.com/chriskacerguis/codeigniter-restserver
      */
      class Users extends REST_Controller {

      function __construct()
      {
         // Construct the parent class
       parent::__construct();
       $this->load->database();
       $this->load->model('Users_model');
       $this->load->helper('url');
       $this->load->helper('form');
       $this->load->library('session');
       $this->load->library("braintree_lib");
       date_default_timezone_set("UTC");
       $config = Array(

        'protocol' => 'sendmail',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'wordwrap' => TRUE

        );

      // $this->load->library('email', $config);
      // Configure limits on our controller methods
      // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
       $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
       $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
       $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
      }


           public function signup_post(){
                $data = array(
                'fname'=>$this->input->post('fname'),
                'lname'=>$this->input->post('lname'),
                'email'=>$this->input->post('email'),
                'password'=>md5($this->input->post('password')),
                'country_code'=>$this->input->post('country_code'),
                'phone'=>$this->input->post('phone'),
                'fb_id'=>$this->input->post('fb_id'),  
                'google_id'=>$this->input->post('google_id'), 
                'company_name'=>$this->input->post('company_name'),
                'date_created' =>date('Y-m-d H:i:s') 
                );
                $loginParams =  array(
                'device_id'=>$this->input->post('device_id'),
                'unique_deviceId '=>$this->input->post('unique_deviceId'),
                'token_id'=>$this->input->post('token_id'),
                'date_created'=>date('Y-m-d H:i:s')   
                );

                /*profile pic of user start*/

                $image='profile_pic';
                $upload_path='public/profile_pic';
                $imagename=$this->file_upload($upload_path,$image);
                $data['profile_pic']=$imagename;



            // $upload_path = "Public/img/app";
            // $image = 'profile_picFile';
            // $finalImage = $this->file_upload($upload_path, $image);
            // $myarray['profile_pic'] = $finalImage;



                /*profile pic of user end*/
                /*generation of refer code start*/
                $refercode="M".mt_rand(1000,9000).mb_substr($data['fname'], 0, 2).rand(5000,9000);
                /*generation of refer code end*/
                $type=$this->input->post('type');
                $user_refercode=$this->input->post('refercode');
                /*if user simply signup start*/
                if (empty($user_refercode)) {  
                  $signUpData=$this->Users_model->sign_up($data,$loginParams,$type,$refercode,$user_refercode="");
                }
                /*if user simply signup end*/
                /*if user uses refer code on signup*/
                else{
                     $getRes = $this->Users_model->select_data('*','tbl_users',array('refercode'=>$user_refercode));
                     if (!empty($getRes)) {  
                          $signUpData=$this->Users_model->sign_up($data,$loginParams,$type,$refercode,$user_refercode);
                          if (!empty($signUpData) && $signUpData != 0){
                          $user=$signUpData[0]->id;


      	                 $addPromo = $this->Users_model->insert_data('tbl_promousersData',array('status'=>0,'promo_id'=>$refercode,'user_to_id'=>$user,'user_refer_id'=>$getRes[0]->id,'type'=>2));

                      }       
                     }
                     else{

                 $result = array(
                     "controller" => "User",
                     "action" => "signup",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "Wrong Referrel Code ",
                     );    
                    print_r(json_encode($result));
                  die;
                  //    $this->set_response($result,REST_Controller::HTTP_OK);      
                  //   return ;
                     }
                }

                

                if (!empty($signUpData) && $signUpData != 0){
                     $result = array(
                     "controller" => "User",
                     "action" => "signup",
                     "ResponseCode" => true,
                     "MessageWhatHappen" =>"sucessfully registered",
                     "signUpResponse" => $signUpData
                     );
                }
                else if($signUpData == 0){
                     $result = array(
                     "controller" => "User",
                     "action" => "signup",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "User Already Exists",
                     ); 
                }

                else {
                     $result = array(
                     "controller" => "User",
                     "action" => "signup",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "Something went wrong",
                     ); 
                }
          print_r(json_encode($result));
          die;
           // $this->set_response($result,REST_Controller::HTTP_OK);
           }
           public function login_post(){
                $data = array(
                'phone'=>$this->input->post('phone'),
                'email'=>$this->input->post('email'),
                'password'=>md5($this->input->post('password')),
                'fb_id'=>$this->input->post('fb_id'),  
                'google_id'=>$this->input->post('google_id'),
                'date_created' =>date('Y-m-d H:i:s')   
                ); 
                $user_type= $this->input->post('user_type');
                $loginParams =  array(
                'device_id'=>$this->input->post('device_id'),
                'unique_deviceId '=>$this->input->post('unique_deviceId'),
                'token_id'=>$this->input->post('token_id'),
                'date_created' =>date('Y-m-d H:i:s') 

                );
               
                /*login type 1,2 and 3 for mannual,fb and google*/
                $type = $this->input->post('type');
                $var = $this->Users_model->login($data,$loginParams,$type,$user_type);

                if(!empty($var) && $var != 1 && $var != 0 && $var!=6 && $var!=4){                 
                     $result = array(
                     "controller" => "User",
                     "action" => "login",
                     "ResponseCode" => true,
                     "MessageWhatHappen" => "Sucessfully Login",
                     "loginResponse" => $var
                     ); 
                }
                elseif ($var == 1) {
                     $result = array(
                     "controller" => "User",
                     "action" => "login",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "Wrong App"
                     );
                }

                  elseif ($var == 6) {
                     $result = array(
                     "controller" => "User",
                     "action" => "login",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "Account suspended"
                     );
                }

                elseif($var== 0){
                     $result = array(
                     "controller" => "User",
                     "action" => "login",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "User does not exist " 
                     ); 
                }
                elseif($var== 4){
                     $result = array(
                     "controller" => "User",
                     "action" => "login",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "Mover can not login in user app" 
                     ); 
                }
           $this->set_response($result, REST_Controller::HTTP_OK);
           }
           public function logout_post(){
             $user_id=$this->input->post('user_id');
             $unique_deviceId=$this->input->post('unique_deviceId');
             $log_out= $this->Users_model->log_out($unique_deviceId,$user_id);
               if (!empty($log_out) && $log_out != 0){
                 $result = array(
                 "controller" => "User",
                 "action" => "logout",
                 "ResponseCode" => true,
                 "MessageWhatHappen" =>"sucessfully logged out",
                 "logoutResponse" => $log_out
                 );
               }
               else if($log_out == 0){
                 $result = array(
                 "controller" => "User",
                 "action" => "logout",
                 "ResponseCode" => true,
                 "MessageWhatHappen" => "Something went wrong"
                 ); 
               }
           $this->set_response($result, REST_Controller::HTTP_OK);
           }
           public function getprofile_post(){
                $id= $this->input->post('user_id');
                $data=$this->Users_model->getone($id);

                     if ($data){
                          $result = array(
                          "controller" => "User",
                          "action" => "getprofile",
                          "ResponseCode" => true,
                          "MessageWhatHappen" =>"your data shows sucessfully",
                          "Response" => $data
                          );
                     }
                     else {
                          $result = array(
                          "controller" => "User",
                          "action" => "getprofile",
                          "ResponseCode" => false,
                          "MessageWhatHappen" =>"Something went wrong",
                          );
                     }
           $this->set_response($result,REST_Controller::HTTP_OK);  
           }
           public function updateprofile_post(){
              $arra = array(
                'id'=>$this->input->post('id'),
                'fname'=>$this->input->post('fname'),
                'lname'=>$this->input->post('lname'),
                 'company_name'=>$this->input->post('company_name'),
                'country_code'=>$this->input->post('country_code'),
                'phone'=>$this->input->post('phone'),  
                ); 


                /*updation of profile pic start*/
                $image='profile_pic';
                $upload_path='public/profile_pic';
                $imagename=$this->file_upload($upload_path,$image);
                $arra['profile_pic']=$imagename;
                /*updation of profile pic end*/

              $data=array_filter($arra);


              $new_password=($this->input->post('newpassword'));
              $old_password=($this->input->post('oldpassword'));
              /*in case user want to update password start*/
              if(!empty($new_password) && !empty($old_password)){
              $passwordchk = $this->Users_model->select_data('*','tbl_users',array('id'=>$data['id'],'password'=>md5($old_password)));
              /*checking of old password start*/
              if($passwordchk){
                $data['password']=md5($new_password);
                          $var= $this->Users_model->update_data('tbl_users',$data,array('id'=>$data['id']));
                          $getRes = $this->Users_model->select_data('*','tbl_users',array('id'=>$data['id']));
                          $result = array(
                          "controller" => "User",
                          "action" => "updateprofile",
                          "ResponseCode" => true,
                          "MessageWhatHappen" =>"Your data updated sucessfully",
                          "response"=>$getRes
                          );
                     }else {
                           $result = array(
                          "controller" => "User",
                          "action" => "updateprofile",
                          "ResponseCode" => false,
                          "MessageWhatHappen" =>"oldpassword doesnot match"
                          );
                     }  
            }
            /*checking of old password end*/


            /*in case user want to update password end*/



            /*in case user want to update information except password start*/
            elseif(empty($new_password && $old_password)){
             $passwordchk = $this->Users_model->select_data('*','tbl_users',array('id'=>$data['id']));
              if($passwordchk){
                          $var= $this->Users_model->update_data('tbl_users',$data,array('id'=>$data['id']));
                          $getRes = $this->Users_model->select_data('*','tbl_users',array('id'=>$data['id']));
                          $result = array(
                          "controller" => "User",
                          "action" => "updateprofile",
                          "ResponseCode" => true,
                          "MessageWhatHappen" =>"Your data updated sucessfully",
                          "response"=>$getRes
                          );
                     }else {
                           $result = array(
                          "controller" => "User",
                          "action" => "updateprofile",
                          "ResponseCode" => false,
                          "MessageWhatHappen" =>"Something went wrong"
                          );
                     }  
            }
            /*in case user want to update information except password end*/  
            else{
               $result = array(
                          "controller" => "User",
                          "action" => "updateprofile",
                          "ResponseCode" => false,
                          "MessageWhatHappen" =>"Something went wrong",
                        
                          );

            }  
           $this->set_response($result,REST_Controller::HTTP_OK); 

           }

           public function getvechicle_get(){
                $data=$this->Users_model->getallvechicle();
                if ($data){
                     $result = array(
                     "controller" => "User",
                     "action" => "getvechicle",
                     "ResponseCode" => true,
                     "MessageWhatHappen" =>"your data shows sucessfully",
                     "Response" => $data
                     );
                }else {
                     $result = array(
                     "controller" => "User",
                     "action" => "getvechicle",
                     "ResponseCode" => true,
                     "MessageWhatHappen" =>"No data exist in Table",
                     );
                }
                $this->set_response($result,REST_Controller::HTTP_OK);  
           }
           public function getmove_get(){

                /*all move history data*/
                $data['movedata']=$this->Users_model->getallmove();
                /*setting related data*/
                $data['settingdata']=$this->Users_model->select_data('flight_charges,loading_rate,unloading_rate,movers_charges','tbl_setting');

                if ($data){
                     $result = array(
                     "controller" => "User",
                     "action" => "getmove",
                     "ResponseCode" => true,
                     "MessageWhatHappen" =>"your data shows sucessfully",
                     "Response" => $data
                     );
                }
                else {
                     $result = array(
                     "controller" => "User",
                     "action" => "getmove",
                     "ResponseCode" => true,
                     "MessageWhatHappen" =>"No data exist in Table",
                     );
                }
                $this->set_response($result,REST_Controller::HTTP_OK);  
           }

          
          
          

           // public function sendotp_post()
           // { 
           //      $this->load->library('twilio');
           //      $phone= $this->input->post('phone');
           //      $selectNumber=$this->Users_model->select_data('phone','tbl_otp',array('phone'=>$phone));
           //      $otpGenerate = mt_rand(0,90000); 
           //      $msg="This is your otp for registration".$otpGenerate;
           //      if (empty($selectNumber)) {

           //           $array=array('phone'=>$this->input->post('phone'),
           //           'otp'=>$otpGenerate
           //           );
           //           $admin=$this->Users_model->twillio($phone,$msg);
           //                if ($admin==1) {

           //                     $name=$this->db->insert('tbl_otp',$array);
           //                     $otpId=$this->db->insert_id();
           //                     $insertdata=$this->Users_model->select_data('*','tbl_otp',array('id'=>$otpId));
           //                     if ($insertdata){
           //                          $result = array(
           //                          "controller" => "User",
           //                          "action" => "sendotp",
           //                          "ResponseCode" => true,
           //                          "MessageWhatHappen" =>"your otp send sucessfully",
           //                          "Response" => $insertdata
           //                          );
           //                     }
           //                     else {
           //                          $result = array(
           //                          "controller" => "User",
           //                          "action" => "sendotp",
           //                          "ResponseCode" => false,
           //                          "MessageWhatHappen" =>"Something Went Wrong",
           //                          );
           //                     }

           //                }
           //                else{
           //                     $result = array(
           //                     "controller" => "User",
           //                     "action" => "sendotp",
           //                     "ResponseCode" => false,
           //                     "MessageWhatHappen" =>"Something Went Wrong",
           //                     );

           //                }
           //      }

           //      else{
           //           $existnumber=$this->Users_model->twillio($phone,$msg);
           //           // print_r($existnumber);die();
           //           if ($existnumber==1) {

           //                $arra12=$this->Users_model->update_data('tbl_otp',array('otp'=>$otpGenerate,'date_modified'=>date('Y:m:d H:i:S')),array('phone'=>$phone));
           //                $updateddata=$this->Users_model->select_data('*','tbl_otp',array('phone'=>$phone));
           //                if ($updateddata){
           //                     $result = array(
           //                     "controller" => "User",
           //                     "action" => "sendotp",
           //                     "ResponseCode" => true,
           //                     "MessageWhatHappen" =>"your otp send sucessfully",
           //                     "Response" => $updateddata
           //                     );
           //                }
           //                else{
           //                     $result = array(
           //                     "controller" => "User",
           //                     "action" => "sendotp",
           //                     "ResponseCode" => false,
           //                     "MessageWhatHappen" =>"Something Went Wrong",
           //                     );
           //                }
           //           }
           //           else{
           //                $result = array(
           //                "controller" => "User",
           //                "action" => "sendotp",
           //                "ResponseCode" => false,
           //                "MessageWhatHappen" =>"Something Went Wrong",
           //                );
           //           }
           //      }
           //      $this->set_response($result,REST_Controller::HTTP_OK);  
           // }
           // public function findotp_get(){                         
           //      $phone= $this->input->get('phone');
           //      $phone= str_replace("+","",$phone);
           //      $phone= "+".trim($phone);
           //      // print_r($phone);die();
           //      $data=$this->Users_model->select_data('phone,otp','tbl_otp',array('phone'=>$phone));
           //           if ($data){
           //                $result =  $data;
           //           }
           //           else {
           //                $result = array(
           //                "MessageWhatHappen" =>"Something went wrong",
           //                );
           //           }
           //      $this->set_response($result,REST_Controller::HTTP_OK);  
           // }
     


           public function bookmove_post(){
                $data = array(
                     'user_id'=>$this->input->post('user_id'),
                     'vehicle_id'=>$this->input->post('vehicle_id'),
                     'moveType_id'=>$this->input->post('move_id'),
                     'receipt_number'=>$this->input->post('receipt_number'),
                     'pickup_loc'=>$this->input->post('pickup_loc'),  
                     'destination_loc'=>$this->input->post('destination_loc'),  
                     'booking_date'=>$this->input->post('booking_date'),
                     'booking_time'=>$this->input->post('booking_time'),  
                     'estimated_price'=>$this->input->post('estimated_price'),
                     'pickup_latitude'=>$this->input->post('pickup_latitude'),  
                     'pickup_longitude'=>$this->input->post('pickup_longitude'),  
                     'destination_latitude'=>$this->input->post('destination_latitude'),
                     'destination_longitude'=>$this->input->post('destination_longitude'),  
                     'time_duration'=>$this->input->post('time_duration'),
                     'distance'=>$this->input->post('distance'),
                     'path_polyline'=>$this->input->post('path_polyline'),
                     'pickup_level'=>$this->input->post('pickup_level'),
                     'destination_level'=>$this->input->post('destination_level'),  
                     'pickup_movers'=>$this->input->post('pickup_movers'),
                     'destination_movers'=>$this->input->post('destination_movers'),
                     'description'=>$this->input->post('description'),

                     'distance_fare'=>$this->input->post('distance_fare'),
                     'hourly_fare'=>$this->input->post('hourly_fare'),
                     'pickup_flight_fare'=>$this->input->post('pickup_flight_fare'),
                     'destination_flight_fare'=>$this->input->post('destination_flight_fare'),
                     'loading_fare'=>$this->input->post('loading_fare'),
                     'unloading_fare'=>$this->input->post('unloading_fare'),
                     'movers_fare'=>$this->input->post('movers_fare'),
                     'loading_time'=>$this->input->post('loading_time'),
                     'unloading_time'=>$this->input->post('unloading_time'),
                     );

                     $data['card_id']=$this->input->post('card_id');

                     $data['promoid']=$this->input->post('promoid');


                      $data['city_id']=$this->input->post('city_id');

               

            /*item images start*/
            if (isset($_FILES['item_image1'])) {          
         
            $image='item_image1';
            $upload_path='public/item_image';
            $imagename1 = $this->file_upload($upload_path,$image);
            $item1=$imagename1;
            }

            if (isset($_FILES['item_image2'])) {  

            $image='item_image2';
            $upload_path='public/item_image';
            $imagename2=$this->file_upload($upload_path,$image);
            // $imagename=$this->file_upload($upload_path,$image,$name);
            $item2=$imagename2;
            }


            if (isset($_FILES['item_image3'])) {  
            $image='item_image3';
            $upload_path='public/item_image';
            $imagename3=$this->file_upload($upload_path,$image);
            $item3=$imagename3;
            }


            if (isset($_FILES['item_image4'])) {      
            $image='item_image4';
            $upload_path='public/item_image';
            $imagename4=$this->file_upload($upload_path,$image);
            $item4=$imagename4;
            }
            /*item images end*/

          
            if(isset($_POST['item_image1'])){
              
                     $item1 =$this->input->post('item_image1');
                     $item2=$this->input->post('item_image2');
                     $item3=$this->input->post('item_image3');
                     $item4=$this->input->post('item_image4');
            }


            /*item images serilize start*/
            $seru=array($item1,$item2,$item3,$item4);
            $data['item_image']=serialize($seru);
            /*item images serialize end*/

            if(isset($_POST['imagename'])){
              $imagename = $_POST['imagename'];
              }
            /*receipt image start*/
            if (isset($_FILES['receipt_image'])) {  
            $image='receipt_image';
            $upload_path='public/receipt_image';
            $imagename=$this->file_upload($upload_path,$image);
            $data['receipt_image']=$imagename;
            }
            /*receipt image end*/

            if (!empty($data['promoid'])) {
              
            $Promodata = $this->Users_model->update_data('tbl_promousersData',array('status'=>1),array('id'=>$data['promoid']));
            
            }

                /*get minimum booking charges from total price start */
                $minBookingCharge = $this->Users_model->select_data('*','tbl_setting');

                $getbookingcharge = $minBookingCharge[0]->min_booking_charge;
                $amountdeduct = ($getbookingcharge / 100) * $data['estimated_price'];
                $deductprice=($amountdeduct);
                /*get minimum booking charges from total price end*/

                $data['admin_percentage']=$minBookingCharge[0]->admin_percentage;


                  $getCardDetail=$this->db->query("SELECT * from tbl_cardDetail  where id='".$data['card_id']."' and user_id='".$data['user_id']."'")->result();
                  foreach ($getCardDetail as $key => $value) {
                    $getCardDetail[$key]->cutomerid=$this->db->query("SELECT * from tbl_braintreeUsersDetail where user_id='".$data['user_id']."' and card_no='".$value->card_no."' ")->result();        
                  }
                  $cusId=$getCardDetail[0]->cutomerid[0]->customer_id;
                            $trasactdata = Braintree_Transaction::sale([
                            'amount' => $deductprice,
                            'customerId' => $cusId
                            ]);
                            // print_r($trasactdata);die();
                  $msg=$trasactdata->message;
                  $txnid=$trasactdata->transaction->id;

                if($trasactdata->success==1){
                  /*if user balence more then deduct balence start*/

                      $insertdata = $this->Users_model->insert_data('tbl_booking',$data);
                      $bookingdata=array('booking_id'=>$insertdata,'status'=>0);
                      $inserthistorydata = $this->Users_model->insert_data('tbl_moveHistory',$bookingdata);
                           

                           $transArray = array(
                                    'amount_debited'=>$deductprice,
                                    'user_id'=>$data['user_id'],
                                    'txn_id'=>$txnid,
                                    'card_id'=>$data['card_id'],
                                    'move_id'=>$insertdata,
                                    'type'=>'1',
                                    'date_created'=>date('Y-m-d H:i:s')
                                    );
                     $transResponse = $this->Users_model->insert_data('tbl_transactions',$transArray);
                        /*push code start*/
                          $pushData['message'] = "You have recieved a request for new task";
                          $pushData['action'] = "new move";
                          $pushData['booking_id'] = $insertdata;
                          $pushData['Utype'] = 1;
                          $pushData['iosType'] = 1;/*for new book*/
                          $selectlogin=$this->Users_model->bookmove($data);
                

                              foreach ($selectlogin as  $loginUsers => $value) {
                             
                                $pushData['token'] = $value->token_id;
                                    
                                if($value->device_id == 1){

                                 $this->Users_model->iosPush($pushData);

                                }else if($value->device_id == 0){

                                 $this->Users_model->androidPush($pushData);
                                }
                              }   
                  
                        /*push code end*/  


                if(empty($insertdata)){
                     $result = array(
                     "controller" => "User",
                     "action" => "bookmove",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "Something went wrong"
                     );
                }else{                    
                     $result = array(
                     "controller" => "User",
                     "action" => "bookmove",
                     "ResponseCode" => true,
                     "MessageWhatHappen" => "Booked successfully",
                     "response"=>$msg,
                     "Move_id"=>$insertdata
                     );
                }
               
            
              }
              else{


                  $result = array(
                        "controller" => "User",
                        "action" => "bookmove",
                        "ResponseCode" => false,
                        "MessageWhatHappen" => "txn failed",
                        "response"=>$msg,
                        "bookedPercentage" => $getbookingcharge
                      );
              }
                $this->set_response($result,REST_Controller::HTTP_OK);  
            }
                public function braintreeToken_get(){
                  $clientToken = Braintree_ClientToken::generate();
                  $result = array(
                        "token" => $clientToken
                      );
                  $this->set_response($result,REST_Controller::HTTP_OK);  

                }
               

                public function customerRating_post(){
                     $data = array(
                          'move_id'=>$this->input->post('move_id'),
                          'driver_id'=>$this->input->post('driver_id'),
                          'user_id'=>$this->input->post('user_id'),
                          'rating'=>$this->input->post('rating'),
                          'comment'=>$this->input->post('comment')

                          ); 
                     $result=$this->Users_model->customerRating($data);
                           if ($result){
                               $result = array(
                               "controller" => "User",
                               "action" => "customerRating",
                               "ResponseCode" => true,
                               "MessageWhatHappen" =>"your rating has been sucessfully submitted",
                               "Response" => $result
                               );
                          }
                          else{
                               $result = array(
                               "controller" => "User",
                               "action" => "customerRating",
                               "ResponseCode" => false,
                               "MessageWhatHappen" =>"Something Went Wrong",
                               );
                          }
                     $this->set_response($result,REST_Controller::HTTP_OK);  


                }
                public function addCard_post(){
                
                     $data = array(
                     'user_id'=> $this->input->post('user_id'),
                     'card_no'=> $this->input->post('card_no'),
                     'expiry_month'=>$this->input->post('expiry_month'),
                     'expiry_year'=>$this->input->post('expiry_year'),
                     'nameoncard'=>$this->input->post('name'),
                     'nounce'=>$this->input->post('nounce'),
                     'is_default'=> $this->input->post('is_default'),
                     );
                      $updateddata=$this->Users_model->select_data('*','tbl_cardDetail',array('card_no'=>$data['card_no'],'user_id'=>$data['user_id']));
                      /*add card  start*/
                     if(empty($updateddata)){

                    /*if user want to make default card start*/
                    if($data['is_default']==1) {
                      $status=0;                    
                      $uptCardstatus = $this->Users_model->update_data('tbl_cardDetail',array('is_default'=>$status),array('user_id'=>$data['user_id']));
                      $uptbraintreestatus = $this->Users_model->update_data('tbl_braintreeUsersDetail',array('is_default'=>$status),array('user_id'=>$data['user_id']));
                    }


                         $result = Braintree_Customer::create([
                                  'firstName' => $data['nameoncard'],
                                  'paymentMethodNonce' =>$data['nounce']
                              ]);
                         // print_r($result);die();
                         $customer_id=$result->customer->id;
                         if (!empty($customer_id)) {
                           
                        
                    /*if user want to make default card end*/
                      $braintreedetail=array(
                     'user_id'=> $data['user_id'],
                     'customer_id'=> $customer_id,
                     'card_no'=> $data['card_no'],
                    'is_default'=> $data['is_default']
                     );
                     $result=$this->db->insert('tbl_cardDetail', $data);
                     $result1=$this->db->insert('tbl_braintreeUsersDetail', $braintreedetail);



                          if ($result){
                               $result = array(
                                    "controller" => "User",
                                    "action" => "addCard",
                                    "ResponseCode" => true,
                                    "MessageWhatHappen" =>"card added sucessfully",
                               );
                          }
                          else{
                               $result = array(
                               "controller" => "User",
                               "action" => "addCard",
                               "ResponseCode" => false,
                               "MessageWhatHappen" =>"Something Went Wrong",
                               );
                          }
                     }
                     else{
                        $result = array(
                               "controller" => "User",
                               "action" => "addCard",
                               "ResponseCode" => false,
                               "MessageWhatHappen" =>"Something Went Wrong",
                               );

                     }
                   }
                     /*add card end*/
                         else{
                               $result = array(
                               "controller" => "User",
                               "action" => "addCard",
                               "ResponseCode" => false,
                               "MessageWhatHappen" =>"card Already added",
                               );
                          }
                     $this->set_response($result, REST_Controller::HTTP_OK);
                }


                public function cardListing_post(){
                     $user_id = $this->input->post('user_id');
                     $result=$this->Users_model->cardlist($user_id);
                    $settdata=$this->db->query("SELECT min_booking_charge FROM tbl_setting")->result();
                           if ($result){
                               $result = array(
                               "controller" => "User",
                               "action" => "cardListing",
                               "ResponseCode" => true,
                               "MessageWhatHappen" =>"your data shows sucessfully",
                               "Response" => $result,
                               "setData" => $settdata
                               );
                          }
                          else{
                               $result = array(
                               "controller" => "User",
                               "action" => "cardListing",
                               "ResponseCode" => false,
                               "MessageWhatHappen" =>"Something Went Wrong",
                               );
                          }
                     $this->set_response($result,REST_Controller::HTTP_OK);  

                }
                public function transactionListing_post(){
                     $user_id = $this->input->post('user_id');
                     $result=$this->Users_model->transactionListing($user_id);
                           if ($result){
                               $result = array(
                               "controller" => "User",
                               "action" => "transactionListing",
                               "ResponseCode" => true,
                               "MessageWhatHappen" =>"your data shows sucessfully",
                               "Response" => $result
                               );
                          }
                          else{
                               $result = array(
                               "controller" => "User",
                               "action" => "transactionListing",
                               "ResponseCode" => false,
                               "MessageWhatHappen" =>"Something Went Wrong",
                               );
                          }
                     $this->set_response($result,REST_Controller::HTTP_OK);  

                }
                public function deletecard_post(){
                     $message = array(
                          'user_id'=> $this->input->post('user_id'),
                          'card_id'=> $this->input->post('card_id')
                     );

                     $check_cardDetail = $this->Users_model->select_data('*','tbl_cardDetail',array('user_id'=>$message['user_id'],'id'=>$message['card_id']));

                     $data12 = $this->Users_model->deletebraintree($check_cardDetail);
                     $data = $this->Users_model->deletecard($message);
                     if(!empty($data))
                          {
                          $result = array(
                          "controller" => "User",
                          "action" => "deletecard",
                          "ResponseCode" => true,
                          "MessageWhatHappen" => "Card deleted sucessfully"
                          );
                     
                     }else{
                          $result = array(
                          "controller" => "User",
                          "action" => "deletecard",
                          "ResponseCode" => false,
                          "MessageWhatHappen" => "Something went wrong"
                          );
                     }
                     $this->set_response($result, REST_Controller::HTTP_OK);


                }
                public function applypromo_post(){
                       $message = array(
                          'user_id'=> $this->input->post('user_id'),
                          'promo_id'=> $this->input->post('promo_id')

                     );
                     $promocode=$this->input->post('promocode');
                     $promodata = $this->Users_model->applypromo($message,$promocode);
                   
                      if($promodata == 1){
                     $result = array(
                     "controller" => "User",
                     "action" => "applypromo",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "Expired",
                     ); 
                     }
                     else if($promodata == 0){
                     $result = array(
                     "controller" => "User",
                     "action" => "applypromo",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "Code dosent exist",
                     ); 
                     }
                      else if($promodata == 2){
                     $result = array(
                     "controller" => "User",
                     "action" => "applypromo",
                     "ResponseCode" => true,
                     "MessageWhatHappen" => "Applied Sucessfully",
                     ); 
                     }
                     else if($promodata == 3){
                     $result = array(
                     "controller" => "User",
                     "action" => "applypromo",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "Already Applied",
                     ); 
                     }
                     else if($promodata == 5){
                     $result = array(
                     "controller" => "User",
                     "action" => "applypromo",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "Already used refercode",
                     ); 
                     }
                    else if($promodata == 6){
                     $result = array(
                     "controller" => "User",
                     "action" => "applypromo",
                     "ResponseCode" => true,
                     "MessageWhatHappen" => "Sucessfully used refercode",
                     ); 
                     }
                     else if($promodata == 8){
                     $result = array(
                     "controller" => "User",
                     "action" => "applypromo",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "You code limit has been reached",
                     ); 
                     }
                     elseif ($promodata!=0 && $promodata!=1 && $promodata!=2 && $promodata!=3 && $promodata!=5 && $promodata!=6 && $promodata!=8 ) {
                      	
                       $result = array(
                       "controller" => "User",
                       "action" => "applypromo",
                       "ResponseCode" => true,
                       "MessageWhatHappen" => "sucess",
                       "response" => $promodata
                       ); 
                  	}

                $this->set_response($result,REST_Controller::HTTP_OK);

                }
                public function yourMoveList_post(){
                    $user_id = $this->input->post('user_id');
                    $type = $this->input->post('type');
                    // $result=$this->Users_model->bookingHistory($user_id,$type);
                    /*pending booking case start*/
                    if($type==1){
                      $acceptedbooking = $this->Users_model->select_data('*','tbl_booking',array('user_id'=>$user_id,'is_accepted'=>0,'is_started'=>0,'is_completed'=>0,'is_cancelled'=>0,));
                      // $i=0;

                      $acceptedbooking12=array();
                      foreach ($acceptedbooking as $key => $value) {
                      $acceptedbooking12= unserialize($value->item_image); 
                              $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $acceptedbooking[$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$acceptedbooking[$key]->itemimages=array();
                      }
                      }
                      // print_r($acceptedbooking);die();
                      if(!empty($acceptedbooking)){
                      $result = array(
                      "controller" => "User",
                      "action" => "yourMoveList",
                      "ResponseCode" => true,
                      "MessageWhatHappen" =>"your data shows sucessfully",
                      "Response" => $acceptedbooking,
                      );
                      }
                      elseif (empty($acceptedbooking)) {
                          $result = array(
                      "controller" => "User",
                      "action" => "yourMoveList",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"No data exist in table",
                          );
                        
                      }
                      else{
                      $result = array(
                      "controller" => "User",
                      "action" => "yourMoveList",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"Something went wrong",
                      );
                      }
                    }
                        if($type==0){
                      $acceptedbooking = $this->Users_model->select_data('*','tbl_booking',array('user_id'=>$user_id));
                      // $i=0;

                      $acceptedbooking12=array();
                      foreach ($acceptedbooking as $key => $value) {
                      $acceptedbooking12= unserialize($value->item_image); 
                              $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $acceptedbooking[$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$acceptedbooking[$key]->itemimages=array();
                      }
                      }
                      // print_r($acceptedbooking);die();
                      if(!empty($acceptedbooking)){
                      $result = array(
                      "controller" => "User",
                      "action" => "yourMoveList",
                      "ResponseCode" => true,
                      "MessageWhatHappen" =>"your data shows sucessfully",
                      "Response" => $acceptedbooking,
                      );
                      }
                      elseif (empty($acceptedbooking)) {
                          $result = array(
                      "controller" => "User",
                      "action" => "yourMoveList",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"No data exist in table",
                          );
                        
                      }
                      else{
                      $result = array(
                      "controller" => "User",
                      "action" => "yourMoveList",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"Something went wrong",
                      );
                      }
                    }
                    /*pending booking case end*/
                    /*started booking case start*/
                    elseif($type==2){

                      $acceptedbooking =  $this->db->query("select * from tbl_booking where user_id= ".$user_id." and( (is_accepted=1 or is_started=1) and is_completed=0 ) and is_cancelled =0 ")->result();
                      $acceptedbooking12=array();
                      foreach ($acceptedbooking as $key => $value) {
                      $acceptedbooking12= unserialize($value->item_image); 
                              $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $acceptedbooking[$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$acceptedbooking[$key]->itemimages=array();
                      }
                      }
                      if(!empty($acceptedbooking)){
                      $result = array(
                      "controller" => "User",
                      "action" => "yourMoveList",
                      "ResponseCode" => true,
                      "MessageWhatHappen" =>"your data shows sucessfully",
                      "Response" => $acceptedbooking
                      );
                      }
                            elseif (empty($acceptedbooking)) {
                          $result = array(
                      "controller" => "User",
                      "action" => "yourMoveList",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"No data exist in table",
                          );
                        
                      }
                      else{
                      $result = array(
                      "controller" => "User",
                      "action" => "yourMoveList",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"Something went wrong",

                      );

                      }
                    }
                    /*started booking case end*/
                    /*complete booking case start*/
                    elseif($type==3){
                      $acceptedbooking = $this->Users_model->select_data('*','tbl_booking',array('user_id'=>$user_id,'is_completed'=>1));
                      $acceptedbooking12=array();
                      foreach ($acceptedbooking as $key => $value) {
                        $acceptedbooking12= unserialize($value->item_image); 

                                $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $acceptedbooking[$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$acceptedbooking[$key]->itemimages=array();
                      }
                      }
                        if(!empty($acceptedbooking)){
                          $result = array(
                          "controller" => "User",
                          "action" => "yourMoveList",
                          "ResponseCode" => true,
                          "MessageWhatHappen" =>"your data shows sucessfully",
                          "Response" => $acceptedbooking
                          );
                        }
                              elseif (empty($acceptedbooking)) {
                          $result = array(
                      "controller" => "User",
                      "action" => "yourMoveList",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"No data exist in table",
                          );
                        
                      }
                        else{
                          $result = array(
                          "controller" => "User",
                          "action" => "yourMoveList",
                          "ResponseCode" => false,
                          "MessageWhatHappen" =>"Something went wrong",

                          );

                        }
                    }
                    /*completed booking case end*/
                    /*cancelled booking case start*/
                    elseif($type==4){
                      $acceptedbooking = $this->Users_model->select_data('*','tbl_booking',array('user_id'=>$user_id,'is_cancelled'=>1));
                      $acceptedbooking12=array();
                      foreach ($acceptedbooking as $key => $value) {
                        $acceptedbooking12= unserialize($value->item_image); 

                                $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $acceptedbooking[$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$acceptedbooking[$key]->itemimages=array();
                      }
                      }
                      if(!empty($acceptedbooking)){
                          $result = array(
                          "controller" => "User",
                          "action" => "yourMoveList",
                          "ResponseCode" => true,
                          "MessageWhatHappen" =>"your data shows sucessfully",
                          "Response" => $acceptedbooking
                          );
                        }
                              elseif (empty($acceptedbooking)) {
                          $result = array(
                      "controller" => "User",
                      "action" => "yourMoveList",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"No data exist in table",
                          );
                        
                      }
                        else{
                          $result = array(
                          "controller" => "User",
                          "action" => "yourMoveList",
                          "ResponseCode" => false,
                          "MessageWhatHappen" =>"Something went wrong",

                          );

                      }
                    }
                    /*cancelled booking case end*/
                    $this->set_response($result,REST_Controller::HTTP_OK);  
                }
                public function moveDetailHistory_post(){
                      $message = array(
                          'user_id'=> $this->input->post('user_id'),
                          'move_id'=> $this->input->post('move_id'),
                          'user_Type'=> $this->input->post('user_Type')
                     );
                    $moveHistorydata = $this->Users_model->moveDetailHistory($message);
                      $acceptedbooking12=array();
                      foreach ($moveHistorydata['booking_data'] as $key => $value) {
                      	$moveHistorydata['booking_data'][$key]->cardno=$this->db->query("select card_no from tbl_cardDetail where id='".$value->card_id."'")->result();


                        $acceptedbooking12= unserialize($value->item_image); 
                                   
                  



                             $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $moveHistorydata['booking_data'][$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$moveHistorydata['booking_data'][$key]->itemimages=array();
                      }



                      }
                      $serverTime=date("Y-m-d H:i:s");

                     if(empty($moveHistorydata['booking_data']) && empty($moveHistorydata['move_data'])){  
                     $result = array(
                     "controller" => "User",
                     "action" => "moveDetailHistory",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "data does not exist in table",
                     "servertime"=>$serverTime
                     ); 
                     }
                     else{
                          $result = array(
                     "controller" => "User",
                     "action" => "moveDetailHistory",
                     "ResponseCode" => true,
                     "MessageWhatHappen" => "Your data shows sucessfully",
                     "response"=>$moveHistorydata,
                     "servertime"=>$serverTime
                     );
                     }
                    $this->set_response($result,REST_Controller::HTTP_OK);    

                }
      	 public function forgotpassword_post() {

      			$email = $this->post('email');

      			$id = $this->Users_model->forgotpassword($email);
            // print_r($id);die();

      				if ($id == 0)
      				{
      				$result = array(
      				"controller" => "user",
      				"action" => "forgotpassword",
      				"ResponseCode" => false,
      				"MessageWhatHappen" => "Email does not exist in our database"
      				);
      				} else {

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
            <th style=font-size:20px; font-weight:bolder; text-align:right;padding-bottom:10px;border-bottom:solid 1px #ddd;> Hello " . $id['fname'] . "</th>
            </tr>

            <tr>
            <td style=font-size:16px;>
            <p> You have requested a password retrieval for your user account at Movers.To complete the process, click the link below.</p>
             <p> This is valid for 30 Minutes.</p>
            <p><a href=" . site_url('api/User/newpassword?id=' . $id['b_id']) . ">Change Password</a></p>
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
              // $this->email->priority(3);
              // $this->email->set_newline("\r\n");
              $this->email->to($email);
              $this->email->from('moversondemand@gmail.com', 'MOVERS');
              $this->email->subject('Forgot Password');
              $this->email->message($body);
              $mail = $this->email->send();
      				$result = array(
      				"controller" => "user",
      				"action" => "forgotpassword",
      				"ResponseCode" => true,
      				"MessageWhatHappen" => "Mail Sent Successfully"
      				);
      				}

      			$this->set_response($result, REST_Controller::HTTP_OK);
      		}

      		function newpassword_get($user_id=null)
      		{
      		if ($user_id!="") {
      		$user_id = base64_decode($user_id);
      		}else{
      		$user_id = base64_decode($this->get('id'));
      		}

      		$useridArr = explode("_", $user_id);
      		$user_id = $useridArr[0];
      		$data['id'] = $user_id;


      		$data['title'] = "new Password";
      		$this->load->view('templete/header');
      		$this->load->view('templete/newpassword', $data);
      		}

      		function updateNewpassword_post()
      		{

      			$uid = $this->input->post('id');
      			$static_key = "afvsdsdjkldfoiuy4uiskahkhsajbjksasdasdgf43gdsddsf";
      			$id = $uid . "_" . $static_key;
      			$id = base64_encode($id);
      			$message = ['id' => $this->input->post('id') , 'password' => $this->input->post('password') , 'base64id' => $id];
      			$this->load->library('form_validation');
      			$this->form_validation->set_rules('password', 'Password', 'trim|required|md5');
      			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]|md5');
      			if ($this->form_validation->run() == FALSE)
      			{

      			$this->session->set_flashdata('msg', '<span style="color:red">Please Enter Same Password</span>');
      			redirect("api/User/newpassword?id=" . $message['base64id']);
      			}
      			else
      			{

      			$this->Users_model->updateNewpassword($message);
      			}
      		 }
              public function moveAction_post(){
                $booking_id = $this->input->post('booking_id');
                $driver_id = $this->input->post('user_id');
                $type = $this->input->post('type');
                $cancelUser_type = $this->input->post('cancelUser_type');
                $totalPrice = $this->input->post('totalPrice');
                $reason = $this->input->post('reason');
                $bookingDetails = $this->Users_model->select_data('*','tbl_booking',array('id'=>$booking_id));
                $moveDetail=$this->Users_model->select_data('*','tbl_moveHistory',array('booking_id'=>$booking_id));

        
                /*accepted case by driver*/
                if ($type==1) {  
                    /*for one time hit next hit get error*/
                  if ($bookingDetails[0]->is_accepted==1 || $bookingDetails[0]->is_cancelled==1 || $bookingDetails[0]->is_completed==1) {
                    $result = array(
                    "controller" => "User",
                    "action" => "moveAction",
                    "ResponseCode" => false,
                    "ErrorCode" => 401,
                    "MessageWhatHappen" => "Move accepted failed"
                    );
                    $this->set_response($result, REST_Controller::HTTP_OK);
                    return true;
                        } else {
                        $bookingdata = $this->Users_model->update_data('tbl_booking',array('driver_id'=>$driver_id,'is_accepted'=>1),array('id'=>$booking_id));
                        $moveData = array(
                        "driver_id"=>$driver_id,
                        "status"=>1,
                        'accepted_time'=>date('Y-m-d H:i:s')
                        );
                        $insertMove_history = $this->Users_model->update_data('tbl_moveHistory',$moveData,array("booking_id"=>$booking_id));
                        $action = "Move accepted";
                        $bookinguserDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$bookingDetails[0]->user_id));
                        $bookingdriverDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$driver_id));
                        $bookingloginuserDetails = $this->Users_model->select_data('*','tbl_login',array('user_id'=>$bookingDetails[0]->user_id,'status'=>1));
                        $vehicleNumber = $this->Users_model->select_data('*','tbl_driverDetail',array('driver_id'=>$driver_id));
                       
                        $vehicleName=$this->Users_model->select_data('*','tbl_vechicleType',array('id'=>$vehicleNumber[0]->vehicle_id));
                     

                        /*rating in round off start*/
                        $avgrating=$this->db->query("SELECT round(AVG(rating))  as driverrating FROM tbl_customerRating WHERE driver_id= '".$driver_id."'")->result();
                        /*rating in round off end*/
                        
                        /*push message start*/
                        $pushData['message'] = $bookingdriverDetails[0]->fname.' '.$bookingdriverDetails[0]->lname." has accepted your task request";
                        $pushData['name'] =$bookingdriverDetails[0]->fname.' '.$bookingdriverDetails[0]->lname;
                        $pushData['action'] = "Move accepted";
                            $pushData['Utype'] = 2;
                        $pushData['booking_id'] = $booking_id;
                        $pushData['profile_pic']=$bookingdriverDetails[0]->profile_pic;
                        $pushData['avgrating'] = $avgrating[0]->driverrating;
                        $pushData['vehicleName'] = $vehicleName[0]->name;
                        $pushData['vehicleNumber'] = $vehicleNumber[0]->vehicle_no;
                        
                        $pushData['iosType'] = 4;/*accepted by driver*/
                        foreach ($bookingloginuserDetails as $key => $value) {
                        
                          $pushData['token'] = $value->token_id;
                          if($value->device_id == 1){
                            $this->Users_model->iosPush($pushData);
                          }else if($value->device_id == 0){
                            $this->Users_model->androidPush($pushData);
                          }
                        }
                        // die();
                  
                        /*push message end*/
                        }
                }
                /*started case*/
                elseif ($type==2) {    /* started by driver*/
                    /*for one time hit next hit get error*/
                  if ($bookingDetails[0]->is_accepted==0 || $bookingDetails[0]->is_started==1 || $bookingDetails[0]->is_cancelled==1 || $bookingDetails[0]->is_completed==1) {
                  $result = array(
                  "controller" => "User",
                  "action" => "moveAction",
                  "ResponseCode" => false,
                  "ErrorCode" => 401,
                  "MessageWhatHappen" => "Move started failed"
                  );
                  $this->set_response($result, REST_Controller::HTTP_OK);
                  return true;
                  }else {

                  $bookingprevDetails = $this->Users_model->select_data('*','tbl_booking',array('driver_id'=>$driver_id,'is_accepted'=>1,'is_started'=>1,'is_completed'=>0,'is_cancelled'=>0));




                    if (empty($bookingprevDetails)) {


                      $estimatesecond=$bookingDetails[0]->booking_date.' '.$bookingDetails[0]->booking_time;




                      $bookingprevDetails = $this->Users_model->select_data('*','tbl_booking',array('driver_id'=>$driver_id,'is_accepted'=>1,'is_started'=>1));

                       $bookingdriverDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$driver_id));

                      $date=date("Y-m-d H:i:s");

                      if ($estimatesecond<=$date) {

                  $bookingdata = $this->Users_model->update_data('tbl_booking',array('driver_id'=>$driver_id,'is_started'=>1),array('id'=>$booking_id));
                  $moveData = array(
                  "driver_id"=>$driver_id,
                  "status"=>2,
                  'started_time'=>date('Y-m-d H:i:s')
                  );
                  $insertMove_history = $this->Users_model->update_data('tbl_moveHistory',$moveData,array("booking_id"=>$booking_id));
                      $action = "Move started";
                  $bookinguserDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$bookingDetails[0]->user_id));
                  $bookingdriverDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$driver_id));
                  $bookingloginuserDetails = $this->Users_model->select_data('*','tbl_login',array('user_id'=>$bookingDetails[0]->user_id,'status'=>1));

                  /*push message start*/
                  $pushData['message'] = "Your task has started with ".$bookingdriverDetails[0]->fname.' '.$bookingdriverDetails[0]->lname;
                  $pushData['action'] = "Move started";
                  $pushData['booking_id'] = $booking_id;
        			     $pushData['Utype'] = 2;
                   $pushData['iosType'] = 5;/*started by driver*/
                  foreach ($bookingloginuserDetails as $key => $value) {

                  $pushData['token'] = $value->token_id;
                  if($value->device_id == 1){
                  	$this->Users_model->iosPush($pushData);
                  }else if($value->device_id == 0){
                  	$this->Users_model->androidPush($pushData);
                  }
                  }
                  /*push message end*/
                }
                else{

                  $action="you can not start before booking date time";
                  }
                }

               
                else{

                  $action="you can't start already started";
                }
                 }
                }
                /*completion case*/
                elseif($type==3){   /*is completed by driver*/
                /*for one time hit next hit get error*/
              
                    if ($bookingDetails[0]->is_accepted==0 || $bookingDetails[0]->is_started==0 || $bookingDetails[0]->is_cancelled==1 || $bookingDetails[0]->is_completed==1) {
                    $result = array(
                    "controller" => "User",
                    "action" => "moveAction",
                    "ResponseCode" => false,
                    "ErrorCode" => 401,
                    "MessageWhatHappen" => "Move completed failed"
                    );
                    $this->set_response($result, REST_Controller::HTTP_OK);
                    return true;
                    }else {

                      $bookeddatetime=$moveDetail[0]->started_time;

                      $date=date("Y-m-d H:i:s");
                      $date1=strtotime($date);

                      $estimatesecond=$bookingDetails[0]->time_duration;
                      $dateinsec=strtotime($bookeddatetime);
                      $newdate=$dateinsec+$estimatesecond;
                      $finnaldate= date('Y-m-d H:i:s',$newdate);
                      $finnaldate1=strtotime($finnaldate);
                      $aa=$date-$finnaldate;

                       $time_diff = $date1-$finnaldate1;
                     $aa= $time_diff/60;

                

                       $movecompletetime = $this->Users_model->select_data('*','tbl_setting');

                     $buffer=$movecompletetime[0]->move_complete_buffer_time;

                      if ($aa<$buffer) {
                     /**/
                    $getCardDetail=$this->db->query("SELECT * from tbl_cardDetail  where id='".$bookingDetails[0]->card_id."'")->result();
                    foreach ($getCardDetail as $key => $value) {
                      $getCardDetail[$key]->cutomerid=$this->db->query("SELECT * from tbl_braintreeUsersDetail where user_id='".$bookingDetails[0]->user_id."' and card_no='".$value->card_no."' ")->result();
                    }

                      
                       $charge= $movecompletetime[0]->min_booking_charge;
                       $abc=(($totalPrice/100)*$charge);
                       

            



                  if (!empty($bookingDetails[0]->promoid)) {

                    $promoDetail=$this->db->query("select * from tbl_promousersData where id='".$bookingDetails[0]->promoid."'")->result();

                    $promoCodeDetail=$this->db->query("select * from tbl_promocode where id='".$promoDetail[0]->promo_id."'")->result();
   


                    if (!empty($promoCodeDetail)) {

                    $promopercentage=$promoCodeDetail[0]->value;
                    $promomaxAmount=$promoCodeDetail[0]->max_amount;
                    $totalpercent=$totalPrice*($promopercentage/100);
                    $roundTotal=$totalpercent;


                 
                    if ($roundTotal>$promomaxAmount) {

                      $bookingdata = $this->Users_model->update_data('tbl_booking',array('discount_amount'=>$promomaxAmount),array('id'=>$booking_id));
                        $amountdata=$totalPrice-$promomaxAmount;


                    }
                    else{

             $bookingdata = $this->Users_model->update_data('tbl_booking',array('discount_amount'=>$roundTotal),array('id'=>$booking_id));
                          $amountdata=$totalPrice-$roundTotal;
                    }
                    if ($promoDetail[0]->status=1) { 
                    $updatePromodata = $this->Users_model->update_data('tbl_promousersData',array('status'=>2),array('id'=>$bookingDetails[0]->promoid));
                   }
                   else{
                       $updatePromodata = $this->Users_model->update_data('tbl_promousersData',array('status'=>3),array('id'=>$bookingDetails[0]->promoid));
                   }

                  }

                  else{


                     $ReferDetails = $this->Users_model->select_data('referal_amount,referal_percentage','tbl_setting');
                     $promopercentage=$ReferDetails[0]->referal_percentage;
                    $promomaxAmount=$ReferDetails[0]->referal_amount;
                    $totalpercent=$totalPrice*($promopercentage/100);
                    $roundTotal=($totalpercent);
                    if ($roundTotal>$promomaxAmount) {

                       $bookingdata = $this->Users_model->update_data('tbl_booking',array('discount_amount'=>$promomaxAmount),array('id'=>$booking_id));


                        $amountdata=$totalPrice-$promomaxAmount;
                    }
                    else{

                       $bookingdata = $this->Users_model->update_data('tbl_booking',array('discount_amount'=>$roundTotal),array('id'=>$booking_id));
                      $amountdata=$totalPrice-$roundTotal;
                    }
                    $updateReferdata = $this->Users_model->update_data('tbl_promousersData',array('status'=>2),array('id'=>$bookingDetails[0]->promoid));
                  }
                  }
                  else{
                    $amountdata=$totalPrice;
                  }

                    $price=$amountdata-$abc;

          
                  $cusId=$getCardDetail[0]->cutomerid[0]->customer_id;

                            $trasactdata = Braintree_Transaction::sale([
                            'amount' => $price,
                            'customerId' => $cusId
                          
                            ]);
                  $msg=$trasactdata->message;
                  $txnid=$trasactdata->transaction->id;

                if($trasactdata->success==1){
                  /*if user balence more then deduct balence start*/

                           $transArray = array(
                                    'amount_debited'=>$price,
                                    'user_id'=>$bookingDetails[0]->user_id,
                                    'txn_id'=>$txnid,
                                    'card_id'=>$bookingDetails[0]->card_id,
                                    'move_id'=>$booking_id,
                                    'type'=>'1',
                                    'date_created'=>date('Y-m-d H:i:s')
                                    );
                     $transResponse = $this->Users_model->insert_data('tbl_transactions',$transArray);
        

                    $bookingdata = $this->Users_model->update_data('tbl_booking',array('is_completed'=>1),array('id'=>$booking_id));
                    $moveData = array(
                    "driver_id"=>$driver_id,
                    "status"=>3,
                    'completed_time'=>date('Y-m-d H:i:s')
                    );

                    $insertMove_history = $this->Users_model->update_data('tbl_moveHistory',$moveData,array("booking_id"=>$booking_id));
                    $bookinguserDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$bookingDetails[0]->user_id));
                    $action = "Move completed";

                    $bookingdriverDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$driver_id));
                    $bookingloginuserDetails = $this->Users_model->select_data('*','tbl_login',array('user_id'=>$bookingDetails[0]->user_id,'status'=>1));
                    $get_percentage = $this->Users_model->select_data('*','tbl_setting');
                    $percentage = $get_percentage[0]->min_booking_charge;


                    /*update in driver fund table start*/
                    $getDriverBalance = $this->Users_model->select_data('*','tbl_driversFund',array('driver_id'=>$bookingdriverDetails[0]->id));

                    // $getDriverWallet = $this->Users_model->select_data('*','tbl_wallet',array('user_id'=>$bookingdriverDetails[0]->driver_id));


                     // print_r($getDriverBalance);die();


                     $getAdminpercent=$totalPrice*($bookingDetails[0]->admin_percentage/100);
                     $Driverbalance=$totalPrice-$getAdminpercent;
                    $updatedriveramount=$getDriverBalance[0]->outstanding_amount+$Driverbalance;
                    $uptdriverDAta = $this->Users_model->update_data('tbl_driversFund',array('outstanding_amount'=>$updatedriveramount,'date_modified'=>date('Y-m-d H:i:s')),array('driver_id'=>$bookingdriverDetails[0]->id));

                    // $newDriverbalance=$getDriverWallet[0]->balence+$Driverbalance;
                    // $uptwalletdriverDAta = $this->Users_model->update_data('tbl_wallet',array('balence'=>$newDriverbalance,'date_modified'=>date('Y-m-d H:i:s')),array('user_id'=>$bookingdriverDetails[0]->id));




                    $transUserArray = array(
                    'amount_credited'=>$Driverbalance,
                    'user_id'=>$driver_id,
                    'txn_id'=>'on_wallet',
                    'move_id'=>$bookingDetails[0]->id,
                    'type'=>'3',
                    'date_created'=>date('Y-m-d H:i:s')
                    );
                    $transResponse = $this->Users_model->insert_data('tbl_transactions',$transUserArray);
                    /*update in driver fund table end*/
                    /*driver pay end*/
                    /*send push message start*/
                    $pushData['message'] = "Your task with ".$bookingdriverDetails[0]->fname.' '.$bookingdriverDetails[0]->lname." has completed";
                    $pushData['action'] = "Move completed";
                    $pushData['booking_id'] = $booking_id;
                    $pushData['Utype'] = 2;
                    $pushData['iosType'] = 6;/*completed */
                    foreach ($bookingloginuserDetails as $key => $value) {
                    $pushData['token'] = $value->token_id;
                    if($value->device_id == 1){
                    $this->Users_model->iosPush($pushData);
                    }else if($value->device_id == 0){
                    $this->Users_model->androidPush($pushData);
                    }
                    }
                    /*send push message end*/


                    /*invoice mail start*/
                    $bookinguserDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$bookingDetails[0]->user_id));
                    $bookingdriverDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$driver_id));
                    $time= $this->Users_model->select_data('*','tbl_moveHistory',array('booking_id'=>$booking_id));
                    /*value for invoice email templete start*/
                    $username=$bookinguserDetails[0]->fname;
                    $total=$bookingDetails[0]->total_price;
                    $pick=$bookingDetails[0]->pickup_loc;
                    $drop=$bookingDetails[0]->destination_loc;

                    $starttime=$bookingDetails[0]->booking_time;
                    $completetime=$time[0]->completed_time;
                    $currentdate=date('Y-m-d');
                    
                    $drivername=$bookingdriverDetails[0]->fname;
                    $estimate=$bookingDetails[0]->estimated_price;
                    $email = $bookinguserDetails[0]->email; 
                    /*values for invoice email templete end*/
                                 /* To customer */
                    $body = 
                    '<!DOCTYPE html>
                    <html lang="en">

                    <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>Invoice email</title>

                    <style type="text/css">
                    .table_width {
                    width: 600px;
                    margin: 0px auto;
                    float: none;
                    }
                    .map img {
                    width: 600px;
                    }
                    .logo > img {
                     padding: 7px 0;
                     width: 45%;}
                    .logo {
                    float: none;
                    padding: 0px;
                    margin: 0px;
                    text-align: center;
                    }
                    .headings h1 {
                    color: #5c5c5c;
                    font-size: 30px;
                    margin: 0;
                    padding: 0;
                    font-weight: 600;
                    text-align: center;
                    }
                    .headings h4 {
                    color: #727272;
                    font-size: 17px;
                    line-height: 31px;
                    margin: 0;
                    padding: 4px 0 0;
                    font-weight: normal;
                    }
                    .headings {
                    float: none;
                    padding: 10px 27px;
                    text-align: center;
                    }
                    .timing {
                    background: #f6f6f6 none repeat scroll 0 0;
                    padding: 5px 17px;
                    }
            
                    .Estimated h4{
                    color: #5c5c5c;
                    font-size: 20px;
                    margin: 0;
                    padding: 11px 0 0;
                    font-weight: 500;
                    text-align: center;

                    }
                    .timing h3 {
                    color: #5c5c5c;
                    font-size: 20px;
                    margin: 0;
                    padding: 11px 0 0;
                    font-weight: 500;
                    }
                                
                    .timing span {
                    color: #434343;
                    float: right;
                    font-size: 14px;
                    font-weight: normal;
                    padding: 0px 11px 2px;
                    }
                
                    .profile img {
                    width: 60%;
                    padding: 20px 11px;
                    }
                    .go_with h5 {
                    color: #848484;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    padding: 0;
                    }
                    .go_with h5 span {
                    color: #333;
                    }
                    .rating {
                    background: #f6f6f6;
                    padding: 0px;
                    width: 80%;
                    margin: 0px auto;
                    }
                    .rating p {
                    color: #727272;
                    font-size: 17px;
                    margin: 0;
                    padding: 14px 10px;
                    }
                    .discription p {
                    margin: 0px;
                    padding: 0 0 0 12px;
                    line-height: 31px;
                    font-size: 14px;
                    color: #727272;
                    font-weight: normal;
                    }
                    .boder_bottom {
                    border-bottom: 1px solid #eeeeee;
                    padding: 0 0 10px;
                    }
                    .fare h3 {
                    color: #000;
                    font-size: 18px;
                    line-height: 31px;
                    margin: 0;
                    padding: 13px 0 0;
                    font-weight: normal;
                    }
                    .base_fare h4 {
                    color: #848484;
                    font-size: 16px;
                    font-weight: normal;
                    margin: 0;
                    padding: 10px 0;
                    }
                    .base_fare p {
                    color: #848484;
                    font-size: 16px;
                    font-weight: normal;
                    margin: 0;
                    padding: 10px 0;
                    text-align: right;
                    }
                    .total h4 {
                    color: #000;
                    font-size: 18px;
                    line-height: 31px;
                    margin: 0;
                    padding: 3px 0 0;
                    font-weight: normal;
                    }
                    .total p {
                    color: #000;
                    font-size: 16px;
                    font-weight: normal;
                    margin: 0;
                    padding: 16px 0;
                    text-align: right;
                    }
                    .copy_right {
                    background: #2b92df none repeat scroll 0 0;
                    margin: 0;
                    padding: 3px 0 0;
                    text-align: center;
                    }
                    .copy_right > p {
                    color: #ffffff;
                    font-size: 18px;
                    padding: 0px 0 0;
                    text-align: center;
                    }
                    .postion {position: relative!important;top: -29px!important;}

                    .table_width{width: 600px; margin: 0px auto; float: none; background: #dddddd none repeat scroll 0 0;}
                    </style>
                    </head>

                    <body style="font-family: "Roboto", sans-serif;">

                    <div class="table_width">
                    <table cellpading="0" cellspacing="0" border="0" style="width:600px background-color:#ccc; margin:0px auto;">

                    <tr>

                    <th class="map"><img src="http://phphosting.osvin.net/moversOnDemand/Admin/public/img/map.jpg">
                    </th>
                    </tr>

                    <tr>
                    <td class="logo"><img src="http://phphosting.osvin.net/moversOnDemand/Admin/public/img/ic_logo_dashboard.png">
                    </td>
                    </tr>

                    <tr>                        
                    <td class="headings"><h4>Thanks for choosing MOVERS, '.$username.'</h4></td>
                    </tr>
                    <tr>                <td class="headings"><h4>'.$currentdate.'</h4></td>
                    </tr>
                    <tr><td class="headings"><h1> Total price</h1><h1>$ '.$estimate.'</h1></td></tr>

              


                    <tr>
                    <td>
                    <table>
                    <td width="30%" class="profile"><img src="http://phphosting.osvin.net/moversOnDemand/Admin/public/img/dum.png" >
                    </td>
                    <td class="go_with" vertical-align="top" width="70%">

                    <table width="100%">
                    <tr>
                    <td class="headings"><h1> You Rode with Osvin '.$drivername.'</h1></td>

                    </tr>
                    </table>
                    </td>
                    </table>
                    </td>
                    </tr>





                    <tr>
                    <td class="boder_bottom">
                    <table width="100%">
                    <tr class="">
                    <td width="50%" class="Estimated">
                    <h4>Total Fare</h4>
                    </td>
                    <td width="50%" class="Estimated">
                    <h4>'.$estimate.'</h4>
                    </td>
                    </tr>
                    </table>
                    </td>
                    </tr>
                    <tr>                <td class="copy_right">
                    <p>Copyright &copy; 2017 Movers On Demand All rights reserved. </p>
                    </td></tr>



                    </table>
                    </div>
                    </body>

                    </html>';
                      $this->load->library('email');
                      $this->email->from('support@moversOnDemand.com', 'Movers');
                      $this->email->to($email);
                      $this->email->subject('Request Completed');
                      $this->email->message($body);
                      $this->email->send();
                    /*invoice email end*/
                      }
                      else{
                        $action=$msg;
                      }
                    }
                      else{
                         $action = "Move completed failed due to time";
                      }
                    }
                }
              /*cancelled case*/
             elseif ($type==4) {
              /*for one time hit next hit get error*/
                if ($bookingDetails[0]->is_started==1 || $bookingDetails[0]->is_cancelled==1 || $bookingDetails[0]->is_completed==1) {
                $result = array(
                "controller"   => "User",
                "action"       => "moveAction",
                "ResponseCode" => false,
                "ErrorCode"    => 401,
                "MessageWhatHappen" => "Move cancelled failed"
                );
                $this->set_response($result, REST_Controller::HTTP_OK);
                return true;
                }else {
                if ($cancelUser_type==1) {   /*cancelled by driver start*/

                   $bookingdata = $this->Users_model->update_data('tbl_booking',array('is_cancelled'=>1),array('id'=>$booking_id));
                  
                    $updateMove_history = $this->Users_model->update_data('tbl_moveHistory',array('status'=>4,'cancelled_time'=>date('Y-m-d H:i:s'),'cancelled_by'=>1),array('booking_id'=>$booking_id,'driver_id'=>$driver_id));


                    $bookinguserDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$bookingDetails[0]->user_id));


                    $bookingdriverDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$driver_id));
                    $bookingloginuserDetails = $this->Users_model->select_data('*','tbl_login',array('user_id'=>$bookingDetails[0]->user_id,'status'=>1));
                    /*push message start*/
                    $pushData['message'] = $bookingdriverDetails[0]->fname.' '.$bookingdriverDetails[0]->lname." has cancelled your task request";
                    $pushData['action'] = "Move cancelled";
                    $pushData['booking_id'] = $booking_id;
                    $pushData['Utype'] = 2;
                    $pushData['iosType'] = 3;/*cancelled by driver*/
                    foreach ($bookingloginuserDetails as $key => $value) {

                      $pushData['token'] = $value->token_id;
                      if($value->device_id == 1){
                        $this->Users_model->iosPush($pushData);
                      }else if($value->device_id == 0){
                        $this->Users_model->androidPush($pushData);
                      }
                    }
                    /*push message end*/

                  $txndetail=$this->db->query("SELECT * FROM tbl_transactions where user_id='".$bookingDetails[0]->user_id."' AND move_id='".$bookingDetails[0]->id."' ORDER BY date_created DESC Limit 1")->result();

                    /*get minimum booking charges from total price start */
                    $minBookingCharge = $this->Users_model->select_data('min_booking_charge','tbl_setting');
                    $getbookingcharge = $minBookingCharge[0]->min_booking_charge;
                    $amountdeduct = ($getbookingcharge / 100) * $bookingDetails[0]->estimated_price;
                    $deductprice=($amountdeduct);
                    /*get minimum booking charges from total price end*/

                    $resultSettle = Braintree_Transaction::submitForSettlement($txndetail[0]->txn_id);
                    $msg=$resultSettle->message;
                    if ($resultSettle->success==1) {
                    $resultrefund = Braintree_Transaction::refund($txndetail[0]->txn_id);
                       $msg=$resultrefund->message;
                     if ($resultrefund->success==1) {
                    $txnid=$resultrefund->transaction->id;
                    $amount=$resultrefund->transaction->amount;    
                    $transArray = array(
                      'amount_credited'=>$amount,
                      'user_id'=>$bookingDetails[0]->user_id,
                      'txn_id'=>$txnid,
                      'card_id'=>$bookingDetails[0]->card_id,
                      'move_id'=>$bookingDetails[0]->id,
                      'type'=>'2',
                      'date_created'=>date('Y-m-d H:i:s')
                    );
                    $transResponse = $this->Users_model->insert_data('tbl_transactions',$transArray);

                /*refund user in case of cancel by driver end*/
                /*reason of cancel start*/
                $cancelArray = array(
                'user_id'=>$bookingDetails[0]->user_id,
                'status'=>1,
                'driver_id'=>$driver_id,
                'reason'=>$reason,
                'date_created'=>date('Y-m-d H:i:s')
                );
                $transResponse = $this->Users_model->insert_data('tbl_cancelBooking',$cancelArray);
                /*reason of cancel end*/
                $action = "Move cancelled";
              }
                else{
                  $action="error msg".$msg;/*refund error*/
                }
              }else{
              $action="error msg".$msg;/*settlement error*/
            }

                /*cancelled by driver end*/
                }
                else if($cancelUser_type == 2) {   /*cancelled by user*/
                        $bookingdata = $this->Users_model->update_data('tbl_booking',array('is_cancelled'=>1),array('id'=>$booking_id));
                $updateMove_history = $this->Users_model->update_data('tbl_moveHistory',array('status'=>4,'cancelled_time'=>date('Y-m-d H:i:s'),'cancelled_by'=>2),array('booking_id'=>$booking_id));

                /*refund user in case of booking time is greater then 24 hours start*/
                /*check time interval start*/
                $bookdate=$bookingDetails[0]->booking_date;
                $booktime=$bookingDetails[0]->booking_time;
                $curentdatetime=date('Y-M-d H:i:s');
                $combineddatetime = $bookdate . ' ' . $booktime;
                $interval = round((strtotime($combineddatetime) - strtotime($curentdatetime))/3600, 1);
                $action = "Move cancelled";
                /*check time interval end*/

                if ($interval>24) {


                  $txndetail=$this->db->query("SELECT * FROM tbl_transactions where user_id='".$bookingDetails[0]->user_id."' AND move_id='".$bookingDetails[0]->id."' ORDER BY date_created DESC Limit 1")->result();

                   $resultSettle = Braintree_Transaction::submitForSettlement($txndetail[0]->txn_id);
                    $msg=$resultSettle->message;
                    if ($resultSettle->success==1) {
                    $resultrefund = Braintree_Transaction::refund($txndetail[0]->txn_id);
                       $msg=$resultrefund->message;
                     if ($resultrefund->success==1) {
                    $txnid=$resultrefund->transaction->id;
                    $amount=$resultrefund->transaction->amount;    
                    $transArray = array(
                      'amount_credited'=>$amount,
                      'user_id'=>$bookingDetails[0]->user_id,
                      'txn_id'=>$txnid,
                      'card_id'=>$bookingDetails[0]->card_id,
                      'move_id'=>$bookingDetails[0]->id,
                      'type'=>'2',
                      'date_created'=>date('Y-m-d H:i:s')
                    );
                    $transResponse = $this->Users_model->insert_data('tbl_transactions',$transArray);
                            $cancelArray = array(
                            'user_id'=>$bookingDetails[0]->user_id,
                            'status'=>1,
                            'driver_id'=>$driver_id,
                            'reason'=>$reason,
                            'date_created'=>date('Y-m-d H:i:s')
                            );
                            $transResponse = $this->Users_model->insert_data('tbl_cancelBooking',$cancelArray);
                            /*reason of cancel end*/
                            $action = "Move cancelled";
                           }
                           else{
                            $action="error msg".$msg;/*refund error*/

                           }
                        }   
                        else{
                        $action="error msg".$msg;/*settlement error*/
                         }

                }

                /*refund user in case of booking time is greater then 24 hours end*/
                /*else only cancelled and not to be refund*/

                 /*notification to driver that user has cancelled start*/
                 $bookingdriverDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$bookingDetails[0]->driver_id));
                  $bookinglogindriverDetails = $this->Users_model->select_data('*','tbl_login',array('user_id'=>$bookingDetails[0]->driver_id,'status'=>1));
                  /*push code start*/
                    $pushData['message'] = $bookingdriverDetails[0]->fname.' '.$bookingdriverDetails[0]->lname." has cancelled your booking request";
                    $pushData['action'] = "Move cancelled";
                    $pushData['booking_id'] = $booking_id;
                    $pushData['Utype'] = 1;
                    $pushData['iosType'] = 3;/*cancelled by driver*/
                    foreach ($bookinglogindriverDetails as $key => $value) {
                      $pushData['token'] = $value->token_id;
                      if($value->device_id == 1){
                        $this->Users_model->iosPush($pushData);
                      }else if($value->device_id == 0){
                        $this->Users_model->androidPush($pushData);
                      }
                    }
                    /*push code end*/
                 /*notification to driver that user has cancelled end*/ 
                 /*reason of cancel start*/
                $cancelArray = array(
                'user_id'=>$bookingDetails[0]->user_id,
                'status'=>2,
                'driver_id'=>$driver_id,
                'reason'=>$reason
                );
                $transResponse = $this->Users_model->insert_data('tbl_cancelBooking',$cancelArray);
                /*reason of cancel end*/
                }
              }

              }/*cancel type end*/
              elseif ($type==5) {

                $declined = array(
                'move_id'=>$booking_id,
                'driver_id'=>$driver_id,
                );
                $bookingdata = $this->Users_model->insert_data('tbl_declinedDriver',$declined);
                $action="Move declined";
                
                
              }

              // if(empty($bookingdata)){
              //   $result = array(
              //   "controller" => "User",
              //   "action" => "moveAction",
              //   "ResponseCode" => false,
              //   "MessageWhatHappen" => "Not updated"
              //   );
              // } else
              if (!empty($action)) {
                   $result = array(
                "controller" => "User",
                "action" => "moveAction",
                "ResponseCode" => true,
                "MessageWhatHappen" => $action
                );
                
              }


              elseif(empty($action)){
                $result = array(
                "controller" => "User",
                "action" => "moveAction",
                "ResponseCode" => false,
                "MessageWhatHappen" => $action." successfully"
                );
              }
              else{
              	   $result = array(
                "controller" => "User",
                "action" => "moveAction",
                "ResponseCode" => false,
                "MessageWhatHappen" => "something went wrong"
                );


              }
                $this->set_response($result, REST_Controller::HTTP_OK);
          }

          public function getdriverprofile_post(){
                 $id= $this->input->post('driver_id');
                $data['profiledata'] = $this->Users_model->select_data('*','tbl_users',array('id'=>$id));
                $data['driverdetaildata'] = $this->Users_model->select_data('*','tbl_driverDetail',array('driver_id'=>$id));
                $data['vehicle_detail'] = $this->Users_model->select_data('*','tbl_vechicleType',array('id'=>$data['driverdetaildata'][0]->vehicle_id));
                $data['walletdata'] = $this->Users_model->select_data('*','tbl_driversFund',array('driver_id'=>$id));
                $data['transactiondata'] = $this->Users_model->select_data('*','tbl_transactions',array('user_id'=>$id));

                /*rating in round off start*/
                $data['avgrating']=$this->db->query("SELECT round(AVG(rating)) as driverrating FROM tbl_customerRating WHERE driver_id=$id")->result();
                /*rating in round off end*/
                
                if ($data){
                          $result = array(
                          "controller" => "User",
                          "action" => "getdriverprofile",
                          "ResponseCode" => true,
                          "MessageWhatHappen" =>"your data shows sucessfully",
                          "Response" => $data
                          );
                     }
                     else {
                          $result = array(
                          "controller" => "User",
                          "action" => "getdriverprofile",
                          "ResponseCode" => false,
                          "MessageWhatHappen" =>"Something went wrong",
                          );
                     }
           $this->set_response($result,REST_Controller::HTTP_OK);  
          }
               /*update driver latitude and longitude api*/
                public function updateDriverLoc_post(){
                      $user_id = $this->input->post('user_id');
                      $latitude = $this->input->post('latitude');
                      $longitude = $this->input->post('longitude');
                     $result=$this->Users_model->update_data('tbl_users',array('latitude'=>$latitude,'longitude'=>$longitude),array('id'=>$user_id));
                           if ($result){
                               $result = array(
                               "controller" => "User",
                               "action" => "updateDriverLoc",
                               "ResponseCode" => true,
                               "MessageWhatHappen" =>"your data updated sucessfully",
                            
                               );
                          }
                          else{
                               $result = array(
                               "controller" => "User",
                               "action" => "updateDriverLoc",
                               "ResponseCode" => false,
                               "MessageWhatHappen" =>"Something Went Wrong",
                               );
                          }
                     $this->set_response($result,REST_Controller::HTTP_OK);  

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
            public function getcurrentMove_post(){
              $user_id=$this->input->post('user_id');
              $date=date('Y-m-d');  /*server date*/
              $time=date('H:i:s');  /*server time*/

              $accdata=$this->db->query("SELECT * FROM tbl_booking where driver_id = '".$user_id."' AND is_accepted='1' AND is_started='1' AND is_completed='0' AND is_cancelled='0' ")->result();
              /*if current any started move get Start*/
              if (!empty($accdata)) {
                      $data['booking_data']=$this->Users_model->select_data('*','tbl_booking',array('driver_id'=>$user_id,'is_accepted'=>1,'is_started'=>1,'is_completed'=>0,'is_cancelled'=>0));

                      $acceptedbooking12=array();
                      foreach ($data['booking_data'] as $key => $value) {
                      $acceptedbooking12= unserialize($value->item_image); 
                          $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $acceptedbooking[$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$acceptedbooking[$key]->itemimages=array();
                      }
                      }
              }
               /*if current any started move get end*/
              /*else give current date topmost from live server time start*/
              else{

      // AND booking_time >='".$time."' 
              $data['booking_data']=$this->db->query("SELECT * FROM tbl_booking where driver_id = '".$user_id."' AND ( is_accepted='1' OR is_started='0') AND is_completed='0' AND is_cancelled='0'  AND  booking_date = '".$date."' ORDER BY booking_time ASC LIMIT 1")->result();

                      $acceptedbooking12=array();
                      foreach ($data['booking_data'] as $key => $value) {
                      $acceptedbooking12= unserialize($value->item_image); 
                           $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $acceptedbooking[$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$acceptedbooking[$key]->itemimages=array();
                      }
                      }
              }
              /*else give current date topmost from live server time end*/
            $data['move_data'] = $this->Users_model->select_data('*','tbl_moveHistory',array('booking_id'=>$data['booking_data'][0]->id));
            $getvehicleid = $this->Users_model->select_data('vehicle_id','tbl_driverDetail',array('driver_id'=>$data['booking_data'][0]->driver_id));
            $data['usersDetail'] = $this->Users_model->select_data('fname,lname,country_code,phone,profile_pic','tbl_users',array('id'=>$data['booking_data'][0]->user_id));
                if (($data)){
                          $result = array(
                          "controller" => "User",
                          "action" => "getcurrentMove",
                          "ResponseCode" => true,
                          "MessageWhatHappen" =>"your data shows sucessfully",
                          "Response" => $data
                          );
                     }
               
                     else {
                          $result = array(
                          "controller" => "User",
                          "action" => "getcurrentMove",
                          "ResponseCode" => false,
                          "MessageWhatHappen" =>"Something went wrong",
                          );
                     }
           $this->set_response($result,REST_Controller::HTTP_OK);  
            }
            /*driver move listing start*/
            public function driverMovelisting_post(){
               $driver_id=$this->input->post('driver_id'); 
               $type=$this->input->post('type');
               /*type 1 for accepted and started case start*/
               if ($type==1) {
                    $acceptedbooking =  $this->db->query("select * from tbl_booking where driver_id= ".$driver_id." and (is_accepted=1 or is_started=1) and is_completed=0 and is_cancelled=0")->result();
                       /*serialize process for item images start*/
                      $acceptedbooking12=array();
                      foreach ($acceptedbooking as $key => $value) {
                      $acceptedbooking12= unserialize($value->item_image); 
                           $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $acceptedbooking[$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$acceptedbooking[$key]->itemimages=array();
                      }
                      }
                      /*serialize process end*/


                      if(!empty($acceptedbooking)){
                      $result = array(
                      "controller" => "User",
                      "action" => "driverMovelisting",
                      "ResponseCode" => true,
                      "MessageWhatHappen" =>"your data shows sucessfully",
                      "Response" => $acceptedbooking,
                      );
                      }
                      else{
                      $result = array(
                      "controller" => "User",
                      "action" => "driverMovelisting",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"Something went wrong",
                      );
                      }
                    }
                    /*type 1 for accepted and started case end*/

                    
                   /*type 2 for completed case start */
               elseif ($type==2) {
                     $acceptedbooking = $this->Users_model->select_data('*','tbl_booking',array('driver_id'=>$driver_id,'is_accepted'=>1,'is_started'=>1,'is_completed'=>1));
                       /*serialize process for item images start*/              
                      $acceptedbooking12=array();
                      foreach ($acceptedbooking as $key => $value) {
                      $acceptedbooking12= unserialize($value->item_image); 
                           $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $acceptedbooking[$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$acceptedbooking[$key]->itemimages=array();
                      }
                      }
                       /*serialize process end*/
                      if(!empty($acceptedbooking)){
                      $result = array(
                      "controller" => "User",
                      "action" => "driverMovelisting",
                      "ResponseCode" => true,
                      "MessageWhatHappen" =>"your data shows sucessfully",
                      "Response" => $acceptedbooking,
                      );
                      }
                      else{
                      $result = array(
                      "controller" => "User",
                      "action" => "driverMovelisting",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"Something went wrong",
                      );
                      }
                 
               }
               /*type 2 for completed case end */

               /*type 3 for cancelled case start */
               elseif($type==3){
                    $acceptedbooking = $this->Users_model->select_data('*','tbl_booking',array('driver_id'=>$driver_id,'is_cancelled'=>1));
                       /*serialize process for item images start*/
                      $acceptedbooking12=array();
                      foreach ($acceptedbooking as $key => $value) {
                           $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $acceptedbooking[$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$acceptedbooking[$key]->itemimages=array();
                      }
                      }
                       /*serialize process for item images end*/
                      if(!empty($acceptedbooking)){
                      $result = array(
                      "controller" => "User",
                      "action" => "driverMovelisting",
                      "ResponseCode" => true,
                      "MessageWhatHappen" =>"your data shows sucessfully",
                      "Response" => $acceptedbooking,
                      );
                      }
                      else{
                      $result = array(
                      "controller" => "User",
                      "action" => "driverMovelisting",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"Something went wrong",
                      );
                      }

               }
               /*type 3 for cancelled case end */
                      $this->set_response($result,REST_Controller::HTTP_OK);  

            }
            public function getCities_POST(){
            	$city_name = $this->input->post('city_name');
            	$country_name=$this->input->post('country_name');

               	$this->db->select('*');
               	$this->db->like('city_name', $city_name);
               	$this->db->like('country_name', $country_name);
                $response = $this->db->get('tbl_cities')->result();
         

            	      if(!empty($response)){
                      $result = array(
                      "controller" => "User",
                      "action" => "getCities",
                      "ResponseCode" => true,
                      "MessageWhatHappen" =>"your data shows sucessfully",
                      "Response" => $response,
                      );
                      }
                      else{
                      $result = array(
                      "controller" => "User",
                      "action" => "getCities",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"Something went wrong",
                      );
                      }

               
               /*type 3 for cancelled case end */
                    $this->set_response($result,REST_Controller::HTTP_OK); 
            	

            }
           	/*editmove api*/
            public function editMove_post(){


            	$move_id= $this->input->post('book_id');
           
            
              $data = array(
                     'user_id'=>$this->input->post('user_id'),
                     'pickup_loc'=>$this->input->post('pickup_loc'),  
                     'destination_loc'=>$this->input->post('destination_loc'),  
                     'booking_date'=>$this->input->post('booking_date'),
                     'booking_time'=>$this->input->post('booking_time'),  
                     'estimated_price'=>$this->input->post('estimated_price'),
                     'pickup_latitude'=>$this->input->post('pickup_latitude'),  
                     'pickup_longitude'=>$this->input->post('pickup_longitude'),  
                     'destination_latitude'=>$this->input->post('destination_latitude'),
                     'destination_longitude'=>$this->input->post('destination_longitude'),  
                     'time_duration'=>$this->input->post('time_duration'),
                     'distance'=>$this->input->post('distance'),
                     'path_polyline'=>$this->input->post('path_polyline'),
                     'distance_fare'=>$this->input->post('distance_fare'),
                     'hourly_fare'=>$this->input->post('hourly_fare')
                     );
              $data['city_id']= $this->input->post('city_id');
                  /*refund start*/
                  $arra = $this->Users_model->select_data('*','tbl_booking',array('id'=>$move_id));
                  // print_r($arra);die();
                  $data['vehicle_id']=$arra[0]->vehicle_id;

                  $txndetail=$this->db->query("SELECT * FROM tbl_transactions where user_id='".$data['user_id']."' AND move_id='".$move_id."' ORDER BY date_created DESC Limit 1")->result();
                  // print_r($txndetail);

                      /*new transaction start*/
                    /*get minimum booking charges from total price start */
                    $minBookingCharge = $this->Users_model->select_data('min_booking_charge','tbl_setting');
                    $getbookingcharge = $minBookingCharge[0]->min_booking_charge;
                    $amountdeduct = ($getbookingcharge / 100) * $data['estimated_price'];
                    $deductprice=($amountdeduct);
                    /*get minimum booking charges from total price end*/


                    if ($arra[0]->estimated_price != ($data['estimated_price'])) {


                    
                  

                    $resultset = Braintree_Transaction::submitForSettlement($txndetail[0]->txn_id);
                    // print_r($result12);
                    $msg=$resultset->message;
                    if ($resultset->success==1) {
                      // echo "settlement set";
                    // print_r($resultrefund);
                    $resultrefund = Braintree_Transaction::refund($txndetail[0]->txn_id);
                       $msg=$resultrefund->message;
                     if ($resultrefund->success==1) {
                      // echo "refund sucess";
                    $txnid=$resultrefund->transaction->id;
                    $amount=$resultrefund->transaction->amount;    
                    $transArray = array(
                      'amount_credited'=>$amount,
                      'user_id'=>$data['user_id'],
                      'txn_id'=>$txnid,
                      'card_id'=>$arra[0]->card_id,
                      'move_id'=>$move_id,
                      'type'=>'2',
                      'date_created'=>date('Y-m-d H:i:s')
                    );
                    $transResponse = $this->Users_model->insert_data('tbl_transactions',$transArray);
                    /*refund end*/

                    


                    $getCardDetail=$this->db->query("SELECT * from tbl_cardDetail  where id='".$arra[0]->card_id."'")->result();
                    foreach ($getCardDetail as $key => $value) {
                      $getCardDetail[$key]->cutomerid=$this->db->query("SELECT * from tbl_braintreeUsersDetail where user_id='".$data['user_id']."' and card_no='".$value->card_no."' ")->result();
                    }
                    $cusId=$getCardDetail[0]->cutomerid[0]->customer_id;
                        $result123 = Braintree_Transaction::sale([
                              'amount' => $deductprice,
                              'customerId' => $cusId
                              ]);

                    $txnid=$result123->transaction->id;
                    $msg=$result123->message;
                      /*new transaction end*/     
                  if ($result123->success==1) {

                      /*if user balence more then deduct balence start*/
                      $transArray = array(
                        'amount_debited'=>$deductprice,
                        'user_id'=>$data['user_id'],
                        'txn_id'=>$txnid,
                        'card_id'=>$arra[0]->card_id,
                        'move_id'=>$move_id,
                        'type'=>'1',
                        'date_created'=>date('Y-m-d H:i:s')
                      );
                      $transResponse = $this->Users_model->insert_data('tbl_transactions',$transArray);
                      $newBookingdata= $this->Users_model->update_data('tbl_booking',$data,array('id'=>$move_id));
                      $bookingdata=array('booking_id'=>$move_id,'status'=>0);
                      $newMovedata= $this->Users_model->update_data('tbl_moveHistory',$bookingdata,array('id'=>$move_id));

                      /*push code start*/
                        $pushData['message'] = "You have recieved a request for new task";
                        $pushData['action'] = "new move";
                        $pushData['Utype'] = 1;
                        $pushData['iosType'] = 1;/*new book*/
                        $pushData['booking_id'] = $move_id;

                        $selectlogin=$this->Users_model->bookmove($data);


                 
                            foreach ($selectlogin as  $loginUsers => $value) {
                              $pushData['token'] = $value->token_id;
                              if($loginUsers->device_id == 1){
                               $this->Users_model->iosPush($pushData);
                              }else if($loginUsers->device_id == 0){
                               $this->Users_model->androidPush($pushData);
                              }
                            } 
                        
                      /*push code end*/  


                      if(empty($newBookingdata)){
                           $result = array(
                           "controller" => "User",
                           "action" => "editMove",
                           "ResponseCode" => false,
                           "response" => $msg,
                           "MessageWhatHappen" => "Something went wrong"
                           );
                      }else{                    
                           $result = array(
                           "controller" => "User",
                           "action" => "editMove",
                           "ResponseCode" => true,
                           "response" => $msg,
                           "MessageWhatHappen" => "booking data updated sucessfully",
                           "Move_id"=>$move_id
                           );
                      }     
                    }
                    else{
                      $action=$msg;
                    }
                }
                else{
                  $action=$msg;/*refund msg*/
                }
                }
                else{
                  $action=$msg;/*settlement error*/
                }
              }
              elseif($arra[0]->estimated_price == $data['estimated_price']){


                      // print_r($unfiltered);
                      $newBookingdata= $this->Users_model->update_data('tbl_booking',$data,array('id'=>$move_id));
                
                  
                      $bookingdata=array('booking_id'=>$move_id,'status'=>0);
                      $newMovedata= $this->Users_model->update_data('tbl_moveHistory',$bookingdata,array('id'=>$move_id));

                      /*push code start*/
                        $pushData['message'] = "You have recieved a request for new task";
                        $pushData['action'] = "new move";
                        $pushData['Utype'] = 1;
                        $pushData['iosType'] = 1;/*new book*/
                        $pushData['booking_id'] = $move_id;
                        $selectlogin=$this->Users_model->bookmove($data);

                 
                            foreach ($selectlogin as  $loginUsers => $value) {
                              $pushData['token'] = $value->token_id;
                              if($loginUsers->device_id == 1){
                               $this->Users_model->iosPush($pushData);
                              }else if($loginUsers->device_id == 0){
                               $this->Users_model->androidPush($pushData);
                              }
                            } 
                        
                      /*push code end*/  


                      if(empty($newBookingdata)){
                           $result = array(
                           "controller" => "User",
                           "action" => "editMove",
                           "ResponseCode" => false,
                           "MessageWhatHappen" => "Something went wrong"
                           );
                      }
                 
                      else{                    
                           $result = array(
                           "controller" => "User",
                           "action" => "editMove",
                           "ResponseCode" => true,
                           "MessageWhatHappen" => "booking data updated sucessfully",
                           "Move_id"=>$move_id
                           );
                      }     




              }
                 else{
                      $result = array(
                          "controller" => "User",
                          "action" => "editMove",
                          "ResponseCode" => false,
                          "MessageWhatHappen" => "something went wrong",
                          "response" => $msg,
                          "bookedPercentage" => $getbookingcharge
                      );
                    }
                $this->set_response($result,REST_Controller::HTTP_OK);  

            }
            public function retryMove_post(){
              $move_id=$this->input->post('move_id');
              $card_id=$this->input->post('card_id');


              $data['promoid']=$this->input->post('promoid');

              $arra = $this->Users_model->select_data('*','tbl_booking',array('id'=>$move_id));
              // print_r($arra);

              $data=array(
                'user_id'=>$arra[0]->user_id,
                'vehicle_id'=>$arra[0]->vehicle_id,
                'driver_id'=>$DriverId,
                'moveType_id'=>$arra[0]->moveType_id,
                'receipt_number'=>$arra[0]->receipt_number,
                'pickup_loc'=>$arra[0]->pickup_loc,
                'destination_loc'=>$arra[0]->destination_loc,

                'estimated_price'=>$arra[0]->estimated_price,
                'total_price'=>$arra[0]->total_price,
                'pickup_latitude'=>$arra[0]->pickup_latitude,
                'pickup_longitude'=>$arra[0]->pickup_longitude,
                'destination_latitude'=>$arra[0]->destination_latitude,
                'destination_longitude'=>$arra[0]->destination_longitude,
                'time_duration'=>$arra[0]->time_duration,
                'distance'=>$arra[0]->distance,
                'path_polyline'=>$arra[0]->path_polyline,
                'pickup_level'=>$arra[0]->pickup_level,


                'destination_level'=>$arra[0]->destination_level,
                'pickup_movers'=>$arra[0]->pickup_movers,
                'destination_movers'=>$arra[0]->destination_movers,
                'description'=>$arra[0]->description,
                'distance_fare'=>$arra[0]->distance_fare,
                'hourly_fare'=>$arra[0]->hourly_fare,


                'pickup_flight_fare'=>$arra[0]->pickup_flight_fare,
                'destination_flight_fare'=>$arra[0]->destination_flight_fare,
                'loading_fare'=>$arra[0]->loading_fare,
                'unloading_fare'=>$arra[0]->unloading_fare,
                'movers_fare'=>$arra[0]->movers_fare,
                'loading_time'=>$arra[0]->loading_time,
                'unloading_time'=>$arra[0]->unloading_time,


                'receipt_image'=>$arra[0]->receipt_image,
                'item_image'=>$arra[0]->item_image,


                'card_id'=>$arra[0]->card_id,
                'promoid'=>$arra[0]->promoid,
                'admin_percentage'=>$arra[0]->admin_percentage,
                 'city_id'=>$arra[0]->city_id

                );
                  unset($data['driver_id']);
                  unset($data['card_id']);
                  $data['card_id']=$card_id;

                  $data['booking_date']=$this->input->post('booking_date');
                  $data['booking_time']=$this->input->post('booking_time');

                
                /*new transaction start*/

                /*get minimum booking charges from total price start */
                
                $minBookingCharge = $this->Users_model->select_data('min_booking_charge','tbl_setting');
                $getbookingcharge = $minBookingCharge[0]->min_booking_charge;
                $amountdeduct = ($getbookingcharge / 100) * $data['estimated_price'];
                $deductprice=($amountdeduct);
                
                /*get minimum booking charges from total price end*/

                  $getCardDetail=$this->db->query("SELECT * from tbl_cardDetail  where id='".$card_id."'")->result();
                  foreach ($getCardDetail as $key => $value) {
                    $getCardDetail[$key]->cutomerid=$this->db->query("SELECT * from tbl_braintreeUsersDetail where user_id='".$data['user_id']."' and card_no='".$value->card_no."' ")->result();
                  }
                  $cusId=$getCardDetail[0]->cutomerid[0]->customer_id;
                      $resultsale = Braintree_Transaction::sale([
                            'amount' => $deductprice,
                            'customerId' => $cusId
                            ]);
                  $txnid=$resultsale->transaction->id;
             
                  $msg=$resultsale->message;
                
                 if ($resultsale->success==1) {
                          
                                    $transArray = array(
                                    'amount_debited'=>$deductprice,
                                    'user_id'=>$data['user_id'],
                                    'card_id'=>$card_id,
                                    'txn_id'=>$txnid,
                                    'type'=>'1',
                                    'date_created'=>date('Y-m-d H:i:s')
                                    );
                     $transResponse = $this->Users_model->insert_data('tbl_transactions',$transArray);
                      $insertdata = $this->Users_model->insert_data('tbl_booking',$data);
                      $bookingdata=array('booking_id'=>$insertdata,'status'=>0);
                     $inserthistorydata = $this->Users_model->insert_data('tbl_moveHistory',$bookingdata);


                        /*push code start*/
                          $pushData['message'] = "You have recieved a request for new task";
                          $pushData['action'] = "new move";
                          $pushData['iosType'] = 1;/*new move*/
                              $pushData['Utype'] = 1;/*for driver push*/
                          $pushData['booking_id'] = $insertdata;
                          $selectlogin=$this->Users_model->bookmove($data);

              
                              foreach ($selectlogin as  $loginUsers => $value) {
                                $pushData['token'] = $value->token_id;
                                if($loginUsers->device_id == 1){
                                 $this->Users_model->iosPush($pushData);
                                }else if($loginUsers->device_id == 0){
                                 $this->Users_model->androidPush($pushData);
                                }
                              }   
           
                if(empty($insertdata)){
                     $result = array(
                     "controller" => "User",
                     "action" => "retrymove",
                     "ResponseCode" => false,
                     "MessageWhatHappen" => "Something went wrong"
                     );
                }else{                    
                     $result = array(
                     "controller" => "User",
                     "action" => "retrymove",
                     "ResponseCode" => true,
                     "MessageWhatHappen" => "Booked successfully",
                     "response"=>$msg,
                     "Move_id"=>$insertdata
                     );
                }
               
            
              }
              else{


                  $result = array(
                        "controller" => "User",
                        "action" => "retrymove",
                        "ResponseCode" => false,
                        "MessageWhatHappen" => "txn failed",
                        "response"=>$msg,
                        "bookedPercentage" => $getbookingcharge
                      );
              }
                $this->set_response($result,REST_Controller::HTTP_OK);  
            }




            /*updation of images for booking*/
            public function updateItemimages_post(){
            		$move_id=$this->input->post('move_id');
                $description=$this->input->post('description');

      	        /*item images start*/
            if (isset($_FILES['item_image1'])) {          
         
            $image='item_image1';
            $upload_path='public/item_image';
            $imagename1 = $this->file_upload($upload_path,$image);
            $item1=$imagename1;
            }

          if (isset($_FILES['item_image2'])) {  

            $image='item_image2';
            $upload_path='public/item_image';
            $imagename2=$this->file_upload($upload_path,$image);
            // $imagename=$this->file_upload($upload_path,$image,$name);
            $item2=$imagename2;
          }


            if (isset($_FILES['item_image3'])) {  
            $image='item_image3';
            $upload_path='public/item_image';
            $imagename3=$this->file_upload($upload_path,$image);
            $item3=$imagename3;
          }


          if (isset($_FILES['item_image4'])) {      
            $image='item_image4';
            $upload_path='public/item_image';
            $imagename4=$this->file_upload($upload_path,$image);
            $item4=$imagename4;
          }
            /*item images end*/
      	  


      	        /*item images serilize start*/
      	        $seru=array($item1,$item2,$item3,$item4);
      	        $item_image=serialize($seru);
      	        /*item images serialize end*/

      	         $response = $this->Users_model->update_data('tbl_booking',array('item_image'=>$item_image,'description'=>$description),array('id'=>$move_id));


                   $acceptedbooking = $this->Users_model->select_data('item_image,description','tbl_booking',array('id'=>$move_id));
                      // $i=0;

                      $acceptedbooking12=array();
                      foreach ($acceptedbooking as $key => $value) {

                      $acceptedbooking12= unserialize($value->item_image); 
                       $acceptedbooking12=array_filter($acceptedbooking12);
                       $acceptedbooking12=array_values($acceptedbooking12);

                      if (!empty($acceptedbooking12)) {
                      $acceptedbooking[$key]->itemimages=$acceptedbooking12;
                      	
                      }
                      else{
                      	$acceptedbooking[$key]->itemimages=array();
                      }
                      }
                      // die();




                  if(!empty($acceptedbooking)){
                      $result = array(
                      "controller" => "User",
                      "action" => "updateItemimages",
                      "ResponseCode" => true,
                      "response"=>$acceptedbooking,
                      "MessageWhatHappen" =>"your data updated sucessfully",
           
                      );
                      }
                      else{
                      $result = array(
                      "controller" => "User",
                      "action" => "updateItemimages",
                      "ResponseCode" => false,
                      "MessageWhatHappen" =>"Something went wrong",
                      );
                      }

                    $this->set_response($result,REST_Controller::HTTP_OK); 

            }

            /* Chat module start */

          public function chat_post(){                        

            $message = array(
                'move_id'=> $this->input->post('move_id'),
                'from_id'=> $this->input->post('from_id'),
                'to_id'=> $this->input->post('to_id'),
                'message'=> $this->input->post('message'),
                );
            $fromdata = $this->Users_model->select_data('*','tbl_users',array('id'=>$message['from_id']));
            $todata = $this->Users_model->select_data('*','tbl_users',array('id'=>$message['to_id']));
            
            $message['fromUser_type'] = $fromdata[0]->user_Type;
            
            $message['toUser_type'] = $todata[0]->user_Type;


            $toLoginData =$this->Users_model->selectLogin($message['to_id']);

            $pushData['message'] = $message['message'];
            $pushData['action'] = "chat";
            $pushData['from_name'] = $fromdata[0]->fname.''.$fromdata[0]->lname;
            $pushData['profile_pic'] = $fromdata[0]->profile_pic;
            $pushData['booking_id'] = $message['move_id'];
            $pushData['is_quote'] = '';
            $pushData['value'] = '';
            $pushData['from_id'] = $message['from_id'];
            $pushData['spMessage'] = "You have recieved a message from ".$fromdata[0]->fname.''.$fromdata[0]->lname;
            $pushData['iosType'] = 7;/*for chat*/
            $pushData['Utype'] = ($todata[0]->user_Type == 2)?1:2;


            foreach ($toLoginData as $pushVal) {


                $pushData['token'] = $pushVal->token_id;
                if($pushVal->device_id == 1){
                    $this->Users_model->iosPush($pushData);
                }
                else if($loginUsers->device_id == 0){
                    $this->Users_model->androidPush($pushData);
                }
            }



            $data = $this->Users_model->insert_data('tbl_chat',$message);
            $chatdata = $this->Users_model->select_data('*','tbl_chat',array('id'=>$data));


            if(empty($data)){
                $result = array(
                    "controller" => "User",
                    "action" => "chat",
                    "ResponseCode" => false,
                    "MessageWhatHappen" => "Something went wrong"

                    );
            }else{
                $result = array(
                    "controller" => "User",
                    "action" => "chat",
                    "ResponseCode" => true,
                    "MessageWhatHappen" => "Message send successfully",
                    "response"=>$chatdata

                    );
            }
            $this->set_response($result, REST_Controller::HTTP_OK);
          }


          public function listChat_post(){                                          
            $message = array(
                'move_id'=> $this->input->post('move_id'),
                'from_id'=> $this->input->post('from_id'),
                'to_id'=> $this->input->post('to_id')
                );

            $data = $this->Users_model->customChat_list($message);

            if(empty($data))

            {
                $result = array(
                    "controller" => "User",
                    "action" => "listChat",
                    "ResponseCode" => false,
                    "MessageWhatHappen" => "no chat found"

                    );
            }else{
                $result = array(
                    "controller" => "User",
                    "action" => "listChat",
                    "ResponseCode" => true,
                    "response" => $data

                    );
            }
            $this->set_response($result, REST_Controller::HTTP_OK);
          }

          /* Chat module finish */

          /*for driver password change start*/
          public function changePassword_post(){

            $driver_id=$this->input->post('driver_id');
            $old_password=$this->input->post('old_password');
            $new_password=$this->input->post('new_password');
            $md5password=md5($old_password);
            $md5newpassword=md5($new_password);
            $checkOldpassword = $this->Users_model->select_data('*','tbl_users',array('id'=>$driver_id,'password'=>$md5password));
            if (!empty($checkOldpassword)) {
              $updatepassword = $this->Users_model->update_data('tbl_users',array('password'=>$md5newpassword),array('id'=>$driver_id));


              if (!empty($updatepassword)) {
                   $result = array(
                    "controller" => "User",
                    "action" => "changePassword",
                    "ResponseCode" => true,
                    "response" => "password changes sucessfully"
                    );
              }
              else{
                  $result = array(
                    "controller" => "User",
                    "action" => "changePassword",
                    "ResponseCode" => false,
                    "response" => "something went wrong"
                    );
              }
            }
            else{
                   $result = array(
                    "controller" => "User",
                    "action" => "changePassword",
                    "ResponseCode" => false,
                    "response" => "old password does not match"
                    );
            }
                $this->set_response($result, REST_Controller::HTTP_OK);

          }
          /*for driver password change end*/
          public function getPromo_post(){
            $user_id=$this->input->post('user_id');
            $type=$this->input->post("type");
            $date=date("Y-m-d");
            if ($type==1) {
            $promo =$this->db->query("SELECT tbl_promousersData.*,tbl_promocode.value,tbl_promocode.max_amount,tbl_promocode.user_max_usage,tbl_promocode.expiry_date,tbl_promocode.promo_code from tbl_promousersData RIGHT Join tbl_promocode on  tbl_promousersData.promo_id=tbl_promocode.id  where user_to_id='".$user_id."'  AND status ='0' AND type='1'")->result();
              $date=date("Y-m-d");
              foreach ($promo as $key => $value) {
                  $getdata=$this->db->query("SELECT * from tbl_promocode where id='".$value->promo_id."' AND expiry_date >='".$date."' ")->result();
                  if (!empty($getdata)) {
                    $promodata['promocodes'][]=$value;
                  }
              }
              $promodata['refercode'] =$this->db->query("SELECT * from tbl_promousersData where (user_to_id='".$user_id."'  AND status ='0' AND type='2') OR (user_refer_id='".$user_id."'  AND status ='2' AND type='2') ")->result();

              foreach ($promodata['refercode'] as $key => $value) {
                $promodata['refercode'][$key]->referdata=$this->db->query("SELECT referal_amount,  referal_percentage from tbl_setting ")->row();
               
                     $promodata['refercode'][$key]->referbyname=$this->db->query("SELECT fname,lname   from tbl_users where id='".$value->user_refer_id."' ")->row();
                  
                  
                     $promodata['refercode'][$key]->refertoname=$this->db->query("SELECT fname,lname   from tbl_users where id='".$value->user_to_id."' ")->row();
                  


                }
              }
              elseif ($type==2) {
             
              $promodata['available']=$this->db->query("SELECT * from tbl_promocode where  expiry_date>= '".$date."'")->result();
            }


              if (!empty($promodata['promocodes'] || $promodata['available'] || $promodata['refercode'])){

                     $result = array(
                    "controller" => "User",
                    "action" => "getPromo",
                    "ResponseCode" => true,
                    "message" => "your data shows sucessfully",
                    "response" => $promodata
                    );

              
            }
            elseif(empty($promodata['applied'] && $promodata['available'])){
                    $result = array(
                    "controller" => "User",
                    "action" => "getPromo",
                    "ResponseCode" => false,
                    "message" => "no data exist in table",
                    );

            }
            else{
               $result = array(
                    "controller" => "User",
                    "action" => "getPromo",
                    "ResponseCode" => false,
                    "message" => "something went wrong",
                    );

            }

                $this->set_response($result, REST_Controller::HTTP_OK);



          }


            public function cronPending_get(){
                   $pendingBooking = $this->Users_model->select_data('*','tbl_booking',array('is_accepted'=>0,'is_started'=>0,'is_completed'=>0,'is_cancelled'=>0,));
               
                   $DeclinedCase = $this->Users_model->select_data('*','tbl_declinedDriver');
                    $gettime= $this->db->query("select buffer_time from tbl_setting")->row();
                    $time=$gettime->buffer_time;
                    $data = array();
                    $mainRes = array();
                   foreach ($pendingBooking as  $value) {


                   		$getcity= $this->db->query("SELECT * from tbl_cities where id='".$value->city_id."'")->result();
      // print_r($getcity);
      $getvehicle= $this->db->query("SELECT * from tbl_vechicleType where id='".$value->vehicle_id."'")->result();  



            		$getdata= $this->db->query("SELECT a.id,a.email,b.token_id,b.device_id,'".$value->id."' as bookingid, ( 3959 * acos( cos( radians('".$value->pickup_latitude."') ) * cos( radians( latitude ) ) * cos( radians(longitude) - radians('".$value->pickup_longitude."') ) + sin( radians('".$value->pickup_latitude."') ) * sin( radians( latitude ) ) ) ) as distance FROM`tbl_users` AS a JOIN tbl_login AS b ON a.id = b.user_id WHERE a.user_Type = 2 and b.status=1  AND a.id IN(SELECT driver_id from tbl_driverDetail where located_at='".$getcity[0]->id."' AND vehicle_id='".$getvehicle[0]->id."') and a.id not in (select driver_id from tbl_declinedDriver where driver_id=a.id and move_id='".$value->id."')  AND a.id NOT IN ( SELECT driver_id  FROM `tbl_booking`  WHERE 'is_accepeted'=1 or 'is_started'=1 and 'is_completed'=0 and 'is_cancelled'=0  and CONCAT('".$value->booking_date."', ' ', '".$value->booking_time."') BETWEEN CONCAT(booking_date, ' ', booking_time) AND DATE_ADD(CONCAT(booking_date, ' ', booking_time) , INTERVAL ('".round($value->time_duration/60)."' + (('".$time."')*2)) MINUTE) OR DATE_ADD(CONCAT('".$value->booking_date."', ' ', '".$value->booking_time."'), INTERVAL('".round($value->time_duration/60)."' + (('".$time."')*2)) MINUTE) BETWEEN CONCAT(booking_date, ' ', booking_time) AND DATE_ADD(CONCAT(booking_date, ' ', booking_time) , INTERVAL ('".round($value->time_duration/60)."' + (('".$time."')*2)) MINUTE))")->result();
           


                      
                      $pushData['message'] = "You have recieved a request for new task";
                      $pushData['action'] = "new move";
                       $pushData['Utype'] = 1;
                            $pushData['booking_id'] = $value->id;
                       $pushData['iosType']=1;
                  foreach ($getdata as $key => $value1) {
                    if($value1->distance < 6000){
                                $data[]=$value1;
                       $pushData['token'] = $value1->token_id;
                      if($value1->device_id == 1){
                        $this->Users_model->iosPush($pushData);
                      }else if($value1->device_id == 0){
                        $this->Users_model->androidPush($pushData);
                      }

                    }
                  }
        
                

            }
            

            }
            public function cancelCron_get(){


               $pendingBooking = $this->Users_model->select_data('*','tbl_booking',array('is_accepted'=>0,'is_started'=>0,'is_completed'=>0,'is_cancelled'=>0,));
               print_r($pendingBooking);

               foreach ($pendingBooking as $key => $value) {
                 $time12=$value->date_created;
                 $book=$value->booking_date .' '.$value->booking_time;
                 $time=date('Y-m-d H:i:s');
                 $det= date('Y-m-d H:i:s', strtotime("$time12  +60 minutes"));

                 /*checking  booking date and time less then current datetime  and datecreated beyond one hours back*/

                 if ($det<=$time || $time > $book) {


                  $txndetail=$this->db->query("SELECT * FROM tbl_transactions where user_id='".$value->user_id."' AND move_id='".$value->id."' ORDER BY date_created DESC Limit 1")->result();
                  print_r($txndetail);


                          $result12 = Braintree_Transaction::submitForSettlement($txndetail[0]->txn_id);

                          $result = Braintree_Transaction::refund($txndetail[0]->txn_id);

                            $txnid=$result->transaction->id;
                            $amount=$result->transaction->amount; 
                            if ($result->success==1) {
                                                                                                       
                           $transArray = array(
                                    'amount_credited'=>$amount,
                                    'user_id'=>$value->user_id,
                                    'txn_id'=>$txnid,
                                    'card_id'=>'',
                                    'move_id'=>$value->id,
                                    'type'=>'2',
                                    'date_created'=>date('Y-m-d H:i:s')
                                    );
                    $transResponse = $this->Users_model->insert_data('tbl_transactions',$transArray);

                    $bookingdata = $this->Users_model->update_data('tbl_booking',array('is_cancelled'=>1),array('id'=>$value->id));
                    $updateMove_history = $this->Users_model->update_data('tbl_moveHistory',array('status'=>4,'cancelled_time'=>date('Y-m-d H:i:s'),'cancelled_by'=>0),array('booking_id'=>$value->id));


                          $cancelUsers = $this->Users_model->select_data('*','tbl_users',array('id'=>$value->user_id));
                          $cancelLogin = $this->Users_model->select_data('*','tbl_login',array('id'=>$value->user_id));
                   



                          $pushData['message'] = "Your move has been cancelled";
                          $pushData['action'] = "move cancelled";
                          $pushData['booking_id'] = $value->id;
                          $pushData['Utype'] = 2;
                          $pushData['iosType'] = 3;/*for cancel book*/


                          foreach ($cancelLogin as $key => $value1) {
                                 
                                    $data[]=$value1;
                                    $pushData['token'] = $value1->token_id;
                                  if($value1->device_id == 1){
                                   $this->Users_model->iosPush($pushData);
                                  }else if($value1->device_id == 0){
                                    $this->Users_model->androidPush($pushData);
                                  }

                                 
                          }



                 }
               }


               }

          
        

            }


            public function late_bookingCANCEL_get(){


             $this->db->select('*');
             $this->db->from('tbl_booking');
             $this->db->where('tbl_booking.is_accepted',1);
             $this->db->where('tbl_booking.is_started', 0);
             $this->db->where('tbl_booking.is_completed', 0);
             $this->db->where('tbl_booking.is_cancelled', 0);

              $data = $this->db->get()->result();
              print_r($data);
              $array=array();
              foreach ($data as $key => $value) {
                      $date=date("Y-m-d H:i:s");
                      print_r($date);
                      echo "1";
                      $estimatesecond=$value->time_duration;
                      $bookeddatetime=$value->booking_date.' '.$value->booking_time;
                       $det= date('Y-m-d H:i:s', strtotime("$bookeddatetime  +30 minutes"));
                       print_r($det);
                       echo "2";

                             if ($det < $date) {
                              echo "oiriut";

                                        $txndetail=$this->db->query("SELECT * FROM tbl_transactions where user_id='".$value->user_id."' AND move_id='".$value->id."' ORDER BY date_created DESC Limit 1")->result();
                                        print_r($txndetail);
                  
                    

                          $result12 = Braintree_Transaction::submitForSettlement($txndetail[0]->txn_id);

                          $result = Braintree_Transaction::refund($txndetail[0]->txn_id);

                            $txnid=$result->transaction->id;
                            $amount=$result->transaction->amount; 
                            if ($result->success==1) {
                                                                                                       
                           $transArray = array(
                                    'amount_credited'=>$amount,
                                    'user_id'=>$value->user_id,
                                    'txn_id'=>$txnid,
                                    'card_id'=>'',
                                    'move_id'=>$value->id,
                                    'type'=>'2',
                                    'date_created'=>date('Y-m-d H:i:s')
                                    );
                    $transResponse = $this->Users_model->insert_data('tbl_transactions',$transArray);

                    $bookingdata = $this->Users_model->update_data('tbl_booking',array('is_cancelled'=>1),array('id'=>$value->id));
                    $updateMove_history = $this->Users_model->update_data('tbl_moveHistory',array('status'=>4,'cancelled_time'=>date('Y-m-d H:i:s'),'cancelled_by'=>0),array('booking_id'=>$value->id));


                          $cancelUsers = $this->Users_model->select_data('*','tbl_users',array('id'=>$value->user_id));
                          $cancelLogin = $this->Users_model->select_data('*','tbl_login',array('id'=>$value->user_id));



                            $cancelDriver = $this->Users_model->select_data('*','tbl_users',array('id'=>$value->driver_id));
                          $cancelDriverlogin = $this->Users_model->select_data('*','tbl_login',array('id'=>$value->driver_id));
                   



                          $pushData['message'] = "Your move has been cancelled";
                          $pushData['action'] = "move cancelled";
                          $pushData['booking_id'] = $value->id;
                          $pushData['Utype'] = 2;
                          $pushData['iosType'] = 3;/*for cancel book*/


                          foreach ($cancelLogin as $key => $value1) {
                                 
                                    $data[]=$value1;
                                    $pushData['token'] = $value1->token_id;
                                  if($value1->device_id == 1){
                                   $this->Users_model->iosPush($pushData);
                                  }else if($value1->device_id == 0){
                                    $this->Users_model->androidPush($pushData);
                                  }

                                 
                          }




                          $pushData['message'] = "Your move has been cancelled by ";
                          $pushData['action'] = "move cancelled";
                          $pushData['booking_id'] = $value->id;
                          $pushData['Utype'] = 1;
                          $pushData['iosType'] = 3;/*for cancel book*/


                          foreach ($cancelDriverlogin as $key => $value1) {
                                 
                                    $data[]=$value1;
                                    $pushData['token'] = $value1->token_id;
                                  if($value1->device_id == 1){
                                   $this->Users_model->iosPush($pushData);
                                  }else if($value1->device_id == 0){
                                    $this->Users_model->androidPush($pushData);
                                  }

                                 
                          }





                 }
                             }
        }
      }


      public function delayed_get(){

         $this->db->select('*');
        $this->db->from('tbl_booking');
        $this->db->where('tbl_booking.is_accepted',1);
        $this->db->where('tbl_booking.is_started', 1);
        $this->db->where('tbl_booking.is_completed', 0);
        $this->db->where('tbl_booking.is_cancelled', 0);
        $data = $this->db->get()->result();
        $date=date("Y-m-d H:i:s");
        $array=array();
        foreach ($data as $key => $value) {
               $date=date("Y-m-d H:i:s");
                      $estimatesecond=$value->time_duration;
                      $bookeddatetime=$value->booking_date.' '.$value->booking_time;
                      $dateinsec=strtotime($bookeddatetime);
                      $newdate=$dateinsec+$estimatesecond;
                      $finnaldate= date('Y-m-d H:i:s',$newdate);
                      $det= date('Y-m-d H:i:s', strtotime("$finnaldate  +30 minutes"));

                             if ($det <= $date) {
                              $array=$data;
                              print_r($array);
                              $totalPrice=$array[0]->estimated_price;



                      /*  moveAction 3 work start*/
                    $getCardDetail=$this->db->query("SELECT * from tbl_cardDetail  where id='".$array[0]->card_id."'")->result();
                    foreach ($getCardDetail as $key => $value) {
                      $getCardDetail[$key]->cutomerid=$this->db->query("SELECT * from tbl_braintreeUsersDetail where user_id='".$array[0]->user_id."' and card_no='".$value->card_no."' ")->result();
                    }

                    print_r($getCardDetail);


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
                    $updatePromodata = $this->Users_model->update_data('tbl_promousersData',array('status'=>2),array('id'=>$array[0]->promoid));
                   }
                   else{
                       $updatePromodata = $this->Users_model->update_data('tbl_promousersData',array('status'=>3),array('id'=>$array[0]->promoid));
                   }

                  }

                  else{


                     $ReferDetails = $this->Users_model->select_data('referal_amount,referal_percentage','tbl_setting');
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
                    $updateReferdata = $this->Users_model->update_data('tbl_promousersData',array('status'=>2),array('id'=>$array[0]->promoid));
                  }
                  }
                  else{
                    $price=$totalPrice;
                  }


                  print_r($price);


                  
          
                  $cusId=$getCardDetail[0]->cutomerid[0]->customer_id;
                  print_r($cusId);

                            $trasactdata = Braintree_Transaction::sale([
                            'amount' => ($price),
                            'customerId' => $cusId
                          
                            ]);
                  $msg=$trasactdata->message;
                  print_r($msg);
                  $txnid=$trasactdata->transaction->id;
                  print_r($txnid);

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
                     $transResponse = $this->Users_model->insert_data('tbl_transactions',$transArray);
        

                    $bookingdata = $this->Users_model->update_data('tbl_booking',array('is_completed'=>1),array('id'=>$array[0]->id));
                    $moveData = array(
                    "driver_id"=>$array[0]->driver_id,
                    "status"=>3,
                    'completed_time'=>date('Y-m-d H:i:s')
                    );

                    $insertMove_history = $this->Users_model->update_data('tbl_moveHistory',$moveData,array("booking_id"=>$array[0]->id));
                    $bookinguserDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$array[0]->user_id));
                    $action = "Move completed";

                    $bookingdriverDetails = $this->Users_model->select_data('*','tbl_users',array('id'=>$array[0]->driver_id));
                    $bookingloginuserDetails = $this->Users_model->select_data('*','tbl_login',array('user_id'=>$array[0]->user_id,'status'=>1));
                    $get_percentage = $this->Users_model->select_data('*','tbl_setting');
                    $percentage = $get_percentage[0]->min_booking_charge;


                    /*update in driver fund table start*/
                    $getDriverBalance = $this->Users_model->select_data('*','tbl_driversFund',array('driver_id'=>$bookingdriverDetails[0]->id));

                    // $getDriverWallet = $this->Users_model->select_data('*','tbl_wallet',array('user_id'=>$bookingdriverDetails[0]->driver_id));


                     // print_r($getDriverBalance);die();


                     $getAdminpercent=$totalPrice*($array[0]->admin_percentage/100);
                     $Driverbalance=$totalPrice-$getAdminpercent;

                    $updatedriveramount=$getDriverBalance[0]->outstanding_amount+$Driverbalance;
                    $uptdriverDAta = $this->Users_model->update_data('tbl_driversFund',array('outstanding_amount'=>$updatedriveramount,'date_modified'=>date('Y-m-d H:i:s')),array('driver_id'=>$bookingdriverDetails[0]->id));

                    // $newDriverbalance=$getDriverWallet[0]->balence+$Driverbalance;
                    // $uptwalletdriverDAta = $this->Users_model->update_data('tbl_wallet',array('balence'=>$newDriverbalance,'date_modified'=>date('Y-m-d H:i:s')),array('user_id'=>$bookingdriverDetails[0]->id));




                    $transUserArray = array(
                    'amount_credited'=>$Driverbalance,
                    'user_id'=>$array[0]->user_id,
                    'move_id'=>$array[0]->id,
                    'txn_id'=>'on_wallet',
                    'type'=>'1',
                    'date_created'=>date('Y-m-d H:i:s')
                    );
                    $transResponse = $this->Users_model->insert_data('tbl_transactions',$transUserArray);
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
                    $this->Users_model->iosPush($pushData);
                    }else if($value->device_id == 0){
                    $this->Users_model->androidPush($pushData);
                    }
                    }
                    /*send push message end*/


                              /**/
                             }
                     
        }



      }







      }

          public function Test_post(){
            $id=$this->input->post('id');
      		$this->db->select('*');
      			$this->db->from('tbl_users');
      			$this->db->join('tbl_login', 'tbl_login.user_id = tbl_users.id');
      			$this->db->where('tbl_users.id', $id);
      			$this->db->where('tbl_login.status', 1);
      			$data = $this->db->get()->result();
      			print_r($data);

      				foreach ($data as $key => $value) {
      			print_r($value);
      			$pushData['msg']="your account has been suspended";
      			$pushData['token_id']=$value->token_id;	
      			$pushData['iosType']=13;/*account suspendationend*/	
      			
      			if ($value->device_id==0) {
      				$push=$this->Users_model->androidPush($pushData);
      				print_r($push);
      				
      			}
      			else{
      				if ($value->user_Type==1) {
      					$pushData['Utype']=1;
      					$push=$this->Users_model->iosPush($pushData);
      				}
      				else{
      					$pushData['Utype']=2;
      					$push=$this->Users_model->iosPush($pushData);
      				}

      			}
      		}
      }


                      public function activeStatus_post(){

                      
                      	$id=$this->input->post('user_id');
                      	$unique_deviceId=$this->input->post('unique_deviceId');
                      	$usertype=$this->input->post('user_type');


                      	$query  = $this->db->query('SELECT * from tbl_users where id = '.$id.'')->result();
                      	if ($query[0]->is_suspend==0) {


                    


                      	 $logindata = $this->Users_model->select_data('*','tbl_login',array('user_id'=>$id,'unique_deviceId'=>$unique_deviceId,'status'=>1));

                      	 if ($usertype==2) {
                      
                      	if (empty($logindata)) {
                      		$msg="you already logged in on another device";
                      		$code=false;

                      	}
                      	else{
                      		
                      		$msg="account active";
                      		$code=true;
                      	}
                      	 }
                      	 else{

                      	 	$msg="account active";
                      		$code=true;
                      	 }

                      	}
                      	else{
                      		$msg="account suspended";
                      		$code=false;
                      	}


                 


                      		  $result = array(
                                      "controller" => "User",
                                      "action" => "activeStatus",
                                      "ResponseCode" => $code,
                                      "response" => $msg
                                      );
                      	$this->set_response($result,REST_Controller::HTTP_OK);  
                      }
                    	public function FindDriver_post(){
                    	$query  = $this->db->query('select * from tbl_booking where id = '.$_POST['book_id'].' and is_accepted = 1')->result();
                        if(!empty($query)){
                    	    $result = array(
                                    "controller" => "User",
                                    "action" => "FindDriver",
                                    "ResponseCode" => true,
                                    "response" => $query

                                    );
                    	}else{
                    		    $result = array(
                                    "controller" => "User",
                                    "action" => "FindDriver",
                                    "ResponseCode" => false,
                                    "response" => 0
                                    );
                    	}

                    	$this->set_response($result,REST_Controller::HTTP_OK);  
                    }
                    public function feedback_post(){

                    	$userid=$this->input->post('user_id');
                    	$comment=$this->input->post('comment');
                    	$rating=$this->input->post('rating');
                      $bookingdata=array('user_id'=>$userid,'comment'=>$comment,'rating'=>$rating);
                      $feedback = $this->Users_model->select_data('*','tbl_feedback',array('user_id'=>$userid));
                      if (!empty($feedback)) {

                      $feedbackdata = $this->Users_model->insert_data('tbl_feedback',$bookingdata);
                      }
                      else{
                      $feedbackdata = $this->Users_model->update_data('tbl_feedback',array('comment'=>$comment,'rating'=>$rating),array('user_id'=>$userid));
                      }
                      if($feedbackdata){
                      $result = array(
                      "controller" => "User",
                      "action" => "feedback",
                      "ResponseCode" => true,
                      "response" => "your feedback submitted sucessfully"

                      );
                      }else{
                      $result = array(
                      "controller" => "User",
                      "action" => "feedback",
                      "ResponseCode" => false,
                      "response" => "something went wrong"
                      );
                      }
                 	$this->set_response($result,REST_Controller::HTTP_OK);  
              }
              public function array_get(){
                $Approve="aghdjh";
  /*            $merchantAccountParams = [
  'individual' => [
    'firstName' =>  "name",
    'lastName' => 'Doe',
    'email' => 'jane@14ladders.com',
    'phone' => '5553334444',
    'dateOfBirth' => '1981-11-19',
    'ssn' => '456-45-4567',
    'address' => [
      'streetAddress' => '111 Main St',
      'locality' => 'Chicago',
      'region' => 'IL',
      'postalCode' => '60622'
    ]
  ],
  'business' => [
    'legalName' => 'Jane\'s Ladders',
    'dbaName' => 'Jane\'s Ladders',
    'taxId' => '98-7654321',
    'address' => [
      'streetAddress' => '111 Main St',
      'locality' => 'Chicago',
      'region' => 'IL',
      'postalCode' => '60622'
    ]
  ],
  'funding' => [
    'descriptor' => 'Blue Ladders',
    'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
    'email' => 'funding@blueladders.com',
    'mobilePhone' => '5555555555',
    'accountNumber' => '1123581321',
    'routingNumber' => '071101307'
  ],
  'tosAccepted' => true,
  'masterMerchantAccountId' => "drivermerchanaccount",
  'id' => "2r365g"
];*/



$merchantAccountParams = [
  'individual' => [
    'firstName' => 'Jane',
    'lastName' => 'Doe',
    'email' => 'jane@14ladders.com',
    'phone' => '5553334444',
    'dateOfBirth' => '1981-11-19',
    'ssn' => '456-45-4567',
    'address' => [
      'streetAddress' => '111 Main St',
      'locality' => 'Chicago',
      'region' => 'IL',
      'postalCode' => '60622'
    ]
  ],
  'funding' => [
    'descriptor' => 'Blue Ladders',
    'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
    'email' => 'funding@blueladders.com',
    'mobilePhone' => '5555555555',
    'accountNumber' => '1123581321',
    'routingNumber' => '071101307'
  ],
  'tosAccepted' => true,
  'masterMerchantAccountId' => 'osvinwebsolution'
];
$result = Braintree_MerchantAccount::create($merchantAccountParams);



print_r($result);die();


              }













              /*new apis */


            public function getVehicleMove_get(){

              /*all move and vehice  data*/
              $data['movedata']=$this->Users_model->select_data('*','tbl_moveType');
              $data['vehicledata']=$this->Users_model->select_data('*','tbl_vechicleType');
              /*setting related data*/
              $data['settingdata']=$this->Users_model->select_data('flight_charges,loading_rate,unloading_rate,movers_charges','tbl_setting');

              if ($data){
                $result = array(
                "controller" => "User",
                "action" => "getmove",
                "ResponseCode" => true,
                "MessageWhatHappen" =>"your data shows sucessfully",
                "Response" => $data
                );
              }
              else {
                $result = array(
                "controller" => "User",
                "action" => "getmove",
                "ResponseCode" => true,
                "MessageWhatHappen" =>"No data exist in Table",
                );
              }
                $this->set_response($result,REST_Controller::HTTP_OK);  
            }


            





}