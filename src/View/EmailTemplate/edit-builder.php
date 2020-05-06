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

    </div>
</div>

<script type="text/javascript">

    // jQuery('#section-visual div.item').on('mouseover', function(){
    //     jQuery(this).addClass('bordered');
    //     // console.log('test');
    // });

    jQuery(window).load(function( $ ) {

        var emailGrid = new Muuri('.email-grid', {
            items: '.item',
            dragEnabled: true,
            // dragContainer: '.builder-container',
            // dragSort: function() {
            //     return [grid1, grid2];
            // }
        });

    })( jQuery );


</script>