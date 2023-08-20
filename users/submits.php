<?php
// Start a session
session_start();

// Define script wide variables
include("../vars.php");

// Connect to Database
require_once("../db_connect.php");

include_once 'pagination-sub.php';
$pagination = new paginate_1($conn);
// Load script functions

require("../functions.php");
require("usrfunctions.php");



// Check if the user is logged in
if (isset($_SESSION["username"])) {
    // User is logged in, Display page header

    echo (getContent("head2"));
    echo "<br />A list of your paid submissions :";
?>
<table align="center" width="50%"  border="0" class="table_style">
<tr>
<td><h2 style="text-align:center; color:blue;">User Submissions</h2></td>
</tr>
<tr>
<td>

	<table align="center" border="1" width="100%" height="100%" id="data">
	<tr style="text-align:center; color:blue; font-size:20px;">
		<td align="left">Url</td>
		<td align="left">title</td>
		<td align="left">typesub</td>
	</tr>
	<?php 
		$query = "SELECT * FROM url_subs";       
		$data_per_Page=5;
		$query_1 = $pagination->paging($query,$data_per_Page);
		$pagination->dataview($query_1);
		$pagination->paginglink($query,$data_per_Page);  
	?>
	</table>

</td>
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




echo "<br />A list of users paid submissions :";

    echo (getContent("admnft"));
} else {
    // User is not logged in, go to login
    header("Location: ./login.php");
    exit();
}
?>