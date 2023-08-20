<?php
// Start a session
session_start();

// Define script wide variables
include("../vars.php");

// Connect to Database
require_once("../db_connect.php");

// Load script functions

require("../functions.php");
require("usrfunctions.php");



// Check if the user is logged in
if (isset($_SESSION["username"])) {
    // User is logged in, Display page header

    echo (getContent("head2"));
?>
<table align="center" width="50%"  border="0" class="table_style">
<tr>
<td colspan=4><h2 style="text-align:center; color:blue;">Directory Submit Options</h2></td>
</tr>
<tr>
<td> option 1 </td>
<td> option 2 </td>
<td> option 3 </td>
<td> option 4 </td>
</tr>
</table>
<?php
    echo (getContent("foot2"));
} else {
    // User is not logged in, go to login
    header("Location: /login.php");
    exit();
}
?>