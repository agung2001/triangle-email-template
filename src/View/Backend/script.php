<script type="text/javascript">
    window.trianglePlugin = {
        name: '<?= TRIANGLE_NAME ?>',
        version: '<?= TRIANGLE_VERSION ?>',
        screen: <?= json_encode(unserialize(TRIANGLE_SCREEN)) ?>,
    };
</script>