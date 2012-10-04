<html>
<head>
<script src="zepto.min.js"></script>
<script>

var urlA = "http://squid.jp.mtvnservices.com/jp/mobile-app-wrapper?q={%22select%22:{%22mtvi:id|Title|Description%22:1,%22Items%22:{%22*%22:1,%22MobileApplicationReferences%22:{%22*%22:1,%22Image%22:{%22*%22:1},%22Platforms%22:{%22*%22:1}}}},%22where%22:{%22byId%22:[%227cb0eea8-8d8b-426f-9ad1-4aa5b91c7322%22]}}&indent=true";

var urlB = "http://mongo-arc-v2.mtvnservices.com/jp/mobile-app-wrapper?q=%7b%22select%22:%7b%22mtvi:id|Title|Description%22:1,%22Items%22:%7b%22mtvi:id|mtvi:contentType|Title|Description%22:1,%22MobileApplicationReferences%22:%7b%22*%22:1,%22Platforms%22:%7b%22*%22:1%7d%7d%7d%7d,%22where%22:%7b%22byId%22:%5b%229fc2b983-1bee-41d2-9381-2f7678922792%22%5d%7d%7d&indent=true";

function test(url){
	$.getJSON(url, function(data){
		$("#result").html(data);
	});
}

$(function($){ 
	console.log("ready");
});

</script>
</head>

<body>
<button onClick="test(urlA)">Test Squid</button> 
<button onClick="test(urlB)">Test Mongo</button> 

<div id="result"></div>

</body>

</html>











