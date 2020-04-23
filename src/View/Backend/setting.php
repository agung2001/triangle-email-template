<div class="triangle-container">
    <div class="header bg-alizarin">
        <ul class="nav-tab-wrapper">
            <li class="nav-tab nav-tab-active" data-tab="section-setting">Setting</li>
            <li class="nav-tab" data-tab="section-about">About</li>
        </ul>
    </div>

    <div class="content">
        <div id="section-setting" class="tab-content current">
            JANCUK
        </div>

        <div id="section-about" class="tab-content">
            <?php
                $path = unserialize(TRIANGLE_PATH);
                $path = $path['plugin_path'] . 'README.md';
                $content = file_get_contents($path);
                $Parsedown = new Parsedown();
                echo $Parsedown->text($content);
            ?>
        </div>
    </div>
</div>