<?php

require '../admin/includes/functions.php';

class staff extends admin
{
	private $con, $sql, $send_query, $get, $row;
	public $temp, $flag, $email, $datetime;
	public function __construct()	//constructor to connect to DB
	{
		parent::__construct();
		$this->row = array();
		$this->con = new connectDB();
		$this->con->connect();
		date_default_timezone_set('Asia/Kolkata');
		$this->datetime = date("Y-m-d H:i:s");
		$this->temp = $this->flag = 0;
	}
	public function __destruct()
	{
		$this->con->disconnect();
	}
	public function login()
	{
		if (isset($_POST['login_submit'])) {
			if (isset($_SESSION['STAFF'])) {
				unset($_SESSION['STAFF']);
			}
			$this->temp = 1;
			$isLogin = 0;
			$this->email = $this->con->escape($_POST['email']);
			$pass = md5($this->con->escape($_POST['pass']));

			$this->sql = "SELECT a.first_name, a.last_name, a.staff_id FROM staff a, login_info l WHERE a.email = l.email AND l.email = ? AND l.password = ?";
			$this->send_query = $this->con->prepare($this->sql);

			mysqli_stmt_bind_param($this->send_query, "ss", $this->email, $pass);
			mysqli_stmt_bind_result($this->send_query, $this->fname, $this->lname, $staff_id);

			if (isset($this->send_query) && mysqli_stmt_execute($this->send_query)) {
				while (mysqli_stmt_fetch($this->send_query)) {
					$isLogin = 1;
				}
				mysqli_stmt_close($this->send_query);
				if (!$isLogin) {
					setMessage("The email and password combination didn't match. Please try again. ");
				} else {
					$_SESSION['STAFF'] = array('NAME' => $this->fname . " " . $this->lname, 'EMAIL' => $this->email, 'STAFFID' => $staff_id);
					redirect("index");
				}
			}
		}
	}
}