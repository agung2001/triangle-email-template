<div class="wrap">
    <!-- Triangle -->
    <h1>
        <img src="<?= $this->get_asset('img','icon.ico',array('type' => 'url')) ?>" alt="Logo">
        Triangle
    </h1><br>

    <!-- Navigation -->
    <?php $activeTab = $_GET['page']; ?>
    <h2 class="nav-tab-wrapper">
        <?php $tab = 'triangle-preview'; ?>
        <a href="<?= admin_url('options-general.php?page='.$tab) ?>" class="nav-tab <?php if($tab==$activeTab) echo 'nav-tab-active'; ?>">
            Preview
        </a>
        <?php $tab = 'triangle-theme'; ?>
        <a href="<?= admin_url('options-general.php?page='.$tab) ?>" class="nav-tab <?php if($tab==$activeTab) echo 'nav-tab-active'; ?>">
            Theme
        </a>
        <?php $tab = 'triangle-setting'; ?>
        <a href="<?= admin_url('options-general.php?page='.$tab) ?>" class="nav-tab <?php if($tab==$activeTab) echo 'nav-tab-active'; ?>">
            Setting
        </a>
    </h2>

</div>