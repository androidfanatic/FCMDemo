<?php

require_once ( 'config.php' );

require_once ( 'fcm_class.php' );

require_once ( 'db_class.php' );

$DASHBOARD = 1;

?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Push Notification Dashboard</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1; user-scalable=no">
        
        <style type="text/css">
            .navbar { border-radius: 0px; }
        </style>
        
    </head>
    
    <body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand active" href="#">
        Push Notification Dashboard
      </a>
    </div>
  </div>
</nav>
        
        <div class="container-fluid">
        
        
            <div class="row">
                <div class="col-xs-3">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Push Notification</strong></li>
                        <li class="list-group-item">
                            <a href="?tab=all">
                                All Devices
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="?tab=single">
                                Single Device
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="?tab=random">
                                Random Devices
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-9">
                    <ul class="list-group">
                        <li class="list-group-item">
<?php

$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';

if ( $tab == '' || $tab == 'all' ) {
    
    include_once( 'tabs_all.php' );
    
} else if ( $tab == 'single' ) {

    include_once( 'tabs_single.php' );
    
} else if ( $tab == 'random' ) {

    include_once( 'tabs_random.php' );
}
?>

                            
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
    </body>
</html>
