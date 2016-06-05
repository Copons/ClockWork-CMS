<?php

/*
fileUpload		($file, $folder, $action, $name, $maxFileSize)
imageUpload		($file, $folder, $action, $name, $maxFileSize)
ckImageUpload	()
ckFileUpload	()
imageThumb		($image, $width, $height)
*/

function fileUpload ($file, $folder, $action = '', $name = '', $maxFileSize = 2000000) {

	$redirect = '../../' . $folder . '.php';
	if ($action != '')
		$redirect .= '?action=' . $action;

	$filename = basename($file['name']);

	if (empty($file)) :
		echo '$file is empty';
		die();
	endif;
	if ($file['error'] != 0) :
		echo '$file error: ' . $file['error'];
		die();
	endif;
	if ($file['size'] >= $maxFileSize) :
		echo '$file size exceed max: ' . $file['size'] . ' &gt; ' . $maxFileSize;
	endif;

	if ($name == '') :
		$strippedFilename = ereg_replace("[^A-Za-z0-9\.]", '_', $filename);
	else :
		$ext = end(explode('.', $filename));
		$strippedFilename = ereg_replace("[^A-Za-z0-9\.]", '_', $name . '.' . $ext);
	endif;

	$newName = '../../../uploads/' . $folder . '/' . $strippedFilename;

	if (file_exists($newName)) :
		echo $newName . ' file exists';
		die();
	endif;

	if (move_uploaded_file($file['tmp_name'], $newName)) :
		//echo 'file uploaded_correctly';
		//die();
		return $strippedFilename;
	else :
		echo 'move_uploaded_files failed';
		die();
	endif;

}




// IMAGE UPLOAD
//
// Checks and uploads requested image and returns image's filename
// $file = $_FILE['uploaded_file']
// $folder = image folder
// $action = action page, used for redirecting after an error
// $name = empty by default
// $maxFileSize = default set up to 500KB
function imageUpload ($file, $folder, $action = '', $name = '', $maxFileSize = 2000000) {
	// Setting up the redirection page
	$redirect = '../../' . $folder . '.php';
	if ($action != '')
		$redirect .= '?action=' . $action;
	// Beginning check and upload
	$filename = basename($file['name']);
	if((!empty($file)) && ($file['error'] == 0)) :
		// Check if the file respect the max file size and the allowed file types
		if (($file['type'] == 'image/jpeg' || $file['type'] == 'image/pjpeg' || $file['type'] == 'image/gif' || $file['type'] == 'image/png') && ($file['size'] <= $maxFileSize)) :
			if ($name == '') :
				// Strip non alphanumeric characters from filename
				$strippedFilename = ereg_replace("[^A-Za-z0-9\.]", '_', $filename);
			else :
				// Get file extension
				$ext = end(explode('.', $filename));
				// Strip non alphanumeric characters from filename
				$strippedFilename = ereg_replace("[^A-Za-z0-9\.]", '_', $name . '.' . $ext);
			endif;
			// Determine the path to which we want to save this file
			$newName = '../../../uploads/' . $folder . '/' . $strippedFilename;
			//$absolutePath = 'd:/Inetpub/webs/metaphyxcom/uploads/' . $folder . '/';
			//$newName = $absolutePath . $strippedFilename;
			// Check if the file with the same name is already exists on the server
			if (!file_exists($newName)) :
				//Attempt to move the uploaded file to it's new place
				if (move_uploaded_file($file['tmp_name'], $newName)) :
					// OK! File uploaded correctly!
					return $strippedFilename;
				else :
					// NO! Generic error!
					setError('upload_generic1');
					redirect($redirect);
				endif;
			else :
				// NO! File already exists!
				setError('upload_exists');
				redirect($redirect);
			endif;
		else :
			// NO! File bigger than max size or filetype not allowed!
			setError('upload_not_allowed');
			redirect($redirect);
		endif;
	else :
		// NO! Generic error!
		setError('upload_generic2');
		redirect($redirect);
	endif;
}




function photogalleryUpload ($file, $maxFileSize = 2000000) {

	$redirect = '../../' . $folder . '.php';
	if ($action != '')
		$redirect .= '?action=' . $action;

	$filename = basename($file['name']);

	if (empty($file)) :
		echo '$file is empty';
		die();
	endif;
	if ($file['error'] != 0) :
		echo '$file error: ' . $file['error'];
		die();
	endif;
	if ($file['size'] >= $maxFileSize) :
		echo '$file size exceed max: ' . $file['size'] . ' &gt; ' . $maxFileSize;
	endif;

	$strippedFilename = time() . '-' . ereg_replace("[^A-Za-z0-9\.]", '_', $filename);

	$newName = '../../uploads/photogallery/' . $strippedFilename;

	if (file_exists($newName)) :
		echo $newName . ' file exists';
		die();
	endif;

	if (move_uploaded_file($file['tmp_name'], $newName)) :
		return $strippedFilename;
	else :
		echo 'move_uploaded_files failed';
		die();
	endif;

}




// CK IMAGE UPLOAD
//
// Checks and uploads requested image and returns image's filename (for CKEditor)
// $file = $_FILE['uploaded_file']
// $folder = image folder
// $action = action page, used for redirecting after an error
// $name = empty by default
// $maxFileSize = default set up to 2MB
function ckImageUpload ($file, $baseUrl, $maxFileSize = 2000000) {
	$callback = array('url' => '', $msg => 'Errore nel caricamento del file.');
	if((!empty($file)) && ($file['error'] == 0)) :
		// Beginning check and upload
		$today = time();
		$day = date('d', $today);
		$month = date('m', $today);
		$year = date('Y', $today);
		$filename = $year . $month . $day . rand() . '_' . basename($file['name']);
		// Check if the file respect the max file size and the allowed file types
		if (($file['type'] == 'image/jpeg' || $file['type'] == 'image/pjpeg' || $file['type'] == 'image/gif' || $file['type'] == 'image/png') && ($file['size'] <= $maxFileSize)) :
			// Strip non alphanumeric characters from filename
			$strippedFilename = ereg_replace("[^A-Za-z0-9\.]", '_', $filename);
			// Determine the path to which we want to save this file
			$newName = '../../uploads/various/' . $strippedFilename;
			//$absolutePath = 'd:/Inetpub/webs/metaphyxcom/uploads/various/';
			//$newName = $absolutePath . $strippedFilename;
			// Check if the file with the same name is already exists on the server
			if (!file_exists($newName)) :
				//chmod($absolutePath, 0777);
				//Attempt to move the uploaded file to it's new place
				if (move_uploaded_file($file['tmp_name'], $newName)) :
					// OK! File uploaded correctly!
					$callback['url'] = $baseUrl . 'uploads/various/' . $strippedFilename;
					$callback['msg'] = '';
				else :
					// NO! Generic error!
					exit();
					$callback['url'] = '';
					$callback['msg'] = 'Il file non e\' stato caricato correttamente. (1)';
				endif;
			else :
				// NO! File already exists!
				$callback['url'] = '';
				$callback['msg'] = 'Il file caricato e\' gia\' presente.';
			endif;
		else :
			// NO! File bigger than max size or filetype not allowed!
			$callback['url'] = '';
			$callback['msg'] = 'Il file caricato e\' troppo grande o non e\' del tipo consentito.';
		endif;
	else :
		// NO! Generic error!
		$callback['url'] = '';
		$callback['msg'] = 'Il file non e\' stato caricato correttamente. (2)';
	endif;
	return $callback;
}




// CK FILE UPLOAD
//
// Checks and uploads requested file and returns file name (for CKEditor)
// $file = $_FILE['uploaded_file']
// $folder = file folder
// $action = action page, used for redirecting after an error
// $name = empty by default
// $maxFileSize = default set up to 2MB
function ckFileUpload ($file, $baseUrl, $maxFileSize = 2000000) {
	$callback = array('url' => '', $msg => 'There was an error during the upload.');
	if((!empty($file)) && ($file['error'] == 0)) :
		// Beginning check and upload
		$today = time();
		$day = date('d', $today);
		$month = date('m', $today);
		$year = date('Y', $today);
		$filename = $year . $month . $day . rand() . '_' . basename($file['name']);
		// Check if the file respect the max file size and the allowed file types
		if ($file['size'] <= $maxFileSize) :
			// Strip non alphanumeric characters from filename
			$strippedFilename = ereg_replace("[^A-Za-z0-9\.]", '_', $filename);
			// Determine the path to which we want to save this file
			$newName = '../../uploads/various/' . $strippedFilename;
			//$absolutePath = 'd:/Inetpub/webs/metaphyxcom/uploads/various/';
			//$newName = $absolutePath . $strippedFilename;
			// Check if the file with the same name is already exists on the server
			if (!file_exists($newName)) :
				//Attempt to move the uploaded file to it's new place
				if (move_uploaded_file($file['tmp_name'], $newName)) :
					// OK! File uploaded correctly!
					$callback['url'] = $baseUrl . 'uploads/various/' . $strippedFilename;
					$callback['msg'] = '';
				else :
					// NO! Generic error!
					$callback['url'] = '';
					$callback['msg'] = 'There was an error during the upload. (1)';
				endif;
			else :
				// NO! File already exists!
				$callback['url'] = '';
				$callback['msg'] = 'The uploaded file already exists.';
			endif;
		else :
			// NO! File bigger than max size or filetype not allowed!
			$callback['url'] = '';
			$callback['msg'] = 'The uploaded file is too big or of an allowed file type.';
		endif;
	else :
		// NO! Generic error!
		$callback['url'] = '';
		$callback['msg'] = 'There was an error during the upload. (2)';
	endif;
	return $callback;
}




// IMAGE THUMB
//
// Returns a scaled size array to create a thumbnail of the requested image
// $image = image filename
// $width = max width of the thumbnail (0 if not requested)
// $height = max height of the thumbnail (0 if not requested)
function imageThumb ($image, $width, $height) {
	$size = getimagesize($image);
	$newSize = array();
	if ($width > 0 && $height > 0) :
		$newSize['w'] = $width;
		$newSize['h'] = $height;
	elseif ($width > 0 && $height == 0) :
		$newSize['w'] = $width;
		$ratio = $size[0]/$width;
		$newSize['h'] = $size[1]/$ratio;
	elseif ($width == 0 && $height > 0) :
		$newSize['h'] = $height;
		$ratio = $size[1]/$height;
		$newSize['w'] = $size[0]/$ratio;
	endif;
	return $newSize;
}



// IMAGE CROP
function cwImageCrop ($image_name, $folder, $thumb_w, $thumb_h, $photogallery = false) {
	if ($image_name == '') return 'image_empty';

	if ($photogallery) :
		$image = '../../uploads/' . $folder . '/' . $image_name;
	else :
		$image = '../../../uploads/' . $folder . '/' . $image_name;
	endif;
	$type = ''; $im = false;
	$size = getimagesize($image);
	switch ($size['mime']) :
		case "image/jpeg" :
			$im = imagecreatefromjpeg($image);
			$type = 'jpg';
			break;
		case "image/gif" :
			$im = imagecreatefromgif($image);
			$type = 'gif';
			break;
		case "image/png" :
			$im = imagecreatefrompng($image);
			$type = 'png';
			break;
		default :
			return 'wrong_mime';
	endswitch;
	$w = imagesx($im);
	$h = imagesy($im);
	$original_aspect = $w / $h;
	$thumb_aspect = $thumb_w / $thumb_h;

	if ($original_aspect >= $thumb_aspect) :
		$new_h = $thumb_h;
		$new_w = $w / ($h / $thumb_h);
	else :
		$new_w = $thumb_w;
		$new_h = $h / ($w / $thumb_w);
	endif;

	$thumb = imagecreatetruecolor($thumb_w, $thumb_h);

	imagecopyresampled(
		$thumb, $im,
		0 - ($new_w - $thumb_w) / 2,
		0 - ($new_h - $thumb_h) / 2,
		0, 0,
		$new_w, $new_h,
		$w, $h
	);

	if ($photogallery) :
		$new_name = '../../uploads/' . $folder . '/' . $thumb_w . 'x' . $thumb_h . '-' . $image_name;
	else :
		$new_name = '../../../uploads/' . $folder . '/' . $thumb_w . 'x' . $thumb_h . '-' . $image_name;
	endif;
	switch ($type) :
		case 'jpg' :
			imagejpeg($thumb, $new_name, 80);
			break;
		case 'gif' :
			imagegif($thumb, $new_name);
			break;
		case 'png' :
			imagepng($thumb, $new_name);
			break;
		default :
			return 'wrong_type';
	endswitch;

	return 'ok';
}

?>
