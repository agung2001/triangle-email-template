<?php if($this->Page): ?>
    <h1><?= $this->Page->getPageTitle() ?></h1>
<?php endif; ?>

<div class="triangle-container">
    <div class="header <?= (isset($background)) ? $background : '' ?>">
        <?= (isset($nav)) ? $this->loadContent($nav) : '' ?>

        <ul class="nav-tab-wrapper <?= (isset($disableTab)) ? '' : 'nav-tab-general' ?>">
            <?php foreach($this->sections as $path => $section): ?>
                <?php
                $slug = str_replace(' ','',strtolower($section['name']));
                $active = isset($section['active']) ? 'nav-tab-active' : '';
                ?>
                <li class="nav-tab <?= $active ?>" data-tab="section-<?= $slug ?>">
                    <?php if(isset($section['link'])){ ?>
                        <?php
                            $url = $this->Service->Page->add_query_arg( NULL, NULL ).'&section='.$section['link'];
                            $url = $this->Service->Page->home_url($url);
                        ?>
                        <a href="<?= $url ?>"><?= $section['name'] ?></a>
                    <?php } else { ?>
                        <?= $section['name'] ?>
                    <?php } ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="content">
        <?php foreach($this->sections as $path => $section): ?>
            <?php
                $slug = str_replace(' ','',strtolower($section['name']));
                $active = isset($section['active']) ? 'current' : '';
            ?>
            <div id="section-<?= $slug ?>" class="tab-content <?= $active ?>">
                <?= (isset($section['link']) && $active=='') ? '' : $this->loadContent($path); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>