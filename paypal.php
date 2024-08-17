<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
       <h1>Bonjour</h1>
     <div id="paypal-button-container"></div>


    <script src="https://www.paypal.com/sdk/js?client-id=AbZpOk7hm3ymgT9AL2LBJ9LYqVXudLeuNuSmgQlCQLJQWeKzmXx9ChdHsNT0pBM7pvEK8YTWxR3YmfJ0">
</script>

     <script>
        
      paypal.Buttons({
       
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo number_format($total, 2); ?>'
                    }
                }]
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
                alert('Transaction complétée par ' + details.payer.name.given_name + '!');
            });
        },
        onError: function(err){
            console.log("erreur dans le paiement",err);
            alert("paiement échoué");
        }

    }).render('#paypal-button-container').then(function () {
 
    });
    </script>

</body>
</html>