<?php
$content = file_get_contents('./bookmarks.html');

$pattern = "/<A.*<\/A>/i";

preg_match_all($pattern,$content,$arr);

foreach( $arr[0] as $link )
{
	//var_dump($link);
	#$pattern = "/href=\"(.*)\"? ADD_DATE/i";
	$pattern = "/http.*\"? ADD_DATE/i";
	preg_match($pattern,$link,$urls);
	$url = str_replace('" ADD_DATE','',$urls[0]);
	$pattern = "/>.*<\/a>$/i";
	preg_match($pattern,$link,$titles);
	
	$title = str_replace('>','',$titles[0]);
	$title = str_replace('</A','',$title);
	//echo $url;
	//exit;
	echo $title.' - '.$url."<br />";
	//echo 'dsd';
}