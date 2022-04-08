<?php
//$file - should contain full url 
// $newFileName - full physical path directory with file name
function getFile($file, $newFileName) 
{ 
    $err_msg = ''; 
    echo "<br>Attempting message download for $file<br>"; 
    $out = fopen($newFileName, 'wb'); 
    if ($out == FALSE){ 
      print "File not opened<br>"; 
      exit; 
    } 

    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_FILE, $out); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_URL, $file); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_exec($ch); 
    echo "<br>Error is : ".curl_error ( $ch); 

    curl_close($ch); 
    fclose($out); 
}
$post = file_get_contents('php://input');
$payload = json_decode($post);
//exec("rm -rf latest V* D*");
rmdir("latest");
rmdir("V*");
rmdir("D*");
$room = fopen("/home/vol9_6/epizy.com/epiz_31243515/htdocs/latest", "w");
fwrite($room, $payload->release->tag_name);
//exec("echo " . $payload->release->tag_name . " >> ./latest");
getFile($payload->release->tarball_url, "/home/vol9_6/epizy.com/epiz_31243515/htdocs/" . $payload->release->tag_name);
exec("wget ". $payload->release->tarball_url);
$phar = new PharData($payload->release->tag_name);
mkdir("/home/vol9_6/epizy.com/epiz_31243515/htdocs/release_folder");
$phar->extractTo('/home/vol9_6/epizy.com/epiz_31243515/htdocs/release_folder', null, true); // extract all files, and overwrite
//exec("tar -xf " . $payload->release->tag_name);
//exec("mv Duedot43* release_folder");

?>