<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once("includes/inc_head.php");
require_once("database/DB_Crud.php");
global $page_name, $active_page, $db, $global_user;

$db = new DB_Crud();

if(isset($_GET['page']))
	$page_name = $_GET['page'];

?>
<body class="page-body">

<div class="page-container">

	<?php
	require_once("includes/inc_side_bar_menu.php");
	?>
	<div class="main-content">
		<?php
		require_once("includes/inc_user_navbar.php");
		?>
		<div id="application-content">
			<?php
			error_reporting(E_ALL & ~E_NOTICE);
			if(empty($_GET['page']))
			{
				require_once("views/dashboard/dashboard.php");
			}
			else
			{
				$file_path = "views/".$page_name.".php";
				require_once (file_exists($file_path)? $file_path : "views/error.php");

			}
			?>


		</div>
		<?php
		require_once("includes/inc_footer.php");
		?>

	</div>


</div>

<?php
if(isset($_GET['page']))
{
	$file = $page_name.".php";
	if(file_exists("scripts/".$file))
	{
		include("scripts/".$file);
	}
	if(file_exists("modals/".$file))
	{
		include("modals/".$file);
	}
}

require_once("includes/inc_bottom_scripts.php");

?>


</body>
</html>