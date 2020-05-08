<!--Start : Builder Container-->
<div class="builder-container">
    <div class="grid email-grid">

        <div class="item col-sm-12">
            <div class="item-content" style="text-align:center;">
                <h1><a href="#">e-Verify</a></h1>
            </div>
        </div>

        <div class="item col-sm-12">
            <div class="item-content text-center">
                <img src="http://wp-dev/app/uploads/EmailTemplate/e-verify/images/email.png" alt="" style="width:300px; display:block; margin:0 auto;">
            </div>
        </div>

        <div class="item col-sm-12">
            <div class="item-content">
                <div class="text" style="text-align: center;">
                    <h2>Please verify your email</h2>
                    <h3>Amazing deals, updates, interesting news right in your inbox</h3>
                    <p><a href="#" class="btn btn-primary">Yes! Subscribe Me</a></p>
                </div>
            </div>
        </div>

        <div class="item col-sm-4">
            <div class="item-content">
                <h3 class="heading">About</h3>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </div>
        </div>
        <div class="item col-sm-4">
            <div class="item-content">
                <h3 class="heading">Contact Info</h3>
                <ul>
                    <li><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                    <li><span class="text">+2 392 3929 210</span></a></li>
                </ul>
            </div>
        </div>
        <div class="item col-sm-4">
            <div class="item-content">
                <h3 class="heading">Useful Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Work</a></li>
                </ul>
            </div>
        </div>

        <div class="item col-sm-12">
            <div class="item-content">
                <p>No longer want to receive these email? You can <a href="#" style="color: rgba(0,0,0,.8);">Unsubscribe here</a></p>
            </div>
        </div>

    </div>
</div>
<!--End : Builder Container-->

<!--Start : Builder Element-->
<div style="display:none;">
    <div id="element-setting">
        <button type="button" id="action-column" class="dashicons-before dashicons-schedule"></button>
        <button type="button" id="action-setting" class="dashicons-before dashicons-admin-tools"></button>
    </div>
    <textarea name="element-setting-dialog" id="element-setting-dialog"></textarea>
</div>
<!--End : Builder Element-->

<style>
    /*.mce-toolbar-grp { display:none; }*/
    /*.jconfirm .mce-toolbar-grp { display:block; }*/
</style>

<script type="text/javascript">
    jQuery(document).ready(function($){
        /** Load Email Grid */
        var emailGrid = new Muuri('.email-grid', {
            items: '.item',
            dragEnabled: true,
        });

        /** Setting Element */
        let elementSetting = $('#element-setting');
        $('.email-grid .item').hover(function(){
            $('.item-content', this).before(elementSetting);
        }, function(){
            elementSetting.remove();
        });

        /** Modify Element */
        $(document).on('click', '#action-setting', function(){
            var itemContent = $(this).parent().parent();
            var content = $('.item-content', itemContent).html();
            $.confirm({
                title: 'Element Setting',
                columnClass: 'col-md-12',
                theme: 'material',
                closeIcon: true,
                animation: 'scale',
                type: 'purple',
                offsetTop: 40,
                content: function () {
                    var self = this;
                    return $.ajax({
                        method: 'POST',
                        url: 'admin-ajax.php',
                        data: {
                            'action'    : 'triangle-editor',
                            'element'   : content,
                        },
                    }).done(function (response) {
                        self.setContent(response);
                    }).fail(function(){
                        self.setContent('Something went wrong.');
                    });
                },
                buttons: {
                    save: function () {
                        $.alert({
                            content: function () {
                                var self = this;
                                return $.ajax({
                                    url: 'https://jsonplaceholder.typicode.com/todos/1',
                                    dataType: 'json',
                                    method: 'get'
                                }).done(function (response) {
                                    self.setContent('Description: ' + response);
                                    self.setTitle('Element Saved!');
                                }).fail(function(){
                                    self.setContent('Something went wrong.');
                                });
                                jQuery('.mce-toolbar-grp').remove();
                            }
                        });
                    },
                    cancel: function () {
                        jQuery('.mce-toolbar-grp').remove();
                    },
                }
            });
        });
    });
</script>