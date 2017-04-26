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
    default:
        echo "{\"result\":0,\"message\":\"unknown action\"}";
        break;
}

	function display_details(){
	$id=get_data("student_id");
    if(!$id){
		echo "{\"result\":0,\"message\":\"unknown studnet id\"}";
		return;
    }

    include("scholarshipattendancematch.php");
    $s=new scholarshipattendancematch();
    $row=$s->get_sponsored_student_details($id);
    if(!$row){
        echo "{\"result\":0,\"message\":\"error while getting student record {$s->error}\"}";
        return;
    }
    $str=json($row);

    echo "{\"result\":1,\"student\":";
    echo $str;
    

    // echo ",\"school_attendance\":[";
    // if($s->get_student_attendance($id)){
        // $row=$s->fetch();
        // while($row){
            // $str=json($row);
            // echo $str;
            // $row=$s->fetch();
            // if($row){
                // echo ",";
            // }
        // }

    
    // }
    // echo "]";
    // echo ",\"scholarship_payments\":[";
    // if($s->get_student_scholarhsip_payment($id)){
        // $row=$s->fetch();
        // while($row){
            // $str=json($row);
            // echo $str;
            // $row=$s->fetch();
            // if($row){
                // echo ",";
            // }
        // }


    // }
    // echo "]";
    echo "}";
	}
?>