<?php
//Index page

/*require_once 'public/User.php';
$user = new User();
echo '<pre>';
print_r($user->select());*/

require_once 'public/Frontend.php';
$frontend = new Frontend();
print $frontend->DOM();