<?php
$menu_title = SW_PROJECT_TITLE;
$menu = array (
	array ( "language" => "en_gb", "report" => ".*\.xml", "title" => "<AUTO>" )
	);
?>
<?php
$menu_title = SW_PROJECT_TITLE;
$menu = array (
	array ( "report" => "<p>In the top menu you can find all the reports that you can view on the screen or download to PDF or CSV.</p><p><a style=\"text-decoration: underline !important\"  target=\"_self\" href=\"http://eapconstruction.com/app/index.php/dashboard\">Go back</a></p>", "title" => "TEXT" ),
	);

$admin_menu = $menu;


$dropdown_menu = array(
                    array ( 
                        "project" => "Payroll",
                        "title" => "Payroll",
                        "items" => array (
							array ( "reportfile" => "General.xml" )
                            )
                        ),
                );
?>