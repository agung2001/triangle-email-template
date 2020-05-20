(function( $ ) {

    /**
     * @settings @control @id : control_triangle_container_width
     * */
    $(document).on('input', '#control_triangle_container_width', function(){
        $(this).parent().find('.triangle_range_value').html( $(this).val() );
    });

})( jQuery );
