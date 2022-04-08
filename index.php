<?php
$post = file_get_contents('php://input');
$payload = json_decode($post);
exec("rm -rf latest V* D*");
exec("echo " . $payload->release->tag_name . " >> ./latest");
exec("wget ". $payload->release->tarball_url);
exec("tar -xf " . $payload->release->tag_name);
exec("mv Duedot43* release_folder");
?>