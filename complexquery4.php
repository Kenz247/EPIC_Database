<body>
  <?php
  $foo = 5;
    include "header.php";
  ?>
  <div class="container" style="padding: 40px 15px">

    <div class="page-header">
      <h1>Other Stuffs aka Complex Queries!!</h1>
      <h3>List the materials that were used by a department that has no chair.</h3>
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
          $sql = 'select materials.name as Material_Name, materials.quantity as Quantity, materials.unitprice as Unit_Price, project.name as Project_name '.
          'from materials inner join project on project.ID = materials.ProjectId where project.ID = ( select project.ID from project inner join faculty_works_on '.
          'on project.ID = faculty_works_on.ProjectId inner join faculty on faculty.ID = faculty_works_on.FacultyId left outer join department on faculty.DeptId = department.ID '.
          'where department.DeptHead is NULL ) order by materials.UnitPrice desc, materials.QUANTITY ASC';
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
    <p>
      <h1 style="text-align:left">Results <small>(All departments currenty have heads so query returns nothing)</small></h1>
      <ul class="list-group">
      <?php
        $mat_name = null;
        $quantity = null;
        $unit_price = null;
        $project_name = null;
        $stmt->bind_result($mat_name, $quantity, $unit_price, $project_name);
        while ( $stmt->fetch() )
        {
          echo '<address>';
           echo ('<strong> Material Name: ' . htmlentities($mat_name) . '</strong><br>');
           echo('Quantity: ' . htmlentities($quantity) . '<br>');
           echo('Unit Price: $' . htmlentities($unit_price) . '<br>');
           echo('Project: ' . htmlentities($project_name) . '<br>');
          echo '</address>';
        }
        $stmt->close();
      ?>
    </ul>
    </p>


        <hr />
<?php } ?>
        <p>
          <b>DB Disconnection</b>:
          <?php
            echo ( ( $mysqli->close() )?( '<span class="label label-success">Success</span>' ):( '<span class="label label-danger">Failure</span>' ) );
          ?>
        </p>

    </div>
