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
			if(isset($_SESSION[$name]["err_msg"]))
				unset($_SESSION[$name]);
		}
	}
?>