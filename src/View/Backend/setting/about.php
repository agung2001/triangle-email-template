<?php
$path = unserialize(TRIANGLE_PATH);
$path = $path['plugin_path'] . 'README.md';
$content = file_get_contents($path);
$Parsedown = new Parsedown();
echo $Parsedown->text($content);
?>
