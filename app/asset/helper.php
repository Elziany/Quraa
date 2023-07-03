<?php
function uploadImage($file,$path){

$fileExtension=$file->getClientOriginalExtension();
$imageName=$file->hashName();
$ImagePath=$file->storeAs($path,$imageName);
return $ImagePath;
}
