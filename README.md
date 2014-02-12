#Patchwork Invoicer

**Simple CodeIgniter Invoicer**

This invoicer is an old project I used to learn more about CodeIgniter, PHP frameworks and MVC. It isn't anything fancy, but a handful of other freelancers and I have been using it successfully for a couple of years now.

- One user per install
- Designed for use on localhost (If you want to use it on a live server, at least setup basic authentication over HTTPS)
- Requires Apache with mod_rewrite

##Install

1. Clone repository to a folder in your web root
2. Create a new database and import patchwork-invoicer.sql
3. Open .htaccess and adjust `RewriteBase /` on line 3 to match the path to the new folder (ex. `RewriteBase /patchwork-invoicer`)
4. In `application/config/config.php`, change `$config['base_url']	= '/';` to match the path from step 2 (ex. `$config['base_url']	= '/patchwork-invoicer';`)
5. Modify the db connection details in `application/config/database.php` to match those of the database created in the second step
6. In `application/config/user_info.php`, fill out the user details that will appear in the header of generated invoices

##Usage

1. Add client(s)
2. Add project(s)
3. Add chunk(s)
3. Add invoice
4. Print invoice
5. View report