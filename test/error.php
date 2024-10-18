<?php
$uri = 'http://' . $_SERVER['HTTP_HOST'] . 'test/view.php';
if($uri != 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']){

    $_SESSION['flag']=[];
}