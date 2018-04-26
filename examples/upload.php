<?php 
include('../../class.upload.php/src/class.upload.php');
$handle = new upload($_FILES["file"]);
if ($handle->uploaded) {
	$handle->file_new_name_body   = time();
	$handle->image_resize         = true;
	$handle->image_x              = 800;
	$handle->image_ratio_y        = true;
	$handle->process('uploads');
	if ($handle->processed) {
		echo 'image resized';
		$handle->clean();
	} else {
		echo 'error : ' . $handle->error;
	}
}