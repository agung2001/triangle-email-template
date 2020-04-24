<form method="POST">
    <input type="hidden" name="field_menu_slug" value="<?= $menuSlug ?>">
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row">
                    <h3>User Interface (UI)</h3>
                </th>
            </tr>

            <!-- Animation -->
            <tr>
                <th scope="row"><label for="field_option_animation">Animation</label></th>
                <td>
                    <div id="field-template-container" class="field-container">
                        <label class="switch">
                            <input type="checkbox" name="field_option_animation" <?= ($options['triangle_animation']) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                        <p class="field-info"> Turn on/off animation </p>
                    </div>
                </td>
            </tr>

            <!-- Submit -->
            <tr>
                <th scope="row">&nbsp;</th>
                <td>
                    <div class="field-container">
                        <button typpe="submit" class="btn-submit">SAVE</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</form>