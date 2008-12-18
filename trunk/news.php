<?php
include_once('start.php');

// FUNCTIONALITY
$j = md5($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);
$feed = checkcache($j);
if(!$feed) {
	include_once('Classes/simplepie.php');
	$simplepie = new SimplePie;
	$url = 'http://www.google.com/news?sourceid=navclient-ff&rlz=1B3GGGL_enIN279IN280&hl=en&ned=us&q='.urlencode($_GET['keyword']).'&ie=UTF-8&nolr=1&output=rss';
	$simplepie->set_feed_url($url);
	$simplepie->init();
	$dig_feed = $simplepie;
	$feed = "<ul>";
	if($dig_feed) {
		foreach($dig_feed->get_items() as $item) {
			$feed .= "<li><a href='" .$item->get_link() . "' target='_blank'>" . $item->get_title() . "</a><br />";
			$desc = str_replace("<a ", "<a target='_blank' ", $item->get_description());
			$feed .= $desc."
			</li>";
		}
	}
	$feed .= "</ul>";
	cachefunction($j, $feed);
	$cache = 'no cache';
} else {
	$cache = 'cache';
}
?>
<h1><?php echo ucwords($_GET['keyword']); ?> :: News</h1>
<?php 
echo $feed;
?><!-- #BeginLibraryItem "/Library/endtime.lbi" --><?php
$TIMEEND = microtime(true);
$time = $TIMEEND - $TIMESTART;

echo "<br /><br /><br /><br /><div align='right'><b>Time To Load:</b> $time seconds ($cache)</div>";
?><!-- #EndLibraryItem --><p>&nbsp;</p>