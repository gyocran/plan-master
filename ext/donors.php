<?php
	include_once("adb.php");
	class donors extends adb{
		function donors(){
        adb::adb();
        $this->er_code_prefix=2400;     //error prefix for this class is 25
        $this->src="payments";
		}
		
		function get_grants() {
			$str_query = "SELECT grant_package_id,name FROM `grant_package`";

			if (!$this->sql_query($str_query)) {
				$this->error = $this->log_error(LOG_LEVEL_DB_FAIL, 14, "error while getting sponsored student details. see {$this->error} for detail");
            return false;
			}
			return $this->fetch();
		}
		
		
		function get_grant_details_per_student($filter=false) {

			$str_query = "SELECT scholarship_package.sponsored_student_sponsored_student_id as student_id,`grant_package`.grant_package_id as grant_package_id, `grant_package`.name as grant_name, `grant_package`.code as grant_code, scholarship_package.annual_amount as grant_amount FROM `grant_package` inner join scholarship_package on `grant_package`.grant_package_id = scholarship_package.grant_package_grant_package_id";
			
			if($filter!=false){
				$str_query=$str_query . " where $filter";
			}

			if (!$this->sql_query($str_query)) {
				$this->error = $this->log_error(LOG_LEVEL_DB_FAIL, 14, "error while getting sponsored student details. see {$this->error} for detail");
            return false;
			}
			return $this->fetch();
		}
		
		function get_details_by_grant($grant_id=false){
			$filter=false;
			if($grant_id!=false){
				$filter=" `grant_package`.grant_package_id = $grant_package_id ";
			}
			return $this->get_grant_details($filter);
		}
		
		//may not need this function
		function get_total_amount_per_year(){
			$str_query = "SELECT grant_package_grant_package_id as grant_package_id,start_date as scholarship_year,sum(annual_amount) as total_amount FROM `scholarship_package` group BY `grant_package_grant_package_id` ASC";
			
			if (!$this->sql_query($str_query)) {
				$this->error = $this->log_error(LOG_LEVEL_DB_FAIL, 14, "error while getting sponsored student details. see {$this->error} for detail");
            return false;
			}
			return $this->fetch();
		}
		
		function get_gender_statistics($grant_package_id){
			$str_query="SELECT sa.student_gender as gender,count(sa.student_gender) as count FROM scholarship_package sp inner join sponsored_student ss on sp.sponsored_student_sponsored_student_id = ss.sponsored_student_id inner join student_applicant sa on ss.student_applicant_student_applicant_id = sa.student_applicant_id WHERE grant_package_grant_package_id = $grant_package_id group by sa.student_gender";
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting all grant packages. see error {$this->error} for details.");
            return false;
			}
			// echo $str_query;
        // return $this->fetch();
		return true;
        }
		
		function get_mother_status($grant_id){
			$str_query="SELECT count(app_mother_isalive) as mother_alive FROM `student_applicant` sa WHERE app_mother_isalive = 1 and app_grant_id=$grant_id";
			// echo $str_query;
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while mother status. see error {$this->error} for details.");
				return false;
			}
        return $this->fetch();
		}
	
		function get_father_status($grant_id){
			$str_query="SELECT count(app_father_isalive) as father_alive FROM `student_applicant` sa WHERE app_father_isalive = 1 and app_grant_id=$grant_id";
			// echo $str_query;
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while father status. see error {$this->error} for details.");
            return false;
			}
        return $this->fetch();
		}
		
		function get_sponsored_student_total($grant_id){
			$str_query="SELECT count(*) as total_students FROM `student_applicant` WHERE app_grant_id = $grant_id";
			// echo $str_query;
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting all sponsored students count. see error {$this->error} for details.");
            return false;
			}
        return $this->fetch();
		}
		
		function get_schools_in_towncity(){
			$str_query="SELECT towncity,count(*) as count FROM `schools` group by towncity";
			// echo $str_query;
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting schools count. see error {$this->error} for details.");
            return false;
			}
        return $this->fetch();
		}
		
		// function get_cost_for_financial_year($financial_year_id){
			// $str_query="SELECT sum(annual_amount) as amount FROM `scholarship_package` inner join `scholarship_payment` on `scholarship_payment`.scholarship_package_scholarship_package_id = `scholarship_package`.scholarship_package_id inner join `payment_request` on `payment_request`.payment_request_id = `scholarship_payment`.payment_request_payment_request_id inner join `financial_year` on `payment_request`.financial_year_financial_year_id = `financial_year`.financial_year_id where `financial_year`.financial_year_id = $financial_year_id";
			// if(!$this->sql_query($str_query)){
				// $this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting all grant packages. see error {$this->error} for details.");
            // return false;
			// }
			// echo $str_query;
        // return $this->fetch();
		// return $this->fetch();
        // }
		
		function get_yearly_cost_for_grant($financial_year_id,$grant_id){
			$str_query="SELECT ifnull(sum(`scholarship_payment`.amount),0) as amount FROM `scholarship_package` inner join `scholarship_payment` on `scholarship_payment`.scholarship_package_scholarship_package_id = `scholarship_package`.scholarship_package_id inner join `payment_request` on `payment_request`.payment_request_id = `scholarship_payment`.payment_request_payment_request_id inner join `financial_year` on `payment_request`.financial_year_financial_year_id = `financial_year`.financial_year_id where `financial_year`.financial_year_id = $financial_year_id and `scholarship_payment`.status = 'PAID' and `scholarship_package`.grant_package_grant_package_id =$grant_id";
			
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting cost for financial year. see error {$this->error} for details.");
            return false;
			}
		return $this->fetch();
        }
		
		// function get_grant_student_list_by_name($search_text=false){
			// $filter = "";
			// if($search_text){
				// $filter=" (`student_firstname` like '%$search_text%' or `student_lastname` like '%$search_text%')";
			// }
			// return $this->get_grant_student_list($filter,$page,$limit,$orderBy)
		// }
		
		function get_grant_student_list($grant_id,$filter=false){
			// if($filter!=false){
				// $filter = " and" . $filter;
			// }
			$str_query="SELECT `sponsored_student`.student_firstname, `sponsored_student`.student_middlename, `sponsored_student`.student_lastname, `scholarship_package`.end_date, `schools`.school_name,`scholarship_payment`.status FROM `scholarship_package` inner join `sponsored_student` on `scholarship_package`.sponsored_student_sponsored_student_id = `sponsored_student`.sponsored_student_id inner join `scholarship_payment` on `scholarship_payment`.scholarship_package_scholarship_package_id = `scholarship_package`.scholarship_package_id inner join `schools` on `schools`.`school_id` = `scholarship_payment`.schools_school_id where grant_package_grant_package_id = $grant_id";
			// echo $str_query;
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting all grant packages. see error {$this->error} for details.");
            return false;
			}
			// echo $str_query;
        // return $this->fetch();
		return $this->fetch();
        }
		
		function get_financial_year_list(){
			$str_query="SELECT financial_year_id,year_name FROM `financial_year` order by date_start desc";
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting list of financial years. see error {$this->error} for details.");
            return false;
			}
			// echo $str_query;
        // return $this->fetch();
		return $this->fetch();
        }
		
		function get_lifetime_cost_for_grant($grant_id){
			$str_query="SELECT ifnull(sum(amount),0) as lifetime_cost FROM `scholarship_payment` left join `scholarship_package` on `scholarship_payment`.scholarship_package_scholarship_package_id = `scholarship_package`.scholarship_package_id where `scholarship_payment`.status = 'paid' and `scholarship_package`.grant_package_grant_package_id = $grant_id";
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting grant lifetime cost. see error {$this->error} for details.");
            return false;
			}
			// echo $str_query;
        // return $this->fetch();
		return $this->fetch();
        }
		
		function get_total_amount_for_programarea($grant_id){
			$str_query="SELECT programarea_name,(SELECT ifnull(sum(spa.amount),0) as programarea_amount FROM `scholarship_payment` spa inner join `scholarship_package` spk on spa.scholarship_package_scholarship_package_id = spk.scholarship_package_id where spa.programarea_residentarea_id = programarea_id and spk.grant_package_grant_package_id = 5) as programarea_amount FROM `programarea`";
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting grant lifetime cost. see error {$this->error} for details.");
            return false;
			}
			// echo $str_query;
        // return $this->fetch();
		return $this->fetch();
        }
		
		function get_current_year_cost_for_grant($grant_id){
			$str_query="SELECT ifnull(sum(`scholarship_payment`.amount),0) as amount FROM `scholarship_package` inner join `scholarship_payment` on `scholarship_payment`.scholarship_package_scholarship_package_id = `scholarship_package`.scholarship_package_id inner join `payment_request` on `payment_request`.payment_request_id = `scholarship_payment`.payment_request_payment_request_id inner join `financial_year` on `payment_request`.financial_year_financial_year_id = `financial_year`.financial_year_id where `financial_year`.financial_year_id = (SELECT financial_year_id FROM `financial_year` ORDER BY date_start desc limit 1) and `scholarship_payment`.status = 'PAID' and `scholarship_package`.grant_package_grant_package_id = $grant_id";
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting grant lifetime cost. see error {$this->error} for details.");
            return false;
			}
		return $this->fetch();
        }
		
		function get_communities_under_grant($grant_id){
			$str_query="SELECT count(distinct `community`.community_id) as communities_under_grant FROM `sponsored_student` left join `community` on `sponsored_student`.community_community_id = `community`.community_id left join `scholarship_package` on `scholarship_package`.sponsored_student_sponsored_student_id = `sponsored_student`.sponsored_student_id where `scholarship_package`.grant_package_grant_package_id = $grant_id";
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting communities under grant. see error {$this->error} for details.");
            return false;
			}
			// echo $str_query;
        // return $this->fetch();
		return $this->fetch();
        }
		
		function get_all_communities(){
			$str_query="SELECT count(community_id) as all_communities FROM `community`";
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting all communities. see error {$this->error} for details.");
            return false;
			}
			// echo $str_query;
        // return $this->fetch();
		return $this->fetch();
        }
		
		function get_programs_of_sponsored_students($grantid){
			$str_query="SELECT program,count(program) as num_students FROM `school_attendance` inner join `scholarship_package` on `school_attendance`.sponsored_student_sponsored_student_id = `scholarship_package`.sponsored_student_sponsored_student_id where `scholarship_package`.grant_package_grant_package_id = $grantid group by program";
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting sponsored student programs. see error {$this->error} for details.");
            return false;
			}
			// echo $str_query;
        // return $this->fetch();
		return $this->fetch();
		}
		
		function get_grant_lifetime_cost_per_year($grantid){
			$str_query="SELECT year_name,ifnull((SELECT ifnull(`scholarship_payment`.amount,0) from `payment_request` inner join `scholarship_payment` on `scholarship_payment`.payment_request_payment_request_id = `payment_request`.payment_request_id inner join `scholarship_package` on `scholarship_payment`.scholarship_package_scholarship_package_id = `scholarship_package`.scholarship_package_id where `scholarship_package`.grant_package_grant_package_id = $grantid and `payment_request`.financial_year_financial_year_id = `financial_year`.financial_year_id),0) as total_amount_per_year FROM `financial_year`";
			if(!$this->sql_query($str_query)){
				$this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting total amount per year. see error {$this->error} for details.");
            return false;
			}
			// echo $str_query;
        // return $this->fetch();
		return $this->fetch();
		}
	}
?>