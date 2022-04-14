<?php

chdir("../");

require_once("lib/class/App.php");

$app = new \App\App();
echo $app->render();
