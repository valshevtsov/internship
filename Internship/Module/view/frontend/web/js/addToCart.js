require(['jquery', 'Magento_Customer/js/customer-data'], function ($, customerData) {
    $(document).ready(function () {

        $('button[name = "addToCart"]').on('click', function (e) {

            e.preventDefault();

            var sku = $('#sku').val();
            var qty = $('#quantity').val();

            var form = $('form#cart-form');

            if (sku && qty) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        /* Minicart reloading */
                        customerData.reload(['cart'], true);
                        if (response.length != 0) {
                            customerData.reload(['messages'], true);
                        } else {
                            $('#info').empty();
                            $('#sku').val('');
                            $('#quantity').val('');
                        }
                    }
                });
            } else {
                alert('Enter all values');
            }
        })
    });

});
