<?php
include 'mainphp.php';
session_start();
if(isset($_POST['stupload'])){
	$file=$_FILES['stufile'];
	$fileName=$file['name'];
	$fileSize=$file['size'];
	$fileType=$file['type'];
	$error=$file['error'];
	$fileTmpName=$file['tmp_name'];
	date_default_timezone_set("Asia/kolkata");
	$clock=date('y/m/d h:i:s');
	$_SESSION['postTime']=$clock;
	$fileExt=explode('.',$fileName);
	$fileActExt=strtolower(end($fileExt));	
	if($error===0)
	{	

		if($fileSize<2000000)
		{
		$fileNameNew=uniqid('',true).".".$fileActExt;
		$fileDestination='uploads/'.$fileNameNew;
		move_uploaded_file($fileTmpName,$fileDestination);
		$professor=$_POST["professor"];
		$content=$_POST["description"];
		$idnum=$_SESSION["id"];
		$tara=$con->query("select *from clearner where cid='$idnum'");
		while($same2u=$tara->fetch_array()){
			$section=$same2u['class'];
		}
		$con->query("insert into cassignment(idnum,section,prof,cont,file,time) values('$idnum','$section','$professor','$content','$fileDestination','$clock')");
		header("location: assignment.php?upload success");
		}else{
			echo"<html><head><script>alert('file size is too big')</script></head></html>";
			include 'submit.php';
		}
	}else{
			echo"<html><head><script>alert('error=1 , while uploading this file')</script></head></html>";
			include'submit.php';
	}
}
?>
