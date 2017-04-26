<?php
require ('./smartyHeader.php');

$msg = 'Hi. This here is Smarty!';
$title = 'Hi there.';

$smarty->assign('title',$title);
$smarty->assign('message',$msg);
$smarty->assign("FirstName", array("John", "Mary", "James", "Henry"));

$smarty->display('index.tpl');
?>