1.	Do NOT delete the .htaccess file.
2.	If .htaccess file isn't found, create a .htaccess file with the following contents: 

<!-- 
	RewriteEngine on 
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_FILENAME}\.php -f
	RewriteRule ^(.*)$ $1.php [NC,L]
	# PHP error handling for development servers
	php_flag display_startup_errors off
	php_flag display_errors off
	php_flag html_errors off
	php_flag ignore_repeated_errors off
	php_flag ignore_repeated_source off
	php_flag report_memleaks on
	php_value docref_root 0
	php_value docref_ext 0
	php_value error_reporting -1
 -->

3.	Test Payment Gateway details:
	Card:
		Card Number:	Any Visa or Master Card (Ex: 4111-1111-1111-1111)
		Expiration Month & Year:	Any Future month and Year (Ex: 11/21)
		CVV:	123
	Wallet:
		Mobile Number:	77777 77777
		Password:	Paytm12345
		OTP:	489871


4.	Do not login into multiple accounts simultaneously on the same window. Create a new window (either 	incognito mode or a different browser).
	(Example: Do not try to sign in to customer and admin accounts simultaneously in the same window. Singing in would work, but if the user tries to logout from any one account, it would result in the entire session getting turned off which would result in logging out from both accounts. )

5.	Do not delete the "guest@swadesh.com" entry from the Dataset.

6.	Admin Login:
	admin@swadesh.com
	pass: 123456

	Staff Login:
	staff@swadesh.com
	pass: 123456

	Customer Login:
	swadeshrest@gmail.com
	pass: 123456

Live website: https://kproj.me/swadesh/"# restaurant-order-website" 
