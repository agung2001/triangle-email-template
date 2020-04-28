<form method="POST" id="contact-form">
    <table class="form-table" role="presentation">
        <input type="hidden" name="field_menu_slug" value="<?= $this->esc('attr',$menuSlug) ?>">
        <div id="form-message"></div>
        <tbody>
            <tr>
                <th scope="row">
                    <h3>Configuration</h3>
                </th>
            </tr>

            <!-- Template Field -->
            <tr>
                <th scope="row"><label for="field_template">Template</label></th>
                <td>
                    <?= $this->loadContent('Element.loading-field', [
                        'id' => 'loading-field-template'
                    ]) ?>
                    <div id="field-template-container" class="field-container field-ajax">
                        <select name="field_template" id="select-field-template"></select>
                        <p class="field-info">Choose email template</p>
                    </div>
                </td>
            </tr>

            <!-- User Field -->
            <tr>
                <th scope="row"><label for="field_users">User</label></th>
                <td>
                    <?= $this->loadContent('Element.loading-field', [
                        'id' => 'loading-field-user'
                    ]) ?>
                    <div id="field-user-container" class="field-container field-ajax">
                        <!-- UI -->
                        <select name="user" id="select-user-lists"></select>
                        <a id="add-user-to-lists">+</a>
                        <p class="field-info"> Select user to be contacted </p>
                        <!-- Values -->
                        <div class="field-ajax">
                            <input type="text" id="default-user" value="<?= $this->esc('attr',$user_id) ?>">
                            <input type="text" name="field_users" id="field-users">
                        </div>
                        <div id="user-lists"></div>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <h3>Information</h3>
                </th>
            </tr>

            <!-- From Name -->
            <tr>
                <th scope="row"><label for="field_from_name">From Name</label></th>
                <td>
                    <div class="field-container">
                        <input type="text" name="field_from_name" id="field-from-name" placeholder="Your Name...">
                    </div>
                </td>
            </tr>

            <!-- From Email -->
            <tr>
                <th scope="row"><label for="field_from_email">From Email</label></th>
                <td>
                    <div class="field-container">
                        <input type="text" name="field_from_email" id="field-from-email" placeholder="Your Email Address...">
                    </div>
                </td>
            </tr>

            <!-- Email Subject -->
            <tr>
                <th scope="row"><label for="field_email_subject">Email Subject</label></th>
                <td>
                    <div class="field-container">
                        <input type="text" name="field_email_subject" id="field-email-subject" placeholder="Email Subject...">
                    </div>
                </td>
            </tr>

            <!-- Submit -->
            <tr>
                <td></td>
                <td>
                    <div class="field-container">
                        <button typpe="submit" class="btn-submit">SEND</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</form>