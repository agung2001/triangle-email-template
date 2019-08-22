<div class="wrap">

    <h1>
        <img src="<?= $this->get_asset('img','icon.ico',array('type' => 'url')) ?>" alt="circle-logo">
        Triangle
    </h1>

    <h2 class="nav-tab-wrapper">
        <a href="#" class="nav-tab nav-tab-active">
            Setting
        </a>
    </h2>

    <?php
        if($_POST){
            update_option('triangle_setting_stage',$_POST['stage']);
            update_option('triangle_setting_extras',$_POST['extras']);
        }

        $mode = get_option('triangle_setting_stage');
        $extras = get_option('triangle_setting_extras');
    ?>

    <form method="POST" style="margin-top:30px;">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label>Mode</label>
                    </th>
                    <td>
                        <select name="stage" class="input">
                            <option value="dev" <?php if('sandbox'==$mode) echo 'selected'; ?>>Development</option>
                            <option value="live" <?php if('live'==$mode) echo 'selected'; ?>>Live</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label>Extra Route Email - Please seperate email by comma.</label>
                    </th>
                    <td>
                        <textarea name="extras" cols="30" rows="10"><?= $extras ?></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <input name="save" class="button-primary" value="Save changes" type="submit">
    </form>

</div>

<style>
	.input {
		width:300px;
	}
</style>