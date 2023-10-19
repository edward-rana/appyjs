<?php
class input{
	function posts(){
		return $_POST;
	}
	function post($key){
		return isset($_POST[$key]) ? $_POST[$key] : '';
	}
	function gets(){
		return $_GET;
	}
	function get($key){
		return isset($_GET[$key]) ? $_GET[$key] : '';
	}
}