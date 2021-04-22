function required() {
  let firstName = document.getElementById("usualFirstName").value;
  let lastName  = document.getElementById("lastName").value;
  let birthDate = document.getElementById("birthDate").value;

  if (firstName === "") {
    alert("Insérer votre Prénom svp !");
    
    return false;

  } else if (lastName === "") {
      alert("Insérer votre Nom svp !");
      
      return false;
  
  } else if (birthDate === "") {
      alert("Insérer votre Date de Naissance svp !");
      
      return false;
  
  } else {
    
    return true; 
  }
}

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
