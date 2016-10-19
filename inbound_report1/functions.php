<?php
function checklogin(){
	if(empty($_SESSION['username']))
	{
		logout();
	}
}
function valueNotFound(){
	session_destroy(); 
	header("Location: index.php?invalident=".rand()); 
	
}
 function logout(){
		unset($_SESSION['sessionId']);
		unset($_SESSION['username']);
		setcookie("username","", time()-7200, "/");
		

		session_destroy(); 
		header("Location: index.php?sessexp=".rand()); 
 }
 function encryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
	return( $qEncoded );
 
}

function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
return( $qDecoded );
}

function c2ccurlrequest($requesturl='')
{
	if($requesturl=='')
	return false;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$requesturl);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,"");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close($ch);
	return $server_output;
}

function recursiveRemoveDirectory($directory)
{
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) { 
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    
}

 ?>