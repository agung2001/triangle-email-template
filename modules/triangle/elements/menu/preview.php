<?php
    if($_POST && $_POST['sendto'] != ""){
        $testStatus = $this->test_mail($_POST['sendto']);    
    }
?>

<div class="wrap">
    <div class="box" style="padding-bottom:30px;">
        <h2>
            <i class="fa fa-adjust"></i>
            Preview Mail
        </h2><hr>
        <iframe src="<?= admin_url('admin-ajax.php?action=triangle_theme_template') ?>" frameborder="0" style="width:100%; height:500px;"></iframe>
    </div>
    <div class="box" style="margin-top:20px;">
        <h2>
            <i class="fa fa-envelope"></i>
            Test Mail
        </h2><hr>
        <?php if(isset($testStatus)) echo '<b style="color:orange;">Test Mail Sent!</b>'; ?>
        <form method="POST" style="padding:0px;">
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th style="width:90%; padding:20px;">
                            <input type="text" name="sendto" placeholder="example@mail.com..." style="width:100%;">
                        </th>
                        <td style="width:10%; padding:20px;">
                            <input type="submit" name="save" class="button-primary fullwidth" value="Send Test Mail">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>