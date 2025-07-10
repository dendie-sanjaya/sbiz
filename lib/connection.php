<?php 
include dirname(__FILE__).'/../config/config.php';

$con = mysql_connect($config['db']['server'],$config['db']['username'],$config['db']['password']);
mysql_select_db($config['db']['database'],$con);
 
?>
