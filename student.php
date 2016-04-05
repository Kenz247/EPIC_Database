<body>
  <?php
  $foo = 4;
    include "header.php";
  ?>
  <div class="container" style="padding: 40px 15px">

    <div class="page-header">
      <h1>Students</h1>
    </div>
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

    <p>
      <b>SQL to Prepare</b>:
      <?php

        $sql = null;
          $sql = 'SELECT Student.FirstName as FirstName, Student.LastName as LastName, Student.Email, Major.Name as Major, ' .
            'Project.Name as Project ' .
            'From Student inner join Major on Student.Major_ID = Major.ID inner join Student_Works_on on Student.Id = Student_Works_on.StudentId ' .
            'inner join Project on Project.ID = Student_Works_on.ProjectId ';
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
      <h1>Student</h1>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Major</th>
              <th>Project Name</th>
          </thead>
          <tbody>
      <?php
        $inc = 1;
        $firstName = null;
        $lastName = null;
        $major = null;
        $project_name = null;
        $email = null;
        $stmt->bind_result($firstName, $lastName, $email, $major, $project_name);

        while ( $stmt->fetch() )
        {
              echo ('<tr>');
              echo ('<th scope="row">' . htmlentities($inc) . '</th>');
              echo ('<td>' . htmlentities($firstName) . '</td>');
              echo ('<td>' . htmlentities($lastName) . '</td>');
              echo ('<td>' . htmlentities($email) . '</td>');
              echo ('<td>' . htmlentities($major) . '</td>');
              echo ('<td>' . htmlentities($project_name) . '</td>');
              echo ('</tr>');
              $inc = $inc + 1;
        }


        $stmt->close();
      ?>
        </tbody>
      </table>
    </p>
    <hr />

    <p>
      <b>DB Disconnection</b>:
      <?php
        echo ( ( $mysqli->close() )?( '<span class="label label-success">Success</span>' ):( '<span class="label label-danger">Failure</span>' ) );
      ?>
    </p>
  </div>

  <?php
    }
  ?>
