<?php
	session_start();
	include('dbconnect.php');
	$number = $_REQUEST['From'];
	$response = "";
	$query = $conn->prepare("select number from numbers where number = '{$number}'");
	$query->execute();
	$result = $query->fetch(PDO::FETCH_NUM);
	if(empty($result)){
		$time = time();
		$query = $conn->prepare("Insert into numbers VALUES('{$number}','{$time}')");
		$query->execute();
		$needCommands = true;
	}
	if(time() - $result[1] > 14400 || $needCommands == true){
		$response .= "Choose One: Candidates,
		Poll Locations,Deadlines,What Do I Bring";
	}
	$userDirectory = $_SESSION['directory'];
    // if it doesnt, set the default
    if(empty($userDirectory) || !isset($_SESSION['directory'])) {
        $userDirectory = "Home";
    }
	$userAskedFor = $_REQUEST['Body'];
	// Commands will be an array of results from the DB of all the relvant info based on what $userDirectory is
	// so it will be a command and directory type system.
	$command = array('Candidates','Poll Location','deadlines','What To Bring','Help',
	'A. Weiner','Spizer');
	$do = "";
	foreach($command as $currentCommand){
		if(preg_match("/{$currentCommand}/i",$userAskedFor) === 1){
			$do = $currentCommand;
			break;
		}; 
	}
	switch($userDirectory){
		case 'Home':
			switch($do){
				case "Candidates":
					// will return the list of candidates based on the users AREA CODE.
					$response = "A. Weiner, Spizer,Bloomberg";
					break;
				case "Poll Location":
					// will ask for a zip
					$response = "Near what Zip Code";
					break;
				case "deadlines":
					// Will query db based on area code and return w/e the nearest deadlines are
					// NO NEED FOR A DEADLINES CASE!
					$response = "Are closer than trhey appaear";
					$do = 'Home';
					break;
				case "What To Bring":
					// Might query the db for this? Idk depending on the data I can get from google civic.
					$response = "";
					break;
				default:
					$response = "Try one of these:Candidates,Poll Locations,Deadlines,What To Bring";
					break;
			}
			break;
		case 'Candidates':
			switch($do){
				case "A. Weiner": $response = "What do you want to know abt Weiner";
									break;
				case "Spizer":	$response = "what is a Spizer";
								break;
				default:	$response = "IDK that Crook";
							break;
			}
		break;
		case 'What do I need':
			$response = "To register and have an ID and money to bribe the offical.";
			$do = "Home";
			break;
		case 'Poll Location':
			$response = "There is no voting location avaliable.You can't vote";
			$do = "Home";
			break;
		/*case "Deadlines":
			$response = "You have 5 minutes to vote.";
			$do = "Home";
			break;*/
	}
	// NOW IT SHOULD DO THIS IFF ITS IN CANDIDATE
	// Loop throu the candidates? Or test if its candidates or so
	if($_SESSION['directory'] == 'Spizer'){
		$_SESSION['directory'] = 'Home';
	}
	
	$_SESSION['directory'] = $do;
	
	
	/*$charsUsed = 0;
	while(strlen(print_r($_REQUEST)) > $charsUsed){
		$response .= "</Sms>" . substr(print_r($_REQUEST),$charsUsed,100) . "<Sms>";
		$charsUsed += 100;
	}*/
	//$numberOfMessages = count($client->account->sms_messages);
	/*$arrayOfMessages = array();
	foreach($client->account->sms_messages as $message){
		if($message->from === $number){
			array_push($arrayOfMessages,$message);
		}
	}
	$recent = strtotime($arrayOfMessages[0]->date_sent);
	foreach($arrayOfMessages as $message){
		if($recent < strtotime($message->date_sent)){
			$recent = $message;
		}
	}
	if($recent == strtotime($arrayOfMessages[0]->date_sent)){
		$recent = $arrayOfMessages[0];
	}
	
	//$response .= "</Sms>";
	$part1 = substr(print_r($_POST),0,60); */
	header('content-type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
	<Sms><?php echo $response . $userDirectory ; ?></Sms>
</Response>