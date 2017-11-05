<?php

// put the polls answer in db

require_once('init.php');

$user = $_SESSION['user_id'];

if (isset($_POST['poll'], $_POST['choice'])){
	
	$poll = $_POST['poll'];
	$choice = $_POST['choice'];
	
	$voteQuery = "INSERT INTO polls_answers (user, poll, choice)
					SELECT ?, ?, ?
					FROM polls
					WHERE EXISTS (SELECT id FROM polls WHERE id=?
					AND DATE(NOW()) BETWEEN starts AND ends)
					AND EXISTS (SELECT id FROM polls_choices WHERE id=? AND poll=?)
					AND NOT EXISTS (SELECT id FROM polls_answers WHERE user=? and poll=?)
					LIMIT 1
	";
	$stmt = $dbc->prepare($voteQuery);
	$stmt->bind_param('iiiiiiii', $user, $poll, $choice, $poll, $choice, $poll, $user, $poll);
	$stmt->execute();
	$stmt->store_result();
	echo 'OK'; 
	
}

header('Location: index.php');
exit();

?>