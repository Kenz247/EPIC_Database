<body>
  <?php
  $foo = 6;
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


<h2> Get student and class info that is working on a project with the company that sent #x email </h2>
  <form method="GET" action="<?php echo htmlentities( $_SERVER['PHP_SELF'] ); ?>">
    <div class="form-group">
      <label for="exampleInput">Enter Doc Id <small>(4 is the only value that has data for it</small>)</label>
        <input type="text" class="form-control" id="exampleInput" name="<?php echo htmlentities( PARAM_NAME ); ?>" placeholder="n/a" value="4">
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
      if ( !is_null( $param) )
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
          echo ('Student Name: '. htmlentitites($sfirst_name) . ' ' . htmlentitites($slast_name));
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



    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    </body>
