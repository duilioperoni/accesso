<?php
/**************************************************************
SIM UPDate SENSor
Update sensor of a thing simulation API
requires following GET parameters
"thing": id code of the thing ( "B001", "B002", ect) according with "thing" table in database
"sensor": value of the thing sensor 0=available, 1=engaged
Rules:
From Devices: sensor=0 update status to vacant (0) if current status is engaged (1)
			  sensor=1 update status to engaged (1) if current status is vacant (0) or reserved (2), no action if maintenance (3)
Returns the global status of the updated thing as a string in JSON format:
{"response":"ok | ok","data":{"id":"id_code","description":"descr_id","type:"M|W|H|A","status":"0|1|2|3","sensore:"0|1","timestamp":"##########"} | "fail_desc" }
***************************************************************/
//extract GET parameters
$thing = $_REQUEST['thing'];
$rqsensor = $_REQUEST['sensor'];
//connect to database
//local SDK
$mysqli = new mysqli('localhost','accessouser','qwerty','accesso');
//remote SDK: replace  hostname or IP, username, password, dbname with appropriate values
//$mysqli = new mysqli('hostname or IP','username','password','dbname');
$result = $mysqli -> query("SELECT status FROM thing WHERE id='$thing'");
$row = $result -> fetch_assoc();
$curstatus=$row['status'];
if(($rqsensor==0)&&($curstatus==1)){ 					//sensor low in restroom engaged: transition to vacant
	$curstatus=0;
}
if(($rqsensor==1)&&(($curstatus==0)||($curstatus==2))){ //sensor high in restroom vacant or reserver: transition to engaged
	$curstatus=1;
}
//update sensor value in related database record
$result = $mysqli -> query("UPDATE thing SET status=$curstatus,sensor=$rqsensor,timestamp=UNIX_TIMESTAMP() WHERE id='$thing'");
//exatract current thing global status as an associative array
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
