Admin panel added.
Files created/modified:
- config.php (DB connection)
- admin/ (login, dashboard, edit_page, manage_faq, manage_products, setup.php, logout.php)
- uploads/ (for product images)
- db_setup.sql (SQL to create DB and tables)
- db_seed_products.sql (seed product inserts if h-products.json existed)
- index.php, about.php, faq.php, contact.php, products.php (frontend pages reading from DB)

How to use:
1. Place this project in your PHP-enabled server (XAMPP, LAMP, etc).
2. Open browser to /WEB-SITE-PROJECT.github.io/admin/setup.php to run the DB setup (run once).
   - Default DB user in config.php is root with empty password. Adjust config.php if different.
3. Login at /WEB-SITE-PROJECT.github.io/admin/login.php with username 'admin' and password 'admin123' (change after first login).
4. Use the dashboard to edit pages, manage FAQs and products.
5. Uploaded product images are saved to /uploads/

Security notes:
- Remove or protect setup.php after running.
- Change default admin password immediately.
- Consider using HTTPS and additional hardening for production.
