<?php

	///////////////////////////////////////////////////
	// CHANGE THESE VALUES AS NECESSARY
	///////////////////////////////////////////////////

	define( 'DB_SERVER', 'localhost' );
	define( 'DB_USER',   'root' );
	define( 'DB_PW',	 '' );
	define( 'DB_NAME',   'epic' );

	///////////////////////////////////////////////////

	define( 'PARAM_NAME', 'email_address' );

	$param = 'Email';
	if ( isset( $_GET[ PARAM_NAME ] ) )
	{
		$param = trim( $_GET[ PARAM_NAME ] );
		if ( empty( $param ) )
		{
			$param = null;
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>EPIC</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel="apple-touch-icon" sizes="57x57" href="./apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="./apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="./apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="./apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="./apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="./apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="./apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="./apple-touch-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon-180x180.png">
		<link rel="icon" type="image/png" href="./favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="./android-chrome-192x192.png" sizes="192x192">
		<link rel="icon" type="image/png" href="./favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="./favicon-16x16.png" sizes="16x16">
		<link rel="manifest" href="./manifest.json">
		<link rel="mask-icon" href="./safari-pinned-tab.svg" color="#5bbad5">
		<link rel="shortcut icon" href="./favicon.ico">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="msapplication-TileImage" content="./mstile-144x144.png">
		<meta name="msapplication-config" content="./browserconfig.xml">
		<meta name="theme-color" content="#ffffff">
	</head>
	<body><nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">EPIC</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="index.php">Home</a></li>
					<li><a href="project.php">Project</a></li>
					<li><a href="#contact">Contact</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>
		<div class="container" style="padding: 40px 15px" align="center">

			<div class="page-header" align="left">
				<h1><strong>E</strong><small>xterally Collaborative</small> <strong>P</strong><small>roject Based</small> <Strong>I</Strong><small>nterdisciplinary</small> <Strong>C</Strong><small>ulture</small></h1>
			</div>

			<form method="GET" action="<?php echo htmlentities( $_SERVER['PHP_SELF'] ); ?>">
				<div class="form-group">
					<label for="exampleInput">Email Address</label>
	    			<input type="text" style="width:200px" class="form-control" id="exampleInput" name="<?php echo htmlentities( PARAM_NAME ); ?>" placeholder="Email addres" value="<?php echo htmlentities( ( is_null( $param ) )?( '' ):( $param ) ) ?>">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form>

			<hr />

			<p>
				<a href="email.php?email_address=stuff" target="_blank">what you see</a>
			</p>

			<p>
				<b>DB Connection</b>:
				<?php
					var_dump($param);
					error_reporting( E_STRICT );
					mysqli_report( MYSQLI_REPORT_STRICT );

					try {
						$mysqli = new mysqli( DB_SERVER, DB_USER, DB_PW, DB_NAME );
						echo ( '<span class="label label-success">Success</span>' );
						$connected = true;
					} catch (Exception $e) {
						echo ( '<span class="label label-danger">' . htmlentities( $e->getMessage() ) . '</span>' );
						$connected = false;
					}
				?>
			</p>

			<?php
				if ( $connected )
				{
			?>
					<p>
						<b>Character Set UTF-8</b>:
						<?php
							if (!$mysqli->set_charset('utf8')) {
								echo ( '<span class="label label-danger">' . htmlentities( $mysqli->error ) . '</span>' );
								$connected = false;
							} else {
								echo ( '<span class="label label-success">Success</span>' );
							}
						?>
					</p>
			<?php
				}
			?>

			<?php
				if ( $connected )
				{
			?>

				<hr />

				<p>
					<b>SQL to Prepare</b>:
					<?php

						$sql = null;
						if ( !is_null( $param ))
						{
							$sql = 'SELECT project.Name as Project_Name, emails.Content as Content, emails.Sender as "From", emails.Recipient as "To" ' .
										'from emails inner join project on project.ID = emails.ProjectId ' .
										'where emails.Sender = ( ' .
								    'SELECT faculty.Email ' .
								    'from faculty ' .
								    'WHERE faculty.LastName like ? ' .
								    ') ' .
								    'ORDER by project.Name desc, emails.Recipient desc';
						}

						echo ( '<code>' . htmlentities( $sql ) . '</code>' );

					?>
				</p>

				<p>
					<b>Preparing</b>:
					<?php
						if ( !( $stmt = $mysqli->prepare( $sql ) ) )
						{
							echo ( '<span class="label label-danger">' . htmlentities( $mysqli->error ) . '</span>' );
							return;
						}
						else
						{
							echo '<span class="label label-success">Success</span>';
						}
					?>
				</p>

				<?php
					if ( !is_null( $param ) )
					{
				?>
					<p>
						<b>Binding parameter</b>:
						<?php
							if ( !$stmt->bind_param( "s", $param ) )
							{
								echo ( '<span class="label label-danger">binding error</span>' );
								return;
							}
							else
							{
								echo '<span class="label label-success">Success</span>';
							}
						?>
					</p>
				<?php
					}
				?>

				<p>
					<b>Executing</b>:
					<?php
						if ( !$stmt->execute() )
						{
							echo ( '<span class="label label-danger">' . htmlentities( $stmt->error ) . '</span>' );
							return;
						}
						else
						{
							echo '<span class="label label-success">Success</span>';
						}
					?>
				</p>

				<hr />

				<p>
					<h1 style="text-align:left">Results</h1>
					<ul class="list-group">
					<?php

						$project_name = null;
						$to = null;
						$from = null;
						$content = null;
						$stmt->bind_result($project_name, $content, $from, $to);

						while ( $stmt->fetch() )
						{
							echo '<address>';
							 echo ('<strong> Project: ' . htmlentities($project_name) . '</strong><br>');
							 echo ('From: ' . htmlentities($from) . '<br>');
							 echo ('To: ' . htmlentities($to) . '<br><br>');
							 echo (htmlentities($content). '<br>');
							echo '</address>';
						}

						$stmt->close();

					?>
				</ul>
				</p>

				<hr />

				<p>
					<b>DB Disconnection</b>:
					<?php
						echo ( ( $mysqli->close() )?( '<span class="label label-success">Success</span>' ):( '<span class="label label-danger">Failure</span>' ) );
					?>
				</p>

			<?php
				}
			?>
	</div>

	<script src="js/jquery-1.12.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	</body>
</html>
