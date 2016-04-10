<head>
  <?php
  $foo = 10;
    include "header.php";
  ?>
</head>
<body>
  <div class="container" style="padding: 40px 15px">
    <div class="page-header">
      <h1>What Interests You?</h1>
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

              $sql = 'SELECT Interests.InterestId as interest_id, Interests.Interest as interest_name ' .
                  'FROM Interests ' .
                  'Order by Interests.Interest asc';
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

        <div class="container">
          <form action="interest.php" method="post">

        Select Your Interests<br />

      <?php
        $interest_name = null;
        $interest_id = null;
        $stmt->bind_result($interest_id, $interest_name);
        while ( $stmt->fetch() )
        {
              echo ('<input type="checkbox" name="options[]" value="' . htmlentities($interest_id) . '"/>' . htmlentities($interest_name) . '<br />');
        }
        $stmt->close();
      ?>

    <br />
    <h4>Show similarities with</h4>
    <input type="radio" name="filter" value="1" />Projects<br />
    <input type="radio" name="filter" value="2" />Students<br />
    <input type="radio" name="filter" value="3" />Faculty<br />
    <input type="radio" name="filter" value="4" />Students and Faculty<br />



  <br/>
    <input type="submit" name="formSubmit" value="Submit"   />

    </form>
        <?php
        $interest_list = isset($_POST['options']) ? $_POST['options'] : '';
        $filter = isset($_POST['filter']) ? $_POST['filter'] : '';
        $interest_where = 'Interests.InterestID = ';
        $param = null;
    if(empty($filter)){
      echo("You need to select which similarities you would like to show. <br />");
    }
    else{
      $param = $filter;
      
    }
    if(empty($interest_list))
    {
      echo("You didn't select any interests. <br />");
    }
    else
    {
      $N = count($interest_list);
      for($i=0; $i < $N; $i++)
      {
        if($i < $N-1){
          $interest_where = $interest_where . $interest_list[$i] . ' OR Interests.InterestID = ';
        }
        else{
          $interest_where = $interest_where . $interest_list[$i];
        }
      }
    }
  ?>

  </div>
  <hr />

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
    if(!is_null($param)){
      switch($param){
        case "1": $sql = 'SELECT project.ID, project.Name, project.projectstatus, concat(faculty.FirstName, " ", faculty.LastName) as project_leader ' .
'from project inner join projectinterests on project.ID = projectinterests.ProjectId ' .
'inner join interests on projectinterests.InterestId = interests.InterestID ' .
'inner join faculty on project.LeaderId = faculty.id ' .
'where ' . htmlentities($interest_where) . ';';
        break;
        case "2": $sql = 'SELECT Project.ID, Project.Name, Student.FirstName, Student.LastName, Student.Email ' .
  'from Student inner join student_works_on on student.ID = student_works_on.StudentId ' .
  'inner join project on student_works_on.ProjectId = project.ID ' .
  'inner join studentinterests on student.ID = studentinterests.StudentId ' .
  'inner join interests on studentinterests.InterestId = interests.InterestID ' .
  'where ' . htmlentities($interest_where) . ';';
        break;
        case "3": $sql = 'SELECT Project.ID, Project.Name, faculty.FirstName, faculty.LastName, faculty.Email ' .
        'from faculty inner join faculty_works_on on faculty.ID = faculty_works_on.FacultyId ' .
        'inner join project on faculty_works_on.ProjectId = project.ID ' .
        'inner join facultyinterests on faculty.ID = facultyinterests.FacultyId ' .
        'inner join interests on facultyinterests.InterestId = interests.InterestID ' .
        'where ' . htmlentities($interest_where) . ';';
        break;
        case "4": $sql = 'SELECT Project.ID, Project.Name, Student.FirstName, Student.LastName, Student.Email ' .
  'from Student inner join student_works_on on student.ID = student_works_on.StudentId ' .
  'inner join project on student_works_on.ProjectId = project.ID ' .
  'inner join studentinterests on student.ID = studentinterests.StudentId ' .
  'inner join interests on studentinterests.InterestId = interests.InterestID ' .
  'where ' . htmlentities($interest_where) . ' ' .
  'UNION ' .
  'SELECT Project.ID, Project.Name, faculty.FirstName, faculty.LastName, faculty.Email ' .
  'from faculty inner join faculty_works_on on faculty.ID = faculty_works_on.FacultyId ' .
  'inner join project on faculty_works_on.ProjectId = project.ID ' .
  'inner join facultyinterests on faculty.ID = facultyinterests.FacultyId ' .
  'inner join interests on facultyinterests.InterestId = interests.InterestID ' .
  'where ' . htmlentities($interest_where) . ';';
        break;
        default: $sql = null;
        break;
      }
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


  <p>
    <!--<b>Executing</b>:-->
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


  <p>
    <!--<h1 style="text-align:left">Emails</h1>-->
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <?php
          if($param != 1){
            echo('<th>First Name</th>');
            echo('<th>Last Name</th>');
            echo('<th>Email</th>');
          }
          ?>
          <th>Project Name</th>
          <?php
          if($param == 1){
              echo('<th>Project Status</th>');
              echo('<th>Project Leader</th>');
          }
          ?>
      </thead>
      <tbody>
    <?php
    if($param == 1){
      $inc = 1;
      $project_name = null;
      $project_id = null;
      $project_status = null;
      $leader_name = null;
      $stmt->bind_result($project_id, $project_name, $project_status, $leader_name);

      while ( $stmt->fetch() )
      {
        echo ('<tr>');
        echo ('<th scope="row">' . htmlentities($inc) . '</th>');
        echo ('<td><a href="project.php?stuff=' . htmlentities($project_id) . '">' . htmlentities($project_name).'</a></td>');
        echo('<td>' . htmlentities($project_status).'</a></td>');
        echo ('<td>' . htmlentities($leader_name) . '</td>');
        echo ('</tr>');
        $inc = $inc + 1;
      }
    }
    else{
      $inc = 1;
      $project_name = null;
      $first_name = null;
      $last_name = null;
      $email = null;
      $project_id = null;
      $stmt->bind_result($project_id, $project_name, $first_name, $last_name, $email);

      while ( $stmt->fetch() )
      {
        echo ('<tr>');
        echo ('<th scope="row">' . htmlentities($inc) . '</th>');
        echo ('<td>' . htmlentities($first_name) . '</td>');
        echo('<td>' . htmlentities($last_name).'</a></td>');
        echo ('<td>' . htmlentities($email) . '</td>');
        echo ('<td><a href="project.php?stuff=' . htmlentities($project_id) . '">' . htmlentities($project_name).'</a></td>');
        echo ('</tr>');
        $inc = $inc + 1;
      }
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
</body>
