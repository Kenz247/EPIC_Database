	<body>
		<?php
			$foo = 1;
			include "header.php";
		?>

		<div class="container" style="padding: 40px 15px" align="center">

			<div class="page-header" align="left">
				<h1><strong>E</strong><small>xterally Collaborative</small> <strong>P</strong><small>roject Based</small> <Strong>I</Strong><small>nterdisciplinary</small> <Strong>C</Strong><small>ulture</small></h1>
			</div>

			<hr />

			<p>
				<b>DB Connection</b>:
				<?php

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


				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
				    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
				    <div class="item active">
							<a href="project.php?stuff=2">
				      	<img src="art.jpg" alt="Art">
							</a>
				    </div>
				    <div class="item">
							<a href="project.php?stuff=3">
				      	<img src="bike.jpg" alt="Electric Bike">
							</a>
				    </div>
						<div class="item">
							<a href="project.php?stuff=1">
								<img src="oscar.jpg" alt="Oscar the Talking Trash Can">
							</a>
						</div>
				  </div>

				  <!-- Controls -->
				  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>

				<div class="container" align="center">
					<h2>About</h2>
					<p class="lead">Epic is awesome.</p>
				</div>

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
	<?php include "stolenfooter.php" ?>
	</body>
</html>
