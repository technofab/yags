<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="it" lang="it" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yags!</title>
<script type="text/javascript" src="highslide/highslide.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
    hs.graphicsDir = 'highslide/graphics/';
</script>
</head>
<body>
<center>
<?php
/***********************************************************************\
*                  						       							*
* Another Great Gallery Script by Fabrizio Alberti alias technofab 		*
* contacts: http://about.me/technofab - email: iltechnofab@gmail.com    *
* Requisites httpd 2.x and PHP 5.x      								*
*								       									*
* Disclaimer:							       							*
* These software are allowed to use under GPL license by technofab     	*
* refer to http://www.gnu.org/licenses/gpl.html			       			*
*								       									*
\***********************************************************************/

//////////////////////// Settings /////////////////////////////////////////////////////////////////////////////
$image_folder = "images";			// Folder where images are stored
$thumbnails_folder = "thumbnails";	// Folder where will create thumbnails
$thumbnails_ratio = 0.1;   			// Thumnails ratio: for example 0.1 equals as reduce size to 10%
$images_per_row = 5;				// Numbers of images per row
$use_highslide = "Y";				// Use or not Highslide.js thumbnail viewer. Correct values are Y or N
$execution_time_limit = 120; 		// Execution time limit sn seconds. 120 seconds should be ok 
///////////////////////////////////////////////////////(///////////////////////////////////////////////////////

/// ---------------------------> Don't modify anything after this line <----------------------------------- ///

$start = time();
$i = 0;

///////////////////////////////////////////// Create thumbnails ///////////////////////////////////////////////

set_time_limit($execution_time_limit);
chdir($image_folder); 
$files = glob('*.{jpg}', GLOB_BRACE);
foreach($files as $file) {
	
	// Get image attributes
	list($width, $height) = getimagesize($file);
	
	// Set thumbnail attributes
	$new_width = $width * $thumbnails_ratio;
	$new_height = $height * $thumbnails_ratio;
	
	// Resample image
	$image_p = imagecreatetruecolor($new_width, $new_height);
	$image = imagecreatefromjpeg($file);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

	// Create single thumbnail
        chdir('..'); 
	imagejpeg($image_p, "thumbnails/$file", 100);
	chdir($image_folder);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////// Create html view for thumbnails /////////////////////////////////////////

$images = glob($thumbnails_folder."*.jpg");
foreach($files as $file) {
$thumb = "'$thumbnails_folder/$file'";
$picture = "'$image_folder/$file'";
if (strtoupper($use_highslide) == "N")
{
echo '<a href='.$picture.'>';
}
else
{
echo '<a href='.$picture.' class="highslide" onclick="return hs.expand(this)">';
};
echo '<img src='.$thumb.' alt="'.$file.'"/>';
echo '</a>&nbsp;&nbsp;';



//////////////////////////////// Put n thumbnails per row as defined in settings //////////////////////////////

$i = $i + 1 ;
if ($i % $images_per_row == 0) {
   // You have displayed a row so break
   echo '<br/>' ;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

$totaltime = time() - $start;
?>
<br/>
<p>
<a href="http://validator.w3.org/check?uri=referer">
<img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /><br/>
</a>
Elaborato in <?php echo $totaltime;?> secondi <br/>
Powered by <a href="http://highslide.com" target="_new">Highslide Js</a>
</p>
</center>
</body>
</html>
