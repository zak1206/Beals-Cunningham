<?php
ob_start();

$cssStuf = 'HELLO THERE';

include 'inc/header.php';

function add_lazyload_core($content)
{

    $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
    $dom = new DOMDocument();
    @$dom->loadHTML($content);

    // Convert Images
    $images = [];

    foreach ($dom->getElementsByTagName('img') as $node) {
        $images[] = $node;
    }

    foreach ($images as $node) {
        $fallback = $node->cloneNode(true);

        $oldsrc = $node->getAttribute('src');
        $node->setAttribute('data-src', $oldsrc);
        $newsrc = '/images/placeholder.gif';
        $node->removeAttribute('src');

        $oldsrcset = $node->getAttribute('srcset');

        $newsrcset = '';

        $classes = $node->getAttribute('class');
        $newclasses = $classes . ' lozad';
        $node->setAttribute('class', $newclasses);
    }




    $newHtml = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace(array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));
    return $newHtml;
}

function minify_output($input)
{
    return $input;
}

function minify_css($input)
{
    if (trim($input) === "") return $input;
    return preg_replace(
        array(
            // Remove comment(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
            // Remove unused white-space(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
            // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
            '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
            // Replace `:0 0 0 0` with `:0`
            '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
            // Replace `background-position:0` with `background-position:0 0`
            '#(background-position):0(?=[;\}])#si',
            // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
            '#(?<=[\s:,\-])0+\.(\d+)#s',
            // Minify string value
            '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
            '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
            // Minify HEX color code
            '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
            // Replace `(border|outline):none` with `(border|outline):0`
            '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
            // Remove empty selector(s)
            '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
        ),
        array(
            '$1',
            '$1$2$3$4$5$6$7',
            '$1',
            ':0',
            '$1:0 0',
            '.$1',
            '$1$3',
            '$1$2$4$5',
            '$1$2$3',
            '$1:0',
            '$1$2'
        ),
        $input
    );
}
// JavaScript Minifier
function minify_js($input)
{
    if (trim($input) === "") return $input;
    return preg_replace(
        array(
            // Remove comment(s)
            '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
            // Remove white-space(s) outside the string and regex
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
            // Remove the last semicolon
            '#;+\}#',
            // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
            '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
            // --ibid. From `foo['bar']` to `foo.bar`
            '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
        ),
        array(
            '$1',
            '$1$2',
            '}',
            '$1$3',
            '$1.$3'
        ),
        $input
    );
}

$stringog = ob_get_clean();
$header = preg_replace_callback(
    '#{bean}(.*?){\/bean}#',
    "bean_get_extra",
    $stringog
);
$headerout = preg_replace_callback(
    '#{include}(.*?){\/include}#',
    "caffeine_include_get",
    $header
);
$headeroutfin = preg_replace_callback(
    '#{nav}(.*?){\/nav}#',
    "caffeine_include_nav",
    $headerout
);

$thepagePut .= $headeroutfin;

echo minify_output($thepagePut);

?>
<?php

//$info->logVisits($pageDetails[0]["id"]);
$html = str_replace('../../../../img/', 'img/', $pageDetails[0]["page_content"]);

function process_mod($matches)
{
    $info = new site();
    $ars = $matches[1];
    $content = $info->processMod($ars);
    return $content;
}

$html = preg_replace_callback(
    '#{mod}(.*?){/mod}#',
    "process_mod",
    $html
);



function bean_get($matches)
{
    $info = new site();
    $ars = $matches[1];
    $pageDetails = $info->getpageDetails($_REQUEST["pagename"]);
    $content = $info->getBeanItems($ars, $pageDetails[0]["id"]);
    return str_replace('../../img/', 'img/', $content);
}

$html0 = preg_replace_callback(
    '#{bean}(.*?){\/bean}#',
    "bean_get",
    $html
);

function bean_get_extra($matches)
{
    $info = new site();
    $ars = $matches[1];
    $pageDetails = $info->getpageDetails($_REQUEST["pagename"]);
    $content = $info->getBeanItems($ars, $pageDetails[0]["id"]);
    return str_replace('../img', 'img/', $content);
}

$html00 = preg_replace_callback(
    '#{bean}(.*?){\/bean}#',
    "bean_get_extra",
    $html0
);


function caffeine_include_get($matches)
{
    $info = new site();
    $comp = $matches[1];
    $content = $info->getInclude($comp);
    return $content;
}

$htmlout = preg_replace_callback(
    '#{include}(.*?){\/include}#',
    "caffeine_include_get",
    $html00
);


function caffeine_include_nav($matches)
{
    $info = new site();
    $comp = $matches[1];
    $content = $info->getNavigations($comp);
    return $content;
}

$htmlgo = preg_replace_callback(
    '#{nav}(.*?){\/nav}#',
    "caffeine_include_nav",
    $htmlout
);



function location_get($matches)
{
    $info = new site();
    $ars = $matches[1];
    $content = $info->getLocationSmall($ars);
    return $content;
}

$htmlgo = preg_replace_callback(
    '#{locsmall}(.*?){/locsmall}#',
    "location_get",
    $htmlgo
);

function location_get_page($matches)
{
    $info = new site();
    $ars = $matches[1];
    $content = $info->getLocationPage($ars);
    return $content;
}

$htmlgo = preg_replace_callback(
    '#{locpage}(.*?){/locpage}#',
    "location_get_page",
    $htmlgo
);



function form_get($matches)
{
    $info = new site();
    $ars = $matches[1];
    $content = $info->produceForm($ars);
    return $content;
}

$htmlgo = preg_replace_callback(
    '#{form}(.*?){/form}#',
    "form_get",
    $htmlgo
);


function getusedfet($matches)
{
    $info = new site();
    $ars = $matches[1];
    $content = $info->getUsedEquipFet();
    return $content;
}

$htmlgo = preg_replace_callback(
    '#{usedfeatured}MFv30{/usedfeatured}#',
    "getusedfet",
    $htmlgo
);




if ($htmlgo != '') {
    $htmlgo = str_replace("// <![CDATA[", "", $htmlgo);
    $htmlgo = str_replace("<span id=\"CmCaReT\"></span>", "", $htmlgo);
    $htmlgo = str_replace("// ]]>", "", $htmlgo);

    $htmlgoOut = '<div class="body_sets"><div itemscope itemtype="https://schema.org/Blog">';
    $htmlgoOut .= str_replace('../img', 'img', $htmlgo);
    $htmlgoOut .= '</div></div>';

    echo $htmlgoOut;
} else {
    echo '<div class="container"><h1><i class="fa fa-hand-o-right"></i> No Provided Content!</h1><p><strong>Sorry the page that you are looking at does not contain content.</strong> <br>You may click on one of the menu items above to go to a different page.</p></div>';
}




?>


<?php
ob_start();
include 'inc/footer.php';
$string = ob_get_clean();
$footer = preg_replace_callback(
    '#{bean}(.*?){\/bean}#',
    "bean_get_extra",
    $string
);
$footerout = preg_replace_callback(
    '#{include}(.*?){\/include}#',
    "caffeine_include_get",
    $footer
);
$footeroutfin = preg_replace_callback(
    '#{nav}(.*?){\/nav}#',
    "caffeine_include_nav",
    $footerout
);

$footeroutfin = preg_replace_callback(
    '#{form}(.*?){/form}#',
    "form_get",
    $footeroutfin
);

echo minify_output($footeroutfin);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$url = $_SERVER['REQUEST_URI'];
$page = substr($url, strrpos($url, '/') + 1);


$output = preg_replace('/<div class="modal fade">(.+?)<\/div>/s', '', $htmlgo);

$contentSearch = strip_tags(trim($output));
$contentSearch = trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $contentSearch));
$contentSearch = str_replace('Writing guidelines We want to publish your review, so please: Keep your review focused on the product - Avoid writing about customer service; contact us instead if you have issues requiring immediate attention - Refrain from mentioning competitors or the specific price you paid for the product - Do not allow children to operate, ride on or play near equipment Rating Full Name Review Title Email Your Review Submit Review', '', $contentSearch);
$contentSearch = str_replace('× Request a Quote ×', '', $contentSearch);
$contentSearch = str_replace(' Review For ' . $pagename . '', '', $contentSearch);
$contentSearch = str_replace('   Go Back', '', $contentSearch);
//$info->updateSaerch($pagename,$title,$url,$contentSearch);

?>
