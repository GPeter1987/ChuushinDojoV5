<?php
	/*
	 * Sanitizes the given $input string.
	 */
	function sanitize($input){
		global $conn;
		return $conn->real_escape_string(htmlspecialchars(stripslashes(trim($input))));
	}
?>