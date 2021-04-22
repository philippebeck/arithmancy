paypal.Buttons({
  style: {
    color:  "blue",
    shape:  "pill",
    label:  "pay"
  },

  createOrder: function() {

    return fetch("index.php?access=order!create", {

      method: "post",
      headers: {
        "content-type": "application/json"
      }
    })
    .then(function(res) {

      return res.json();
    })
    .then(function(data) {

      return data.id;
    });
  },

  onApprove: function(data) {

    return fetch("index.php?access=order!capture", {

      headers: {
        "content-type": "application/json"
      },
      body: JSON.stringify({
        orderID: data.orderID
      })
    })
    .then(function(res) {

      return res.json();
    })
    .then(function(details) {

      alert("Transaction validée par " + 
        details.payer.name.given_name + 
        details.payer.name.surname);
    })
  },

  onCancel : function (data) {
    alert("Transaction annulée !");
  }

})
.render("#paypal-button");
