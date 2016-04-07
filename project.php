	<body>
		<?php
		$foo = 2;
			include "header.php";
		?>
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

      <hr />

      <p>
        <h3>Please select a project:</h3>
				<div class="container" align="center">
					<form>
						<select name="stuff" class="form-control" style="width:220px">
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
      <hr />

			<p>
				<!--<b>DB Disconnection</b>:-->
				<?php
					//echo ( ( $mysqli->close() )?( '<span class="label label-success">Success</span>' ):( '<span class="label label-danger">Failure</span>' ) );
				?>
			</p>

		<?php
			}
		?>
		<hr />

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

			<hr />

			<p>
				<!--<b>SQL to Prepare</b>:-->
				<?php

					$sql = null;
					if ( !is_null( $param ))
					{
						$sql = 'SELECT project.Name as Project_Name, project.ProjectStatus as Project_Status, ' .
						'project.About as about_project, '.
						'project.StartDate as Start_Date, project.EndDate as EndDate, project.Budget as Budget, ' .
						'concat(faculty.LastName, ", ", faculty.FirstName) as Project_Leader ' .
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
					$project_start = null;
					$project_end = null;
					$project_budget = null;
					$project_leader = null;
					$stmt->bind_result($project_name, $project_status, $about_project, $project_start, $project_end, $project_budget, $project_leader);

					while ( $stmt->fetch() )
					{
						echo '<address>';
						 echo ('<strong> Project: ' . htmlentities($project_name) . '</strong><br>');
						 echo ('About: '. htmlentities($about_project) . '<br>');
						 echo ('Status: ' . htmlentities($project_status) . '<br>');
						 echo ('Start Date: ' . htmlentities($project_start) . '<br>');
						 echo ('End Date: ' . htmlentities($project_end). '<br>');
						 echo('Budget: ' . htmlentities($project_budget) . '<br>');
						 echo('Project Leader: ' . htmlentities($project_leader) . '<br>');
						echo '</address>';
					}

					$stmt->close();

				?>
			</ul>
			</p>

			<hr />
			<hr />

				<hr />

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
	</body>
</html>
