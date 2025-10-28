window.onload = function() {
    const textContainer = document.getElementById("descriptionText");
    const text = textContainer.innerHTML;

    const lines = text.split('\n');
    let formattedText = '';

    for (let i = 0; i < lines.length; i++) {
        formattedText += lines[i] + '<br>';
    }

    textContainer.innerHTML = formattedText;
};

//This script down here should: Grab the ISBN of the Book of the subpage, validate it, and send it to add-to-shopping-cart.php, where it is then decided if it is encoded into cookies (if no ISSET customerid superglobal), else, it is loaded up into database

function sendBookInfoToPHP(ISBN) {
    var xhr = new XMLHttpRequest();
    var url = '../db/shopping-cart/add-to-shopping-cart.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    var data = {
        ISBN: ISBN
    };

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                //alert("Article successfully added to shopping cart!");
                console.log('Response from PHP page:', xhr.responseText);
            } else {
                //alert("There was an error adding the article to the shopping cart.");
            }
        }
    };

    xhr.send(JSON.stringify(data));
}

document.addEventListener("DOMContentLoaded", function() {
    let ISBN = document.getElementById("bookID").textContent;
    ISBN = ISBN.replace(/"/g, '');
    ISBN = parseInt(ISBN);

    document.getElementById("addToCartButton").addEventListener("click", function() {
        sendBookInfoToPHP(ISBN);
    });
});