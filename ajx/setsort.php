<?
setcookie("setsort",$_GET['sort'],0,"/");
setcookie("setdirection",$_GET['direction'],0,"/");
Header("Location: ".$_SERVER['HTTP_REFERER']);
?>