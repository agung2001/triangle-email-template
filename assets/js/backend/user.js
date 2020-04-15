jQuery(document).ready(function( $ ) {

    /**
     * Add Contact Option
     * @userPage
     * @return  void
     * */
    $('#the-list tr').each(function(){
        let id = $(this).attr('id');
        let html = `<span class="contact"> | <a href="#" class="triangle-contact" data-user="${id}" data-toggle="modal" data-target="#exampleModal">Contact</a></span>`;
        $('.row-actions').append(html);
    });

    /**
     * Trigger
     * @userPage
     * */
    // $('.triangle-contact').click(() => {
    //     let id = $(this)
    //         .parent()
    //         .attr('class');
    //     console.log(id);
    // });

});