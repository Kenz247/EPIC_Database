<head>
	<?php
	$foo = 2;
	include "header.php";
	 ?>
	<body>
		<div class="container" style="padding: 40px 15px">

			<div class="page-header">
				<h1>Current Projects</h1>
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

      <p>
        <!--<b>SQL to Prepare</b>:-->
        <?php

          $sql = null;
            $sql = 'SELECT project.id as Project_Id, project.Name as Project_Name ' .
            'From project ' .
            'order by project.name asc;';

          //echo ( '<code>' . htmlentities( $sql ) . '</code>' );

        ?>
      </p>

      <p>
        <!--<b>Preparing</b>:-->
        <?php
          if ( !( $stmt = $mysqli->prepare( $sql ) ) )
          {
            //echo ( '<span class="label label-danger">' . htmlentities( $mysqli->error ) . '</span>' );
            return;
          }
          else
          {
            //echo '<span class="label label-success">Success</span>';
          }
        ?>
      </p>



      <p>
        <!--<b>Executing</b>:-->
        <?php
          if ( !$stmt->execute() )
          {
            //echo ( '<span class="label label-danger">' . htmlentities( $stmt->error ) . '</span>' );
            return;
          }
          else
          {
            //echo '<span class="label label-success">Success</span>';
          }
        ?>
      </p>


      <p>
        <h3>Please select a project:</h3>
				<div class="container" align="center">
					<form>
						<select name="stuff" class="form-control" style="width:220px">
							<option value=0>Projects</value>
        <?php

          $project_name = null;
					$project_id = null;
          $stmt->bind_result($project_id, $project_name);

          while ( $stmt->fetch() )
          {
                echo ('<option value=' . htmlentities($project_id) . ' text-align:center>' . htmlentities($project_name) . '</value>');
          }


          $stmt->close();
        ?>
						</select>
						<br>
					<input type="submit" class="form-control" style="width:100px"/>
					<?php
						$param = $_GET['stuff'];
						?>
				</form>
			</div>
      </p>

			<p>
				<!--<b>DB Disconnection</b>:-->
				<?php
					//echo ( ( $mysqli->close() )?( '<span class="label label-success">Success</span>' ):( '<span class="label label-danger">Failure</span>' ) );
				?>
			</p>

		<?php
			}
		?>

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


			<p>
				<!--<b>SQL to Prepare</b>:-->
				<?php

					$sql = null;
					if ( !is_null( $param ))
					{
						$sql = 'SELECT project.Name as Project_Name, project.ProjectStatus as Project_Status, ' .
						'project.About as about_project, faculty.email as pl_email, '.
						'project.StartDate as Start_Date, project.EndDate as EndDate, project.Budget as Budget, ' .
						'concat(faculty.FirstName," ", faculty.LastName) as Project_Leader ' .
						'from project inner join faculty on project.LeaderId = faculty.ID where project.id = ? ';
					}

					//echo ( '<code>' . htmlentities( $sql ) . '</code>' );

				?>
			</p>

			<p>
				<!--<b>Preparing</b>:-->
				<?php
					if ( !( $stmt = $mysqli->prepare( $sql ) ) )
					{
						//echo ( '<span class="label label-danger">' . htmlentities( $mysqli->error ) . '</span>' );
						return;
					}
					else
					{
						//echo '<span class="label label-success">Success</span>';
					}
				?>
			</p>

			<?php
				if ( !is_null( $param ) )
				{
			?>
				<p>
					<!--<b>Binding parameter</b>:-->
					<?php
						if ( !$stmt->bind_param( "s", $param ) )
						{
							//echo ( '<span class="label label-danger">binding error</span>' );
							return;
						}
						else
						{
							//echo '<span class="label label-success">Success</span>';
						}
					?>
				</p>
			<?php
				}
			?>
			<p>
				<!--<b>Executing</b>:-->
				<?php
					if ( !$stmt->execute() )
					{
						//echo ( '<span class="label label-danger">' . htmlentities( $stmt->error ) . '</span>' );
						return;
					}
					else
					{
						//echo '<span class="label label-success">Success</span>';
					}
				?>
			</p>

			<hr />

			<p>
				<!--<h1 style="text-align:left">Results</h1>-->
				<ul class="list-group">
				<?php

					$project_name = null;
					$about_project = null;
					$project_status = null;
					$pl_email = null;
					$project_start = null;
					$project_end = null;
					$project_budget = null;
					$project_leader = null;
					$stmt->bind_result($project_name, $project_status, $about_project,$pl_email,$project_start, $project_end, $project_budget, $project_leader);

					while ( $stmt->fetch() )
					{
						echo '<address>';
						 echo ('<h4><strong> Project: ' . htmlentities($project_name) . '</strong></h4>');
						 echo ('<strong>About: </strong>'. htmlentities($about_project) . '<br>');
						 echo ('<strong>Status: </strong>' . htmlentities($project_status) . '<br>');
						 echo ('<strong>Start Date: </strong>' . htmlentities($project_start) . '<br>');
						 echo ('<strong>End Date: </strong>' . htmlentities($project_end). '<br>');
						 echo ('<strong>Budget:</strong> $' . htmlentities($project_budget) . '.00' .'<br>');
						 echo ('<strong>Want to get involved? Contact:</strong> ' . htmlentities($project_leader) . '<strong> Email: </strong>' . htmlentities($pl_email));
						echo '</address>';
					}

					$stmt->close();

				?>
			</ul>
			</p>

				<p>
					<!--<b>DB Disconnection</b>:-->
					<?php
						//echo ( ( $mysqli->close() )?( '<span class="label label-success">Success</span>' ):( '<span class="label label-danger">Failure</span>' ) );
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
