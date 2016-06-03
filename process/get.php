<?
session_start();
include_once("SQL.class.php");
include_once("method.php");

if($_POST["type"] == null && $_GET["process"] == null)
{
	alert("정상적인 방법으로 접근해주세요");
	redirect("../index.php");
}

$type = protect($_POST["type"]);
$process = protect($_GET["process"]);

$sql = new SQL($dbid, $dbpw, $dbname);
$sql->execute("SET NAMES utf8");

// POST로 받은 명령
if($type == "orders") // 등록한 사이트 리스트 반환
{
	$query = $sql->execute("select * from crepe where complete='F' order by number;");
	$sendData = "";

	while($row = mysql_fetch_array($query))
	{
		$sendData = $sendData.$row["number"]."#".$row["n_strawberry"]."#".$row["n_banana"]."#".$row["price"]."#".$row["datetime"]."$";
	}
	echo $sendData;
}
else if($type == "result")
{
	$query = $sql->execute("select * from crepe");

	$n_strawberry = 0;
	$n_banana = 0;
	$price = 0;

	while($row = mysql_fetch_array($query))
	{
		$n_strawberry += (int)$row["n_strawberry"];
		$n_banana += (int)$row["n_banana"];
		$price += (int)$row["price"];
	}
	echo $n_strawberry."$".$n_banana."$".$price."$";
}

// GET으로 받은 명령
$number = $_GET["number"];

if($process == "complete")
{
	$query = $sql->execute("update crepe set complete='T' where number=".$number);
}
else if($process == "delete")
{
	$query = $sql->execute("delete from crepe where number=".$number);
}
else if($process == "add")
{
	$n_strawberry = $_GET["n_strawberry"];
	$n_banana = $_GET["n_banana"];

	if($n_strawberry == "" && $n_banana == "")
	{
		redirect("../neworder.html");
	}
	else
	{
		if($n_strawberry == "")
			$n_strawberry = 0;
		if($n_banana == "")
			$n_banana = 0;

		$price = (int)$n_strawberry * $price_strawberry + (int)$n_banana * $price_banana;
		$datetime = date("n-j,G:i");

		$query = $sql->execute("insert into crepe(n_strawberry, n_banana, price, datetime) values(".$n_strawberry.",".$n_banana.",".$price.",'".$datetime."');");
	}
}

redirect("../index.html");


?>