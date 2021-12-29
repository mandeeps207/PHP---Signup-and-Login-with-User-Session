<?php
$db_host="localhost"; //Database Host
$db_user="root";	//Database User
$db_password="";	//Database Password  
$db_name="filepond_users";	//Database Name

try
{
    // Connect to Database using PDO method
	$conn=new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOEXCEPTION $e)
{
    //Getting Error if any
	$e->getMessage();
}

?>