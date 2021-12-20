<?php
function formatFileSize($size)
{

  $a = array("B", "KB", "MB", "GB", "TB", "PB");
  $pos = 0;
  while ($size >= 1024) {
    $size /= 1024;
    $pos++;
  }
  return round($size, 2) . " " . $a[$pos];
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
  <a class="goback" href="/"><i class="fa fa-arrow-left fa-lg" aria-hidden="true"></i>go back</a>
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
    $main_dir = $_GET['var'];
    $dir = $dir . '/' . $main_dir . '/' . $folder;
    $path = scandir($dir);
    $skip = array('.', '..');
    foreach ($path as $file) {
      if (!in_array($file, $skip)) {
        $files = basename($file);
        echo '<div class="flexbox">';
        echo '<ul><i class="fa fa-file fa-2x" aria-hidden="true"></i><a download href="' . $main_dir . '/dist' . '/' . $file . '">' . $files . '</a></ul>';
        echo '<div class="folderinfo">';
        echo '<div class="foldersize">' . formatFileSize(filesize($main_dir . '/dist' . '/' . $file)) . '</div>';
        echo '<div class="foldercreate">' . date("d.n.Y", filemtime($main_dir . '/dist' . '/' . $file)) . '</div>';
        echo '</div>';
        echo '</div>';
      }
      // if(is_dir($file)){
      //   if(!in_array($file, $skip)){
      //     $files = basename($file);
      //     echo '<ul><i class="fa fa-folder fa-3x" aria-hidden="true"></i><a href="folder.php?var=', urlencode($file), '">'.$files.'</a></ul>';
      //   }
      // }
      // else{
      //   if(!in_array($file, $skip)){
      //     $files = basename($file);
      //     echo '<ul><a download href="'.$main_dir.'/dist'.'/'.$file.'">'.$files.'</a></ul>';
      //   }
      // }
    }
    ?>
  </div>
</body>

</html>