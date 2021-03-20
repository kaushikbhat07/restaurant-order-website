To run on a local environment:
----------------------------------------------------------------------
1.	Import the .sql file found in the directory Database File/.
Change the database name and password in the config.ini files found in includes/, admin/includes/, staff/includes.

2.	The project uses [PHPMailer](https://github.com/PHPMailer/PHPMailer) to send emails. 
To be able to send emails on a local environment, update the user and pass parameters in config.ini files found in includes/, admin/includes/, staff/includes with your GMAIL ID and password.

3. Turn on less secure apps on your gmail ID. (Follow the instructions under "Turning on 'less secure apps' settings as mailbox user" [here](https://hotter.io/docs/email-accounts/secure-app-gmail/)). This is required for the emails to be sent.
----------------------------------------------------------------------
Other credentials:

1.	Test Payment Gateway details:
	Card:
		Card Number:	Any Visa or Master Card (Ex: 4111-1111-1111-1111)
		Expiration Month & Year:	Any Future month and Year (Ex: 11/21)
		CVV:	123
	Wallet:
		Mobile Number:	77777 77777
		Password:	Paytm12345
		OTP:	489871

2.	Admin Login:
	admin@swadesh.com
	pass: 123456

	Staff Login:
	staff@swadesh.com
	pass: 123456

	Customer Login:
	swadeshrest@gmail.com
	pass: 123456

3. 	Customer:	http://swadesh.epizy.com/swadesh/
	Admin:	http://swadesh.epizy.com/swadesh/admin	
	Staff:	http://swadesh.epizy.com/swadesh/staff
