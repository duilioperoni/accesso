<?php
/**************************************************************
SIM UPDate STATus
Update status of a thing simulation API
requires following GET parameters
"thing": id code of the thing ( "B001", "B002", ect) according with "thing" table in database
"status": value of the thing status 0=available, 1=engaged 2=reserved, 3=maintenance
Rules:
From Teacher App: request status 2 only if status=0
From Maint App:   request status 0 or 3 no codintion
From Broker console: also status 1 allowed
From Devices: status 0 or 1 indirectly set via setudpsens
Returns the global status of the updated thing as a string in JSON format:
{"response":"ok | ok","data":{"id":"id_code","description":"descr_id","type:"M|W|H|A","status":"0|1|2|3","sensore:"0|1","timestamp":"##########"} | "fail_desc" }
***************************************************************/
//extract GET parameters
$thing = $_REQUEST['thing'];
$rqstatus = $_REQUEST['status'];
//connect to database
//local SDK
$mysqli = new mysqli('localhost','accessouser','qwerty','accesso');
//remote SDK: replace  hostname or IP, username, password, dbname with appropriate values
//$mysqli = new mysqli('hostname or IP','username','password','dbname');
//get current status
$result = $mysqli -> query("SELECT status,sensor FROM thing WHERE id='$thing'");
$row = $result -> fetch_assoc();
$curstatus=$row['status'];
$cursensor=$row['sensor'];
if(($rqstatus==2)&&!(curstatus==0)){	//refuse not valid teacher reserve
	$rqstatus=$curstatus;	
}
if(($rqstatus==0)&&($curstatus==3)){ //exit from maintenance
	if($cursensor==0) $rqstatus=0;	 //goto vacant
	else              $rqstatus=1;	 //goto engaged
}
//update status value in related database record
$result = $mysqli -> query("UPDATE thing SET status=$rqstatus,timestamp=UNIX_TIMESTAMP() WHERE id='$thing'");
//extract current thing global status as an associative array
$result = $mysqli -> query("SELECT * FROM thing WHERE id='$thing'");
$row = $result -> fetch_assoc();
//transform result in JSON format
$response['response']='ok';
$response['data']['id']=$row['id'];
$response['data']['description']=$row['description'];
$response['data']['type']=$row['type'];
$response['data']['status']=$row['status'];
$response['data']['sensor']=$row['sensor'];
$response['data']['timestamp']=$row['timestamp'];
//send response to client in JSON format
header('Content-type: application/json');
echo json_encode($response);
?>
