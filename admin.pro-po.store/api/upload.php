<?php
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
  $tempFilePath = $_FILES['file']['tmp_name'];
  $fileName = $_FILES['file']['name'];
  $destinationPath = '/var/www/pro-po.store/storage/' . $fileName;
  $shortDestinationPath = '/storage/' . $fileName;
  
  if (move_uploaded_file($tempFilePath, $destinationPath)) {
    echo $shortDestinationPath;
  } else {
    echo '1';
  }
} else {
  echo '1';
}
?>