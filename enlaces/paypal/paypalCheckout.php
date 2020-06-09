<div id="paypal-button" class="m-0 p-0 mt-2 w-100"></div>
<script src="https://www.paypalobjects.com/api/checkout.js">
</script>
<script>
    paypal.Button.render({
        env: '<?php echo PayPalENV; ?>',
        client: {
            <?php if (ProPayPal) { ?>
                production: '<?php echo PayPalClientId; ?>'
            <?php } else { ?>
                sandbox: '<?php echo PayPalClientId; ?>'
            <?php } ?>
        },
        payment: function(data, actions) {
            return actions.payment.create({
                transactions: [{
                    amount: {
                        total: '<?php echo $productPrice; ?>',
                        currency: '<?php echo $currency; ?>'
                    }
                }]
            });
        },
        onAuthorize: function(data, actions) {
            return actions.payment.execute()
                .then(function() {
                    location.href = "paypal/orderDetails.php?paymentID=" + data.paymentID + "&payerID=" + data.payerID + "&token=" + data.paymentToken;
                });
        }
    }, '#paypal-button');
</script>