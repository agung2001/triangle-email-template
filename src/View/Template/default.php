<div class="wrap">

    <?php if($this->Page): ?>
        <h1><?= $this->Page->getPageTitle() ?></h1>
    <?php endif; ?>

    <div class="triangle-container">
        <div class="header <?= (isset($background)) ? $background : '' ?>">
            <?= (isset($nav)) ? $this->loadContent($nav) : '' ?>

            <ul class="nav-tab-wrapper">
                <?php foreach($this->sections as $path => $option): ?>
                    <?php
                        $slug = str_replace(' ','',strtolower($option['name']));
                        $active = isset($option['active']) ? 'nav-tab-active' : '';
                    ?>
                    <li class="nav-tab <?= $active ?>" data-tab="section-<?= $slug ?>">
                        <?= $option['name'] ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="content">
            <?php foreach($this->sections as $path => $option): ?>
                <?php
                    $slug = str_replace(' ','',strtolower($option['name']));
                    $active = isset($option['active']) ? 'current' : '';
                ?>
                <div id="section-<?= $slug ?>" class="tab-content <?= $active ?>">
                    <?= $this->loadContent($path) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

