<?php 
$server		= 'localhost';
$username	= 'root';
$password	= '';
$database	= 'job portal';
$con=mysql_connect($server, $username,  $password, $database);
if(!$con)
{
 	exit('Error: could not establish database connection');
}

if(!mysql_select_db($database,$con))
{
 	exit('Error: could not select the database');
}

?>