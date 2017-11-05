<?PHP
/*
This is the connection DB script and settings.

This file should be above the projects files root.

modify the requier settings in the pages.
*/ 



DEFINE ('DB_USER', 'your_db_user_name');
DEFINE ('DB_PASSWORD', 'your_db_password');
DEFINE ('DB_HOST', 'your_host');
DEFINE ('DB_NAME', 'your_db_name');


// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$dbc) {
trigger_error ('Could not connect to MySQL: ' . mysqli_connect_error() );
echo "not connected";
}else{
//echo "connected";
}
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

?>