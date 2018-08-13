<?php
/*
Author: Mohana Srinivasan
Date : 12-Aug-2018
Script: api_model.php
Usage: Class and Methods for PHP_API Requiremnt model
*/
Class Api_model{

	/*Method For Making API Call via Curl*/
	public static function callAPI($method, $url, $data){
	   	$curl = curl_init();
	   	switch ($method){
	      	case "POST":
	         	curl_setopt($curl, CURLOPT_POST, 1);
	         	if ($data)
	            	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	         	break;
	      	case "PUT":
	         	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	         	if ($data)
	            	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                         
	         	break;
	      	default:
	         	if ($data)
	            	$url = sprintf("%s?%s", $url, http_build_query($data));
	   	}
	   
	   	// OPTIONS:
	   	curl_setopt($curl, CURLOPT_URL, $url);
	   	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	      'Content-Type: application/json',
	   	));
	  	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	   	// EXECUTE:
	   	$result = curl_exec($curl);	   
	   	if (!$result || curl_errno($curl) !== CURLE_OK){
		    echo 'cURL error (' . curl_errno($curl) . '): ' . curl_error($curl);
		}
	   	if(!$result){die("Connection Failure");}
	   	curl_close($curl);
	   	return $result;
	}

	/*Method For Processing Json Response*/
	public static function get_json_response($response){
		$result = array();
		if($response['Count']){
			$result['Count'] = $response['Count'];
			foreach ($response['Results'] as $key => $value) {
				$result['Results'][$key]['Description'] = $response['Results'][$key]['VehicleDescription'];
				$result['Results'][$key]['VehicleId'] = $response['Results'][$key]['VehicleId'];
			}
		} else {
			$result['Count'] = 0;
			$result['Results'] = [];
		}
		return json_encode($result, JSON_PRETTY_PRINT);
	}

	/*Method For Requirement One*/
	public static function get_requirement_one($modelyear,$make,$model){
		$model = str_replace(" ","",$model);
	 	$get_data = self::callAPI('GET', 'https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/'.$modelyear.'/make/'.$make.'/model/'.$model.'?format=json', false);
		$response = json_decode($get_data, true);
		return self::get_json_response($response);
	}

	/*Method For Requirement Two*/
	public static function get_requirement_two($modelyear,$make,$model){
		return self::get_requirement_one($modelyear,$make,$model);
	}

	/*Method For Requirement Three*/
	public static function get_requirement_three($modelyear,$make,$model){
		$response = json_decode(self::get_requirement_one($modelyear,$make,$model),true);
		if($response['Count']){
			foreach($response['Results'] as $key => $value){
				$VehicleId = $response['Results'][$key]['VehicleId'];
				$get_data = self::callAPI('GET', 'https://one.nhtsa.gov/webapi/api/SafetyRatings/VehicleId/'.$VehicleId.'?format=json', false);
				$result = json_decode($get_data, true);
				$response['Results'][$key]['CrashRating'] = $result['Results']['0']['OverallRating'];
			}
		}
		return json_encode($response, JSON_PRETTY_PRINT);
	}

}
?>