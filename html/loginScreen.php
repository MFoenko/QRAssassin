<html>
	<head>	
		<script type="text/javascript">
		function login(loginForm){
			uname = loginForm.elements['uname'].value;
			pword = loginForm.elements['pword'].value;
			$.post("php/login.php", {
				uname: uname,
				pword: pword
			}, function(data, responseText, xhr){
				//console.log(data+"\n"+"\n"+responseText);
				responseJSON = JSON.parse(data);
				switch(responseJSON.response){
					case "INVALID_INFO":
							loginOutput(responseJSON.message, 'red');
								return false;
					case "OK":
							location.reload();
				}
			});
			return false;
		}

		function register(registerForm){
			uname = registerForm.elements['uname'].value;
			pword = registerForm.elements['pword'].value;
			fname = registerForm.elements['fname'].value;
			$.post("php/register.php", {
				uname: uname,
				pword: pword,
				fname: fname
			}, function(data, responseText, xhr){
				console.log(data+"\n"+"\n"+responseText);
				responseJSON = JSON.parse(data);
				switch(responseJSON.response){
					case "USERNAME_TAKEN":
							registerOutput(responseJSON.message, 'red');
								return false;
					case "USERNAME_TOO_LONG":
							registerOutput(responseJSON.message, 'red');
								return false;
					case "OK":
							registerOutput(responseJSON.message, 'green');
								return false;

				}
			});
			return false;
		}

		function loginOutput(text, color){
			if(text)
				$('#loginOutput').text(text);
			if(color)
				$('#loginOutput').css('color',color);

		}	
		function registerOutput(text, color){
			if(text)
				$('#registerOutput').text(text);
			if(color)
				$('#registerOutput').css('color',color);

		}


		</script>
		<link rel="stylesheet" type="text/css" href="css/login.css">
	
	</head>

	<body>
		<h1>QR Assassin</h1>
		<div class="forms">

			<form id="loginForm" method="POST" action="php/login.php" onsubmit="return login(this)">

				<h3> Login </h3>

				<label>Username:<input type="text" name="uname"></label>

				<label>Password:<input type="password" name="pword"></label>

				<input type="submit" value='Login'>

				<br /><span id="loginOutput"></span>
			</form>
			<br /><span class="link_span" onclick="$('#registerForm').toggle();">Or Register!</span>
			<form id="registerForm" method='POST' action="php/register.php" onsubmit="return register(this)">

				<h3> Register </h3>

				<label>Full Name:<input type="text" name="fname"></label>

				<label>Username:<input type="text" name="uname"></label>

				<label>Password:<input type="password" name="pword"></label>

				<input type="submit" value='Register'>

				<br /><span id="registerOutput"></span>

			</form>




		</div>

	</body>

</html>