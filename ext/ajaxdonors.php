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
    echo "{\"result\":1,\"communites\":[";
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
?>