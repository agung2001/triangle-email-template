<?= $this->loadContent('Element.loading', [
    'id' => 'loading-contact-send'
]) ?>
<h1 id="email-send-status"><?= $status ?></h1>
<script type="text/javascript">
    setTimeout(function(){ email_status(); }, 5000);
    function email_status(){
        animate('#loading-contact-send', 'animated fadeOut').hide();
        animate('#email-send-status', 'animated flash').show();
        let delayMillis = 5000;
        setTimeout(function() {
            window.location = 'admin.php?page=triangle';
        }, delayMillis);
    }
</script>