<?php
// You destination directory (i.e) images are to be stored here
$upload_directory = "uploads"; 			
//The full path to the image will be saved
$upload_directory_path = $upload_directory."/";
// The prefix name to large images
$l_img_prefix =  	'';		
// Here you can prefix for the cropped image name
$thb_image_prefix = "thumb_";	
 // New name of the large image (append the timestamp to the filename)	
$l_img_name = $l_img_prefix.$_POST['filename']; 
// New name of the thumbnail image (append the timestamp to the filename)
$thb_image_name = $thb_image_prefix.$_POST['filename'];    
// Width of thumbnail image
$thb_width = "156";						
// Height of thumbnail image
$thb_height = "156";						
$l_img_location = $upload_directory_path.$l_img_name;
$thb_img_location = $upload_directory_path.$thb_image_name;

if (isset($_POST["filename"]) && file_exists($l_img_location)) {
	//Get the new coordinates to crop the image.
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thb_width/$w;
	$cropped = resizeThumbnailImage($thb_img_location, $l_img_location,$w,$h,$x1,$y1,$scale);
}

function resizeThumbnailImage($thb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);

	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$thb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$thb_image_name,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thb_image_name);  
			break;
    }
	chmod($thb_image_name, 0777);
	return $thb_image_name;
}

?>