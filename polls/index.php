<?php

/* 
	main page for the polls
	the worker can answer if there is available polls
	the poll script is setted in the DB for a limited time for users
*/

require_once('init.php');

$user = $_SESSION['user_id'];

// querying the available polls

$pollsQuery = $dbc->query('SELECT id, question FROM polls WHERE DATE(NOW()) BETWEEN starts AND ends');

while ($row = $pollsQuery->fetch_object()){
	$polls[] = $row;
}

$_SESSION['user_id'] = $user;


?> 
 
 
 <!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Title</title>
		
		<link rel="stylesheet" href="css/main.css">
	</head>
		<ul>
			<?php if(!empty($polls)): ?>
				<ul>
					<?php foreach($polls as $poll): ?>
						<li>
							<a href="poll.php?poll=<?php echo $poll->id;?>"><?php echo $poll->question; ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			
			<?php else: ?>
				<p>No polls Available!</p>
			<?php endif; ?>
		</ul>
	<body>
		<?php echo $_SESSION['user_id'];?>
	</body>

</html> 