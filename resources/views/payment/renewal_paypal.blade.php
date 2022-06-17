<!DOCTYPE html>
    <html lang="en">
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>PayPal Payment Gateway</title>
        <script>
            window.userID = "{{ auth()->id() }}";
        </script>

      </head>
	  <style>
		  html, body {
				height: 100%;
			}

			html {
				display: table;
				margin: auto;
			}

			body {
				display: table-cell;
				vertical-align: middle;
			}
	  </style>

      <body>
        <div id="paypal-button-container"></div>


        <form id="form" action="/renewal_payment" method="post">
            @csrf
            <input type="hidden" name="userId" value="{{auth()->id()}}">
        </form>
        
        <!-- Sample PayPal credentials (client-id) are included -->
        <script src="https://www.paypal.com/sdk/js?client-id=Abnd3cK8ov29nLBOag509J09jIRZwGvSLPP1oVTlr2JLHfRbAaL-1drkwUFVBZ_2oP8xxpBVC6GVUnZb"></script>
        <script>
          const paypalButtonsComponent = paypal.Buttons({
              // optional styling for buttons
              // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
              style: {
                color: "gold",
                shape: "rect",
                layout: "vertical"
              },

              // set up the transaction
              createOrder: (data, actions) => {
                  // pass in any options from the v2 orders create call:
                  // https://developer.paypal.com/api/orders/v2/#orders-create-request-body
                  const createOrderPayload = {
                      purchase_units: [
                          {
                              amount: {
                                  value: "29.10"
                              }
                          }
                      ]
                  };

                  return actions.order.create(createOrderPayload);
              },

              // finalize the transaction
              onApprove: (data, actions) => {
                  const captureOrderHandler = (details) => {
                      const payerName = details.payer.name.given_name;
                      console.log('Transaction completed');
                      document.getElementById("form").submit();
                  };

                  return actions.order.capture().then(captureOrderHandler);
              },

              // handle unrecoverable errors
              onError: (err) => {
                  console.error('An error prevented the buyer from checking out with PayPal');
              }
          });

          paypalButtonsComponent
              .render("#paypal-button-container")
              .catch((err) => {
                  console.error('PayPal Buttons failed to render');
              });
        </script>
      </body>
    </html>