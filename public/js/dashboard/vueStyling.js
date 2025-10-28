const SharedState = {
    // shared with app as active state for logic impl.
    activeChips: []
};

function fetchOrderDetails() {
    // fetch link to paymentUpdate page
    fetch('https://fliegenderteppich.org/db/database_handler/Payment/paymentUpdate.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ command: "SEND FETCHED DB DETAILS" })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            // receive data (success)
            app.groupOrdersByCustomer(data);
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}

// app vue instance used for fetching based on chips
const app = new Vue({
    el: '#app',
    data: function() {
        return {
            ordersByCustomer: {},
            selectedItem: null,
            allOrders: []
        };
    },

    methods: {
        // all fetched db objects are grouped by customerid
        groupOrdersByCustomer(data) {
            this.ordersByCustomer = data.reduce((acc, order) => {
                // group arr. by customerid
                if (!acc[order.CustomerID]) {
                    acc[order.CustomerID] = [];
                }
                acc[order.CustomerID].push(order);
                return acc;
            }, {});
            this.flattenOrders();
            console.log("Grouped Orders by CustomerID:", this.ordersByCustomer);
        },
        // called when f.e. merge sort, split into single 1 dimensional arrays for easier sorting
        flattenOrders() {
            //flatten all orders into single array, for easier merge sorting...
            this.allOrders = [];
            for (let customerId in this.ordersByCustomer) {
                this.allOrders = this.allOrders.concat(this.ordersByCustomer[customerId]);
            }
        },
        // communicating function with database php function
        fetchOrderDetails(command1) {
            // promise for resolving or rejecting answer form payment update
            return new Promise((resolve, reject) => {
                fetch('https://fliegenderteppich.org/db/database_handler/Payment/paymentUpdate.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ command: command1 })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        this.groupOrdersByCustomer(data);
                        resolve(); // resolve promise after processing the data
                    })
                    .catch(error => {
                        console.error('There has been a problem with your fetch operation:', error);
                        reject(error); // reject  promise if there's error
                    });
            });
        },
        // called when order is clicked
        showDetails(order) {
            this.selectedItem = order;
        },
        // called when order details are shown and go back to orders button is clicked
        hideDetails() {
            this.selectedItem = null;
        },
        // called when chip only delivered is active
        updateOrderToSent(bookID) {
            const requestBody = {
                command: "CHANGE DETAILS TO DELIVERING",
                orderId: bookID
            };

            const url = 'https://fliegenderteppich.org/db/database_handler/Payment/paymentUpdate.php';
            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestBody)
            };
            fetch(url, options)
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Network response was not ok');
                    }
                })
                .then(data => {
                    this.fetchOrderDetails("SEND FETCHED DB DETAILS");
                    alert("Order updated succesfully.");
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        },
        handleOrderChange(order) {
            this.updateOrderToSent(order.OrderNumber);

            let fullAddress = `${order.delivery_street_address}, ${order.delivery_postal_code} ${order.delivery_city}, ${order.delivery_country}`;
            if (order.CustomerName === null) {
                order.CustomerName = "Customer";
            }
            this.notifySender(order.CustomerName, order.BookName, order.OrderDate, fullAddress, order.Price, order.EmailAddress);
        },
        // communicates with mail bot to notify customer when admin clicks on order sent - arriving -> mail tells customer about 3-4 days time till book arrives
        notifySender(Name, Product, Date, Address, Price, Email) {
            const requestBody = {
                command: "NOTIFY SENDER",
                customerName: Name,
                customerProduct: Product,
                OrderDate: Date,
                ShippingAddress: Address,
                Price: Price,
                EmailAddress: Email,
            };

            console.log(requestBody);


            const url = 'https://fliegenderteppich.org/db/database_handler/Payment/paymentUpdate.php';
            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestBody)
            };
            fetch(url, options)
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Network response was not ok');
                    }
                })

        },
        //part of merge sort algorithm with falttenorders, mergesort, and merge
        sortNewestOldest(status) {
            // This would show the groups in the same logic, except that every customerid group is sorted, we do the other way (--> reimplement if later, as works)
            if (status === "added") {
                // Use the flat structure for sorting
                const sortedOrders = this.mergeSort(this.allOrders);
                console.log(sortedOrders);

                // Reformat sortedOrders to match structure of ordersByCustomer
                this.ordersByCustomer = sortedOrders.reduce((acc, order) => {
                    if (!acc[order.CustomerID]) {
                        acc[order.CustomerID] = [];
                    }
                    acc[order.CustomerID].push(order);
                    return acc;
                }, {});
                console.log("sortNewestOldest fucniton called, (status = 'added') data: ");
                console.log(this.ordersByCustomer);
            }


            if (status === "removed") {
                // Re-fetch original order details
                this.fetchOrderDetails("SEND FETCHED DB DETAILS");
            }
        },
        // classic merge sort by date field of each array
        mergeSort(arr) {
            if (arr.length <= 1) {
                return arr;
            }

            const middle = Math.floor(arr.length / 2);
            const left = arr.slice(0, middle);
            const right = arr.slice(middle);

            return this.merge(this.mergeSort(left), this.mergeSort(right));
        },

        merge(left, right) {
            let result = [];
            let leftIndex = 0;
            let rightIndex = 0;

            while (leftIndex < left.length && rightIndex < right.length) {
                if (new Date(left[leftIndex].OrderDate) > new Date(right[rightIndex].OrderDate)) {
                    result.push(left[leftIndex]);
                    leftIndex++;
                } else {
                    result.push(right[rightIndex]);
                    rightIndex++;
                }
            }

            return result.concat(left.slice(leftIndex)).concat(right.slice(rightIndex));
        },
        fetchAllOrders(status) {
            if (status === 'undelivered_cancel_and_merge_sort') {

                this.fetchOrderDetails("FETCH ALL ORDERS")
                    .then(() => {
                        console.log("Data fetched, now sorting");
                        this.sortNewestOldest('added');
                    })
                    .catch(error => console.error('Error in fetching orders:', error));


            } else if (status === 'undelivered_cancel_and_noFilter_applied') {
                this.fetchOrderDetails("FETCH ALL ORDERS");
            } else if (status === 'delivered_cancel_and_noFilter_applied') {
                this.fetchOrderDetails("FETCH ALL ORDERS");
            } else if (status === 'delivered_cancel_and_merge_sort') {
                this.fetchOrderDetails("FETCH ALL ORDERS")
                    .then(() => {
                        console.log("Data fetched, now sorting");
                        this.sortNewestOldest('added');
                    })
                    .catch(error => console.error('Error in fetching orders:', error));
            }
        },
        isChipActive(chipId) {
            return SharedState.activeChips.some(c => c.id === chipId);
        },
        // IMPORTANT: currently not active but (fully) implemented, as google matrix distance API requires bank account to generate key
        // if there was a valid api key, when clicked on button distance of driving car to destination from certain point calculated and printed
        calculateTravelTime() {
            if (!this.selectedItem) return;

            var origin = 'Danziger Straße 89231 Neu Ulm, Deutschland, Bayern';
            var destination = this.selectedItem.delivery_street_address + ', ' +
                this.selectedItem.delivery_city + ', ' +
                this.selectedItem.delivery_postal_code + ', ' +
                this.selectedItem.delivery_country;

            var service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix({
                origins: [origin],
                destinations: [destination],
                travelMode: 'DRIVING',
            }, (response, status) => {
                if (status == 'OK') {
                    var results = response.rows[0].elements[0];
                    var distance = results.distance.text;
                    var duration = results.duration.text;
                    alert('Distance: ' + distance + ', Travel Time: ' + duration);
                }
            });
        },
    },
    mounted() {
        fetchOrderDetails();
    }
});


new Vue({
    el: '#chip-filter',
    data: function() {
        return {
            // by default, only undelivered chip filter is active
            activeChips: [
                { id: 'undelivered', label: 'Only Undelivered Orders', action: this.fetchAllOrders }
            ],
            availableChips: [
                { id: 'delivered', label: 'Only Delivered Orders', action: this.fetchCompletedOrders },
                { id: 'newest', label: 'From newest to oldest', action: this.fetchAllOrders }
            ],
            showAvailable: false
        };
    },
    methods: {
        // called when a chip is added, checks what kind of chip is added -> respective functions called to selected chips
        addChip(chip) {
            const hasNewest = this.activeChips.some(c => c.id === 'newest');

            if (chip.id === 'newest') {
                app.sortNewestOldest("added");
            } else if (chip.id === 'undelivered' && !hasNewest) {
                app.fetchOrderDetails('SEND FETCHED DB DETAILS');
            } else if (chip.id === 'undelivered' && hasNewest) {
                app.fetchOrderDetails('SEND FETCHED DB DETAILS')
                    .then(() => {
                        console.log("Data fetched, now sorting");
                        app.sortNewestOldest('added');
                    })
                    .catch(error => console.error('Error in fetching orders:', error));
            } else if (chip.id === 'delivered' && hasNewest) {
                app.fetchOrderDetails('ONLY FETCH DELIVERING')
                    .then(() => {
                        console.log("Data fetched, now sorting");
                        app.sortNewestOldest('added');
                    })
                    .catch(error => console.error('Error in fetching orders:', error));
            } else if (chip.id === 'delivered' && !hasNewest) {
                app.fetchOrderDetails('ONLY FETCH DELIVERING');
            }

            this.activeChips.push(chip);
            this.availableChips = this.availableChips.filter(c => c.id !== chip.id);
            this.showAvailable = false;
        },
        removeChip(chip1, index) {
            //does chip have newest active (filter for fetching)
            const hasNewest = this.activeChips.some(c => c.id === 'newest');
            const hasClass2Delivered = this.activeChips.some(c => c.id === 'delivered');
            const hasClass2Undelivered = this.activeChips.some(c => c.id === 'undelivered');

            // conditional logic which calls sorting and/or db fetch statements depending on which chips got deleted (so which stay active)
            if (chip1.id === 'newest' && !(hasClass2Delivered || hasClass2Undelivered)) {
                app.fetchOrderDetails("FETCH ALL ORDERS");
            } else if (chip1.id === 'newest' && hasClass2Delivered) {
                app.fetchOrderDetails('ONLY FETCH DELIVERING');
                console.log("filter gets deleted, but chip delivered only active");
            } else if (chip1.id === 'newest' && hasClass2Undelivered) {
                app.fetchOrderDetails('SEND FETCHED DB DETAILS');
                console.log("filter gets deleted, but chip undelivered only active");
            } else if (chip1.id === 'undelivered' && hasNewest) {
                app.fetchAllOrders('undelivered_cancel_and_merge_sort');
            } else if (chip1.id === 'undelivered' && !hasNewest) {
                app.fetchAllOrders('undelivered_cancel_and_noFilter_applied');
            } else if (chip1.id === 'delivered' && !hasNewest) {
                app.fetchAllOrders('delivered_cancel_and_noFilter_applied');
            } else if (chip1.id === 'delivered' && hasNewest) {
                app.fetchAllOrders('delivered_cancel_and_merge_sort');
            }
            const chip = this.activeChips.splice(index, 1)[0];
            this.availableChips.push(chip);
            this.showAvailable = false;

            SharedState.activeChips = this.activeChips;
        },
        showAvailableChips() {
            // boolean constants which indicate if specific chips are selected/active
            const hasFilteringChip = this.activeChips.some(chip => chip.id === 'newest');
            const hasSelectionChip = this.activeChips.some(chip => chip.id === 'undelivered' || chip.id === 'delivered');

            if (hasSelectionChip && !hasFilteringChip) {
                // only filtering chip showed as selection chip already active
                this.availableChips = [
                    { id: 'newest', label: 'From newest to oldest', action: this.fetchAllOrders }
                ];
            } else if (!hasSelectionChip) {
                // no selection chip active both selection chips printed
                this.availableChips = [
                    { id: 'delivered', label: 'Only Delivered Orders', action: this.fetchCompletedOrders },
                    { id: 'undelivered', label: 'Only Undelivered Orders', action: this.fetchAllOrders }
                ];
                // filtering chip only showed if not already active
                if (!hasFilteringChip) {
                    this.availableChips.push({ id: 'newest', label: 'From newest to oldest', action: this.fetchAllOrders });
                }
            } else if (hasSelectionChip && hasFilteringChip) {
                this.availableChips = [];
            }
            this.showAvailable = !this.showAvailable;
        },
        fetchAllOrders() {
            // implement logic for all ord. ?
        },
        fetchCompletedOrders() {
            // implement logic for all complete ?
        }
    }
});
