<?php

function setMessage($error)
{
	echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		  ' . $error . '
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';
}
function clear_input($input) 	//htmlspclchars, removes empty spaces
{
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}
function redirect($location)	//Simplifying the HEADER(location: $loc) function
{
	return header("Location: $location");
}

class customer
{
	private $con, $sql, $send_query, $get, $row, $datetime;
	public $temp, $flag, $email, $fname, $lname, $quantity, $item_id, $totalPrice, $totalQuantity, $handling, $amountToPay, $last_id;
	public function __construct()	//constructor to connect to DB
	{
		$this->totalQuantity = 1;
		$this->row = array();
		$this->con = new connectDB();
		$this->con->connect();
		date_default_timezone_set('Asia/Kolkata');
		$this->datetime = date("Y-m-d H:i:s");
		$this->temp = $this->flag = 0;
		$this->quantity = 1;
		require 'PHPMailer/PHPMailerAutoload.php';
		// if(isset($_SESSION['CART_ACTIVE'])) {
		// }		
	}
	public function __destruct()
	{
		$this->con->disconnect();
	}
	public function display_categories_homepage()	//display categories in index#menu
	{
		$this->sql = "SELECT cat_id, icon_url, cat_title, cat_desc from categories ORDER BY date_added ASC";
		$this->send_query = $this->con->prepare($this->sql);
		if (isset($this->send_query)) {
			// mysqli_stmt_bind_param($this->send_query, "i", $cat_id);
			mysqli_stmt_execute($this->send_query);
			mysqli_stmt_bind_result($this->send_query, $cat_id, $icon_url, $cat_title, $cat_desc);
			while (mysqli_stmt_fetch($this->send_query)) {
				echo '
				<div class="col-lg-4 col-md-6 box wow bounceInUp" data-wow-duration="1.4s">
		        <div class="icon"><img src="' . $icon_url . '"></div>
		        <h4 class="title"><a href="menu?cat=' . base64_encode($cat_id) . '" class="menu-categories">' . $cat_title . '</a></h4>
		        <p class="description">' . $cat_desc . '</p>
		        </div>
				';
			}
			mysqli_stmt_close($this->send_query);
		}
	}

	public function get_items_menu_page()	//display items & cat in menu?cat=MTEx
	{
		if (isset($_GET['cat'])) {
			$cat_id = base64_decode($_GET['cat']);
			$this->sql = "SELECT i.item_id, i.item_title, i.item_price, i.item_image, i.isAvailable, i.sub_cat_id FROM items i WHERE cat_id = ? AND i.isAvailable = 1 ORDER BY date_added ASC";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "i", $cat_id);
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_bind_result($this->send_query, $item_id, $item_title, $item_price, $item_image, $isAvailable, $sub_cat_id);
				while (mysqli_stmt_fetch($this->send_query)) {
					echo '
		            <div class="col-xl-3 col-md-6 mb-4 portfolio-item filter-' . $sub_cat_id . ' wow fadeInUp">
		            <div class="portfolio-wrap">
		              <div class="card border-0 shadow">
		                <div class="card-body">
		                    <h5 class="card-title mb-0"><a href="item?itid=' . base64_encode($item_id) . '" class="item-name">' . $item_title . '</a></h5>
		                    <div class="card-text text-black-50">&#8377; ' . $item_price . '</div>
		                    <div class="add-to-cart">
		                        <a href="item?itid=' . base64_encode($item_id) . '&cart=' . base64_encode($item_id) . '"><img src="img/icons/addtocart.png" alt="Add to cart"></a> 
		                    </div>  
		                </div>
		                <a href="item?itid=' . base64_encode($item_id) . '"><img src="' . $item_image . '" class="card-img-top img-fluid" alt="..."></a>
		              </div>
		            </div>                
		            </div>
					';
				}
				mysqli_stmt_close($this->send_query);
			}
		} else {
			redirect("notfound");	//if QUERY STRING is changed.
		}
	}

	public function get_cat_menu_page()	//display items & cat in menu?cat=MTEx
	{
		if (isset($_GET['cat'])) {
			$cat_id = $this->con->escape(clear_input(base64_decode($_GET['cat'])));
			$this->sql = "SELECT cat_title FROM categories WHERE cat_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			mysqli_stmt_bind_param($this->send_query, "i", $cat_id);
			mysqli_stmt_bind_result($this->send_query, $cat_title);
			mysqli_stmt_execute($this->send_query);
			if (isset($this->send_query) && mysqli_stmt_store_result($this->send_query)) {
				$cat_exists = mysqli_stmt_num_rows($this->send_query);
				if ($cat_exists >= 1) {
					while (mysqli_stmt_fetch($this->send_query)) {
						echo '<h3 class="section-title">' . $cat_title . '</h3>';
					}
					echo '
			        </header>

			        <div class="row">
			          <div class="col-lg-12">
			            <ul id="portfolio-flters">
			              <li data-filter="*" class="filter-active">All</li>
					';
					mysqli_stmt_free_result($this->send_query);
					mysqli_stmt_close($this->send_query);
				} else {
					mysqli_stmt_free_result($this->send_query);
					mysqli_stmt_close($this->send_query);
					// redirect("index");
					redirect("notfound");
				}
			}
			if ($cat_exists >= 1) {
				$this->sql = "SELECT s.sub_cat_id, s.sub_cat_title FROM subcategories s WHERE s.cat_id = ? ORDER BY s.date_added ASC";
				$this->send_query = $this->con->prepare($this->sql);
				if (isset($this->send_query)) {
					mysqli_stmt_bind_param($this->send_query, "i", $cat_id);
					mysqli_stmt_bind_result($this->send_query, $sub_cat_id, $sub_cat_title);
					mysqli_stmt_execute($this->send_query);
					while (mysqli_stmt_fetch($this->send_query)) {
						echo '
			              <li data-filter=".filter-' . $sub_cat_id . '">' . $sub_cat_title . '</li>
						';
					}
					mysqli_stmt_close($this->send_query);
				}
			}
		}
	}

	public function display_categories_sidebar()	//item?itid=MzMzMzY0 - OTHER CATEGORIES TO CHOOSE FROM
	{
		$sep1 = '<a href="item" class="list-group-item-cus list-group-item-action">';
		$sep2 = '</a>';
		$this->sql = "SELECT c.cat_id, c.cat_title, c.icon_url FROM categories c ORDER BY c.date_added ASC";
		$this->send_query = $this->con->query($this->sql);
		if (isset($this->send_query)) {
			while ($this->row = mysqli_fetch_array($this->send_query)) {
				echo '
				<div class="card">
					<div class="card-header" id="headingOne">
					  <h2 class="mb-0">
					  <img src="' . $this->row['icon_url'] . '">
					    <a href="menu?cat=' . base64_encode($this->row['cat_id']) . '" class="btn btn-link" type="button">
					       ' . $this->row['cat_title'] . '
					    </a>
					    <button class="btn btn-link categories-next"><a href="menu?cat=' . base64_encode($this->row['cat_id']) . '" target="_blank"><i class="ion ion-android-open"></i></a></button>
					    <!-- <a href="menu"></a> -->
					  </h2>
					</div>
				</div>
				';
			}
		} else {
			redirect("notfound");
		}
	}

	public function related_items()		//item?itid=MzMzMzY0
	{
		$this->sql = "SELECT i.item_id, i.item_title, i.item_price, i.item_image, i.isAvailable, i.sub_cat_id FROM items i WHERE i.isAvailable = 1 ORDER BY RAND() LIMIT 4";
		$this->send_query = $this->con->prepare($this->sql);
		if (isset($this->send_query)) {
			// mysqli_stmt_bind_param($this->send_query, "i", $cat_id);
			mysqli_stmt_bind_result($this->send_query, $item_id, $item_title, $item_price, $item_image, $isAvailable, $sub_cat_id);
			mysqli_stmt_execute($this->send_query);
			while (mysqli_stmt_fetch($this->send_query)) {
				echo '
	            <div class="col-xl-3 col-md-6 mb-4 portfolio-item filter-' . $sub_cat_id . ' wow fadeInUp">
	            <div class="portfolio-wrap">
	              <div class="card border-0 shadow">
	                <div class="card-body">
	                    <h5 class="card-title mb-0"><a href="item?itid=' . base64_encode($item_id) . '" class="item-name">' . $item_title . '</a></h5>
	                    <div class="card-text text-black-50">&#8377; ' . $item_price . '</div>
	                    <div class="add-to-cart">
	                        <a href="item?itid=' . base64_encode($item_id) . '&cart=' . base64_encode($item_id) . '"><img src="img/icons/addtocart.png" alt=""></a> 
	                    </div>  
	                </div>
	                <a href="item?itid=' . base64_encode($item_id) . '"><img src="' . $item_image . '" class="card-img-top img-fluid" alt="' . $item_title . '"></a>
	              </div>
	            </div>                
	            </div>
				';
			}
			mysqli_stmt_close($this->send_query);
		}
	}

	public function display_item_page()			//item?itid=MzMzMzY0 - the big image
	{
		if (isset($_GET['itid'])) {
			$item_id = $this->con->escape(clear_input(base64_decode($_GET['itid'])));
			$this->sql = "SELECT i.item_title, i.item_price, i.item_image, i.isAvailable, i.item_limit FROM items i WHERE i.item_id = " . $item_id;
			$this->send_query = $this->con->prepare($this->sql);

			if (isset($this->send_query)) {
				mysqli_stmt_bind_result($this->send_query, $item_title, $item_price, $item_image, $isAvailable, $item_limit);
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_store_result($this->send_query);
				if (mysqli_stmt_num_rows($this->send_query) >= 1) {
					while (mysqli_stmt_fetch($this->send_query)) {
						echo '
				        <h1 class="my-4"><b>' . $item_title . '</b>
				        <br><small>&#8377;&nbsp;' . $item_price . '</small>
				        </h1>

				        <img class="img-fluid" src="' . $item_image . '" alt="' . $item_image . '">
						';
					}
					mysqli_stmt_close($this->send_query);
				} else {
					mysqli_stmt_close($this->send_query);
					redirect("notfound");
				}
			}
		} else {
			redirect("notfound");
		}
	}

	public function register_account()		//http://localhost/swadesh/register
	{
		// $this->flag = 0;
		if (isset($_POST['register_submit']) && !isset($_GET['s'])) {
			$pass = md5($this->con->escape($_POST['pass']));
			$pass_confirm = md5($this->con->escape($_POST['pass_confirm']));
			if ($pass === $pass_confirm) {
				$this->fname = $this->con->escape(clear_input($_POST['fname']));
				$this->lname = $this->con->escape(clear_input($_POST['lname']));
				$this->email = $this->con->escape(clear_input($_POST['email']));
				$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';		//generate verify key
				$verify_key = substr(str_shuffle($str_result), 0, 20); 		//generate verify key

				$this->sql = "INSERT INTO `login_info` (`email`, `password`, `date_added`) VALUES (?, ?, ?)";
				$this->send_query = $this->con->prepare($this->sql);
				mysqli_stmt_bind_param($this->send_query, "sss", $this->email, $pass, $this->datetime);

				$sql2 = "INSERT INTO `customers` (`first_name`, `last_name`, `email`, `login_access`, `verify_key`, `isVerified`) VALUES (?, ?, ?, ?, ?, ?)";
				$this->temp = 0;	//LOGIN ACCESS
				$send_query2 = $this->con->prepare($sql2);
				mysqli_stmt_bind_param($send_query2, "sssisi", $this->fname, $this->lname, $this->email, $this->temp, $verify_key, $this->temp);

				if (isset($this->send_query) && isset($send_query2)) {
					if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_execute($send_query2)) {
						if ($this->verify_email_register($this->email, $this->fname, $this->lname, $verify_key)) {
							mysqli_stmt_close($this->send_query);
							mysqli_stmt_close($send_query2);
							redirect("register?s=1&cid=" . base64_encode($this->con->last_id()));
						} else {
							mysqli_stmt_close($this->send_query);
							mysqli_stmt_close($send_query2);
							setMessage("Could not send verification email. Please check your internet connection. ");
						}
					} else {
						mysqli_stmt_close($this->send_query);
						mysqli_stmt_close($send_query2);
						setMessage("This email ID is already regstered with us. Please use a different email ID. Or <a href='register?resend=" . base64_encode($this->email) . "&s=1'>Click here</a> to resend the verification email");
					}
				}
			} else {
				setMessage("The passwords don't match.");
			}
		}
	}

	public function verify_email_register(&$email, &$fname, &$lname, &$verify_key)		//CALLED IN THE PREVIOUS FUNCTION
	{
		$mail = new PHPMailer;
		$mail->isSMTP();
		// $mail->SMTPDebug = 2;

		$config = parse_ini_file('includes/config.ini', true);

		$mail->Host = 'smtp.gmail.com'; // Which SMTP server to use.
		$mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
		$mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
		$mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
		$mail->Username = $config['user']; // Your Gmail address.
		$mail->Password = $config['pass']; // Your Gmail login password or App Specific Password.

		$name = $fname . " " . $lname;
		// $cc = "kaushik.bantval98@gmail.com";
		$_SERVER['SERVER_PORT'] == 80 ? $port = "http://" : $port = "https://";

		$message = $port . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?key=' . base64_encode($verify_key) . '&s=2&email=' . base64_encode($email);
		$subject = 'Swadesh Restaurant - Email verification';
		// $mail->AddReplyTo($reply_to, $fname);
		$mail->setFrom($mail->Username, 'Swadesh Restaurant'); // Set the sender of the message.
		$mail->addAddress($email, $name); // Set the recipient of the message.
		// $mail->AddCC($cc, 'Kaushik - Website Form');	//CC email
		$mail->Subject = $subject; // The subject of the message.

		$mail->Body = $message; // Set a plain text body.

		// ... or send an email with HTML.
		//$mail->msgHTML(file_get_contents('contents.html'));
		// Optional when using HTML: Set an alternative plain text message for email clients who prefer that.
		//$mail->AltBody = 'This is a plain-text message body'; 

		// Optional: attach a file
		//$mail->addAttachment('images/phpmailer_mini.png');

		if ($mail->send()) {
			return 1;
		} else {
			return 0;
		}
	}

	public function resend_verify_email()		//register?s=1&cid=Mzc=
	{
		if (isset($_GET['resend']) && !isset($_GET['cid'])) {
			$this->email = base64_decode($_GET['resend']);
			$this->sql = "SELECT c.first_name, c.last_name, c.email, c.verify_key FROM customers c WHERE c.email = ?";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "s", $this->email);
				mysqli_stmt_bind_result($this->send_query, $this->fname, $this->lname, $this->email, $verify_key);
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_store_result($this->send_query);
				if (mysqli_stmt_num_rows($this->send_query) == 1) {
					while (mysqli_stmt_fetch($this->send_query)) {
						$emailsent = $this->verify_email_register($this->email, $this->fname, $this->lname, $verify_key);
						if (!$emailsent) {
							setMessage("Could not send verification email. Please check your internet connection. ");
						} else {
							setMessage("A verification link has been sent to your Email ID. Please click on the link and verify your email ID. <a href='register?s=1&resend=" . $_GET['resend'] . "'>Click here</a> to resend the verification link. ");
						}
					}
				} else {
					setMessage("Could not resend the email. Please try registering again after some time. ");
				}
				mysqli_stmt_free_result($this->send_query);
				mysqli_stmt_close($this->send_query);
			}
		}
		if (isset($_GET['cid']) && isset($_GET['resend']))			//isset $get['s'] and $get['s'] == 1 is already checked
		{
			$cid = base64_decode($this->con->escape(clear_input($_GET['cid'])));
			$this->sql = "SELECT c.first_name, c.last_name, c.email, c.verify_key FROM customers c WHERE c.customer_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "i", $cid);
				mysqli_stmt_bind_result($this->send_query, $this->fname, $this->lname, $this->email, $verify_key);
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_store_result($this->send_query);
				if (mysqli_stmt_num_rows($this->send_query) == 1) {
					while (mysqli_stmt_fetch($this->send_query)) {
						$emailsent = $this->verify_email_register($this->email, $this->fname, $this->lname, $verify_key);
						if (!$emailsent) {
							setMessage("Could not send verification email. Please check your internet connection. ");
						} else {
							setMessage("A verification link has been sent to your Email ID. Please click on the link and verify your email ID. <a href='register?s=1&cid=" . $_GET['cid'] . "&resend'>Click here</a> to resend the verification link. ");
						}
					}
				} else {
					setMessage("Could not resend the email. Please try registering again after some time. ");
				}
				mysqli_stmt_free_result($this->send_query);
				mysqli_stmt_close($this->send_query);
			}
		}
	}

	public function verify_email()		//verifies the email sent to customers
	{
		$this->temp = 0;
		$this->flag = 1;
		$verify_key = base64_decode(clear_input($_GET['key']));
		$this->email = base64_decode($_GET['email']);

		$this->sql = "SELECT c.customer_id FROM customers c WHERE c.email = ? AND c.verify_key = ? AND isVerified = ? AND login_access = ?";
		$this->send_query = $this->con->prepare($this->sql);
		if (isset($this->send_query)) {
			mysqli_stmt_bind_param($this->send_query, "ssii", $this->email, $verify_key, $this->temp, $this->temp);
			mysqli_stmt_bind_result($this->send_query, $cid);
			mysqli_stmt_execute($this->send_query);
			mysqli_stmt_store_result($this->send_query);
			if (mysqli_stmt_num_rows($this->send_query) == 1) {
				mysqli_stmt_free_result($this->send_query);
				mysqli_stmt_close($this->send_query);

				$sql2 = "UPDATE customers c SET c.isVerified = ?, c.login_access = ? WHERE c.email = ?";
				$send_query2 = $this->con->prepare($sql2);
				if (isset($send_query2)) {
					mysqli_stmt_bind_param($send_query2, "iis", $this->flag, $this->flag, $this->email);
					mysqli_stmt_execute($send_query2);
					mysqli_stmt_store_result($send_query2);
					if (mysqli_stmt_affected_rows($send_query2) == 1) {
						setMessage("Yay! &#x1f389; Email verified. ");
						echo '
						<div class="text-center p-t-46 p-b-20">
							<span class="no-account">
							<span class="no-account-a"><a href="login">Click here</a></span> to sign in with your credentials.
						</span>
						</div>
						';
					}
				}
			} else {
				mysqli_stmt_free_result($this->send_query);
				mysqli_stmt_close($this->send_query);
				redirect("notfound");
			}
		}
	}

	public function login()
	{
		if (isset($_POST['login_submit'])) {
			if (isset($_SESSION['CUSTOMER'])) {
				unset($_SESSION['CUSTOMER']);
			}
			$this->get = $_SESSION['REFERER'];
			$this->temp = 1;
			$isLogin = 0;
			$this->email = $this->con->escape($_POST['email']);
			$pass = md5($this->con->escape($_POST['pass']));

			$this->sql = "SELECT c.first_name, c.last_name, c.customer_id FROM customers c, login_info l WHERE c.email = l.email AND l.email = ? AND l.password = ? AND c.isVerified = ? AND c.login_access = ?";
			$this->send_query = $this->con->prepare($this->sql);

			mysqli_stmt_bind_param($this->send_query, "ssii", $this->email, $pass, $this->temp, $this->temp);
			mysqli_stmt_bind_result($this->send_query, $this->fname, $this->lname, $customer_id);

			if (isset($this->send_query) && mysqli_stmt_execute($this->send_query)) {
				while (mysqli_stmt_fetch($this->send_query)) {
					$isLogin = 1;
				}
				mysqli_stmt_close($this->send_query);
				if (!$isLogin) {
					setMessage("The email and password combination didn't match. Please try again. ");
				} else {
					$this->delete_cart();
					$_SESSION['CUSTOMER'] = array('NAME' => $this->fname . " " . $this->lname, 'EMAIL' => $this->email, 'CUSTOMERID' => $customer_id);
					unset($_SESSION['location_query']);
					if (isset($_SESSION['CART'])) {
						unset($_SESSION['CART']);
					}
					unset($_SESSION['REFERER']);
					redirect("index");
				}
			}
		}
	}

	public function add_cart()
	{
		// if(isset($_SESSION['CART_ACTIVE'])) {
		// 	unset($_SESSION['CART_ACTIVE']);
		// }
		if (isset($_GET['cart']) && isset($_GET['itid'])) {
			!isset($quantity) ? $quantity = 1 : 0;
			$this->get = 0;
			$this->temp = 1;
			$item_id = base64_decode($this->con->escape(clear_input($_GET['itid'])));

			$session_id = session_id();
			!isset($_SESSION['CUSTOMER']) ? $this->email = "guest@swadesh.com" : $this->email = $_SESSION['CUSTOMER']['EMAIL'];

			$sql2 = "SELECT cart_id FROM cart WHERE email = ? AND session_id = ?";
			$send_query2 = $this->con->prepare($sql2);
			if (isset($send_query2)) {
				mysqli_stmt_bind_param($send_query2, "ss", $this->email, $session_id);
				mysqli_stmt_bind_result($send_query2, $cart_id);
				mysqli_stmt_execute($send_query2);
				mysqli_stmt_store_result($send_query2);
				if (mysqli_stmt_num_rows($send_query2) === 1 && mysqli_stmt_fetch($send_query2)) {
					$this->get = 1;
					// setMessage("1 ret");
				}
				mysqli_stmt_free_result($send_query2);
				mysqli_stmt_close($send_query2);
			}
			if ($this->get === 0) {
				$this->sql = "INSERT INTO `cart` (`email`, `session_id`, `date_added`, `date_modified`) VALUES (?, ?, ?, ?)";
				$this->send_query = $this->con->prepare($this->sql);
				mysqli_stmt_bind_param($this->send_query, "ssss", $this->email, $session_id, $this->datetime, $this->datetime);
				if (isset($this->send_query)) {
					if (mysqli_stmt_execute($this->send_query)) {
						$last_id = mysqli_stmt_insert_id($this->send_query);
					}
					mysqli_stmt_close($this->send_query);
				}
			}
			$this->get = 0;
			isset($cart_id) ? $id = $cart_id : $id = $last_id;
			$sql3 = "INSERT INTO `cart_items` (`cart_id`, `item_id`, `quantity`, `isActive`) VALUES (?, ?, ?, ?)";
			$send_query3 = $this->con->prepare($sql3);
			mysqli_stmt_bind_param($send_query3, "iiii", $id, $item_id, $this->temp, $this->temp);
			if (isset($send_query3)) {
				mysqli_stmt_execute($send_query3);
				mysqli_stmt_store_result($send_query3);
				if (mysqli_stmt_affected_rows($send_query3) === 1) {
					$this->get = 1;
					// if(!isset($_SESSION['CART']))
					// {
					// 	$_SESSION['CART'] = array
					// 	(
					// 		array('NAME'=>"Volvo",'QUANTITY'=>22,'PRICE'=>18),
					// 	);
					// }
					// else
					// {
					// 	array_push($_SESSION['CART'], array('NAME'=>"Suzuki",'QUANTITY'=>69,'PRICE'=>15));
					// }
					// if(!isset($_SESSION['CART_ACTIVE'])) {
					// $_SESSION['CART_UPDATED'] = 1;
					// }
				}
				mysqli_stmt_free_result($send_query3);
				mysqli_stmt_close($send_query3);
			}
			if ($this->get === 0) {
				$this->get = 0;
				$this->sql = "SELECT quantity FROM cart_items WHERE cart_id = ? AND item_id = ?";
				$this->send_query = $this->con->prepare($this->sql);
				mysqli_stmt_bind_param($this->send_query, "ii", $id, $item_id);
				mysqli_stmt_bind_result($this->send_query, $this->quantity);
				if (isset($this->send_query)) {
					mysqli_stmt_execute($this->send_query);
					if (mysqli_stmt_fetch($this->send_query)) {
						$this->totalQuantity = $this->totalQuantity + $this->quantity;
						// setMessage("ttl".$this->totalQuantity);
					}
					mysqli_stmt_close($this->send_query);
				}
				if ($this->totalQuantity <= 10) {
					$this->quantity += 1;
					$this->sql = "UPDATE `cart_items` SET `quantity` = ? WHERE cart_id = ? AND item_id = ?";
					$this->send_query = $this->con->prepare($this->sql);
					mysqli_stmt_bind_param($this->send_query, "iii", $this->quantity, $id, $item_id);
					if (isset($this->send_query)) {
						mysqli_stmt_execute($this->send_query);
						mysqli_stmt_store_result($this->send_query);
						if (mysqli_stmt_affected_rows($this->send_query) === 1) {
							// if(!isset($_SESSION['CART_ACTIVE'])) {
							// $_SESSION['CART_UPDATED'] = 1;
							// }
						}
						mysqli_stmt_free_result($this->send_query);
						mysqli_stmt_close($this->send_query);
					}
				}
			}
			$this->flag = 0;
			if (!isset($_SESSION['CART'])) {
				$_SESSION['CART'] = array(
					array('ID' => $item_id, 'QUANTITY' => $this->quantity)
				);
			} else {
				foreach ($_SESSION['CART'] as $i => $item) {
					if (isset($_SESSION['CART'][$i])) {
						if (in_array(base64_decode($_GET['itid']), $_SESSION['CART'][$i])) {
							$_SESSION['CART'][$i]['QUANTITY'] = $this->quantity;
							$this->flag = 1;
						}
					}
				}
				// for ($i=0; $i < sizeof($_SESSION['CART']); $i++) 
				// { 
				//     if (isset($_SESSION['CART'][$i]))
				//     {
				//     	if(in_array(base64_decode($_GET['itid']), $_SESSION['CART'][$i]))
				//     	{
				//      	$_SESSION['CART'][$i]['QUANTITY'] = $this->quantity;
				//      	$this->flag = 1;
				//     	}
				//     	// else
				//     	// {
				//     	// 	array_push($_SESSION['CART'], array('ID'=>$item_id,'QUANTITY'=>$this->quantity));
				//     	// }
				//     }
				// }
				if ($this->flag == 0) {
					array_push($_SESSION['CART'], array('ID' => $item_id, 'QUANTITY' => $this->quantity));
				}
			}
			if (isset($_SERVER['HTTP_REFERER'])) {
				$referLen = strlen($_SERVER['HTTP_REFERER']);
				$referLen = $referLen - 4;
			}
			if (substr($_SERVER['HTTP_REFERER'], $referLen, 4) == "cart") {
				redirect("cart");
			} else {
				redirect("item?itid=" . base64_encode($item_id));
			}
		}
	}

	public function remove_cart()
	{
		// if(isset($_SESSION['CART_ACTIVE'])) {
		// 	unset($_SESSION['CART_ACTIVE']);
		// }
		if (isset($_GET['reduce']) && isset($_GET['itid'])) {
			// !isset($quantity) ? $quantity = 1 : 0;
			$this->get = 0;
			$this->temp = 1;
			$item_id = base64_decode($this->con->escape(clear_input($_GET['itid'])));

			$session_id = session_id();
			!isset($_SESSION['CUSTOMER']) ? $this->email = "guest@swadesh.com" : $this->email = $_SESSION['CUSTOMER']['EMAIL'];

			$sql2 = "SELECT c.cart_id, q.quantity FROM cart c, cart_items q WHERE c.cart_id = q.cart_id AND c.email = ? AND q.isActive = ? AND c.session_id = ? AND q.item_id = ?";
			$send_query2 = $this->con->prepare($sql2);
			if (isset($send_query2)) {
				mysqli_stmt_bind_param($send_query2, "sisi", $this->email, $this->temp, $session_id, $item_id);
				mysqli_stmt_bind_result($send_query2, $cart_id, $this->quantity);
				mysqli_stmt_execute($send_query2);
				mysqli_stmt_store_result($send_query2);
				if (mysqli_stmt_num_rows($send_query2) >= 1 && mysqli_stmt_fetch($send_query2)) {
					if ($this->quantity > 1) {
						$this->get = 1;
					}
					// setMessage("1 ret");
				}
				mysqli_stmt_free_result($send_query2);
				mysqli_stmt_close($send_query2);
			}
			$id = $cart_id;
			if ($this->get === 1) {
				$this->quantity -= 1;
				$this->sql = "UPDATE `cart_items` SET `quantity` = ? WHERE cart_id = ? AND item_id = ?";
				$this->send_query = $this->con->prepare($this->sql);
				mysqli_stmt_bind_param($this->send_query, "iii", $this->quantity, $id, $item_id);
				if (isset($this->send_query)) {
					mysqli_stmt_execute($this->send_query);
					mysqli_stmt_store_result($this->send_query);
					if (mysqli_stmt_affected_rows($this->send_query) === 1) {
						foreach ($_SESSION['CART'] as $i => $item) {
							if (isset($_SESSION['CART'][$i])) {
								if (in_array(base64_decode($_GET['itid']), $_SESSION['CART'][$i])) {
									$_SESSION['CART'][$i]['QUANTITY'] = $this->quantity;
								}
							}
						}
						// setMessage("q reduced");
					}
					mysqli_stmt_free_result($this->send_query);
					mysqli_stmt_close($this->send_query);
				}
			}
			if ($this->get === 0)	//WHEN QUANTITY IS 1
			{
				// $this->quantity -= 1;
				$this->sql = "DELETE FROM `cart_items` WHERE cart_id = ? AND item_id = ? AND `quantity` = ?";
				$this->send_query = $this->con->prepare($this->sql);
				mysqli_stmt_bind_param($this->send_query, "iii", $id, $item_id, $this->temp);
				if (isset($this->send_query)) {
					mysqli_stmt_execute($this->send_query);
					mysqli_stmt_store_result($this->send_query);
					if (mysqli_stmt_affected_rows($this->send_query) === 1) {
						foreach ($_SESSION['CART'] as $i => $item) {
							if (isset($_SESSION['CART'][$i])) {
								if (in_array($item_id, $_SESSION['CART'][$i])) {
									unset($_SESSION['CART'][$i]);
								}
							}
						}
					}
					mysqli_stmt_free_result($this->send_query);
					mysqli_stmt_close($this->send_query);
				}
			}
			// if(isset($_SERVER['HTTP_REFERER'])) {
			// 	$referer = $_SERVER['HTTP_REFERER'];
			// 	if (strpos($referer, 'cart') === true) {
			// 	    redirect("cart");
			// 	}
			// 	else
			// 	{
			// 		redirect("item?itid=".base64_encode($item_id));
			// 	}
			// }
			// else
			// {
			// 	redirect("item?itid=".base64_encode($item_id));
			// }
			if (isset($_SERVER['HTTP_REFERER'])) {
				$referLen = strlen($_SERVER['HTTP_REFERER']);
				$referLen = $referLen - 4;
			}
			if (substr($_SERVER['HTTP_REFERER'], $referLen, 4) == "cart") {
				redirect("cart");
			} else {
				redirect("item?itid=" . base64_encode($item_id));
			}
		}
	}

	function display_cart_in_item()		//item?itid=MzMzMzY3
	{
		$total = 0;
		$this->temp = 1;
		$this->flag = 0;
		$session_id = session_id();

		isset($_SESSION['CUSTOMER']['EMAIL']) ? $this->email = $_SESSION['CUSTOMER']['EMAIL'] : $this->email = "guest@swadesh.com";
		$this->sql = "SELECT i.item_title, ct.cat_title, i.item_price, i.item_id, q.quantity FROM cart c, cart_items q, items i, categories ct WHERE c.cart_id = q.cart_id AND q.item_id = i.item_id AND i.cat_id = ct.cat_id AND c.email = ? AND q.isActive = ? AND c.session_id = ? ORDER BY c.date_added DESC";
		$this->send_query = $this->con->prepare($this->sql);
		mysqli_stmt_bind_param($this->send_query, "sis", $this->email, $this->temp, $session_id);
		mysqli_stmt_bind_result($this->send_query, $item_title, $cat_title, $item_price, $item_id, $this->quantity);
		if (isset($this->send_query)) {
			mysqli_stmt_execute($this->send_query);
			mysqli_stmt_store_result($this->send_query);
			$this->temp = mysqli_stmt_num_rows($this->send_query);
			echo '
	        <h4 class="d-flex justify-content-between my-3 sub-heading">
	          Your cart
	          <span class="badge badge-secondary badge-pill">' . $this->temp . '</span>
	        </h4>

	        <ul class="list-group mb-3">
			';
			while (mysqli_stmt_fetch($this->send_query)) {
				if (isset($_SESSION['CART'])) {
					for ($i = 0; $i < sizeof($_SESSION['CART']); $i++) {
						if (isset($_SESSION['CART'][$i]) && in_array($item_id, $_SESSION['CART'][$i])) {
							$this->quantity = $_SESSION['CART'][$i]['QUANTITY'];
						}
						// if(!in_array($item_id, $_SESSION['CART'][$i]))
						// {
						// 	unset($_SESSION['CART'][$i]);
						// }
					}
				}
				$sub_total = $item_price * $this->quantity;
				$total += $sub_total;
				echo '
		          <li class="list-group-item d-flex justify-content-between lh-condensed">
		            <div>
		              <h6 class="my-0"><a class="item-cart-link" href="item?itid=' . base64_encode($item_id) . '">' . $item_title . '</a>&nbsp;(x' . $this->quantity . ')</h6>
		              <small class="text-muted">Category: ' . $cat_title . '</small>
		            </div>
		            <span class="text-muted">&#8377;' . $sub_total . '</span>
		          </li>
				';
			}
			echo '
			<li class="list-group-item d-flex justify-content-between">
				<span>Total</span>	            
				<strong>&#8377;' . $total . '</strong>	       
			</li>
			<li class="list-group-item d-flex justify-content-between">
				<small class="text-muted">Additional charges might be applicable. <a href="cart">Goto cart</a> to see additional charges (if any).</small>
			</li>	          
	        </ul>
			';
			mysqli_stmt_free_result($this->send_query);
			mysqli_stmt_close($this->send_query);
		}
	}

	function display_cart_in_checkout()		//http://localhost/swadesh/checkout
	{
		$total = 0;
		$this->temp = 1;
		$this->flag = 0;
		$session_id = session_id();

		isset($_SESSION['CUSTOMER']['EMAIL']) ? $this->email = $_SESSION['CUSTOMER']['EMAIL'] : $this->email = "guest@swadesh.com";
		$this->sql = "SELECT i.item_title, ct.cat_title, i.item_price, i.item_id, q.quantity FROM cart c, cart_items q, items i, categories ct WHERE c.cart_id = q.cart_id AND q.item_id = i.item_id AND i.cat_id = ct.cat_id AND c.email = ? AND q.isActive = ? AND c.session_id = ? ORDER BY c.date_added DESC";
		$this->send_query = $this->con->prepare($this->sql);
		mysqli_stmt_bind_param($this->send_query, "sis", $this->email, $this->temp, $session_id);
		mysqli_stmt_bind_result($this->send_query, $item_title, $cat_title, $item_price, $item_id, $this->quantity);
		if (isset($this->send_query)) {
			mysqli_stmt_execute($this->send_query);
			mysqli_stmt_store_result($this->send_query);
			$this->temp = mysqli_stmt_num_rows($this->send_query);
			echo '
	        <h4 class="d-flex justify-content-between my-3 sub-heading">
	          Your cart
	          <span class="badge badge-secondary badge-pill">' . $this->temp . '</span>
	        </h4>

	        <ul class="list-group mb-3">
			';
			while (mysqli_stmt_fetch($this->send_query)) {
				if (isset($_SESSION['CART'])) {
					for ($i = 0; $i < sizeof($_SESSION['CART']); $i++) {
						if (isset($_SESSION['CART'][$i]) && in_array($item_id, $_SESSION['CART'][$i])) {
							$this->quantity = $_SESSION['CART'][$i]['QUANTITY'];
						}
						// if(!in_array($item_id, $_SESSION['CART'][$i]))
						// {
						// 	unset($_SESSION['CART'][$i]);
						// }
					}
				}
				$sub_total = $item_price * $this->quantity;
				$total += $sub_total;
				echo '
		          <li class="list-group-item d-flex justify-content-between lh-condensed">
		            <div>
		              <h6 class="my-0"><a class="item-cart-link" href="item?itid=' . base64_encode($item_id) . '">' . $item_title . '</a>&nbsp;(x' . $this->quantity . ')</h6>
		              <small class="text-muted">Category: ' . $cat_title . '</small>
		            </div>
		            <span class="text-muted">&#8377;' . $sub_total . '</span>
		          </li>
				';
			}
			if (isset($_POST['checkout_submit'])) {
				$total = $_POST['total_amount'];
				$this->amountToPay = $total;
				$handling = $_POST['handling_charge'];
			}
			echo '
			<li class="list-group-item d-flex justify-content-between">
				<span>Handling Charges</span>	            
				<strong>&#8377;' . $handling . '</strong>	       
			</li>
			<li class="list-group-item d-flex justify-content-between">
				<span>Total</span>	            
				<strong>&#8377;' . $total . '</strong>	       
			</li>				          
	        </ul>
			';
			mysqli_stmt_free_result($this->send_query);
			mysqli_stmt_close($this->send_query);
		}
	}

	public function delete_cart()	//used while logging out
	{
		isset($_SESSION['CUSTOMER']['EMAIL']) ? $email = $_SESSION['CUSTOMER']['EMAIL'] : $email = "guest@swadesh.com";
		$session_id = session_id();
		$this->sql = "SELECT cart_id FROM `cart` WHERE email = ? AND session_id = ?";
		$this->send_query = $this->con->prepare($this->sql);
		mysqli_stmt_bind_param($this->send_query, "ss", $email, $session_id);
		mysqli_stmt_bind_result($this->send_query, $cart_id);
		if (isset($this->send_query) && mysqli_stmt_execute($this->send_query)) {
			while (mysqli_stmt_fetch($this->send_query)) {
				// setMessage($cart_id);
			}
		}
		mysqli_stmt_close($this->send_query);
		// setMessage($cart_id);
		$this->sql = "DELETE FROM `cart_items` WHERE cart_id = ?";
		$this->send_query = $this->con->prepare($this->sql);
		mysqli_stmt_bind_param($this->send_query, "i", $cart_id);
		if (isset($this->send_query)) {
			mysqli_stmt_execute($this->send_query);
			mysqli_stmt_store_result($this->send_query);
			if (mysqli_stmt_affected_rows($this->send_query) >= 1) {
				// setMessage($cart_id);
			}
			mysqli_stmt_free_result($this->send_query);
			mysqli_stmt_close($this->send_query);
		}
	}

	public function display_cart_page()
	{
		$this->totalPrice = 0;
		$this->totalQuantity = 0;
		$this->temp = 1;
		$this->flag = 0;
		$session_id = session_id();

		isset($_SESSION['CUSTOMER']['EMAIL']) ? $this->email = $_SESSION['CUSTOMER']['EMAIL'] : $this->email = "guest@swadesh.com";

		$this->sql = "SELECT i.item_title, i.item_price, i.item_id, q.quantity, i.item_image FROM cart c, cart_items q, items i, categories ct WHERE c.cart_id = q.cart_id AND q.item_id = i.item_id AND i.cat_id = ct.cat_id AND c.email = ? AND q.isActive = ? AND c.session_id = ? ORDER BY c.date_added DESC";
		$this->send_query = $this->con->prepare($this->sql);
		mysqli_stmt_bind_param($this->send_query, "sis", $this->email, $this->temp, $session_id);
		mysqli_stmt_bind_result($this->send_query, $item_title, $item_price, $item_id, $this->quantity, $item_image);
		if (isset($this->send_query)) {
			mysqli_stmt_execute($this->send_query);
			mysqli_stmt_store_result($this->send_query);
			$this->temp = mysqli_stmt_num_rows($this->send_query);
			while (mysqli_stmt_fetch($this->send_query)) {
				$sub_total = $item_price * $this->quantity;
				$this->totalPrice += $sub_total;
				$this->totalQuantity = $this->totalQuantity + $this->quantity;
				echo '
                    <tr>                            
                      <th scope="row" class="f-column cart-data-no-padding">
                        <div class="cart-item">
                          <img src="' . $item_image . '" alt="" width="70" height="70" class="img-fluid rounded shadow-sm">
                          <div class="ml-3 d-inline-block align-middle">
                            <a href="#" class="text-dark d-inline-block align-middle">' . $item_title . '</a>
                          </div>
                        </div>
                      </th>
                      <td class="s-column align-middle cart-data-no-padding"><a href="item?itid=' . base64_encode($item_id) . '&cart=' . base64_encode($item_id) . '" class="fa fa-plus-circle"></a>&nbsp;(x' . $this->quantity . ')&nbsp;<a href="item?itid=' . base64_encode($item_id) . '&reduce=' . base64_encode($item_id) . '" class="fa fa-minus-circle"></a></td>
                      <td class="t-column align-middle cart-data-no-padding"><strong>&#8377; ' . $sub_total . '</strong></td>
                      <td class="fr-column align-middle cart-data-no-padding">
						<a href="cart?cart=' . base64_encode($item_id) . '&delete=' . base64_encode($item_id) . '" class="btn btn-danger btn-circle delete-btn-circle">
						<i class="fas fa-trash"></i>
						</a>
                      </td>

                    </tr>
				';
			}
			if (empty($_SESSION['CART'])) {
				echo '
				<div class="text-center">' . setMessage("Your cart is empty. &#128542;");
				echo '<a class="item-cart-link" href="index#services">Browse categories&nbsp;<i class="fas fa-utensils" style="color: red;"></i></a></div>';
			}
			mysqli_stmt_free_result($this->send_query);
			mysqli_stmt_close($this->send_query);
		}
	}
	public function delete_item_cart()
	{
		if (isset($_GET['cart']) && isset($_GET['delete'])) {
			$item_id = $this->con->escape(clear_input(base64_decode($_GET['delete'])));
			$this->sql = "DELETE FROM `cart_items` WHERE item_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			mysqli_stmt_bind_param($this->send_query, "i", $item_id);
			if (isset($this->send_query)) {
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_store_result($this->send_query);
				if (mysqli_stmt_affected_rows($this->send_query) === 1) {
					for ($i = 0; $i < sizeof($_SESSION['CART']); $i++) {
						if (isset($_SESSION['CART'][$i]) && in_array($item_id, $_SESSION['CART'][$i])) {
							unset($_SESSION['CART'][$i]);
						}
					}
				}
				mysqli_stmt_free_result($this->send_query);
				mysqli_stmt_close($this->send_query);
				redirect("cart");
			}
		}
	}

	public function insert_address()	//payment.php
	{
		$this->get = 0;
		$this->flag = 0;
		if (isset($_SESSION['CUSTOMER']['CUSTOMERID'])) {
			$customer_id = $_SESSION['CUSTOMER']['CUSTOMERID'];
			$address1 = $this->con->escape(clear_input($_POST['address1']));
			$address2 = $this->con->escape(clear_input($_POST['address2']));
			$zip = $this->con->escape(clear_input($_POST['zip']));
			$state = $this->con->escape(clear_input($_POST['state']));
			$city = $this->con->escape(clear_input($_POST['city']));
			$phone_number = $this->con->escape(clear_input($_POST['phone_number']));
			$alt_phone_number = $this->con->escape(clear_input($_POST['alt_phone_number']));

			$this->sql = "SELECT address_id FROM customer_contact WHERE customer_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			mysqli_stmt_bind_param($this->send_query, "i", $customer_id);
			mysqli_stmt_bind_result($this->send_query, $address_id);
			if (isset($this->send_query)) {
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_store_result($this->send_query);
				if (mysqli_stmt_num_rows($this->send_query) === 1) {
					while (mysqli_stmt_fetch($this->send_query)) {
						$this->get = 1;
						$this->flag = $address_id;
					}
				}
				mysqli_stmt_free_result($this->send_query);
				mysqli_stmt_close($this->send_query);
			}
			// echo "ddd".$this->flag;
			// echo "get".$this->get;
			if ($this->get === 1) {
				$this->sql = "UPDATE `customer_contact` SET `address_line_1` = ?, `address_line_2` = ?, `city` = ?, `state` = ?, `pin` = ?, `contact_number` = ?, `alternative_contact_number` = ? WHERE customer_id = ?";
				$this->send_query = $this->con->prepare($this->sql);
				mysqli_stmt_bind_param($this->send_query, "ssssiiii", $address1, $address2, $city, $state, $zip, $phone_number, $alt_phone_number, $customer_id);
				if (isset($this->send_query)) {
					mysqli_stmt_execute($this->send_query);
					// mysqli_stmt_store_result($this->send_query);
					// if(mysqli_stmt_affected_rows($this->send_query) === 1)
					// {
					// 	$last_id = mysqli_stmt_insert_id($this->send_query);
					// }
					// mysqli_stmt_free_result($this->send_query);
					// $last_id = $address_id;
					mysqli_stmt_close($this->send_query);
				}
			} else {
				$this->sql = "INSERT INTO `customer_contact` (`customer_id`, `address_line_1`, `address_line_2`, `city`, `state`, `pin`, `contact_number`, `alternative_contact_number`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				$this->send_query = $this->con->prepare($this->sql);
				mysqli_stmt_bind_param($this->send_query, "issssiii", $customer_id, $address1, $address2, $city, $state, $zip, $phone_number, $alt_phone_number);
				if (isset($this->send_query)) {
					mysqli_stmt_execute($this->send_query);
					mysqli_stmt_store_result($this->send_query);
					if (mysqli_stmt_affected_rows($this->send_query) === 1) {
						$insert_id = mysqli_stmt_insert_id($this->send_query);
					}
					mysqli_stmt_free_result($this->send_query);
					mysqli_stmt_close($this->send_query);
				}
			}
		}
		if (isset($insert_id)) {
			return $insert_id;
		} else {
			return $this->flag;
		}
	}

	public function place_order($order_id, $customer_id, $amount, $address_id, $txnid, $txnstatus, $banktxnid, $bankname, $checksumhash)		//pgResponse.php
	{
		$this->get = 0;
		$this->flag = 0;
		$order_status = "AWAITING CONFIRMATION";
		$transaction_type = "PREPAID";
		$this->sql = "INSERT INTO `orders_received` (`order_id`, `customer_id`, `amount`, `order_status`, `order_date`, `transaction_type`, `address_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$this->send_query = $this->con->prepare($this->sql);
		mysqli_stmt_bind_param($this->send_query, "iiisssi", $order_id, $customer_id, $amount, $order_status, $this->datetime, $transaction_type, $address_id);
		if (isset($this->send_query)) {
			mysqli_stmt_execute($this->send_query);
			mysqli_stmt_store_result($this->send_query);
			if (mysqli_stmt_affected_rows($this->send_query) === 1) {
				$this->get = 1;
			}
			mysqli_stmt_free_result($this->send_query);
			mysqli_stmt_close($this->send_query);
		}
		if ($this->get === 1) {
			$this->sql = "INSERT INTO `order_payment` (`order_id`, `txnid`, `txnstatus`, `banktxnid`, `bankname`, `checksumhash`) VALUES (?, ?, ?, ?, ?, ?)";
			$this->send_query = $this->con->prepare($this->sql);
			mysqli_stmt_bind_param($this->send_query, "iisiss", $order_id, $txnid, $txnstatus, $banktxnid, $bankname, $checksumhash);
			if (isset($this->send_query)) {
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_store_result($this->send_query);
				if (mysqli_stmt_affected_rows($this->send_query) === 1) {
					$this->flag = 1;
				}
				mysqli_stmt_free_result($this->send_query);
				mysqli_stmt_close($this->send_query);
			}
			$this->email = $_SESSION['CUSTOMER']['EMAIL'];
			$session_id = session_id();

			$item_id = array();
			$quantity = array();

			$this->sql = "SELECT item_id, quantity FROM cart_items ce, cart c WHERE ce.cart_id = c.cart_id AND c.email = ? AND c.session_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			mysqli_stmt_bind_param($this->send_query, "ss", $this->email, $session_id);
			mysqli_stmt_bind_result($this->send_query, $this->item_id, $this->quantity);
			if (isset($this->send_query)) {
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_store_result($this->send_query);
				if (mysqli_stmt_num_rows($this->send_query) >= 1) {
					while (mysqli_stmt_fetch($this->send_query)) {
						$this->flag = 1;
						array_push($item_id, $this->item_id);
						array_push($quantity, $this->quantity);
					}
				}
				mysqli_stmt_free_result($this->send_query);
				mysqli_stmt_close($this->send_query);
			}
			for ($i = 0; $i < sizeof($item_id); $i++) {
				$this->sql = "INSERT INTO `ordered_products` (`order_id`, `item_id`, `quantity`) VALUES (?, ?, ?)";
				$this->send_query = $this->con->prepare($this->sql);
				mysqli_stmt_bind_param($this->send_query, "iii", $order_id, $item_id[$i], $quantity[$i]);
				if (isset($this->send_query)) {
					mysqli_stmt_execute($this->send_query);
					mysqli_stmt_close($this->send_query);
				}
			}
		}
		if ($this->get === 1 && $this->flag === 1) {
			// $this->mail_order_prepaid();
			if (isset($_SESSION['CART'])) {
				unset($_SESSION['CART']);
				$this->delete_cart();
			}
			// isset($_SESSION['CART']) ? unset($_SESSION['CART']) : 0;
			return 1;
		} else {
			return 0;
		}
	}

	public function place_order_cash($order_id, $customer_id, $amount, $address_id)	//thankyou.php - cod order
	{
		$this->get = 0;
		$this->flag = 0;
		$order_status = "AWAITING CONFIRMATION";
		$transaction_type = "CASH";
		$this->sql = "INSERT INTO `orders_received` (`order_id`, `customer_id`, `amount`, `order_status`, `order_date`, `transaction_type`, `address_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$this->send_query = $this->con->prepare($this->sql);
		mysqli_stmt_bind_param($this->send_query, "iiisssi", $order_id, $customer_id, $amount, $order_status, $this->datetime, $transaction_type, $address_id);
		if (isset($this->send_query)) {
			mysqli_stmt_execute($this->send_query);
			mysqli_stmt_store_result($this->send_query);
			if (mysqli_stmt_affected_rows($this->send_query) === 1) {
				$this->get = 1;
				// $this->mail_order_cash();
			}
			mysqli_stmt_free_result($this->send_query);
			mysqli_stmt_close($this->send_query);
		}

		if ($this->get === 1) {
			$this->email = $_SESSION['CUSTOMER']['EMAIL'];
			$session_id = session_id();

			$item_id = array();
			$quantity = array();

			$this->sql = "SELECT item_id, quantity FROM cart_items ce, cart c WHERE ce.cart_id = c.cart_id AND c.email = ? AND c.session_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			mysqli_stmt_bind_param($this->send_query, "ss", $this->email, $session_id);
			mysqli_stmt_bind_result($this->send_query, $this->item_id, $this->quantity);
			if (isset($this->send_query)) {
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_store_result($this->send_query);
				if (mysqli_stmt_num_rows($this->send_query) >= 1) {
					while (mysqli_stmt_fetch($this->send_query)) {
						$this->flag = 1;
						array_push($item_id, $this->item_id);
						array_push($quantity, $this->quantity);
					}
				}
				mysqli_stmt_free_result($this->send_query);
				mysqli_stmt_close($this->send_query);
			}
			for ($i = 0; $i < sizeof($item_id); $i++) {
				$this->sql = "INSERT INTO `ordered_products` (`order_id`, `item_id`, `quantity`) VALUES (?, ?, ?)";
				$this->send_query = $this->con->prepare($this->sql);
				mysqli_stmt_bind_param($this->send_query, "iii", $order_id, $item_id[$i], $quantity[$i]);
				if (isset($this->send_query)) {
					mysqli_stmt_execute($this->send_query);
					mysqli_stmt_close($this->send_query);
				}
			}
			if (isset($_SESSION['CART'])) {
				unset($_SESSION['CART']);
				$this->delete_cart();
			}
		}
	}

	public function mail_order_cash($order_id, $amount, $cust_name, $cust_email)		//thankyou.php
	{
		$mail = new PHPMailer;
		$mail->isSMTP();
		// $mail->SMTPDebug = 2;

		$config = parse_ini_file('includes/config.ini', true);

		$mail->Host = 'smtp.gmail.com'; // Which SMTP server to use.
		$mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
		$mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
		$mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
		$mail->Username = $config['user']; // Your Gmail address.
		$mail->Password = $config['pass']; // Your Gmail login password or App Specific Password.
		$email = $cust_email;
		$name = $cust_name;

		$message = "Hey " . $cust_name . ", Your order has been placed!\nORDER ID: " . $order_id . "\nTOTAL AMOUNT: " . $amount . "\nPAYMENT MODE: CASH ON DELIVERY\n";

		$subject = 'Swadesh Restaurant - Order placed';
		// $mail->AddReplyTo($reply_to, $fname);
		$mail->setFrom($mail->Username, 'Swadesh Restaurant'); // Set the sender of the message.
		$mail->addAddress($email, $name); // Set the recipient of the message.
		// $mail->AddCC($cc, 'Kaushik - Website Form');	//CC email
		$mail->Subject = $subject; // The subject of the message.

		$mail->Body = $message; // Set a plain text body.

		// ... or send an email with HTML.
		// $mail->msgHTML(file_get_contents('mail.php'));
		// Optional when using HTML: Set an alternative plain text message for email clients who prefer that.
		// $mail->AltBody = 'Hey there! Your order has been placed and will arrive shortly.'; 

		// Optional: attach a file
		//$mail->addAttachment('images/phpmailer_mini.png');

		if ($mail->send()) {
			return 1;
		} else {
			return 0;
		}
	}

	public function mail_order_prepaid($order_id, $amount, $cust_name, $cust_email, $bank_trans_id, $payment_mode)		//pgResponse.php
	{
		$mail = new PHPMailer;
		$mail->isSMTP();
		// $mail->SMTPDebug = 2;

		$config = parse_ini_file('includes/config.ini', true);

		$mail->Host = 'smtp.gmail.com'; // Which SMTP server to use.
		$mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
		$mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
		$mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
		$mail->Username = $config['user']; // Your Gmail address.
		$mail->Password = $config['pass']; // Your Gmail login password or App Specific Password.
		$email = $cust_email;
		$name = $cust_name;

		$message = "Hey " . $cust_name . ", Your order has been placed!\nORDER ID: " . $order_id . "\nTOTAL AMOUNT: " . $amount . "\nPayment Mode: " . $payment_mode . "\nBank Transaction ID: " . $bank_trans_id . "\n";

		$subject = 'Swadesh Restaurant - Order placed';
		// $mail->AddReplyTo($reply_to, $fname);
		$mail->setFrom($mail->Username, 'Swadesh Restaurant'); // Set the sender of the message.
		$mail->addAddress($email, $name); // Set the recipient of the message.
		// $mail->AddCC($cc, 'Kaushik - Website Form');	//CC email
		$mail->Subject = $subject; // The subject of the message.

		$mail->Body = $message; // Set a plain text body.

		// Optional: attach a file
		//$mail->addAttachment('images/phpmailer_mini.png');

		if ($mail->send()) {
			return 1;
		} else {
			return 0;
		}
	}

	public function view_orders_cust()	//index? modal
	{
		isset($_SESSION['CUSTOMER']['CUSTOMERID']) ? $customer_id = $_SESSION['CUSTOMER']['CUSTOMERID'] : $customer_id = 0;
		$this->sql = "SELECT o.order_id, GROUP_CONCAT(i.item_title, '&nbsp;(x', op.quantity, ')' SEPARATOR '<br>') as `group_item_id`, o.amount, o.order_date, o.transaction_type, o.order_status FROM orders_received o, ordered_products op, items i WHERE o.order_id = op.order_id AND i.item_id = op.item_id AND o.customer_id = ? GROUP BY order_id ORDER BY o.order_date DESC";
		$this->send_query = $this->con->prepare($this->sql);
		if (isset($this->send_query)) {
			mysqli_stmt_bind_param($this->send_query, "i", $customer_id);
			mysqli_stmt_bind_result($this->send_query, $order_id, $item_title, $amount, $order_date, $payment_mode, $order_status);
			if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
				do {
					if (!preg_match("/DELIVERED/mi", $order_status))		//DISPLAYS UNDEIVERED ORDERS(NEW ORDERS)
					{
						echo '
			            <tr>
			                <td>' . $order_id . '</td>
			                <td>' . $item_title . '</td>
			                <td>' . $amount . '</td>
			                <td>' . $order_date . '</td>
			                <td>' . $payment_mode . '</td>
			                <td>' . $order_status . '</td>
			            </tr>';
					}
				} while (mysqli_stmt_fetch($this->send_query));
			}
			mysqli_stmt_close($this->send_query);
		}
	}

	public function check_current_orders()
	{
		$this->temp = 0;
		isset($_SESSION['CUSTOMER']['CUSTOMERID']) ? $customer_id = $_SESSION['CUSTOMER']['CUSTOMERID'] : $customer_id = 0;
		$this->sql = "SELECT o.order_id, o.order_status FROM orders_received o WHERE o.customer_id = ? ORDER BY o.order_date DESC";
		$this->send_query = $this->con->prepare($this->sql);
		if (isset($this->send_query)) {
			mysqli_stmt_bind_param($this->send_query, "i", $customer_id);
			mysqli_stmt_bind_result($this->send_query, $order_id, $order_status);
			if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
				do {
					if (!preg_match("/DELIVERED/mi", $order_status))		//DISPLAYS UNDEIVERED ORDERS(NEW ORDERS)
					{
						$this->temp = 1;
						break;
					}
				} while (mysqli_stmt_fetch($this->send_query));
			}
			mysqli_stmt_close($this->send_query);
		}
		if ($this->temp)
			return 1;
		else
			return 0;
	}

	public function view_order_history_cust()	//index? modal - order history
	{
		isset($_SESSION['CUSTOMER']['CUSTOMERID']) ? $customer_id = $_SESSION['CUSTOMER']['CUSTOMERID'] : $customer_id = 0;
		$this->sql = "SELECT o.order_id, GROUP_CONCAT(i.item_title, '&nbsp;(x', op.quantity, ')' SEPARATOR '<br>') as `group_item_id`, o.amount, o.order_date, o.transaction_type, o.order_status, o.order_modified FROM orders_received o, ordered_products op, items i WHERE o.order_id = op.order_id AND i.item_id = op.item_id AND o.customer_id = ? GROUP BY order_id ORDER BY o.order_date DESC";
		$this->send_query = $this->con->prepare($this->sql);
		if (isset($this->send_query)) {
			mysqli_stmt_bind_param($this->send_query, "i", $customer_id);
			mysqli_stmt_bind_result($this->send_query, $order_id, $item_title, $amount, $order_date, $payment_mode, $order_status, $order_modified);
			if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
				do {
					if (preg_match("/DELIVERED/mi", $order_status))	//DISPLAYS UNDEIVERED ORDERS(NEW ORDERS)
					{
						echo '
			            <tr>
			                <td>' . $order_id . '</td>
			                <td>' . $item_title . '</td>
			                <td>' . $amount . '</td>
			                <td>' . $order_date . '</td>
			                <td>' . $payment_mode . '</td>
			                <td>' . $order_modified . '</td>
			            </tr>';
					}
				} while (mysqli_stmt_fetch($this->send_query));
			}
			mysqli_stmt_close($this->send_query);
		}
	}
	public function send_mail($receiver_email, $receiver_name, $message, $subject)
	{
		$mail = new PHPMailer;
		$mail->isSMTP();
		// $mail->SMTPDebug = 2;
		$config = parse_ini_file('includes/config.ini', true);
		$mail->Host = 'smtp.gmail.com'; // Which SMTP server to use.
		$mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
		$mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
		$mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
		$mail->Username = $config['user']; // Your Gmail address.
		$mail->Password = $config['pass']; // Your Gmail login password or App Specific Password.
		$mail->setFrom($mail->Username, 'Swadesh Restaurant'); // Set the sender of the message.
		$mail->addAddress($receiver_email, $receiver_name); // Set the recipient of the message.
		$mail->Subject = $subject; // The subject of the message.
		$mail->Body = $message; // Set a plain text body.
		if ($mail->send()) {
			return 1;
		} else {
			return 0;
		}
	}
	public function forgotPassword()
	{
		if (isset($_GET['forgotPassword']) && isset($_POST['forgot_submit']) && !isset($_GET['key']) && !isset($_GET['ts'])) {
			$this->flag = 0;
			$this->email = $_POST['email'];
			$this->sql = "SELECT c.verify_key, c.first_name, c.last_name from customers c, login_info l WHERE l.email = ? AND c.email = l.email";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "s", $this->email);
				mysqli_stmt_bind_result($this->send_query, $verify_key, $first_name, $last_name);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
					$this->flag = 1;
				} else {
					setMessage("This email is not registered. Please register an account with this email ID. ");
				}
				mysqli_stmt_close($this->send_query);
			}
			if ($this->flag === 1) {
				$name = $first_name . " " . $last_name;
				$subject = "Swadesh Restaurant - Forgot Password";
				$message = "Click on the link below to change your password. This link expires in 5 minutes. \n";
				if ($_SERVER['SERVER_PORT'] == 80) {
					$host = "http://";
				} else {
					$host = "https://";
				}
				$this->datetime = new DateTime();
				$this->time = new DateTime();
				$this->time = $this->datetime->getTimestamp();
				$message .= $host . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] . "&key=" . base64_encode($verify_key) . "&ts=" . base64_encode($this->time);
				if ($this->send_mail($this->email, $name, $message, $subject)) {
					setMessage("A password reset link has been sent to " . $this->email . ". Please check your mail. ");
				} else {
					setMessage("Password reset link couldn't be sent. ");
				}

				$this->datetime = $this->datetime->format('Y-m-d H:i:s');
				$this->sql = "UPDATE `login_info` SET `date_modified` = ? WHERE email = ?";
				$this->send_query = $this->con->prepare($this->sql);
				mysqli_stmt_bind_param($this->send_query, "ss", $this->datetime, $this->email);
				if (isset($this->send_query)) {
					mysqli_stmt_execute($this->send_query);
					// mysqli_stmt_store_result($this->send_query);
					// if(mysqli_stmt_affected_rows($this->send_query) === 1)
					// {
					// 	setMessage("Date modified");
					// }
					// mysqli_stmt_free_result($this->send_query);
					mysqli_stmt_close($this->send_query);
				}
			}
		} else if (isset($_GET['forgotPassword']) && isset($_GET['key']) && isset($_GET['ts'])) {
			$this->flag = 0;
			$this->get = 0;
			$verify_key = base64_decode($_GET['key']);
			$this->sql = "SELECT c.email, c.verify_key, l.date_modified from customers c, login_info l WHERE c.verify_key = ? AND c.email = l.email";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "s", $verify_key);
				mysqli_stmt_bind_result($this->send_query, $this->email, $verify_key, $date_modified);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
					$this->flag = 1;
					$currentTime = new DateTime();
					$linkSentTime = new DateTime($date_modified);
					if (($currentTime->getTimestamp() - $linkSentTime->getTimestamp()) < 300) {
						$this->get = 1;
					} else {
						redirect("login?forgotPassword&expired");
						//setMessage("This link has expired! ");
					}
				} else {
					redirect("login?forgotPassword&error");
					//setMessage("Invalid link. ");
				}
				mysqli_stmt_close($this->send_query);
			}
			if ($this->flag === 1 && $this->get === 1 && isset($_POST['change_pass'])) {
				$newPass = md5(trim($_POST['pass']));
				$newPassRepeat = md5(trim($_POST['confirm_pass']));
				$this->datetime = $currentTime->format('Y-m-d H:i:s');
				if ($newPass === $newPassRepeat) {
					$this->sql = "UPDATE `login_info` SET `password` = ?, `date_modified` = ? WHERE `email` = ?";
					$this->send_query = $this->con->prepare($this->sql);
					if (isset($this->send_query)) {
						mysqli_stmt_bind_param($this->send_query, "sss", $newPass, $this->datetime, $this->email);
						if (mysqli_stmt_execute($this->send_query)) {
							$this->get = 1;
							redirect("login?forgotPassword&changed");
							//setMessage("Password updated. ");
						} else {
							$this->get = 0;
							setMessage("Password couldn't be updated.");
						}
						mysqli_stmt_close($this->send_query);
					}
				} else {
					setMessage("The Passwords don't match! Please try again. ");
				}
			}
		}
	}
	public function display_pincodes()
	{
		$this->flag = 1;
		$this->sql = "SELECT pin_codes FROM pincodes WHERE available = ?";
		$this->send_query = $this->con->prepare($this->sql);
		if (isset($this->send_query)) {
			mysqli_stmt_bind_param($this->send_query, "i", $this->flag);
			mysqli_stmt_execute($this->send_query);
			mysqli_stmt_bind_result($this->send_query, $pincodes);
			while (mysqli_stmt_fetch($this->send_query)) {
				echo '
					<option value="575001">' . $pincodes . '</option>
				';
			}
			mysqli_stmt_close($this->send_query);
		}
	}
}
