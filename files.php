<?php
chdir('/srv/samba/casa');
$files1 = scandir($dir);

print_r($files1);
?>