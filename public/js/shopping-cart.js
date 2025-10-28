//fetch all from PHP imported HTML items about the books
const bookItems = document.querySelectorAll('.books-metadata');
const bookInfoArray = [];
var actual_total_price_cart;

// function which updates db 
function updateCart(isbn, quantity) {
    // Prepare the data to be sent in the request
    const data = new FormData();
    data.append('isbn', isbn);
    data.append('quantity', quantity);

    // Send the request to the PHP script
    fetch('../db/shopping-cart/cart-updater-db.php', {
            method: 'POST', // Use POST method
            body: data, // Attach the data to the request
        })
        .then(response => response.json()) // Parse the JSON response
        .then(data => {
            console.log('Success:', data); // Handle success
        })
        .catch((error) => {
            console.error('Error:', error); // Handle errors
        });
}

//create a array of objects for all bookItems
bookItems.forEach((metadataElement, index) => {

    const metadataText = metadataElement.textContent.trim();
    const metadataArray = metadataText.split('AND');

    const priceElement = metadataElement.parentElement.querySelector('.total-price');
    const priceOfBook = priceElement.textContent;
    var quantityRelatedPrice = priceOfBook;

    const ISBN = metadataArray[0];
    console.log("ISBN of book: " + ISBN);
    const bookID = metadataArray[1];
    console.log("bookID of book: " + bookID);

    const quantityElement = document.getElementById(bookID);
    const quantity = parseInt(quantityElement.querySelector('input[name="name"]').value);

    const bookInfo = {
        bookID,
        ISBN,
        priceOfBook,
        quantity,
        quantityRelatedPrice,
    };

    bookInfoArray.push(bookInfo);
});


console.log(bookInfoArray);


// Function to iterate over bookInfoArray and call updateCart for each book
function uploadAllBooksInfo() {
    bookInfoArray.forEach((book) => {
        const isbn = parseInt(book.bookID.trim()); // Ensure ISBN is a string and trimmed
        const quantity = parseInt(book.quantity); // Assuming quantity is already an integer

        // Call updateCart function with the current book's ISBN and quantity
        updateCart(isbn, quantity);
    });
}

// Call the function to upload all books info once the site is loaded or at the appropriate time
document.addEventListener('DOMContentLoaded', uploadAllBooksInfo);


//grab the added total price of the books via HTML
var totalPriceElement = document.getElementById('total-price-value');
var totalPriceElementInclusiveShipping = document.getElementById('total-price-value-shipping-included');
var shipping = 2.99

// function which calculates the total price, is called each time the quantity of a book is modified
function updateTotalPrice() {
    let totalBookPrice = 0;
    bookInfoArray.forEach((bookInfo) => {
        var price = parseFloat(bookInfo.priceOfBook.replace(/[^\d.]/g, ''));
        var quantity = parseInt(bookInfo.quantity);
        const quantityPrice = price * quantity;
        bookInfo.quantityRelatedPrice = quantityPrice;
        totalBookPrice += quantityPrice;
        console.log('€' + bookInfo.quantityRelatedPrice.toFixed(2));
        var idOfBook = String(bookInfo.ISBN);
        document.getElementById(idOfBook).innerHTML = ('€' + bookInfo.quantityRelatedPrice.toFixed(2));

    });
    totalPriceElement.innerHTML = ' €' + totalBookPrice.toFixed(2);

    if (totalBookPrice.toFixed(2) < 29.00) {
        shipping = 2.99;
        document.getElementById('Shipping_calculate_price').style.textDecoration = 'none';
    } else {
        shipping = 0.00;
        document.getElementById('Shipping_calculate_price').style.textDecoration = 'line-through';
    }


    totalPriceElementInclusiveShipping.innerHTML = ' €' + (totalBookPrice + shipping).toFixed(2);
    return totalBookPrice;
}


actual_total_price_cart = updateTotalPrice();
console.log(bookItems);

// onclick function called when minus html item is clicked, the respective ISBN is the id name in which the clicked - is
function decrementQuantity(ISBNgiven) {
    let quantityElement = document.getElementById(ISBNgiven);
    let currentQuantity = parseInt(quantityElement.querySelector('input[name="name"]').value);
    if (currentQuantity > 0) {
        quantityElement.querySelector('input[name="name"]').value = currentQuantity - 1;
        ISBNgiven = String(ISBNgiven);
        const targetBook = bookInfoArray.find(bookInfo => bookInfo.bookID === ISBNgiven);
        targetBook.quantity -= 1;
        //upload to db
        updateCart(ISBNgiven, targetBook.quantity);
        console.log(bookInfoArray);
        actual_total_price_cart = updateTotalPrice();
        updateShoppingCart(ISBNgiven, "-1"); // Increase the quantity of ISBN  by 1
    }
}

// same as when minus clicked, but with plus, so augument by 1
function augumentQuantity(ISBNgiven) {
    let quantityElement = document.getElementById(ISBNgiven);
    let currentQuantity = parseInt(quantityElement.querySelector('input[name="name"]').value);
    quantityElement.querySelector('input[name="name"]').value = currentQuantity + 1;
    ISBNgiven = String(ISBNgiven);
    const targetBook = bookInfoArray.find(bookInfo => bookInfo.bookID === ISBNgiven);
    targetBook.quantity += 1;
    //upload to db
    updateCart(ISBNgiven, targetBook.quantity);
    console.log(bookInfoArray);
    actual_total_price_cart = updateTotalPrice();
    updateShoppingCart(ISBNgiven, "+1"); // decrease the quantity of ISBN  by 1
}

// when a number is entered instead of a +/- button clicked also onclick
function updateQuantity(event, bookReference) {
    if (event.key === 'Enter') {
        var key = String("2 " + bookReference);
        var officialQuantity = document.getElementById(key).value;
        if (isNaN(officialQuantity)) {
            document.getElementById(key).value = 0;
            alert("Quantity must be a number!");
            officialQuantity = 0;
        } else if (!Number.isInteger(parseInt(officialQuantity)) || officialQuantity < 0) {
            document.getElementById(key).value = 0;
            alert("Quantity must be a positive integer!");
            officialQuantity = 0;
        } else if (officialQuantity % 1 !== 0) {
            document.getElementById(key).value = 0;
            alert("No fractional part allowed!");
            officialQuantity = 0;
        }
        bookInfoArray.find(bookInfo => bookInfo.bookID === String(bookReference)).quantity = parseInt(officialQuantity);
        console.log(bookInfoArray);
        actual_total_price_cart = updateTotalPrice();
        updateShoppingCart(bookReference, officialQuantity); // set the quantity of ISBN  to x

        //upload to db
        updateCart(bookReference, officialQuantity);
    }
}


// paypal JavaScirpt REST API instantiation
paypal.Buttons({

    // create an order with all book data fetched from array of objects, when paypal button clicked
    createOrder: function(data, actions) {


        var totalWithShipping = parseFloat(actual_total_price_cart + shipping).toFixed(2);


        actual_total_price_cart = parseFloat(actual_total_price_cart).toFixed(2);

        return actions.order.create({
            purchase_units: [{
                /* NEW TESTING API REST JS WITH SHIPPING
                amount: {
                    currency_code: "EUR",
                    value: actual_total_price_cart,
                    breakdown: {
                        item_total: {
                            currency_code: "EUR",
                            value: actual_total_price_cart
                        }
                    }
                },
                */


                /* does not seem to work yet -> works now*/
                amount: {
                    currency_code: "EUR",
                    value: totalWithShipping,
                    breakdown: {
                        item_total: {
                            currency_code: "EUR",
                            value: actual_total_price_cart
                        },
                        shipping: {
                            currency_code: "EUR",
                            value: shipping.toString()
                        }
                    }
                },
                /**/

                items: bookInfoArray
                    .filter(book => book.quantity > 0)
                    .map(book => ({
                        name: book.bookID,
                        unit_amount: {
                            currency_code: "EUR",
                            value: book.priceOfBook.replace(/[^\d.]/g, '')
                        },
                        quantity: book.quantity
                    }))

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
                isFromShopCart: true,
            };

            if (details.purchase_units[0].shipping.address == null || details.purchase_units[0].shipping.address.length <= 3) {
                alert("Keine Adresse angegeben, die Zahlung kann nicht fortgesetzt werden");
                exit();
            }

            sendCustomerInfoToPHP(customerInfo);
        });
    },
    onError: function(err) {
        console.error(err);
    }
}).render('#paypal');

// data not only send to API via REST API, but also to own server, and backend payment processing location (process_payment.php)
function sendCustomerInfoToPHP() {
    var xhr = new XMLHttpRequest();
    var url = '/db/PayPal/process_payment.php';

    //data is sorted and checked
    bookInfoArray.forEach(book => {
        let temp = book.bookID;
        book.bookID = book.ISBN;
        book.ISBN = temp;

        book.quantityRelatedPrice = +book.quantityRelatedPrice.toFixed(2);

        book.ISBN = parseInt(book.ISBN);
        book.priceOfBook = parseFloat(book.priceOfBook.replace('€', '')).toFixed(2);
        book.priceOfBook = parseFloat(book.priceOfBook);
        //+ to convert unary back to num.
    });

    customerInfo.books = bookInfoArray;

    console.log("CustomerInfo Object for shopping cart JS structure");
    console.log(customerInfo);

    //post data and wait for response of php page
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    var data = JSON.stringify(customerInfo);

    //if result good, redirect user ot success.php
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            try {
                const response = JSON.parse(xhr.responseText);
                if (xhr.status === 200) {
                    console.log('Payment processed successfully:', response.message);
                    window.location.href = 'https://fliegenderteppich.org/success.php?status=delete_cart_content';
                } else {
                    // redirect to fail.php, which states that erroneous data has been sent, but that the payment has already been made
                    // link to support subpage, to contact admin
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

//uploader function, which sends AJAX request to php page to check and update params.
//if setcookie() activated, and CustomerID exists ?? merge ?
//if CustomerID exists, update DB orderinfo form
//else, update setcookie() function, must exist tho

//cookie modification funciton, modifies the respective cookies whenever a quantity got modified
function updateShoppingCart(isbn, change) {
    var shoppingCartCookie = getCookie('shopping_cart');
    var shoppingCart;

    if (shoppingCartCookie) {
        try {
            var decodedCookie = decodeURIComponent(shoppingCartCookie);
            shoppingCart = JSON.parse(decodedCookie);
        } catch (e) {
            console.error('Error parsing shopping_cart cookie:', e);
            return;
        }
    } else {
        shoppingCart = {};
    }

    if (change === "+1") {
        shoppingCart[isbn] = shoppingCart[isbn] ? shoppingCart[isbn] + 1 : 1;
    } else if (change === "-1") {
        if (shoppingCart[isbn]) {
            shoppingCart[isbn] -= 1;
            if (shoppingCart[isbn] <= 0) {
                delete shoppingCart[isbn];
            }
        }
    } else if (parseInt(change) > 0) {
        shoppingCart[isbn] = parseInt(change);

    } else {
        return;
    }

    setCookie('shopping_cart', JSON.stringify(shoppingCart), 7);
}
// subfunction for function updateShoppingCart(isbn, change)
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// subfunction for function updateShoppingCart(isbn, change)
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}