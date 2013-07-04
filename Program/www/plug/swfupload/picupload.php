<?php
require_once('../../../config/define.php');
require_once('../../../class/sql.class.php');
$db = new sql();
$id = $_GET['id'];
$dir = $_GET['dir'];
// �ж��Ƿ���ֵ
	if(!$dir){
		HandleError('������ȫ');
		exit();
	}
	
// Code for Session Cookie workaround
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	} else if (isset($_GET["PHPSESSID"])) {
		session_id($_GET["PHPSESSID"]);
	}

	session_start();

	$POST_MAX_SIZE = ini_get('post_max_size');
	$unit = strtoupper(substr($POST_MAX_SIZE, -1));
	$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

	if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
		header("HTTP/1.1 500 Internal Server Error");
		echo "POST exceeded maximum allowed size.";
		exit(0);
	}

// Settings
	$save_path =  $dir;
	$upload_name = "Filedata";
	$max_file_size_in_bytes = 2147483647;				// 2GB in bytes
	$extension_whitelist = array("bmp", "jpg", "gif", "png");	//������ļ�
	$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				//������ļ����ַ�
	
// Other variables	
	$MAX_FILENAME_LENGTH = 260;
	$file_name = '';
	$file_extension = "";
	$uploadErrors = array(
        0=>"�ļ��ϴ��ɹ�",
        1=>"�ϴ����ļ������� php.ini �ļ��е� upload_max_filesize directive �������",
        2=>"�ϴ����ļ������� HTML form �ļ��е� MAX_FILE_SIZE directive �������",
        3=>"�ϴ����ļ���Ϊ�����ļ�",
        4=>"û���ļ��ϴ�",
        6=>"ȱ����ʱ�ļ���"
	);

	if (!isset($_FILES[$upload_name])) {
		HandleError("No upload found in \$_FILES for " . $upload_name);
		exit(0);
	} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
		HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
		exit(0);
	} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
		HandleError("Upload failed is_uploaded_file test.");
		exit(0);
	} else if (!isset($_FILES[$upload_name]['name'])) {
		HandleError("File has no name.");
		exit(0);
	}
	
	$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
	if (!$file_size || $file_size > $max_file_size_in_bytes) {
		HandleError("File exceeds the maximum allowed size");
		exit(0);
	}
	
	if ($file_size <= 0) {
		HandleError("File size outside allowed lower bound");
		exit(0);
	}


//	$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));	

	$file_name = date('YmdHis').rand(100,999).substr($_FILES[$upload_name]['name'],strrpos($_FILES[$upload_name]['name'],'.'));

	if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
		HandleError("Invalid file name");
		exit(0);
	}


	if (file_exists($save_path . $file_name)) {
		HandleError("File with this name already exists");
		exit(0);
	}

// Validate file extension
	$path_info = pathinfo($_FILES[$upload_name]['name']);
	$file_extension = $path_info["extension"];
	$is_valid_extension = false;
	foreach ($extension_whitelist as $extension) {
		if (strcasecmp($file_extension, $extension) == 0) {
			$is_valid_extension = true;

			break;
		}
	}
	if (!$is_valid_extension) {
		HandleError("Invalid file extension",550);
		exit(0);
	}
   
	if (!@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$file_name)) {
		HandleError("�ļ��޷�����.",555);
		exit(0);
	}else{
		$db->setIndexPic($id,$file_name);		
		@chmod($save_path.$file_name,0777);
	}

	echo "File Received";
	exit(0);


	function HandleError($message,$code=500) {
		header("HTTP/1.1 $code Internal Server Error");
		echo $message;
	}

?>
