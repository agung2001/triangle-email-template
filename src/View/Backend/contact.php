<ul class="nav-tab-wrapper">
    <li class="nav-tab nav-tab-active" data-tab="section-contact">Contact</li>
</ul>

<div id="section-about" class="tab-content current">

    <table class="form-table triangle-setting" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><label for="template">Template</label></th>
                <td>
                    <?= $this->loadContent('Element.loading-field', [
                        'id' => 'loading-field-template'
                    ]) ?>
                    <div id="field-template" class="field-ajax">
                        <select name="template" class="reqular-text"></select>
                        <p class="field-info">
                            Pick email template
                        </p>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="user">User</label></th>
                <td>
                    <?= $this->loadContent('Element.loading-field', [
                        'id' => 'loading-field-user'
                    ]) ?>
                    <div id="field-user" class="field-ajax">
                        <select name="user" class="reqular-text"></select>
                        <p class="field-info">
                            Select user to contact
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>