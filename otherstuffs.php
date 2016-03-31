<body>
  <?php
  $foo = 5;
    include "header.php";
  ?>
  <div class="container" style="padding: 40px 15px">

    <div class="page-header">
      <h1>Other Stuffs aka Complex Queries!!</h1>
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
          $sql = 'SELECT department.id as Department_Id, department.Name as Department_Name ' .
                  'FROM department ' .
                  'ORDER BY department.name asc;';
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
      <h1>Money being spent by each department</h1>
      <div class="container" align="center">
        <form>
          <select name="stuff" class="form-control" style="width:200px">
      <?php
        $departmnet_name = null;
        $department_id=null;
        $stmt->bind_result($department_id, $department_name);
        while ( $stmt->fetch() )
        {
            echo ('<option value=' . htmlentities($department_id) . ' text-align:center>' . htmlentities($department_name) . '</value>');
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

  <?php
    }
  ?>
  <hr />

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
          $sql = 'SELECT department.Name, ifnull(sum(materials.UnitPrice),0) ' .
                  'FROM department LEFT JOIN faculty ON department.ID = faculty.DeptId ' .
                  'LEFT JOIN faculty_works_on ON faculty.ID =faculty_works_on.FacultyId ' .
                  'LEFT JOIN project ON faculty_works_on.ProjectId = project.ID ' .
                  'LEFT JOIN materials ON project.ID = materials.ProjectId ' .
                  'WHERE department.id = ? ';
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
      <h1 style="text-align:left"><small>Results</small></h1>
      <ul class="list-group">
      <?php
        $department_name = null;
        $money_spent_per_department = null;
        $stmt->bind_result($department_name, $money_spent_per_department);
        while ( $stmt->fetch() )
        {
          echo '<address>';
           echo ('<strong> Deparment Name: ' . htmlentities($department_name) . '</strong><br>');
           echo('Amount Spent: $' . htmlentities($money_spent_per_department) . '<br>');
          echo '</address>';
        }
        $stmt->close();
      ?>
    </ul>
    </p>

    <?php
      }
    ?>
</div>

<p>
<h2> Get student and class info that is working on a project with the company that sent #x email </h2>

  <form method="GET" action="<?php echo htmlentities( $_SERVER['PHP_SELF'] ); ?>">
    <div class="form-group">
      <label for="exampleInput">Enter Doc Id</label>
        <input type="text" class="form-control" id="exampleInput" name="<?php echo htmlentities( PARAM_NAME ); ?>" placeholder="n/a" value="<?php echo htmlentities( ( is_null( $param ) )?( '' ):( $param ) ) ?>">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>

  <hr />

  <?php
    if ( $connected )
    {
  ?>

    <hr />

    <p>
      <b>SQL to Prepare</b>:
      <?php
        $sql = null;
        if ( !is_null( $param ) )
        {
          $sql = 'select student.FirstName as First_Name, student.LastName as Last_Name, course.Name as Course_name, ' .
                'section.CourseNum as Course, section.SecNum as section, concat(faculty.FirstName, " ", faculty.lastName) as Prof_Name ' .
                'from student inner join studenttakes on student.ID = studenttakes.StudentId ' .
                'inner join section on studenttakes.CourseNum = section.CourseNum AND studenttakes.SecNum = section.SecNum ' .
                'inner join course on course.courseNum=section.courseNum ' .
                'inner join project on section.ProjectId = project.ID ' .
                'inner join faculty on faculty.id=section.profid ' .
                'WHERE project.ID = ( ' .
                  'select project.ID ' .
                  'from project inner join company_collaborates_on on project.ID = company_collaborates_on.ProjectId ' .
                  'inner join company on company_collaborates_on.CompanyId = company.ID ' .
                  'inner join contact on contact.ID = company.ContactId ' .
                  'where contact.ID = ( ' .
                    'select contact.ID ' .
                    'from contact ' .
                    'where contact.Email = ( ' .
                      'select emails.Sender ' .
                      'from emails ' .
                      'where emails.DocID = ? ' .
                      ') ' .
                    ') ' .
                  '); ';
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
      <h1>Results</h1>
      <ul class="list-group">
      <?php
        $sfirst_name = null;
        $slast_name = null;
        $course_name = null;
        $course_num=null;
        $course_section=null;
        $prof_name=null;
        $stmt->bind_result( $sfirst_name, $slast_name, $course_name, $course_num, $course_section, $prof_name);
        while ( $stmt->fetch() )
        {
          echo '<li class="list-group-item">';
          echo ( '<strong> Course Name: </strog>' . htmlentities( $course_name) . '<br>' );
          echo ( 'Course Number: '. htmlentities( $course_num ) . '-'. htmlentities($sec_num));
          echo ( ' Professor: ' .  htmlentities($prof_name) . '<br>');
          echo ('Student Name: '. htmlentitites($sfirst_name . " " . $slast_name));
          echo '</li>';
        }
        $stmt->close();
      ?>
    </ul>
    </p>

    <hr />

  <?php
    }
  ?>
</div>
</p>

<p>
<h2>  Get the information for a class that a professor teaches who has the same interest as the student with entered id. </h2>

  <form method="GET" action="<?php echo htmlentities( $_SERVER['PHP_SELF'] ); ?>">
    <div class="form-group">
      <label for="exampleInput">Enter Student Id</label>
        <input type="text" class="form-control" id="exampleInput" name="<?php echo htmlentities( PARAM_NAME ); ?>" placeholder="n/a" value="<?php echo htmlentities( ( is_null( $param ) )?( '' ):( $param ) ) ?>">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>

  <hr />

  <?php
    if ( $connected )
    {
  ?>

    <hr />

    <p>
      <b>SQL to Prepare</b>:
      <?php
        $sql = null;
        if ( !is_null( $param ) )
        {
          $sql = 'Select course.Name as Course_Name, section.SecNum as Section_Number, section.CourseNum as Course_Number ' .
                  'from section inner join course on section.CourseNum = course.CourseNum ' .
                  'where section.ProfId = ( ' .
                    'select section.ProfId ' .
                    'from section inner join faculty on section.ProfId = faculty.ID ' .
                    'where faculty.ID = ( ' .
                      'SELECT faculty.ID ' .
                      'from faculty INNER JOIN facultyinterests on facultyinterests.FacultyId = faculty.ID ' .
                      'inner join interests on facultyinterests.InterestId = interests.InterestID ' .
                      'where interests.Interest = ( ' .
                        'SELECT interests.Interest ' .
                        'from interests inner join studentinterests on interests.InterestID = studentinterests.InterestId ' .
                        'inner join student on studentinterests.StudentId = student.ID ' .
                        'WHERE student.ID = ? ' .
                        ') ' .
                      ') ' .
                    ') ' .
                    'order by section.CourseNum asc, section.SecNum asc; ' ;
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
      <h1>Results</h1>
      <ul class="list-group">
      <?php
        $course_name = null;
        $sec_num = null;
        $course_num = null;
        $stmt->bind_result( $course_name, $sec_num, $course_num);
        while ( $stmt->fetch() )
        {
          echo '<li class="list-group-item">';
          echo ( '<strong> Course Name: </strog>' . htmlentities( $course_name) . '<br>' );
          echo ( 'Course Number: '. htmlentities( $course_num ) . '-'. htmlentities($sec_num) .'<br>' );
          echo '</li>';
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
</p>



<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
