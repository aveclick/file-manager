<?php
function dir_size($path)
{
  $path = rtrim($path, '/');
  $size = 0;
  $dir = opendir($path);
  if (!$dir) {
    return 0;
  }

  while (false !== ($file = readdir($dir))) {
    if ($file == '.' || $file == '..') {
      continue;
    } elseif (is_dir($path . $file)) {
      $size += dir_size($path . DIRECTORY_SEPARATOR . $file);
    } else {
      $size += filesize($path . DIRECTORY_SEPARATOR . $file);
    }
  }
  closedir($dir);
  return round($size / 1024, 2, PHP_ROUND_HALF_UP);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>File Manager</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header class="header">
    File Manager
  </header>
  <div class="folders">
    <div class="flexbox title">
      Name
      <div class="folderinfo">
        <div class="foldersize">Size</div>
        <div class="foldercreate">Last update</div>
      </div>
    </div>
    <?php
    require 'conf.php';
    $path = scandir($dir);
    $skip = array('.', '..');
    foreach ($path as $file) {
      if (!in_array($file, $skip)) {
        if (is_dir($file)) {
          $files = basename($file);
          $path_f = scandir($dir . '/' . $file);
          foreach ($path_f as $file_f) {
            if (!in_array($file_f, $skip)) {
              $files_f = basename($file_f);
              if ($files_f == $folder) {
                echo '<div class="flexbox">';
                echo '<ul><i class="fa fa-folder fa-3x" aria-hidden="true"></i><a href="folder.php?var=', urlencode($file), '">' . $files . '</a></ul>';
                echo '<div class="folderinfo">';
                echo '<div class="foldersize">' . dir_size($file . '/' . $folder) . ' kB' . '</div>';
                echo '<div class="foldercreate">' . date("d.n.Y", filemtime($file . '/' . $folder)) . '</div>';
                echo '</div>';
                echo '</div>';
              }
            }
          }
        }
      }
    }
    ?>
  </div>
</body>

</html>