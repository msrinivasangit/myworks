<?php
/*
Author: Mohana Srinivasan
Date : 12-Aug-2018
Script: api_controller.php
Usage: Class and Methods for PHP_API Controller
*/
require_once "../api_model.php";
Class Controller extends Api_model{

	/*Constructor for controller to initiate the Api request*/
	public function __construct(){
		$method = $_SERVER['REQUEST_METHOD'];
		header('Content-Type: application/json');
		$data = array();
		if($_GET['requirement']=='three'){
			if ($method == 'GET') {
				$data['year'] = $_GET['year'];
				$data['make'] = $_GET['make'];
				$data['model'] = $_GET['model'];
				$data['withRating'] = $_GET['withRating'];
				if($data['withRating'] == 'true'){
					$result = self::requirement_three($data);
				}else{
					$result = self::requirement_one($data);
				}
			}else{
				$result = "Request Method Should Be GET";
			}
		}else if($_GET['requirement']=='two'){
			if ($method == 'POST') {
				$data['year'] = $_POST['modelYear'];
				$data['make'] = $_POST['manufacturer'];
				$data['model'] = $_POST['model'];
				$result =self::requirement_two($data);
			}else{
				$result = "Request Method Should Be POST";
			}
		}else{
			if ($method == 'GET') {
				$data['year'] = $_GET['year'];
				$data['make'] = $_GET['make'];
				$data['model'] = $_GET['model'];
				$result = self::requirement_one($data);
			}else{
				$result = "Request Method Should Be GET";
			}
		}
		print $result;
	}

	/*Call Requirement One*/
	public static function requirement_one($data){
		return parent::get_requirement_one($data['year'],$data['make'],$data['model']);
	}

	/*Call Requirement Two*/
	public static function requirement_two($data){
		return parent::get_requirement_two($data['year'],$data['make'],$data['model']);
	}

	/*Call Requirement Three*/
	public static function requirement_three($data){
		return  parent::get_requirement_three($data['year'],$data['make'],$data['model']);
	}
}
$ctrl = new Controller();
?>