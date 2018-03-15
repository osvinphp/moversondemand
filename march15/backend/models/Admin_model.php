<?php
class Admin_model extends CI_Model {

	function login($email, $password) {
		$this->db->select('*');
		$this->db->from('tbl_admin');
		$this->db->where('email', $email);
		$this->db->where('password', md5($password));
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function user_list(){
		$data = $this->db->get_where('tbl_users', array('user_Type' => 1))->result();
		return $data;
	}
	public function driver_list(){
		$data = $this->db->query("SELECT tbl_users.*,tbl_driverDetail.located_at, tbl_driverDetail.vehicle_id,tbl_vechicleType.name,tbl_vechicleType.icon from tbl_users join tbl_driverDetail on tbl_driverDetail.driver_id=tbl_users.id join tbl_vechicleType on tbl_vechicleType.id=tbl_driverDetail.vehicle_id  where tbl_users.user_Type='2' ")->result();

		return $data;
	}

	public function pending_booking_list(){

		$this->db->select('*,tbl_booking.id as booked_id,tbl_vechicleType.name as vehiclename');
		$this->db->from('tbl_booking');
		$this->db->join('tbl_vechicleType', 'tbl_vechicleType.id = tbl_booking.vehicle_id');
		$this->db->join('tbl_movepricing', 'tbl_movepricing.move_id = tbl_booking.id');
		$this->db->join('tbl_users', 'tbl_users.id = tbl_booking.user_id');
		$this->db->join('tbl_moveType', 'tbl_moveType.id = tbl_booking.moveType_id');
		$this->db->where('tbl_booking.is_accepted',0);
		$this->db->where('tbl_booking.is_started', 0);
		$this->db->where('tbl_booking.is_completed', 0);
		$this->db->where('tbl_booking.is_cancelled', 0);
		$this->db->order_by("tbl_booking.date_created", "desc");
		$data = $this->db->get()->result();
				return $data;
	}
	public function started_booking_list(){

		$this->db->select('*,tbl_booking.id as booked_id,tbl_moveHistory.*,tbl_vechicleType.name as vehiclename');
		$this->db->from('tbl_booking');
		$this->db->join('tbl_vechicleType', 'tbl_vechicleType.id = tbl_booking.vehicle_id');
		$this->db->join('tbl_movepricing', 'tbl_movepricing.move_id = tbl_booking.id');
		$this->db->join('tbl_users', 'tbl_users.id = tbl_booking.user_id');
		$this->db->join('tbl_moveHistory', 'tbl_moveHistory.booking_id = tbl_booking.id');
		$this->db->join('tbl_moveType', 'tbl_moveType.id = tbl_booking.moveType_id');
		$this->db->where('tbl_booking.is_accepted',1);
		$this->db->where('tbl_booking.is_completed', 0);
		$this->db->where('tbl_booking.is_cancelled', 0);

		$this->db->order_by("started_time", "desc");
		$data = $this->db->get()->result();
		return $data;
	}
	public function completed_booking_list(){

		$this->db->select('*,tbl_booking.id as booked_id,tbl_vechicleType.name as vehiclename');
		$this->db->from('tbl_booking');
		$this->db->join('tbl_vechicleType', 'tbl_vechicleType.id = tbl_booking.vehicle_id');
			$this->db->join('tbl_moveHistory', 'tbl_moveHistory.booking_id = tbl_booking.id');
			$this->db->join('tbl_movepricing', 'tbl_movepricing.move_id = tbl_booking.id');
		$this->db->join('tbl_users', 'tbl_users.id = tbl_booking.user_id');
		$this->db->join('tbl_moveType', 'tbl_moveType.id = tbl_booking.moveType_id');
		$this->db->where('tbl_booking.is_accepted',1);
		$this->db->where('tbl_booking.is_started', 1);
		$this->db->where('tbl_booking.is_completed', 1);
		$this->db->where('tbl_booking.is_cancelled', 0);
		$this->db->order_by("completed_time", "desc");
		$data = $this->db->get()->result();
		return $data;
	}
	public function cancelled_booking_list(){

		$this->db->select('*,tbl_booking.id as booked_id,tbl_vechicleType.name as vehiclename,tbl_moveHistory.*');
		$this->db->from('tbl_booking');
		$this->db->join('tbl_vechicleType', 'tbl_vechicleType.id = tbl_booking.vehicle_id');
		$this->db->join('tbl_movepricing', 'tbl_movepricing.move_id = tbl_booking.id');
		$this->db->join('tbl_moveHistory', 'tbl_moveHistory.booking_id = tbl_booking.id');
		$this->db->join('tbl_users', 'tbl_users.id = tbl_booking.user_id');
		$this->db->join('tbl_moveType', 'tbl_moveType.id = tbl_booking.moveType_id');
		$this->db->where('tbl_booking.is_cancelled', 1);
		$this->db->order_by("cancelled_time", "desc");
		$data = $this->db->get()->result();

		return $data;
	}
	public function booking_detail($id){
		$this->db->select('*, tbl_booking.id,tbl_vechicleType.icon as vehicleimage,tbl_transactions.*,tbl_transactions.date_created as asd');
		$this->db->from('tbl_booking');
		$this->db->where('tbl_booking.id',$id);
		$this->db->join('tbl_vechicleType', 'tbl_vechicleType.id = tbl_booking.vehicle_id');
		$this->db->join('tbl_movepricing', 'tbl_movepricing.move_id = tbl_booking.id');
		$this->db->join('tbl_users', 'tbl_users.id = tbl_booking.user_id');
		$this->db->join('tbl_moveType', 'tbl_moveType.id = tbl_booking.moveType_id');
		$this->db->join('tbl_transactions', 'tbl_transactions.move_id = tbl_booking.id','left');
		// $this->db->where('tbl_transactions.type', 3);
		$data = $this->db->get()->result();
		return $data;
	}

	public function users_detail($id){
		$query = $this->db->get_where('tbl_users', array('id' => $id))->result();
		return $query;
	}


	public function driverdetail($id){
		$this->db->select('* ');
		$this->db->from('tbl_users');
		$this->db->where('tbl_users.id',$id);
		$this->db->join('tbl_driverDetail', 'tbl_driverDetail.driver_id = tbl_users.id');
		$this->db->join('tbl_vechicleType', 'tbl_vechicleType.id = tbl_driverDetail.vehicle_id');
		$data = $this->db->get()->result();
		return $data;
	}

	public function move_list(){
		$data=$this->db->get('tbl_moveType')->result();
		return $data;
	}
	public function vechicle_list(){
		$data= $this->db->query("SELECT * from tbl_vechicleType order by sequence asc ")->result();
		return $data;
	}

	public function dailytransaction(){
		$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id  WHERE DATE(tbl_transactions.date_created) = CURRENT_DATE and tbl_transactions.type!=2")->result();
		return $data;
	}

	public function weektransaction(){
		$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id  WHERE tbl_transactions.date_created > DATE_SUB(NOW(), INTERVAL 7 DAY) and tbl_transactions.type!=2")->result();
		return $data;
	}

		public function monthtransaction(){
		$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id  WHERE tbl_transactions.date_created > DATE_SUB(NOW(), INTERVAL 30 DAY) and tbl_transactions.type!=2")->result();

		return $data;
	}
			public function alltransaction(){
		$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id and tbl_transactions.type!=2")->result();

		return $data;
	}
	public function dailyrefund(){
		$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id  WHERE type='2' and  DATE(tbl_transactions.date_created) = CURRENT_DATE ")->result();
		return $data;
	}

	public function weekrefund(){
			$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id  WHERE  type='2' and tbl_transactions.date_created > DATE_SUB(NOW(), INTERVAL 7 DAY)")->result();
			return $data;
	}
	public function monthrefund(){
			$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id  WHERE  type='2' and tbl_transactions.date_created > DATE_SUB(NOW(), INTERVAL 7 DAY)")->result();
			return $data;
	}
	public function allrefund(){
			$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id  WHERE  type='2' ")->result();
			return $data;
	}

	public function dailytrips(){
			$data=$this->db->query("SELECT tbl_booking.*,tbl_movepricing.estimate_price  from tbl_booking join tbl_movepricing on tbl_movepricing.move_id=tbl_booking.id where DATE(tbl_booking.date_created) = CURRENT_DATE")->result();
			return $data;
	}
	public function weektrips(){
			$data=$this->db->query("SELECT tbl_booking.*,tbl_movepricing.estimate_price  from tbl_booking join tbl_movepricing on tbl_movepricing.move_id=tbl_booking.id where tbl_booking.date_created > DATE_SUB(NOW(), INTERVAL 7 DAY)")->result();
			return $data;
	}
	public function monthtrips(){
			$data=$this->db->query("SELECT tbl_booking.*,tbl_movepricing.estimate_price  from tbl_booking join tbl_movepricing on tbl_movepricing.move_id=tbl_booking.id where tbl_booking.date_created > DATE_SUB(NOW(), INTERVAL 30 DAY)")->result();
			return $data;
	}
	public function alltrips(){
			$data=$this->db->query("SELECT tbl_booking.*,tbl_movepricing.estimate_price  from tbl_booking join tbl_movepricing on tbl_movepricing.move_id=tbl_booking.id ")->result();
			return $data;
	}
	public function dailydrivertransaction(){
		$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id  WHERE tbl_users.user_type=2 and DATE(tbl_transactions.date_created) = CURRENT_DATE")->result();
		return $data;
	}

	public function weekdrivertransaction(){
		$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id  WHERE tbl_users.user_type=2 and DATE(tbl_transactions.date_created) > DATE_SUB(NOW(), INTERVAL 7 DAY)")->result();
		return $data;
	}

		public function monthdrivertransaction(){
		$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id  WHERE tbl_users.user_type=2 and DATE(tbl_transactions.date_created) > DATE_SUB(NOW(), INTERVAL 30 DAY)")->result();

		return $data;
	}
			public function alldrivertransaction(){
		$data=$this->db->query("SELECT tbl_transactions.*,tbl_users.*,tbl_transactions.id as deleteid,tbl_transactions.date_created as txndate FROM tbl_transactions join tbl_users on tbl_users.id=tbl_transactions.user_id where tbl_users.user_type=2  ")->result();

		return $data;
	}





	public function wallet_customerlist(){
		$this->db->select('*');
		$this->db->from('tbl_wallet');
		$this->db->join('tbl_users', 'tbl_users.id = tbl_wallet.user_id');
		$this->db->where('user_Type',1);
		$data = $this->db->get()->result();
		return $data;
	}
	public function wallet_driverlist(){
		$this->db->select('*');
		$this->db->from('tbl_driversFund');
		$this->db->join('tbl_users','tbl_driversFund.driver_id=tbl_users.id');
		$this->db->where('tbl_users.user_Type',2);
		$data = $this->db->get()->result();



		return $data;
	}
	// wallet_list
	public function promocode_list(){
		$data=$this->db->get('tbl_promocode')->result();
		return $data;
	}
	public function setting_list(){
		$data=$this->db->get('tbl_setting')->result();
		// print_r($data);
		return $data;
	}
	public function city_list(){
		$data=$this->db->get('tbl_cities')->result();
		// print_r($data);
		return $data;
	}
	public function delete($id,$table){
		$this->db->where('id', $id);
		$data= $this->db->delete($table);
		return $data;
	}

	public function countdata(){
		$data=$this->db->get('tbl_users')->result();
		return $data;
	}
	public function usercommercial($id){
		$this->db->set('is_commercial', '1');
		$this->db->where('id', $id);
		$data=$this->db->update('tbl_users');
		return $data;
	}
	public function usernormal($id){
		$this->db->set('is_commercial', '0');
		$this->db->where('id', $id);
		$data=$this->db->update('tbl_users');
		return $data;
	}
	public function update_data($tbl_name,$data,$where){                                 /* Update data */

		$this->db->where($where);
		$this->db->update($tbl_name,$data);
		return($this->db->affected_rows())?1:0;
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

	public function freeServiceProviders($serviceTime,$pricingData)
	{


		$gettime= $this->db->query("select buffer_time from tbl_setting")->row();
		$time=$gettime->buffer_time;
		$getcity= $this->db->query("SELECT * from tbl_cities where id='".$serviceTime[0]->pickupcity_id."'")->result();
		$getvehicle= $this->db->query("SELECT * from tbl_vechicleType where id='".$serviceTime[0]->vehicle_id."'")->result();

		$data= $this->db->query("SELECT a.id,a.email,b.token_id,b.device_id,c.located_at FROM`tbl_users` AS a JOIN tbl_login AS b ON (a.id = b.user_id)  JOIN tbl_driverDetail AS c ON (a.id = c.driver_id)     WHERE a.user_Type = 2   and b.status=1 AND a.id IN(SELECT driver_id from tbl_driverDetail where  vehicle_id='".$getvehicle[0]->id."' AND status=1) and a.id not in (select driver_id from tbl_declinedDriver where driver_id=a.id and move_id='".$serviceTime[0]->id."')  AND a.id NOT IN ( SELECT driver_id  FROM `tbl_booking` WHERE 'is_accepeted'=1 or 'is_started'=1 and 'is_completed'=0 and 'is_cancelled'=0  and   CONCAT('".$serviceTime[0]->booking_date."', ' ', '".$serviceTime[0]->slot_starttime."') BETWEEN CONCAT(booking_date, ' ', slot_starttime) AND DATE_ADD(CONCAT(booking_date, ' ', slot_starttime) , INTERVAL ('".$pricingData[0]->time."' + (('".$time."')*2)) MINUTE) OR DATE_ADD(CONCAT('".$serviceTime[0]->booking_date."', ' ', '".$serviceTime[0]->slot_starttime."'), INTERVAL('".$pricingData[0]->time."' + (('".$time."')*2)) MINUTE) BETWEEN CONCAT(booking_date, ' ', slot_starttime) AND DATE_ADD(CONCAT(booking_date, ' ', slot_starttime) , INTERVAL ('".$pricingData[0]->time."' + (('".$time."')*2)) MINUTE))")->result();

			$add=array();
		foreach ($data as $key1 => $value1) {
		$abc=unserialize($value1->located_at);
		foreach ($abc as $key2 => $value2) {

			if ($value2==$serviceTime[0]->pickupcity_id  ) {
				$add[]=$value1;
			}
		}

		}

					$add12=array();
		foreach ($add as $key1 => $value1) {
		$abc=unserialize($value1->located_at);
		foreach ($abc as $key2 => $value3) {

			if ( $value3==$serviceTime[0]->destinationcity_id ) {
				$add12[]=$value1;
			}
		}

		}
		return $add12;

	}
	public function booking(){
		$this->db->select('*');
		$this->db->from('tbl_booking');
		$this->db->where('slot_starttime');

		$data = $this->db->get()->result();
		return $data;
	}
	public function onpending_booking_list(){
		$this->db->select('*,tbl_booking.id as booked_id,tbl_vechicleType.name as vehiclename');
		$this->db->from('tbl_booking');
		$this->db->join('tbl_vechicleType', 'tbl_vechicleType.id = tbl_booking.vehicle_id');
			$this->db->join('tbl_movepricing', 'tbl_movepricing.move_id = tbl_booking.id');

		$this->db->join('tbl_users', 'tbl_users.id = tbl_booking.user_id');
		$this->db->join('tbl_moveType', 'tbl_moveType.id = tbl_booking.moveType_id');
		$this->db->where('tbl_booking.is_accepted',0);
		$this->db->where('tbl_booking.is_started', 0);
		$this->db->where('tbl_booking.is_completed', 0);
		$this->db->where('tbl_booking.is_cancelled', 0);


		$data = $this->db->get()->result();

		return $data;
	}
	public function late_booking_list(){
		$this->db->select('*,tbl_booking.id as booked_id,tbl_vechicleType.name as vehiclename,tbl_booking.driver_id as ddriver');
		$this->db->from('tbl_booking');
		$this->db->join('tbl_vechicleType', 'tbl_vechicleType.id = tbl_booking.vehicle_id');
			$this->db->join('tbl_movepricing', 'tbl_movepricing.move_id = tbl_booking.id');
		$this->db->join('tbl_users', 'tbl_users.id = tbl_booking.user_id');
		$this->db->join('tbl_moveType', 'tbl_moveType.id = tbl_booking.moveType_id');
		$this->db->where('tbl_booking.is_accepted',1);
		$this->db->where('tbl_booking.is_started', 0);
		$this->db->where('tbl_booking.is_completed', 0);
		$this->db->where('tbl_booking.is_cancelled', 0);

		$data = $this->db->get()->result();
		$array=array();
		foreach ($data as $key => $value) {
			     $date=date("Y-m-d H:i:s");
                  $estimatesecond=$value->time_duration;
                  $bookeddatetime=$value->booking_date.' '.$value->slot_starttime;

                         	$data[$key]->userno=$this->db->query("SELECT phone as userno , email as useremail from tbl_users where id='".$value->user_id."'")->result();
                         	$data[$key]->driverno=$this->db->query("SELECT phone as driverno , email as driveremail from tbl_users where id='".$value->ddriver."'")->result();

                         if ($bookeddatetime < $date) {

                         	$array=$data;
                         }
		}
		return $array;

	}

	public function delayed_booking_list(){

		$this->db->select('*,tbl_booking.id as booked_id,tbl_vechicleType.name as vehiclename,tbl_booking.driver_id as ddriver');
		$this->db->from('tbl_booking');
		$this->db->join('tbl_vechicleType', 'tbl_vechicleType.id = tbl_booking.vehicle_id');
			$this->db->join('tbl_movepricing', 'tbl_movepricing.move_id = tbl_booking.id');
		$this->db->join('tbl_users', 'tbl_users.id = tbl_booking.user_id');
		$this->db->join('tbl_moveType', 'tbl_moveType.id = tbl_booking.moveType_id');
		$this->db->where('tbl_booking.is_accepted',1);
		$this->db->where('tbl_booking.is_started', 1);
		$this->db->where('tbl_booking.is_completed', 0);
		$this->db->where('tbl_booking.is_cancelled', 0);

		$data = $this->db->get()->result();
		// print_r($data);die();
		$date=date("Y-m-d H:i:s");
		// print_r($date);die();
		$array=array();
		foreach ($data as $key => $value) {
			     $date=date("Y-m-d H:i:s");
                  $estimatesecond=$value->time_duration;
                  $bookeddatetime=$value->booking_date.' '.$value->slot_starttime;
                  $dateinsec=strtotime($bookeddatetime);
                  $newdate=$dateinsec+$estimatesecond;
                  $finnaldate= date('Y-m-d H:i:s',$newdate);


                      	$data[$key]->userno=$this->db->query("SELECT phone as userno , email as useremail from tbl_users where id='".$value->user_id."'")->result();
                         	$data[$key]->driverno=$this->db->query("SELECT phone as driverno , email as driveremail from tbl_users where id='".$value->ddriver."'")->result();

                         if ($finnaldate <= $date) {
                         	$array=$data;
                         }

		}

		return $array;

	}
		public function insert_data($tbl_name,$data)                                         /* Data insert */
	    {
	      	$this->db->insert($tbl_name, $data);
	       	$insert_id = $this->db->insert_id();
	        return $insert_id;

	    }


}
