# Project Cleanup: Summary of Changes

This document outlines the changes made to the project to prepare it for public release.

## File & Folder Restructuring

*   **`public/`**: Created a new webroot directory. All user-facing PHP files and assets were moved here.
*   **`src/`**: Created a new directory for all backend code, including database handlers and other classes.
*   **`templates/`**: Created a new directory for reusable view partials like headers and footers.
*   **`config/`**: Created a new directory for configuration files.
*   **`docs/`**: Moved all documentation, including the database schema, to this directory.

### File Mappings

| Old Path                                      | New Path                                          |
| --------------------------------------------- | ------------------------------------------------- |
| `404.php`                                     | `public/404.php`                                  |
| `a_book_name.php`                             | `public/a_book_name.php`                          |
| `about-me.php`                                | `public/about-me.php`                             |
| `aboutShipping.php`                           | `public/aboutShipping.php`                        |
| `account.php`                                 | `public/account.php`                              |
| `admin_dashboard.php`                         | `public/admin_dashboard.php`                      |
| `Atomic_Habits.php`                           | `public/Atomic_Habits.php`                        |
| `blog.php`                                    | `public/blog.php`                                 |
| `book_details.php`                            | `public/book_details.php`                         |
| `bookSubpage.php`                             | `public/bookSubpage.php`                          |
| `cart.php`                                    | `public/cart.php`                                 |
| `checkout.php`                                | `public/checkout.php`                             |
| `confirmation.php`                            | `public/confirmation.php`                         |
| `contact.php`                                 | `public/contact.php`                              |
| `dashboard.addBook.php`                       | `public/dashboard.addBook.php`                    |
| `dashboard.blog.php`                          | `public/dashboard.blog.php`                       |
| `dashboard.delete_account.php`                | `public/dashboard.delete_account.php`             |
| `dashboard.messages.php`                      | `public/dashboard.messages.php`                   |
| `dashboard.payment.php`                       | `public/dashboard.payment.php`                    |
| `dashboard.startmenu.php`                     | `public/dashboard.startmenu.php`                  |
| `fail.php`                                    | `public/fail.php`                                 |
| `index.php`                                   | `public/index.php`                                |
| `login.php`                                   | `public/login.php`                                |
| `login2.php`                                  | `public/login2.php`                               |
| `logout.php`                                  | `public/logout.php`                               |
| `settings.php`                                | `public/settings.php`                             |
| `shop.php`                                    | `public/shop.php`                                 |
| `success.php`                                 | `public/success.php`                              |
| `css/`                                        | `public/css/`                                     |
| `js/`                                         | `public/js/`                                      |
| `img/`                                        | `public/img/`                                     |
| `db/`                                         | `src/db/`                                         |
| `includes/`                                   | `templates/includes/`                             |
| `docs/`                                       | `docs/`                                           |
| `database_schema.sql`                         | `docs/database_schema.sql`                        |
| `sql/`                                        | `docs/sql/`                                       |

## Secret Management

*   **Removed Hardcoded Secrets:** All hardcoded secrets, including API keys and database passwords, have been removed from the codebase.
*   **Environment Variables:** Secrets are now loaded from environment variables using `getenv()`.
*   **`.env.example`:** A new `config/.env.example` file has been created to provide a template for the required environment variables.
*   **`.gitignore`:** The `config/.env` file, along with other sensitive files and directories, has been added to the `.gitignore` file to prevent them from being committed to the repository.

### Secret Replacements

*   **PayPal Client ID:** Replaced in multiple files with `getenv('PAYPAL_CLIENT_ID')`.
*   **Database Password:** Replaced in `src/db/database_handler/dbh.classes.php` with `getenv('DB_PASS')`.
*   **Mail Password:** Replaced in `src/db/PayPal/mailBotNotify.php` with `getenv('MAIL_PASSWORD')`.

## Path and URL Updates

*   **JavaScript Files:** Updated hardcoded URLs in `public/js/shopping-cart.js` and `public/js/paypalAPI.js` to use relative paths.
*   **PHP Includes:** All `include` and `require` paths in the user-facing PHP files have been updated to reflect the new directory structure.
