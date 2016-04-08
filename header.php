<?php

  ///////////////////////////////////////////////////
  // CHANGE THESE VALUES AS NECESSARY
  ///////////////////////////////////////////////////

  define( 'DB_SERVER', 'localhost' );
  define( 'DB_USER',   'root' );
  define( 'DB_PW',	 '' );
  define( 'DB_NAME',   'epic' );

  ///////////////////////////////////////////////////

  define( 'PARAM_NAME', 'email_address' );

  $param = 'Email';
  if ( isset( $_GET[ PARAM_NAME ] ) )
  {
    $param = trim( $_GET[ PARAM_NAME ] );
    if ( empty( $param ) )
    {
      $param = null;
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EPIC</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="57x57" href="./apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="./favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="./android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="./favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="./favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="./manifest.json">
    <link rel="mask-icon" href="./safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="./favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="./mstile-144x144.png">
    <meta name="msapplication-config" content="./browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
  </head>

  <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><img alt="Wentworth Crest" height="25" src="http://www.wit.edu/images/crest.png" width="30"/></a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li
        <?php if($foo == 1){
          echo('class="active"');
        }
        ?>
        ><a href="index.php">Home</a></li>
        <li
        <?php if($foo == 2){
          echo('class="active"');
        }
        ?>><a href="project.php">Projects</a></li>
        <li
        <?php if($foo == 3){
          echo('class="active"');
        }
        ?>><a href="faculty.php">Faculty</a></li>
        <li
        <?php if($foo == 4){
          echo('class="active"');
        }
        ?>><a href="student.php">Students</a></li>
        <li
        <?php if($foo == 5){
          echo('class="active"');
        }
        ?>
        ><a href="complexquery1.php">Departments</a></li>
        <li
        <?php if($foo == 6){
          echo('class="active"');
        }
        ?>
        ><a href="complexquery2.php">Query2</a></li>
        <li
        <?php if($foo == 7){
          echo('class="active"');
        }
        ?>
        ><a href="complexquery3.php">Query3</a></li>
        <li
        <?php if($foo == 8){
          echo('class="active"');
        }
        ?>
        ><a href="complexquery4.php">Query4</a></li>
        <li
        <?php if($foo == 9){
          echo('class="active"');
        }
        ?>
        ><a href="contact.php">Contact</a></li>
        <li
        <?php if($foo == 10){
          echo('class="active"');
        }
        ?>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
