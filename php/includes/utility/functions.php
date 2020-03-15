<?php
	/*
	 * Sanitizes the given $input string.
	 */
	function sanitize($input){
		global $conn;
		return $conn->real_escape_string(htmlspecialchars(stripslashes(trim($input))));
	}
	
	/*
	 * Clear all error messages
	 */
	function clearErrors(){
		foreach($_SESSION as $name => $val){
			unset($_SESSION[$name]);
			if(isset($_SESSION[$name])){
				return false;
			}
		}
		return true;
	}
?>