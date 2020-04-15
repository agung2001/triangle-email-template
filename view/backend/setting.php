<ul class="nav-tab-wrapper">
    <li class="nav-tab nav-tab-active" data-tab="section-about">About</li>
</ul>

<div id="section-about" class="tab-content current">
    <?php
        $path = unserialize(Triangle_PATH);
        $path = $path['plugin_path'] . 'README.md';
        $content = file_get_contents($path);
        $Parsedown = new Parsedown();
        echo $Parsedown->text($content);
    ?>
</div>