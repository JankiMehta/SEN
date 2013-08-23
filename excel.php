<?php
include 'connect.php' ;
session_start();
if (isset($_SESSION['id'])) {
	$id=$_SESSION['id'];
	include 'privileges.php';	
	$result=mysql_query($sql,$con);
} else {
	header('Location: login.php');
	}
 include 'change_pw.php';
 
 if($privilege == 'admin'){
 
if(isset($_GET['event_id'])){
$event_id = $_GET['event_id'];
$query = "SELECT s.student_id, s.f_name, s.l_name, p.prog_name, s.CPI, s.DOB FROM student as s, eventregister as e, program as p
			where s.student_id = e.student_id
			and s.prog_id = p.prog_id and e.event_id = '$event_id'";

$export = mysql_query ($query ) or die ( "Sql error : " . mysql_error( ) );

$fields = mysql_num_fields ( $export );
$header = "";
$data="";
//$line = '';
for ( $i = 0; $i < $fields; $i++ )
{
    $header .= mysql_field_name( $export , $i ) . "\t";
}
echo "StudentID"."\t"."First Name"."\t"."Last Name"."\t"."Program"."\t"."CPI"."\t"."DOB"."\n"."\n";
while( $row = mysql_fetch_row( $export ) )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=temp.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$data";
}
}else{
header('Location: index.php');
}
?>