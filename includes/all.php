<?php

// ALL (!) ECDB php files must include this file.
// Use a relative path, since that is the same locally and 
// remotely.

error_reporting(E_ALL);
ini_set( 'display_errors','1');

// cache control
  $days = 1;
  $secs = $days * 24 * 60 * 60;
  header("Cache-Control: max-age=$secs"); //30days (60sec * 60min * 24hours * 30days)

//ZOTERO getZot 
//$from = 'keys' or 'tags', $keysOrTags is an array
//returns full html bibliography, and coins data.
function getZot($from='keys', $keysOrTags)
{
    $zot_style = 'elsevier-harvard2';
    $zot_url_base = 'https://api.zotero.org/groups/280824/';
    $zot_bib_url = $zot_url_base . '/items/?v=3&format=bib&style=' . $zot_style; 
    $zot_coins_url = $zot_url_base . '/items/?v=3&format=coins';
    if($from=='keys')
    {
        $suffix = '&itemKey=';
        $glue = ',';
    }
    else if ($from=='tags')
    {
        $suffix = '&tag=';
        $glue = '&tag=';
    }
    else return '';
    $suffix .= implode($glue, $keysOrTags);
    $zot_bib_url .= $suffix;
    $zot_coins_url .= $suffix;
    $zot_data = file_get_contents($zot_bib_url);
    /* remove<?xml version="1.0"?> */
    $zot_data = str_replace('<?xml version="1.0"?>', '', $zot_data);
    $zot_data .= "\n" . file_get_contents($zot_coins_url);
    return $zot_data;
}

//code to guess whether we are remote or local
//and set paths accordingly
if($_SERVER['DOCUMENT_ROOT']=='/var/www/html') //if local linux
{
    $home_path = '/sssoc';
    $config_path = '/var/www/html/mysql.php';
    $repo_path = '/sssoc/repo/';
    $includes = '/var/www/html/sssoc/includes/';
}
else if ($_SERVER['DOCUMENT_ROOT']=='C:/wamp/www/') //if local windows
{
	$home_path = '/sssoc';
	$config_path = '/wamp/www/mysql.php';
	$repo_path = '/sssoc/repo/';
	$includes = '/wamp/www/sssoc/includes/';
}
else //if remote
{
    $home_path = '/sssoc';
    $config_path = '/home1/adamsmit/mysql.php';
    $repo_path = '/sssoc/repo/';
    $includes = '/home1/adamsmit/public_html/sssoc/includes/';
}
?>
