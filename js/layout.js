String.prototype.replaceAll = function(regExp, replaceStr)
{
	var ori = this;

	while(true)
	{
		if(ori.indexOf(regExp) < 0)
		{
			break;
		}

		ori = ori.replace(regExp, replaceStr);
	}

	return ori;
}

function isPC()
{
	var agent = navigator.userAgent.toLowerCase();
	var filter = new Array('android','iphone','ipad');

	for(var i=0; i<filter.length; i++)
	{
		if(agent.indexOf(filter[i]) != -1)
			return 0;
	}
	return 1;
}

function layout()
{
	if(isPC() == 1)
	{
		$('.page').css({'padding-left':'30%','padding-right':'30%'});
	}
	else
	{
		$('.btn').after('<br /><br />');
	}
}

function addOrders()
{
	data = getPOST("process/get.php", {type:'orders'});
	var splitdata = data.split('$');
	var i;

	for(i=0; i<splitdata.length-1; i++)
	{
		var order = splitdata[i].split('#'); // number, n_strawberry, n_banana, price, datetime 순서
		var number = order[0].replaceAll('\n', '');
		var n_strawberry = order[1];
		var n_banana = order[2];
		var price = order[3];
		var datetime = order[4];

		datetime = datetime.replace('-', '월 ').replace(',', '일, ').replace(':', '시 ') + '분';

		var completeURL = 'process/get.php?process=complete&number=' + number;
		var deleteURL = 'process/get.php?process=delete&number=' + number;

		var dom = '<li class=\"list-group-item\"><h4 class=\"list-group-item-heading\">딸기 ' + n_strawberry + '개 바나나 ' + n_banana + '개<a class=\"inListLink\" onclick=\"return confirm(\'완료하시겠습니까?\');\" href=\"' + completeURL + '\">완료</a></h4><p class=\"list-group-item-text\">' + datetime + '   <a onclick=\"return confirm(\'삭제하시겠습니까?\');\" href=\"' + deleteURL + '\">삭제</a></p></li>';

		$('#mainlist').append(dom);
	};
}