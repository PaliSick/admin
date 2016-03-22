<?php



include("resources/class.database.php");
$database = new Database();


$database->OpenLink();
$tablelist = mysql_list_tables($database->database, $database->link);
while ($row = mysql_fetch_row($tablelist)) {

// fill parameters from form
$class = $table = $row[0];
//$class = $_REQUEST["classname"];

$dir = dirname(__FILE__);

$filename = $dir . "/generated_classes/" . $class . ".class.php";
echo $filename;
// if file exists, then delete it
if(file_exists($filename))
{
unlink($filename);
}

// open file in insert mode
$file = fopen(strtolower($filename), "w+");
$filedate = date("d.m.Y");

$c = "";

$c = "<?php
/*
*
* -------------------------------------------------------
* CLASSNAME:        $class
* GENERATION DATE:  $filedate
* CLASS FILE:       $filename
* FOR MYSQL TABLE:  $table
* FOR MYSQL DB:     $database->database
* -------------------------------------------------------
*/

// **********************
// CLASS DECLARATION
// **********************

class $class extends QueryBuilder {


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************

";

$sql = "SHOW COLUMNS FROM $table;";
$database->query($sql);
$result = $database->result;


while ($row = mysql_fetch_row($result)) 
{
$col=$row[0];

if($col!=$key)
{

$c.= "
	protected $$col;";


} // endif
//"print "$col";
} // endwhile

$c.= "

	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	public function $class() {}

";

$c.="
	// **********************
	// GETTER METHODS
	// **********************

";
// GETTER
$database->query($sql);
$result = $database->result;
while ($row = mysql_fetch_row($result)) 
{
$col=$row[0];
$mname = "get" . $col . "()";
$mthis = "$" . "this->" . $col;
$c.="
	public function $mname {
		return $mthis;
	}
";
}


$c.="
	// **********************
	// SETTER METHODS
	// **********************

";
// SETTER
$database->query($sql);
$result = $database->result;
while ($row = mysql_fetch_row($result)) 
{
$col=$row[0];
$val = "$" . "val";
$mname = "set" . $col . "($" . "val)";
$mthis = "$" . "this->" . $col . " = ";
$c.="
	public function $mname {
		$mthis $val;
	}
";
}










$c.= "

}";
fwrite($file, $c);
	}

?>