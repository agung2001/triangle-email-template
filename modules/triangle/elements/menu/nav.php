
    <h2 class="nav-tab-wrapper">
        <?php 
            foreach($this->config['modules'] as $module):
                $menu = $this->get_module($module['name'],'elements/menu/setting.php',array('type' => 'path'));
                $url = admin_url("{$module['name']}-setting");
                $label = (ucwords($module['name'])==$this->config['name']) ? 'Setting' : ucwords($module['name']);
                if(file_exists($menu)):
        ?>
                    <a href="<?= $url ?>" class="nav-tab nav-tab-active">
                        <?= $label ?>
                    </a>
        <?php 
                endif;
            endforeach;
        ?>
    </h2>
