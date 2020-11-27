$( function() {
    $( "#pot_Name" ).autocomplete({
        source: function( request, response ) {
            $.ajax( {
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function( data ) {
                    List = [];
                    $.each(data, function (i, Plant){
                       List.push(Plant.scientific_name)
                    });
                    response(List);
                },
                error: function (){
                    response();
                }
            } );
        },
        // select: function( event, ui ) {
        //     log( "Selected: " + ui.item.value + " aka " + ui.item.id );
        // }
    });
});