<?php
	
	
	//$dbname = 'mysql:host=localhost;dbname=ift_lift';
	$host = 'sql310.byetcluster.com';
	$dbname = 'b24_13544856_hack';
	$dbUsername = 'b24_13544856';
	$dbPassword = 'mit2018';
	$conn = new PDO('mysql:host=sql310.byetcluster.com;dbname=b24_13544856_hack','b24_13544856','mit2018');
	/*
	function getPDOConnection($hostname, $dbname, $dbuname, $dbpword = "")
	{
		//PDO Object Parameters
		//Formatted string holding the hostname and the database name.
		$hostString = "mysql:host=$hostname;dbname=$dbname";
		
		//Establish connection
		return new PDO($hostString, $dbuname, $dbpword);
	}*/
	
?>