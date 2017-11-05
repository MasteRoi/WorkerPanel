<?php

require_once('init.php');

/* check if user is 'Online' for the poll
if(!isset($_SESSION['user_id'])){ 
	echo 'NOT ON';
}else{
	echo 'ON!'.$_SESSION['user_id'];
}
*/

$user = $_SESSION['user_id'];

if(!isset($_GET['poll'])){
	header('Location: index.php');
}else{
	$id = (int)$_GET['poll'];
	
	// get general post info
	
	$pollQuery = "
		SELECT id, question 
		FROM polls 
		WHERE id = ? 
		AND DATE(NOW()) BETWEEN starts AND ends";
		
	$stmt = $dbc->prepare($pollQuery);
	$stmt->bind_param('i',$id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($poll,$question);
	
	if($stmt->fetch()){
		//var_dump($question);
	}
	$stmt->free_result();
	
	//get student answer for the current poll
	
	$answerQuery = "
		SELECT polls_choices.id AS choice_id, polls_choices.name AS choice_name
		FROM polls_answers JOIN polls_choices 
		ON polls_answers.choice = polls_choices.id
		WHERE polls_answers.user = ?
		AND polls_answers.poll = ?
	
	";
	$ans_stmt=$dbc->prepare($answerQuery);
	$ans_stmt->bind_param('ii',$user ,$id);
	$ans_stmt->execute();
	$ans_stmt->store_result();
	$ans_stmt->bind_result($a1,$b1);
	
	
	if($ans_stmt->fetch()){
		//print_r($a1);
	}
	
	//user completed the poll?
	
	$completed = $ans_stmt->num_rows? true : false;
	
	
	if ($completed){
		//IF QUERY REJECTED:
		//mysql> set global sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
		//mysql> set session sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';

		
		//get all answers
		$answeredQuerey = "
			SELECT
			polls_choices.name,
			COUNT(polls_answers.id) * 100 / (
				SELECT COUNT(*)
				FROM polls_answers
				WHERE polls_answers.poll = ?) AS precentage
			FROM polls_choices
			LEFT JOIN polls_answers
			ON polls_choices.id = polls_answers.choice
			WHERE polls_choices.poll = ?
			GROUP BY polls_choices.id
		";
		
		$ansd_stmt=$dbc->prepare($answeredQuerey);
		$ansd_stmt->bind_param('ii',$id ,$id);
		$ansd_stmt->execute();
		$ansd_stmt->store_result();
		$num_of_rows = $ansd_stmt->num_rows;
		
		
		$ansd_stmt->bind_result($choice, $precents);
		while ($ansd_stmt->fetch()) {
			$choices_Arr[]=$choice;
			$precent[]=$precents;
	   }
		
	}else{
		//get poll choices
		
		$choicesQuery = "
			SELECT polls.id, polls_choices.id AS choice_id, polls_choices.name 
			FROM polls
			JOIN polls_choices
			ON polls.id = polls_choices.poll
			WHERE polls.id = ?
			AND DATE(NOW()) BETWEEN polls.starts AND polls.ends";
			
		$result = $dbc->prepare($choicesQuery);
		
		
		$result->bind_param('i',$id);
		$result->execute();
		$result->store_result();
		$num_of_rows = $result->num_rows;
		
		
		$result->bind_result($poll_id, $choice_id, $choices);
		while ($result->fetch()) {
			//echo 'Poll ID: '.$poll_id.'<br>';
			//echo 'Choice ID: '.$choice_id.'<br>';
			//echo 'Choice: '.$choices.'<br><br>';
			$choicesArr[]=$choices;
			$c_id[]=$choice_id;
	   }
	}
	
}
	
?> 
 
 
 <!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Title</title>
		
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
	
		<?php if(!$question):?>
			<p>Poll doesn't exist</p>
		<?php else:?>
	
		<ul>
			<div class="poll">
				<div class="poll-question">
					<?php echo $question; ?>
				</div>
				
				<?php if($completed): ?>
					<p>You have completed the poll!</p>
					
					<ul>
						<?php foreach($choices_Arr as $index => $choice): ?>
							<li><?php echo $choice; ?> (<?php echo number_format($precent[$index], 2); ?>%)</li>
							
						<?php endforeach; ?>
					</ul>
					
				<?php else:?>
					<?php if(!empty($choices)):?>
						<form action="vote.php" method="POST">
							<div class="poll-options">
							<?php if(is_array($choicesArr)):?>
								<?php foreach($choicesArr as $index => $choice): ?>
									<div class="poll-options">
										<input type="radio" name="choice" value="<?php echo $c_id[$index] ?>" id="<?php echo $index ?>">
										<label for="<?php echo $index ?>"><?php echo $choice ?></label>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>	
							</div>
							<input type="submit" value="Submit Answer">
							<input type="hidden" name="poll" value="<?php echo $poll_id ?>">
						</form>	
					<?php else: ?>
						<p>There's no choices.<p>
					<?php endif; ?>
				<?php endif; ?>
				
			</div>
		</ul>
	
	<?php endif; ?>
	</body>

</html> 