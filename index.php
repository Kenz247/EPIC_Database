	<body>
		<?php
			$foo = 1;
			include "header.php";
		?>

		<div class="container" style="padding: 40px 15px" align="center">

			<div class="page-header" align="left">
				<h1><span style="color: #cc0000; font-size: 1.5em;">E</span><small style="color: black">xterally Collaborative </small><span style="color: #cc0000; font-size: 1.5em;">P</span><small style="color: black">roject Based </small><span style="color: #cc0000; font-size: 1.5em;">I</span><small style="color: black">nterdisciplinary </small><span style="color: #cc0000; font-size: 1.5em;">C</span><small style="color: black">ulture</small></h1>
			</div>


			<p>
				<!--<b>DB Connection</b>:-->
				<?php

					error_reporting( E_STRICT );
					mysqli_report( MYSQLI_REPORT_STRICT );

					try {
						$mysqli = new mysqli( DB_SERVER, DB_USER, DB_PW, DB_NAME );
						//echo ( '<span class="label label-success">Success</span>' );
						$connected = true;
					} catch (Exception $e) {
						//echo ( '<span class="label label-danger">' . htmlentities( $e->getMessage() ) . '</span>' );
						$connected = false;
					}
				?>
			</p>

			<?php
				if ( $connected )
				{
			?>
					<p>
						<!--<b>Character Set UTF-8</b>:-->
						<?php
							if (!$mysqli->set_charset('utf8')) {
								//echo ( '<span class="label label-danger">' . htmlentities( $mysqli->error ) . '</span>' );
								$connected = false;
							} else {
								//echo ( '<span class="label label-success">Success</span>' );
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



				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
				    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
						<li data-target="#carousel-example-generic" data-slide-to="3"></li>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
				    <div class="item active">
							<a href="project.php?stuff=2">
				      	<img src="art.jpg" alt="Art">
      					<div class="carousel-caption" style="color: black; font-size: 2em;">
        					<mark><b>Art</b></mark>
      					</div>
							</a>
				    </div>
				    <div class="item">
							<a href="project.php?stuff=3">
				      	<img src="bike.jpg" alt="Electric Bike">
								<div class="carousel-caption" style="color: black; font-size: 2em;">
									Bike
      					</div>
							</a>
				    </div>
						<div class="item">
							<a href="project.php?stuff=1">
								<img src="oscar.jpg" alt="Oscar the Talking Trash Can">
								<div class="carousel-caption" style="color: black; font-size: 2em;">
									Trash
      					</div>
							</a>
						</div>
						<div class="item">
							<a href="project.php?stuff=1">
								<img src="chuck.jpg" alt="Chuck the Cornhole">
								<div class="carousel-caption" style="color: black; font-size: 2em;">
									Chuck
      					</div>
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

				<p>
					<!--<b>DB Disconnection</b>:-->
					<?php
						//echo ( ( $mysqli->close() )?( '<span class="label label-success">Success</span>' ):( '<span class="label label-danger">Failure</span>' ) );
					?>
				</p>

			<?php
				}
			?>
			<div class="container" align="left">
			<h3>What is EPIC Learning?</h3>
			<p>EPIC Learning is an acronym for an approach to learning that closely mirrors what goes on in real workplaces across the country.</p>
<p><span style="color: #cc0000; font-size: 1.75em;">E</span> is for <strong>externally-collaborative.&#160;</strong>Most people who work in engineering, technology, design, management, and related disciplines work with people outside their own organization: funders, investors, clients, customers, contractors, sub-contractors, regulators or fans. Professionals need to listen to others; grasp their needs, desires, concerns; and respond appropriately. Externally-collaborative learning helps students develop and practice the skills they need to work well with colleagues and other partners.</p>
<p>At Wentworth, we are open to external collaborators of all sorts, from new start-up businesses to major corporations to non-profits of all sizes to government bodies and agencies at all levels (federal, state and local). We are also interested in engaging learning opportunities wherever they arise. For instance, our mechanical engineering students have recently refined the design of stoves produced by Aid Africa, a non-governmental organization (NGO) active in northern Uganda!</p>
<p><span style="color: #cc0000; font-size: 1.75em;">P</span> is for <strong>project-based.</strong> We believe that there&#8217;s an essential role for traditional lectures while allowing students to learn more by getting involved in <strong>experiential learning</strong>. At Wentworth, as in most workplaces, experiential learning takes place largely through work on projects &#8211; sustained efforts with specified objectives along with constraints on time and other resources. We choose projects that we believe offer the best learning opportunities for our students. Some of them are over in a few class sessions; others stretch over several semesters, with different teams of students carrying out different phases.</p>
<p><span style="color: #cc0000; font-size: 1.75em;">I</span> is for <strong>interdisciplinary.</strong> In their careers, our students will work side-by-side with people whose academic background and work experiences vary widely. We model that interaction by organizing interdisciplinary projects bringing together students from two or more majors. Whether it&#8217;s future architects and construction managers, industrial designers and biomedical engineers, or mechanical engineers and computer scientists, students learn more about their own discipline as well as other fields when they work together. Our faculty have discovered that they learn more this way, too.</p>
<p><span style="color: #cc0000; font-size: 1.75em;">C</span> is for <strong>culture</strong>. Opportunities for students from different disciplines to work together, and to do so with external organizations, aren&#8217;t limited to extracurricular activities within&#160;<a href="http://www.wit.edu/accelerate">Accelerate</a>&#160;or the&#160;<a href="http://wit.edu/clp/">Center for Community and Learning Partnerships (CLP),</a> clubs or select students. Externally collaborative, interdisciplinary projects are being built into all of our degree programs and required of all of our students.</p>
<p><span style="color: #cc0000; font-size: 1.75em;">Learning</span> is what it&#8217;s all about. EPIC Learning represents a significant departure from traditional models of teaching. We believe added value arises when students get hands-on experience that prepares them for rewarding jobs and successful careers. That was the rationale when Wentworth began its co-operative education (co-op) program in the 1970s. The same philosophy guides EPIC Learning today.</p>
</div>

	</div>

	<script src="js/jquery-1.12.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<?php include "stolenfooter.php" ?>
	</body>
</html>
