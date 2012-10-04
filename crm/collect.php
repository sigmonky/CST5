<?php
$site = (isset($_GET['site'])) ? $_GET['site'] : "cmt.com"; 
$cid = (isset($_GET['cid'])) ? $_GET['cid'] : "cst_crm";

$purl = (isset($_GET['purl'])) ? $_GET['purl'] : null;

$url = "http://funnel.mtvnservices.com/api/v1/" . $site . "/collections/" . $cid . ".json";
echo($url);
$options = array(
	CURLOPT_RETURNTRANSFER=>true,
	CURLOPT_HEADER=>false,
	CURLOPT_FOLLOWLOCATION=>true,
	CURLOPT_ENCODING=>"",
	CURLOPT_AUTOREFERER=>true,
	CURLOPT_CONNECTTIMEOUT=>120,
	CURLOPT_USERAGENT=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5"
);
$ch      = curl_init( $url );
curl_setopt_array( $ch, $options );
$content = curl_exec( $ch );
$err     = curl_errno( $ch );
$errmsg  = curl_error( $ch );
$header  = curl_getinfo( $ch );
curl_close( $ch );
$data = json_decode($content);
$description = $data->Collection->Description;

$post_url = $data->Collection->link[0]->href;

?>

<div class="funnel" data-status="ACTIVE">
	<form id="cst_crm-form" action="submit.php" method="post">
		<div id="descript">Description:<?php echo($description); ?></div>
		<div id="collect">
			<input type="email" id="cst_crm-field-email" name="email" placeholder="Email..." />
			<input type="text" id="cst_crm-field-date_of_birth" name="date_of_birth" placeholder="Birthday..." />
			<input type="number" min="10000" max="999999" id="cst_crm-field-zip" name="zip" placeholder="Zip..." />
			<input type="hidden" name="post_url" value="<?php echo($post_url); ?>"/>
			<input id="cst_crm-submit" value="Submit" type="submit" tabindex="4"></input>
		</div>
		<?php
			if ($purl){
				echo("<div><a href='".$purl."'>Privacy Policy</a></div>");
			}
		?>
	</form>
</div>
