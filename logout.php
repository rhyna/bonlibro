<?php

require_once 'include/init.php';

Auth::logout();

Url::redirect($ROOT_URL . '/');

?>
