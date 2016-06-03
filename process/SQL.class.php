<?
// SQL 관련 함수
class SQL
{
	var $con;

	function SQL($_LoginID, $_LoginPW, $dbname)
	{
		$this->con = mysql_connect("localhost", $_LoginID, $_LoginPW);
		mysql_select_db($dbname, $this->con);

		mysql_query("set names euckr");
	}

	function execute($sql)
	{
		return mysql_query($sql);
	}

	function close()
	{
		global $con;

		mysql_close($this->con);
	}
}
?>