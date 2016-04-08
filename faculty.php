<?php
$foo = 3;
  include "header.php";
define( 'PARAM', 'var1' );
$var1 = '';
if ( isset( $_GET[ PARAM ] ) )
{
  $var1 = trim( $_GET[ PARAM ] );
  if ( empty( $param ) )
  {
    $var1 = null;
  }
}
 ?>

	<body>
		<div class="container" style="padding: 40px 15px" align="left">

			<div class="page-header" align="left">
				<h1>Faculty</h1>
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

						    $sql = 'SELECT project.Name as project_name, faculty.lastName,faculty.firstname, faculty.Email ' .
                    'FROM faculty INNER JOIN faculty_works_on ON faculty.id=faculty_works_on.facultyid ' .
                    'INNER JOIN project ON project.id=faculty_works_on.projectId ' .
                    'order by project.name asc, faculty.lastName asc';



						//echo ( '<code>' . htmlentities( $sql ) . '</code>' );

					?>
				</p>
        <hr/>
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
        <h1>Who is working on projects? <small>(Some people might not have sent emails)</small></h1>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Project Name</th>
            </thead>
            <tbody>
        <?php
          $inc = 1;
          $first_name= null;
          $last_name=null;
          $major = null;
          $project_name = null;
          $email = null;
          $stmt->bind_result($project_name, $last_name,$first_name, $email);
          while ( $stmt->fetch() )
          {
                echo ('<tr>');
                echo ('<th scope="row">' . htmlentities($inc) . '</th>');
                echo ('<td>' . htmlentities($first_name) . '</td>');
                echo('<td><a href="faculty.php?var1=' . htmlentities($last_name) . '">' . htmlentities($last_name).'</a></td>');
                echo ('<td>' . htmlentities($email) . '</td>');
                echo ('<td>' . htmlentities($project_name) . '</td>');
                echo ('</tr>');
                $inc = $inc + 1;
          }
          $stmt->close();
        ?>
          </tbody>
        </table>
    </p>


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
                $sql = 'SELECT project.Name as Project_Name, emails.Content as Content, emails.Sender as "From", emails.Recipient as "To" ' .
                      'from emails inner join project on project.ID = emails.ProjectId ' .
                      'where emails.Sender = ( ' .
                      'SELECT faculty.Email ' .
                      'from faculty ' .
                      'WHERE faculty.LastName like ? ' .
                      ') ' .
                      'ORDER by project.Name desc, emails.Recipient desc';
              }

              //echo ( '<code>' . htmlentities( $sql ) . '</code>' );

            ?>
          </p>

          <p>
            <!--b>Preparing</b>:-->
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
            if ( !is_null( $var1 ) )
            {
          ?>
            <p>
              <!--<b>Binding parameter</b>:-->
              <?php
                if ( !$stmt->bind_param( "s", $var1 ) )
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


          <p>
            <!--<h1 style="text-align:left">Emails</h1>-->
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
                echo ('<h2>Emails</h2>');
                 echo ('<strong> Project: ' . htmlentities($project_name) . '</strong><br>');
                 echo ('From: ' . htmlentities($from) . '<br>');
                 echo ('To: ' . htmlentities($to) . '<br><br>');
                 echo (nl2br(htmlentities($content)). '<br>');
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
			<?php
				}
			?>
	</div>

</div>

	<script src="js/jquery-1.12.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<?php include "stolenfooter.php" ?>
	</body>
