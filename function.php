<?
if(!isset($_SESSION)) 
{
	session_start(); 
} 
function check_login()
{
	
        if(!isset($_SESSION['authenticated']) || $_SESSION['authenticated']!=true)
        {
               	header("Location: login.php");
               	exit;
        }
	return true;
}
?>
