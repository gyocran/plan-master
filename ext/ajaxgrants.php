<?php
session_start();

if(!isset($_SESSION["PlanGhana"]["PROGRAM_AREA"])){
    echo "{\"result\":0,\"message\":\"no access\"}";
    exit();
}

include_once("const.php");
$cmd=get_data("cmd");
$userlevel=get_user_level();

switch($cmd)
{
    case 1:
        display_details();
        break;
	case 2:
        get_yearly_cost_for_grant();
        break;
	case 3:
        get_gender_stats();
        break;
	case 4:
        get_mother_status();
        break;
	case 5:
        get_father_status();
        break;
	case 6:
        get_all_data();
        break;
	case 7:
        get_grant_student_list();
        break;	
    default:
        echo "{\"result\":0,\"message\":\"unknown action\"}";
        break;
}

	function display_details(){
	// $id=get_data("student_id");
    // if(!$id){
		// echo "{\"result\":0,\"message\":\"unknown studnet id\"}";
		// return;
    // }

		include("donors.php");
		$s=new donors();
		$row=$s->get_grant_details();
		if(!$row){
			echo "{\"result\":0,\"message\":\"error while getting grant details {$s->error}\"}";
			return;
		}
		echo "{\"result\":1,\"grants\":[";
		$row=$s->fetch();
		while($row){
			$str=json($row);
			echo $str;
			$row=$s->fetch();
			if($row){
				echo ",";
			}
		}
		echo "]}";
	}
	
	function get_yearly_cost_for_grant(){
		$financial_year_id=get_data("financial_year_id");
		$grant_id=get_data("grant_id");
		include("donors.php");
		$s=new donors();
		$row=$s->get_yearly_cost_for_grant($financial_year_id,$grant_id);
		if(!$row){
			echo "{\"result\":0,\"message\":\"error while getting yearly cost {$s->error}\"}";
        return;
		}
		echo "{\"result\":1,\"cost\":" . $row["amount"] . "}";
	}
	
	function get_gender_stats(){
		// echo "entered";
		include("donors.php");
		$s=new donors();
		$row=$s->get_gender_statistics(5);
		if(!$row){
			echo "{\"result\":0,\"message\":\"error while getting gender statistics{$s->error}\"}";
        return;
		}
		echo "{\"result\":1,\"gender_stats\":[";
		$row=$s->fetch();
		while($row){
			$str=json($row);
			echo $str;
			$row=$s->fetch();
			if($row){
				echo ",";
			}
		}
		echo "]}";
	}
	
	function get_mother_status(){
		// echo "entered";
		include("donors.php");
		$s=new donors();
		$row=$s->get_mother_status();
		if(!$row){
			echo "{\"result\":0,\"message\":\"error while getting mother status{$s->error}\"}";
        return;
		}
		// print_r($row);
		echo "{\"result\":1,\"mother_status_count\":";
		// $row=$s->fetch();
		// echo($row);
		// while($row){
			$str=$row['mother_alive'];
			echo $str;
			// $row=$s->fetch();
			// if($row){
				// echo ",";
			// }
		// }
		echo "}";
	}
	
	function get_grant_student_list(){
		$id=get_data("grant_id");
		if(!$id){
			echo "{\"result\":0,\"message\":\"unknown grant id\"}";
			return;
		}
		include("donors.php");
		$s=new donors();
		$row=$s->get_grant_student_list($id);
		if(!$row){
			echo "{\"result\":0,\"message\":\"error while getting students {$s->error}\"}";
			return;
		}
		echo "{\"result\":1,\"students\":[";
		// $row=$s->fetch(); // make first record get left out
		while($row){
			$str=json($row);
			echo $str;
			$row=$s->fetch();
			if($row){
				echo ",";
			}
		}
		echo "]}";
	}
	// function get_mother_status(){
		// echo "entered";
		// include("donors.php");
		// $s=new donors();
		// $row=$s->get_mother_status();
	// }
?>