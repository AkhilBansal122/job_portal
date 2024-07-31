<?php


function customEdit($route, $recordId)
{
    return ("<a href='" . $route . "'>Edit</a/>");
}


function customStatus($route, $recordId, $status)
{
    return ("<a href=''></a/>");
}

function defaultImage(){
    $defaultImage=asset('public/images/default.jpg');
    return $defaultImage;
}