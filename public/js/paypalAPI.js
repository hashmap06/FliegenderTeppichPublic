document.addEventListener('DOMContentLoaded', () => {
    const priceText = document.getElementById("price").textContent;
    const shipping = 2.99
    let customerInfo = {};
    let priceDisplayed;
    let ISBNSelected;



    function sendCustomerInfoToPHP(customerInfo) {
        const xhr = new XMLHttpRequest();
        const url = '/db/PayPal/process_payment.php';

        console.log("CustomerInfo Object for single product cart JS structure");
        console.log(customerInfo);


        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        const data = JSON.stringify(customerInfo);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (xhr.status === 200) {
                        console.log('Payment processed successfully:', response.message);
                        window.location.href = "https://fliegenderteppich.org/success.php";
                    } else {
                        console.error('Error in processing payment:', response.error || xhr.statusText);
                        console.log("Payment processing failed: " + response.error);
                        window.location.href = "https://fliegenderteppich.org/fail.php";
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
            }
        };

        xhr.send(data);
    }

    paypal.Buttons({
        createOrder: function(data, actions) {
            priceDisplayed = parseFloat(priceText);

            console.log("Price of bookArticle should be: " + priceDisplayed);

            ISBNSelected = parseInt(document.getElementById("bookID").textContent.replace(/\D/g, ''), 10);

            var price_shipping_included = (priceDisplayed + shipping).toFixed(2)

            if (isNaN(ISBNSelected)) {
                ISBNSelected = 123456789;
            }

            return actions.order.create({
                purchase_units: [{

                    amount: {
                        currency_code: "EUR",
                        value: price_shipping_included,
                        breakdown: {
                            item_total: {
                                currency_code: "EUR",
                                value: priceDisplayed.toFixed(2)
                            },
                            shipping: {
                                currency_code: "EUR",
                                value: shipping.toString()
                            }
                        }
                    },

                    items: [{
                        name: ISBNSelected.toString(),
                        unit_amount: {
                            currency_code: "EUR",
                            value: priceDisplayed.toFixed(2)
                        },
                        quantity: 1
                    }]
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                customerInfo = {
                    name: details.payer.name.given_name + ' ' + details.payer.name.surname,
                    email: details.payer.email_address,
                    address: details.purchase_units[0].shipping.address,
                    transactionId: details.id,
                    orderTime: new Date().toISOString(),
                };

                if (!details.purchase_units[0].shipping.address || details.purchase_units[0].shipping.address.length <= 3) {
                    alert("No address specified, payment can't be continued");
                    window.location.href = "https://fliegenderteppich.org/fail.php";
                }

                customerInfo.books = [{ ISBN: ISBNSelected, priceOfBook: priceDisplayed, quantity: 1, quantityRelatedPrice: priceDisplayed }];

                sendCustomerInfoToPHP(customerInfo);
            });
        },
        onError: function(err) {
            console.error(err);
        }
    }).render('#paypal');
});


function showNotification() {
    var notification = document.getElementById('notification');
    notification.classList.remove('hidden');
    notification.classList.add('show');

    setTimeout(function() {
        notification.classList.remove('show');
        notification.classList.add('hidden');
    }, 3000);
}