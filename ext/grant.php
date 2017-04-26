<?php
/* 

 */
include_once("adb.php");
include_once("grants.php"); //contains duplicate get_grants. Included to avoid deletion that could break code
class grants extends adb{
    function grants(){
        adb::adb();
        $this->er_code_prefix=2300;     //error prefix for this class is 23
        $this->src="grants";
    }

    function add(){

    }

    function delete(){

    }

    function update(){

    }

    function get_grants(){
        $str_query="SELECT `grant_package_id`,`name`, `code`, `annual_amount` FROM grant_package WHERE grant_package_id!=0";
        if(!$this->sql_query($str_query)){
            $this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting all grant packages. see error {$this->error} for details.");
            return false;
        }
        return true;
    }

    function get_grant($grant_package_id){
        $str_query="SELECT `grant_package_id`,`name`, `code`, `annual_amount` FROM grant_package WHERE grant_package_id=$grant_package_id";
        if(!$this->sql_query($str_query)){
            $this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting all grant packages. see error {$this->error} for details.");
            return false;
        }
        return $this->fetch();
        
    }
	
	function get_gender_statistics($grant_package_id){
        $str_query="SELECT sa.student_gender,count(sa.student_gender) as gender_stats FROM scholarship_package sp inner join sponsored_student ss on sp.sponsored_student_sponsored_student_id = ss.sponsored_student_id inner join student_applicant sa on ss.student_applicant_student_applicant_id = sa.student_applicant_id WHERE grant_package_grant_package_id = 4 group by sa.student_gender";
        if(!$this->sql_query($str_query)){
            $this->error=$this->log_error(LOG_LEVEL_DB_FAIL,11,"error while getting all grant packages. see error {$this->error} for details.");
            return false;
        }
        return $this->fetch();
        
    }
	

    function get_grant_summary(){

    }


}
?>
