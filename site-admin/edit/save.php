<?php
error_reporting(0);
define('MAX_FILE_LIMIT', 1024 * 1024 * 2);//2 Megabytes max html file size

function sanitizeFileName($fileName)
{
	//sanitize, remove double dot .. and remove get parameters if any
	$fileName = __DIR__ . '/' . preg_replace('@\?.*$@' , '', preg_replace('@\.{2,}@' , '', preg_replace('@[^\/\\a-zA-Z0-9\-\._]@', '', $fileName)));
	return $fileName;
}

function updateImgLinks($img,$content)
{
    $secureImg = str_replace('http://', 'https://', $img);
    preg_match('~<img.*?url=["\']+(.*?)["\']+~', $img, $result);
    if($result[1] != '') {
        $linkedImg = '<a href="' . $result[1] . '">' . $img . '</a>';
    }else{
        $linkedImg = $img;
    }
    $productDesc = str_replace($img, $linkedImg, $content);

    return $productDesc;
}



$html = "";
if (isset($_POST['startTemplateUrl']) && !empty($_POST['startTemplateUrl'])) 
{
	$startTemplateUrl = sanitizeFileName($_POST['startTemplateUrl']);
	$html = file_get_contents($startTemplateUrl);
} else if (isset($_POST['html']))
{
	$html = substr($_POST['html'], 0, MAX_FILE_LIMIT);
}

$fileName = sanitizeFileName($_POST['fileName']);

///echo "This is ".$html;
///

include('../inc/harness.php');

$pageOn = $_REQUEST["pageon"];

echo $pageOn;

preg_match("/<body[^>]*>(.*?)<\/body>/is", $html, $matches);

$htmlBody = $matches[1];
$htmlBodyEdits = $matches[1];

preg_match_all('/<img[^>]+>/i', $htmlBody, $images);
$i=0;
$imgCount = count($images[0]);
$dataOut = '';
foreach ($images[0] as $image) {
$content = updateImgLinks($image,$htmlBody);
$GLOBALS['htmlBody'] = $content;


$i++;
}

if($dataOut != ''){
    $dataOut = $htmlBodyEdits;
}else{
    $dataOut = $htmlBody;
}


$str = preg_replace('/^[ \t]*[\r\n]+/m', '', $dataOut);
$strw = preg_replace('/^[ \t]*[\r\n]+/m', '', $htmlBodyEdits);
$stripped = preg_replace('/\s+/', ' ', $str);
$stripped = str_replace('contenteditable="true" spellcheckker="false"','',$stripped);
$stripped2 = preg_replace('/\s+/', ' ', $strw);
$stripped2 = str_replace('contenteditable="true" spellcheckker="false"','',$stripped2);



include('../inc/caffeine.php');
$site = new caffeine();
$site->saveIntpage($pageOn,$stripped,$stripped2,'page');



$data->query("UPDATE pages SET page_content = '".$data->real_escape_string($stripped)."', content_edit = '".$data->real_escape_string($stripped2)."' WHERE id = '$pageOn'")or die($data->error);

//if (file_put_contents($fileName, $html))
//	echo $fileName;
//else
//	echo 'Error saving file '  . $fileName;
