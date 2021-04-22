paypal.Buttons({
  style: {
    color:  "blue",
    shape:  "pill",
    label:  "pay"
  },

  createOrder : function (data, actions) {

    return actions.order.create({

      purchase_units : [{
        amount : {
          value : "10.00",
          currency_code : "EUR"
        }
      }]
    });
  },

  onApprove : function (data, actions) {

    return actions.order.capture().then(

      function(details) {
        console.log(details);
        
        alert("Transaction validée par " + 
        details.payer.name.given_name + 
        " " + 
        details.payer.name.surname);

        document.getElementById("form").submit(); 
      }
    );
  },

  onCancel : function (data) {
    alert("Transaction annulée !");
  }

})
.render("#paypal-button");
