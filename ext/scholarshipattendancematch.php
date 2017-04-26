<?php
	include_once("adb.php");
	class scholarshipattendancematch extends adb{
		function scholarshipattendancematch(){
        adb::adb();
        $this->er_code_prefix=2400;     //error prefix for this class is 25
        $this->src="payments";
		}
		
		function get_sponsored_student_details($sponsored_student_id) {

			$str_query = "select sponsored_student.student_firstname as student_firstname, sponsored_student.student_middlename as student_middlename, sponsored_student.student_lastname as student_lastname, school_attendance.start_date as school_startdate, school_attendance.end_date as school_enddate, scholarship_package.start_date as scholarship_startdate, scholarship_package.end_date as scholarship_enddate, scholarship_package.sponsored_student_sponsored_student_id as student_id from scholarship_package inner join school_attendance on school_attendance.sponsored_student_sponsored_student_id = scholarship_package.sponsored_student_sponsored_student_id inner join sponsored_student on sponsored_student.sponsored_student_id = school_attendance.sponsored_student_sponsored_student_id where scholarship_package.sponsored_student_sponsored_student_id = $sponsored_student_id";

			if (!$this->sql_query($str_query)) {
				$this->error = $this->log_error(LOG_LEVEL_DB_FAIL, 14, "error while getting sponsored student details. see {$this->error} for detail");
            return false;
			}
			return $this->fetch();
		}
	}
?>