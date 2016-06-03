/*
	Copyright ⓒ AirWater All Rights Reserved.
	작성자 : 이상현
	이메일 : leesh6796@gmail.com
	소유 : AirWater
*/

var contentType = 'application/x-www-from-urlencoded'; // Content Type

var ajaxValueSave = '';

function Encrypt(text)
{
	return escape(encodeURIComponent(text), false);
}

/*
	get[POST/GET] : 동기식으로 데이터 전송
	send[POST/GET] : 비동기식으로 데이터 전송
*/

// data ex:) header=useWidget&meme=a
function getPOST(url, data)
{
	var returnValue = $.ajax({
			type: "POST",
			url: url,
			data: data,
			async: false,
		}).responseText;

	return returnValue;
}

function getGET(url, data)
{
	var returnValue = $.ajax({
			type: "GET",
			url: url,
			data: data,
			async: false,
		}).responseText;

	return returnValue;
}

// Send 메서드들은 데이터를 JSON 방식으로 넘겨야 한다.
function sendPOST(url, data, success, error)
{
	$.post(url, data, success, error);
}

function sendGET(url, data, success, error)
{
	$.get(url, data, success, error);
}

//그냥 n millis 동안 멈추기
function pause(numberMillis)
{
     var now = new Date();
     var exitTime = now.getTime() + numberMillis;

     while(true)
     {
          now = new Date();
          if (now.getTime() > exitTime)
              return;
     }
}

/*
 * success는 function(msg) { }를 기본으로 함
 * type은 POST와 GET을 뜻함
 * contentType은 기본값 application/x-www-from-urlencoded
 * data는 "name=값&value=값" 이런식으로 사용
*/