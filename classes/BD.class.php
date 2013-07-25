<?php
class BD
{
	private static $conn;
	public function __contruct(){}
	
	public function conn(){
		if(is_null(self::$conn))
		{
			self::$conn = new PDO('mysql:host='.HOST.'; dbname='.DB.'',''.USER.'',''.PASS.'');
		}
		return self::$conn;
	}
}

?>