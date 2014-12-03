<?php 
	$base = 'http://mchail.comuf.com/twilio/assassin/phone_bind/text.php';
	$randomNumber = rand(10000,99999);
	$qry_str = "?code=" . $randomNumber . "&phone=6462400075";
	$ch = curl_init();
	$fullStr = $base . $qry_str;
	echo $fullStr;
	// Set query data here with the URL
	curl_setopt($ch, CURLOPT_URL,$fullStr); 
	//curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	//curl_setopt($ch, CURLOPT_TIMEOUT, '3');
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:23.0) Gecko/20100101 Firefox/23.0');
	
	curl_setopt($ch,CURLOPT_COOKIEJAR,'text.txt');
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_COOKIESESSION, true);
	
	//curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
	//curl_setopt($curl, CURLOPT_AUTOREFERER, true);
	$content = curl_exec($ch);
	curl_close($ch);
	print $content;
	
?>