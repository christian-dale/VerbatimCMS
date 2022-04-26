<?php

chdir("../");

require_once("lib/class/App.php");

$app = new \VerbatimCMS\App();
echo $app->render();
