<head>
    <?php
    $foo = 5;
      include "header.php";
    ?>
</head>
<body>
  <div class="container" style="padding: 40px 15px">

    <div class="page-header">
      <h1>Departments</h1>
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
          $sql = 'SELECT department.id as Department_Id, department.Name as Department_Name ' .
                  'FROM department ' .
                  'ORDER BY department.name asc;';
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
      <h3>Money Spent by Department</h3>
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
          $sql = 'SELECT department.Name, concat("",round((ifnull(sum(materials.UnitPrice*materials.quantity),0)),2)) ' .
                  'FROM department LEFT JOIN faculty ON department.ID = faculty.DeptId ' .
                  'LEFT JOIN faculty_works_on ON faculty.ID =faculty_works_on.FacultyId ' .
                  'LEFT JOIN project ON faculty_works_on.ProjectId = project.ID ' .
                  'LEFT JOIN materials ON project.ID = materials.ProjectId ' .
                  'WHERE department.id = ? ';
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


    <p>
      <?php
        $department_name = null;
        $money_spent_per_department = null;
        $stmt->bind_result($department_name, $money_spent_per_department);
        while ( $stmt->fetch() )
        {
          echo '<address>';
           echo ('<h3><strong> Deparment Name: ' . htmlentities($department_name) . '</strong></h3>');
           echo('<h4>Amount Spent: $' . htmlentities($money_spent_per_department) . '</h4>');
          echo '</address>';
        }
        $stmt->close();
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
          $sql = 'SELECT project.name, materials.name, concat("",(round(materials.unitprice, 2))), materials.quantity ' .
                  'FROM department INNER JOIN faculty ON department.ID = faculty.DeptId ' .
                  'INNER JOIN faculty_works_on ON faculty.ID =faculty_works_on.FacultyId ' .
                  'INNER JOIN project ON faculty_works_on.ProjectId = project.ID ' .
                  'INNER JOIN materials ON project.ID = materials.ProjectId ' .
                  'WHERE department.id = ? ';
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

    <p>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Project Name</th>
              <th>Material</th>
              <th>Unit Price</th>
              <th>Quantity</th>
          </thead>
          <tbody>

      <?php
        $project_name = null;
        $materials_name = null;
        $unit_price = null;
        $quantity = null;
        $stmt->bind_result($project_name, $materials_name, $unit_price, $quantity);
        while ( $stmt->fetch() )
        {
              echo ('<tr>');
              echo ('<td>' . htmlentities($project_name) . '</td>');
              echo ('<td>' . htmlentities($materials_name) . '</td>');
              echo ('<td> $' . htmlentities($unit_price) . '</td>');
              echo ('<td>' . htmlentities($quantity) . '</td>');
              echo ('</tr>');
        }

        $stmt->close();
      ?>
    </table>
    </p>

    <p>
      <!--<b>DB Disconnection</b>:-->
      <?php
        //echo ( ( $mysqli->close() )?( '<span class="label label-success">Success</span>' ):( '<span class="label label-danger">Failure</span>' ) );
      ?>
    </p>
  </div>

  <?php
    }
  ?>
</div>
      <script src="js/jquery-1.12.0.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <?php include "stolenfooter.php" ?>
</body>
