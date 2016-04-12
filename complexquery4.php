<head>
  <?php
  $foo = 9;
    include "header.php";
  ?>
</head>

<body>
  <div class="container" style="padding: 40px 15px">

    <div class="page-header">
      <h1>Complex Query 4</h1>
    </div>
    <p>
      <!--b>DB Connection</b>:-->
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




<p>
<h2>  Get the information for a class that a professor teaches who has the same interest as the student with entered id. </h2>

  <form method="GET" action="<?php echo htmlentities( $_SERVER['PHP_SELF'] ); ?>">
    <div class="form-group">
      <label for="exampleInput">Enter Student Id </label>
        <input type="text" class="form-control" id="exampleInput" name="<?php echo htmlentities( PARAM_NAME ); ?>" placeholder="n/a" value="1">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>


  <?php
    if ( $connected )
    {
  ?>


    <p>
      <!--<b>SQL to Prepare</b>:-->
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
        //  echo '<span class="label label-success">Success</span>';
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
