# FliegenderTeppich Bookshop

This is a public-facing version of the FliegenderTeppich bookshop website, an A-Level project. This repository has been cleaned of any sensitive information and reorganized for public release.

## Features

*   **Book Catalogue:** Browse and search for books.
*   **Shopping Cart:** Add books to a shopping cart and manage your selection.
*   **Checkout:** Securely purchase books using PayPal.
*   **User Accounts:** Create an account to manage your orders and personal information.
*   **Admin Dashboard:** A dashboard for administrators to manage books, orders, and users.
*   **Asynchronous Payment Processing:** Utilizes PayPal API integration and a Redis queue for efficient and secure online transactions.

## Local Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/newFliegenderTeppich.git
    cd newFliegenderTeppich
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    ```

3.  **Configure environment variables:**
    -   Copy the example environment file:
        ```bash
        cp config/.env.example config/.env
        ```
    -   Open `config/.env` and fill in the required values for your local environment (PayPal API keys, database credentials, etc.).

4.  **Set up the database:**
    -   Import the database schema from `docs/database_schema.sql` into your MySQL database.

5.  **Run the application:**
    -   You can use a local web server like Apache or Nginx, or use the built-in PHP server:
        ```bash
        php -S localhost:8000 -t public
        ```

## PayPal Environment Variables

This project uses the PayPal API for payments. You will need to create a PayPal developer account and obtain API credentials. The following environment variables need to be set in your `config/.env` file:

*   `PAYPAL_CLIENT_ID`: Your PayPal client ID.

## Deployment Note

I keep a private branch 'german_override_changes' on my Pi; this public repo is a cleaned snapshot.