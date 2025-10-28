<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMu1AWFgpYTCpLIB25eM7qKN7x981Fg30&libraries=places"></script>

    <link rel="stylesheet" href="css/Dashboard/payment_style.css">
</head>
<body>
    <?php
    $currentPage2 = basename($_SERVER['PHP_SELF']);
    $currentPage = 'dashboard.startmenu.php';
    include('../templates/includes/sidenavbar.php');
    ?>
    <?php
    
    if (isset($_SESSION['CustomerID']) && isset($_SESSION['Admin'])) {
        ?>
        <div class="content">
            <div class="see_payment_dashboard">
                <div id="chip-filter">
                    <div class="chip-filter-orders-chip">
                        <!-- Aktive Filter -->
                        <span v-for="(chip, index) in activeChips" :key="chip.id" class="mdl-chip mdl-chip--deletable">
                            <span @click="chip.action" class="mdl-chip__text">{{ chip.label }}</span>
                            <button @click="removeChip(chip, index)" type="button" class="mdl-chip__action"><i class="material-icons">cancel</i></button>
                        </span>

                        <!-- Button zum Hinzufügen von Filtern -->
                        <button @click="showAvailableChips" class="mdl-button mdl-js-button mdl-button--fab">
                            <i class="material-icons">add</i>
                        </button>

                        <!-- Verfügbare Filter -->
                        <div v-if="showAvailable" class="available-chips">
                            <span v-for="chip in availableChips" :key="chip.id" @click="addChip(chip)">
                                {{ chip.label }}
                            </span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="payment-list-definition">
                    <span>Name der Bestellung</span> 
                    <span>Bestellung absenden ?</span>
                </div>
                <div id="app" :class="{'selected-item-active': selectedItem}">
                    <div class="order-list" v-if="!selectedItem">
                        <div v-for="(customerOrders, customerId) in ordersByCustomer" :key="'customer-' + customerId" class="customer-orders">
                            <h3 v-if="customerOrders[0]">
                                <span v-if="customerOrders[0].CustomerName">Benutzername: {{ customerOrders[0].CustomerName }}</span>
                                <span v-else>Nicht angemeldet</span>
                            </h3>
                            <div v-for="order in customerOrders" :key="order.OrderNumber" class="order-item" @click.self="showDetails(order)">
                                <span @click="showDetails(order)">Buch: {{ order.BookName }}</span>
                                <input type="checkbox" v-model="order.sent" class="sent-checkbox" v-if="!isChipActive('delivered')" :id="'checkbox-' + order.OrderNumber" @click="handleOrderChange(order)">
                                <label :for="'checkbox-' + order.OrderNumber" class="custom-checkbox" v-if="!isChipActive('delivered')"></label>
                            </div>
                        </div>
                    </div>

                    <div class="order-details" v-if="selectedItem">
                        <h3>Bestellungsdetails - {{ selectedItem.BookName }}</h3>
                        <p>System registrierte Email: {{ selectedItem.EmailAddress }}</p>
                        <p>System registrierter Name: {{ selectedItem.Name }}</p>
                        <p v-if="selectedItem.PaymentID === 1">Payment Type: Regular PayPal</p>
                        <p>Preis: {{ selectedItem.Price }}</p>
                        <p>Quantität: {{ selectedItem.Quantity}}</p>
                        <p>Finaler Preis: {{ selectedItem.Total}}</p>
                        <p>Datum der Bestellung: {{ selectedItem.OrderDate }}</p>
                        <p>Produkt Name: {{ selectedItem.BookName }}</p>
                        <h3>Liefer Addresse:</h3>
                        <hr>
                        <p>Land: {{ selectedItem.delivery_country }}</p>
                        <p>Stadt: {{ selectedItem.delivery_city }}</p>
                        <p>Postleizahl: {{ selectedItem.delivery_postal_code }}</p>
                        <p>Straße: {{ selectedItem.delivery_street_address }}</p>
                        <!--<button @click="calculateTravelTime">Calculate Travel Time</button>-->
                        <button @click="hideDetails">Zurück</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <script src="js/dashboard/vueStyling.js"></script>
</body>
</html>
