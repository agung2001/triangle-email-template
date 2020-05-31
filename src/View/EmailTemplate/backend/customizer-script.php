<script type="text/javascript">
    var customizerSetting = {
        <?php foreach($settings as $key => $setting): ?>
            <?= $key ?>: `<?= $setting->getArgs()['customFieldValue'] ?>`,
        <?php endforeach; ?>
    };
</script>