<?
session_start();

?>

<? // 변수 선언
$dbid = "";
$dbpw = "";

$dbname = "";
$key = "";

$developeMode = false; // 개발 중일 때만 true로 해둬야 한다.

$price_strawberry = 2500;
$price_banana = 2000;
?>

<?
function redirect($site)
{
	echo "<script>location.href='".$site."';</script>";
}

function alert($message)
{
	echo "<script>alert('".$message."');</script>";
}

// 보안 관련 함수
function GuardInjection($str) // SQL 인젝션 방어
{
	$str = str_replace("\'", "", $str);
	return $str;
}

function removeXSS($content) // XSS 필터링
{
	/* 
	IE6과 7의 expression() 기능을 이용한 취약점을 방지하기 위해
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />를 반드시 붙여야 한다.
	*/

	// 악성 태그들 모두 제거
	$content = preg_replace('/(<)(|\/)(\!|\?|html|head|title|meta|body|script|style|base|noscript|
	form|input|select|option|optgroup|textarea|button|label|fieldset|legend|iframe|embed|object|param|
	frameset|frame|noframes|basefont|applet| isindex|xmp|plaintext|listing|bgsound|marquee|blink|
	noembed|comment|xml)/i', '&lt;$3', $content);

	// 스크립트 핸들러를 모두 제거
	$content = preg_replace_callback("/([^a-z])(o)(n)/i", 
	create_function('$matches', 'if($matches[2]=="o") $matches[2] = "&#111;";
	else $matches[2] = "&#79;"; return $matches[1].$matches[2].$matches[3];'), $content);

	return $content;
}

function protect($str)
{
	// SQL Injection 방어
	$str = str_replace("\'", "", $str);

	// XSS 공격 방어
	/* 
	IE6과 7의 expression() 기능을 이용한 취약점을 방지하기 위해
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />를 반드시 붙여야 한다.
	*/

	// 악성 태그들 모두 제거
	$str = preg_replace('/(<)(|\/)(\!|\?|html|head|title|meta|body|script|style|base|noscript|
	form|input|select|option|optgroup|textarea|button|label|fieldset|legend|iframe|embed|object|param|
	frameset|frame|noframes|basefont|applet| isindex|xmp|plaintext|listing|bgsound|marquee|blink|
	noembed|comment|xml)/i', '&lt;$3', $str);

	// 스크립트 핸들러를 모두 제거
	$str = preg_replace_callback("/([^a-z])(o)(n)/i", 
	create_function('$matches', 'if($matches[2]=="o") $matches[2] = "&#111;";
	else $matches[2] = "&#79;"; return $matches[1].$matches[2].$matches[3];'), $str);

	// 공백 제거
	//$str = str_replace(" ", "", $str);

	return $str;
}
?>