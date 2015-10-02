<?php

  require '../PathPattern.php';

  $uploadFolder = new PathPattern\Folder;

  $uploadFolder->setPattern(':Y/:m/:d/images><>||');
  
  echo $uploadFolder->getPath();