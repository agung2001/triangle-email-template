
<table role="presentation" cellspacing="0" cellpadding="0" style="width:100%; border-radius:5px; border:1px solid #eee;">
    <tr>
        <td style="padding: 10px;  font-size: 15px; line-height: 20px;" colspan="1">
            <?php
                if(isset($content)){
                    echo $content;
                } else {
                    echo '<center>Content</center>';
                }
            ?>
        </td>
    </tr>
</table>