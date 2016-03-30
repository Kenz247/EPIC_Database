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

    <p>
      <b>DB Disconnection</b>:
      <?php
        echo ( ( $mysqli->close() )?( '<span class="label label-success">Success</span>' ):( '<span class="label label-danger">Failure</span>' ) );
      ?>
    </p>

  <?php
    }
  ?>
  <hr />

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
</html>
