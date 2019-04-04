require(['jquery'],function($){
    $(document).ready(function(){

        $("#sku").on('keyup', function(e){

            if (e.keyCode == undefined) {
                return 0;
            }
            var typing = $(this).val();

            var cancel = null;
            if(typing.length > 2){

                if(cancel) {
                    cancel.abort();
                }

                var cancel =
                    $.ajax({
                        url: 'customrouter/search/autocomplete',
                        type: 'post',
                        data: $('#cart-form').serialize(),
                        dataType: 'json',
                        success: function(response){
                            var get = response;

                            for(var propt in get){
                                $('#info').append('<option value="'+ propt +'">' + get[propt] + '</option>')
                            }
                        },
                    })
            } else {
                $('#info').empty();
            }
        });

    });
})