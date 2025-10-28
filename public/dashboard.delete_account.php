<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Books</title>
    <link rel="stylesheet" href="css/Dashboard/delete-account.css">
</head>
<body>
    <?php
    $currentPage2 = basename($_SERVER['PHP_SELF']);
    $currentPage = 'dashboard.startmenu.php';
    include('../templates/includes/sidenavbar.php');

    include('../src/db/database_handler/dbh.classes.php');

    class CustomerData {
        private $db;

        public function __construct() {
            $this->db = (new Dbh())->connect();
        }

        public function getAllCustomersExceptOne($excludedId) {
            $stmt = $this->db->prepare("SELECT * FROM custinfo WHERE CustomerID != :excludedId");
            $stmt->bindValue(':excludedId', $excludedId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function deleteCustomer($customerId) {
            $stmt = $this->db->prepare("DELETE FROM custinfo WHERE CustomerID = :customerId");
            $stmt->bindValue(':customerId', $customerId, PDO::PARAM_INT);
            $stmt->execute();
        }

        public function getCustomerInteractionAverages() {
            try {
                $sql = "
                WITH OrderTotals AS (
                    SELECT CustomerID, SUM(Total) as TotalAmount 
                    FROM orderinfo 
                    WHERE status IN ('COMPLETED', 'DELIVERING', 'APPROVED') 
                    GROUP BY CustomerID
                ), MessageCounts AS (
                    SELECT CustomerID, COUNT(*) as MessageCount 
                    FROM messages 
                    GROUP BY CustomerID
                )
                SELECT 
                    c.CustomerID,
                    ROUND(COALESCE(o.TotalAmount, 0), 2) as TotalSpent,
                    COALESCE(m.MessageCount, 0) as SumMessages
                FROM 
                    custinfo c
                LEFT JOIN 
                    OrderTotals o ON c.CustomerID = o.CustomerID
                LEFT JOIN 
                    MessageCounts m ON c.CustomerID = m.CustomerID
                GROUP BY 
                    c.CustomerID, o.TotalAmount, m.MessageCount
                ORDER BY 
                    TotalSpent DESC;                           
                ";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $results;
            } catch (PDOException $e) {
                // Handle the exception
                error_log("Database error in getCustomerInteractionAverages: " . $e->getMessage());
                return false;
            }
        }
        
    }

    // call the db fetch classes for our vue.js instance when site is loaded
    $customerData = new CustomerData();
    $customers = $customerData->getAllCustomersExceptOne(4);
    $list_table_best_customers = $customerData->getCustomerInteractionAverages();

    // Output PHP Data as JSON for Vue.js
    echo '<script>var initialData = ' . json_encode($customers) . ';</script>';
    echo '<script>var list_table_best_customers = ' . json_encode($list_table_best_customers) . ';</script>';

    ?>

    <?php if (isset($_SESSION['CustomerID']) && isset($_SESSION['Admin'])): ?>
        <div class="content">
        <div id="app" class="inside-content-placement-div">
            <div class="list_id_show">
                <ul>
                    <li v-for="customer in sortedCustomers" :key="customer.CustomerID">
                        {{ customer.username }} - {{ customer.EmailAddress }}
                        <div class="buttons-to-click">
                            <button @click="banCustomer(customer.CustomerID)">Ban</button>
                            <button @click="selectCustomer(customer)">Details</button>
                        </div>
                        <div v-if="selectedCustomer && selectedCustomer.CustomerID === customer.CustomerID">
                            <p>Username: {{ selectedCustomer.username }}</p>
                            <p>Name: {{ selectedCustomer.Name }} </p>
                            <p>Date Of birth: {{ selectedCustomer.DOB }} </p>
                            <p>Email: {{ selectedCustomer.EmailAddress }}</p>
                            <p>Address: {{ selectedCustomer.Address }} </p>
                            <p>CustomerID: {{ selectedCustomer.CustomerID }} </p>
                            <hr>
                            <h3>Order related Informations:</h3>
                            <p>Total Spent: {{ findCustomerData(selectedCustomer.CustomerID).TotalSpent }}</p>
                            <p>Total of Messages written: {{ findCustomerData(selectedCustomer.CustomerID).SumMessages }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                customers: initialData,
                selectedCustomer: null,
                customerData: list_table_best_customers,
            },
            computed: {
                sortedCustomers() {
                    return this.customers.sort((a, b) => {
                        const aData = this.findCustomerData(a.CustomerID);
                        const bData = this.findCustomerData(b.CustomerID);
                        // Convert TotalSpent to a number before subtraction
                        const aTotalSpent = parseFloat(aData.TotalSpent) || 0;
                        const bTotalSpent = parseFloat(bData.TotalSpent) || 0;
                        return bTotalSpent - aTotalSpent;
                    });
                }
            },
            methods: {
                findCustomerData(customerId) {
                    return this.customerData.find(data => data.CustomerID === customerId) || {};
                },
                fetchCustomers() {
                    window.location.reload();
                },
                banCustomer(customerId) {
                    console.log(customerId);
                    axios.post('../src/db/database_handler/Payment/paymentUpdate.php', {
                        command: "DELETE CUSTOMERID",
                        CustomerID: customerId
                    })
                    .then(response => {
                        if(response.status === 200) {
                            alert("Customer successfully deleted");
                            this.fetchCustomers();
                        } else {
                            alert("Failed to delete customer");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("This user account cannot be deleted because it has associated orders or messages.");
                    });
                },
                selectCustomer(customer) {
                    if (this.selectedCustomer && this.selectedCustomer.CustomerID === customer.CustomerID) {
                        this.selectedCustomer = null;
                    } else {
                        this.selectedCustomer = customer;
                    }
                },
            }
        });
    </script>
</body>
</html>