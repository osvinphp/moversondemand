<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Driver extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Driver_model');
		$this->load->helper('url');
		$this->load->library('session');


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
	public function index(){
		$value['data']= $this->Driver_model->get_value();
		$value['country']=	$this->db->query('SELECT distinct country_name  from tbl_cities')->result();
		// SELECT `id`, distinct(`location`) FROM `exchange`
		// print_r($value['country']);die;
		$value['vehicletype']=$this->db->get('tbl_vechicleType')->result();
		$value['code']=$this->db->get('tbl_countrycode')->result();
		$this->load->view('moversnew',$value);
	}
				/* list users detail per user id*/
	public function getspecific(){
		// print_r($_POST['country']);die();
		$user =$this->db->get_where('tbl_cities', array('country_name' => $_POST['country']))->result();
		// print_r($user);die;
		print_r(json_encode($user));
		// $this->template();
		// $this->load->view('usersDetail.php',$data);
	}

	public function signup(){

		// print_r($_POST);die;


		if (isset($_POST['submit'])) {
			$selectusers = $this->Driver_model->select_data('*','tbl_users',array('email'=>$_POST['email'],'phone'=>$_POST['phone']));
			if (empty($selectusers)) {



			if (empty($_POST['fname']|| $_POST['email'] ||  $_POST['phone'] || $_POST['license_no'] ||$_POST['vehicle_no']  )) {
				$this->session->set_flashdata('msg1', 'Please fill valid fields');
				redirect('Driver');
			}
			// print_r($_POST);die;


				$image='profile_pic';
				$upload_path='public/driverdetail';
				$imagename1 = $this->file_upload($upload_path,$image);
				$data['profile_pic']=$imagename1;


				$image='license_image_front';
				$upload_path='public/driverdetail';
				$imagename1 = $this->file_upload($upload_path,$image);
				$data['license_image_front']=$imagename1;


				$image='license_image_back';
				$upload_path='public/driverdetail';
				$imagename1 = $this->file_upload($upload_path,$image);
				$data['license_image_back']=$imagename1;


				$image='rc_image_front';
				$upload_path='public/driverdetail';
				$imagename1 = $this->file_upload($upload_path,$image);
				$data['rc_image_front']=$imagename1;



				$image='rc_image_back';
				$upload_path='public/driverdetail';
				$imagename1 = $this->file_upload($upload_path,$image);
				$data['rc_image_back']=$imagename1;



				$image='insurance_image_front';
				$upload_path='public/driverdetail';
				$imagename1 = $this->file_upload($upload_path,$image);
				$data['insurance_image_front']=$imagename1;



				$image='insurance_image_back';
				$upload_path='public/driverdetail';
				$imagename1 = $this->file_upload($upload_path,$image);
				$data['insurance_image_back']=$imagename1;



				$image='vehicle_image_front';
				$upload_path='public/driverdetail';
				$imagename1 = $this->file_upload($upload_path,$image);
				$data['vehicle_image_front']=$imagename1;


				$image='vehicle_image_back';
				$upload_path='public/driverdetail';
				$imagename1 = $this->file_upload($upload_path,$image);
				$data['vehicle_image_back']=$imagename1;






				$users = array(
					'fname'=>$_POST['fname'],
					'lname'=>$_POST['lname'],
					'email'=>$_POST['email'],
					'country_code'=>$_POST['country_code'],
					'phone'=>$_POST['phone'],
					'profile_pic'=>$data['profile_pic'],
					'user_Type'=>2,
					'manual_signUp'=>1,
					'date_created' =>date('Y-m-d H:i:s')
					);

				$insert_users= $this->Driver_model->insert_data('tbl_users',$users);
				$ctt=serialize($_POST['cityselect']);

				$driverDetail = array(
					'driver_id'=>$insert_users,
					'located_at'=>$ctt,
					'country_name'=>$_POST['pty_select'],
					'license_no'=>$_POST['license_no'],
					'vehicle_no'=>$_POST['vehicle_no'],
					'vehicle_id'=>$_POST['vehicle_id'],
					'license_image_front'=>$data['license_image_front'],
					'license_image_back'=>$data['license_image_back'],
					'rc_image_front'=>$data['rc_image_front'],
					'rc_image_back'=>$data['rc_image_back'],
					'insurance_image_front'=>$data['insurance_image_front'],
					'insurance_image_back'=>$data['insurance_image_back'],
					'vehicle_image_front'=>$data['vehicle_image_front'],
					'vehicle_image_back'=>$data['vehicle_image_back'],
					);
				$insert_driverDetail= $this->Driver_model->insert_data('tbl_driverDetail',$driverDetail);

				$bankDetail = array(
					'user_id'=>$insert_users,
					'bank_name'=>$_POST['bank_name'],
					'account_name'=>$_POST['account_name'],
					'account_number'=>$_POST['account_number'],
					'account_bsb'=>$_POST['account_bsb']
					);
				$insert_bankDetail= $this->Driver_model->insert_data('tbl_bankDetail',$bankDetail);


					$fundData = array(
					'driver_id'=>$insert_users,
					'outstanding_amount'=>'0',
					'paid_amount'=>'0',
					);
				$insert_Funddata= $this->Driver_model->insert_data('tbl_driversFund',$fundData);



				// $walletdata = array(
				// 	'user_id'=>$insert_users,
				// 	'balence'=>'0'

				// 	);
				// $walletdata12 = $this->Driver_model->insert_data('tbl_wallet',$walletdata);



				if ($insert_Funddata) {

					$this->session->set_flashdata('signup','Your detail has been sucessfully submitted.We  will sent a mail of confirmation  within 48 hours');
					redirect('Driver');
				}
				else{
					$this->session->set_flashdata('no','Something went wrong');
					redirect('Driver');
				}
			}
			else{
				$this->session->set_flashdata('already','Email already registered !');
				redirect('Driver');
			}


		}
	}

	public function templete(){
		$this->load->view('Template/header');
		// $this->load->view('Template/footer');
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
}
