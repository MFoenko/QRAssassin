<?php

?>
<!Doctype HTML>
<html>
	<head>
		<title>Hackathon</title>
		<script type="text/javascript">
		function hasMessageNumChanged()
			{
				if (window.XMLHttpRequest){
					conRequest = new XMLHttpRequest();
				}	
				else{
					conRequest = new ActiveXObject("Microsoft.XMLHttp");
				}	
					
				conRequest.onreadystatechange = function(){
					if(conRequest.readyState === 4){
					x = conRequest.responseText.split("::");
					console.log(x);
					}
				};
				url = "getMessages.php?function=messagesChanged";
				conRequest.open("GET", url, true);
				conRequest.send(null);
			}
		</script>
	</head>
	<body>
	
	
	</body>
</html>