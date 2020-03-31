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

class admin
{
	private $con, $sql, $send_query, $get, $row;
	public $temp, $flag, $email, $datetime;
	public function __construct()	//constructor to connect to DB
	{
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
	public function add_category()		//form ops to add cat to DB in index?add_cat
	{
		if (isset($_POST['add_category']) && isset($_POST['cat_title'])) {
			$cat_title = $this->con->escape((clear_input($_POST['cat_title'])));
			$cat_desc = $this->con->escape((clear_input($_POST['cat_desc'])));
			if (isset($_GET['img'])) {
				if (!preg_match("/^[a-z A-Z]*$/", $cat_title)) {
					setMessage("Invalid format entered. Only text allowed.");
				} else {
					$this->datetime = date("Y-m-d H:i:s");
					$this->get = base64_decode($_GET['img']);
					$length = strlen($this->get);
					$this->get = substr($this->get, 3, $length);
					// $post = $_POST['cat_title'];
					$sql2 = "INSERT INTO categories(cat_title, icon_url, date_added, cat_desc) VALUES('{$cat_title}','{$this->get}','{$this->datetime}','{$cat_desc}')";
					$this->send_query = $this->con->query($sql2);
					$this->send_query ? setMessage("Category {$cat_title} has been added.") : setMessage("Error: Couldn't add category. " . $this->con->db_error());
				}
			} else {
				setMessage("Please select an image.");
			}
		}
	}

	public function display_category_icons()	//displays icons in index?add_cat 
	{
		$icon_url = "";
		$sql2 = "SELECT icon_url FROM icons";
		$this->send_query = $this->con->prepare($sql2);
		if (isset($this->send_query)) {
			// mysqli_stmt_bind_param($this->send_query, "dt", $param);
			mysqli_stmt_execute($this->send_query);
			mysqli_stmt_bind_result($this->send_query, $icon_url);

			// index?cat&modify_cat&mod=MTM3
			if (isset($_GET['cat']) && isset($_GET['modify_cat']) && isset($_GET['mod'])) {
				while (mysqli_stmt_fetch($this->send_query)) {
					$icon_url = "../" . $icon_url;
					echo '<a href="index?cat&modify_cat&mod=' . $_GET['mod'] . '&img=' . base64_encode($icon_url) . '"><img src="' . $icon_url . '"></a>';
				}
				if (isset($_GET['img'])) {
					echo '<br><br><label>Selected image:</label>';
					$this->get = base64_decode($_GET['img']);
					echo '<br><img src="' . $this->get . '">';
				}
				mysqli_stmt_close($this->send_query);

				$sql2 = "SELECT icon_url FROM categories WHERE cat_id = " . base64_decode($_GET['mod']) . " ";
				$send_query2 = $this->con->query($sql2);
				if (isset($send_query2)) {
					while ($this->row = mysqli_fetch_array($send_query2)) {
						echo '<br><br><label>Current image:</label>';
						echo '<br><img src="../' . $this->row['icon_url'] . '">';
					}
				}
			} else 		//ADD CATEGORY
			{
				while (mysqli_stmt_fetch($this->send_query)) {
					$icon_url = "../" . $icon_url;
					echo '<a href="index?cat&add_cat&img=' . base64_encode($icon_url) . '"><img src="' . $icon_url . '"></a>';
				}
				if (isset($_GET['img'])) {
					echo '<br><br><label>Selected image:</label>';
					$this->get = base64_decode($_GET['img']);
					echo '<br><img src="' . $this->get . '">';
				}
				mysqli_stmt_close($this->send_query);
			}
		}
	}

	public function add_subcat()	//form ops to add subcat to DB in index?add_cat
	{
		if (isset($_POST['add_subcat']) && isset($_POST['subcat_title']) && isset($_POST['dropdown_cat'])) {
			$subcat_title = $this->con->escape((clear_input($_POST['subcat_title'])));
			$cat_id = $this->con->escape((clear_input($_POST['dropdown_cat'])));

			if (!preg_match("/^[a-z A-Z]*$/", $subcat_title)) {
				setMessage("Invalid format entered. Only text allowed.");
			} else {
				$this->datetime = date("Y-m-d H:i:s");
				$sql2 = "SELECT cat_title FROM categories WHERE cat_id = " . $cat_id;
				$this->send_query = $this->con->query($sql2);
				if ($this->send_query) {
					while ($this->row = mysqli_fetch_array($this->send_query)) {
						$cat_title = $this->row['cat_title'];
					}
				}
				$sql2 = "INSERT INTO subcategories(cat_id, sub_cat_title, date_added) VALUES('{$cat_id}','{$subcat_title}','{$this->datetime}')";
				$this->send_query = $this->con->query($sql2);
				$this->send_query ? setMessage("Sub-category <strong>{$subcat_title}</strong> has been added under the Category <strong>{$cat_title}</strong>.") : setMessage("Error: Couldn't add Sub-category. " . $this->con->db_error());
			}
		}
	}

	public function display_cat_dropdown()	//displays categories in the drop down in index?cat&add_cat#wsubcat
	{
		if (isset($_GET['modify_prod']) && isset($_GET['prod']) && $_GET['modify_prod'] == 1 && isset($_GET['id'])) {
			$id = base64_decode($_GET['id']);
			$this->sql = "SELECT cat_id, cat_title FROM categories ORDER BY date_added ASC";
			$this->send_query = $this->con->query($this->sql);
			if ($this->send_query) {
				$sql2 = "SELECT cat_id FROM items WHERE item_id = " . $id;
				$send_query2 = $this->con->query($sql2);
				while ($row2 = mysqli_fetch_array($send_query2)) {
					$this->get = $row2['cat_id'];
				}
				while ($this->row = mysqli_fetch_array($this->send_query)) {
					if ($this->row['cat_id'] == $this->get) {
						$selected = "selected";
					} else {
						$selected = "";
					}
					echo '<option value="' . $this->row['cat_id'] . '" ' . $selected . '>' . $this->row['cat_title'] . '</option>';
				}
			}
		} else {
			$sql2 = "SELECT cat_id, cat_title FROM categories ORDER BY date_added ASC";
			$this->send_query = $this->con->query($sql2);
			if ($this->send_query) {
				while ($this->row = mysqli_fetch_array($this->send_query)) {
					echo '<option value="' . $this->row['cat_id'] . '">' . $this->row['cat_title'] . '</option>';
				}
			}
		}
	}

	public function display_cat_view()	//displays cat and subcat in index?cat&view_cat
	{
		$sql2 = "SELECT c.cat_id, icon_url, cat_title, GROUP_CONCAT('<li>' ,sub_cat_title, '</li>' SEPARATOR '') as `group_sub_cat_title` FROM categories c LEFT JOIN subcategories s ON c.cat_id = s.cat_id GROUP BY cat_title ORDER BY c.date_added ASC";

		$this->send_query = $this->con->query($sql2);
		if ($this->send_query) {
			while ($this->row = mysqli_fetch_array($this->send_query)) {
				echo '<div id="exampleAccordion' . $this->row['cat_id'] . '" data-children=".item">
        		<div class="item">
            	<img src="../' . $this->row['icon_url'] . '">
            	<button type="button" aria-expanded="true" aria-controls="exampleAccordion1" data-toggle="collapse" href="#collapseExample' . $this->row['cat_id'] . '" class="m-0 p-0 btn btn-link">' . $this->row['cat_title'] . '</button>
	            <div data-parent="#exampleAccordion' . $this->row['cat_id'] . '" id="collapseExample' . $this->row['cat_id'] . '" class="collapse">
	                <p class="mb-3">
	                    <ul>
	                    	' . $this->row['group_sub_cat_title'] . '
	                    </ul>
	                </p>
	            </div>
	            </div>
    			</div>';
			}
		} else {
			setMessage("Error: " . $this->con->db_error());
		}
	}

	public function check_for_subcat($cat_id)
	{
		$i = 0;
		$id = $cat_id;
		$sql2 = "SELECT sub_cat_title FROM subcategories WHERE cat_id = ?";
		$send_query2 = $this->con->prepare($sql2);
		if (isset($send_query2)) {
			mysqli_stmt_bind_param($send_query2, "i", $id);
			mysqli_stmt_execute($send_query2);
			mysqli_stmt_bind_result($send_query2, $sub_cat_title);
			while (mysqli_stmt_fetch($send_query2)) {
				$i = $i + 1;
			}
			mysqli_stmt_close($send_query2);
		}
		if ($i >= 1) {
			return 1;
		} else {
			return 0;
		}
	}

	public function display_cat_modify()	//displays cat & subcat in index?cat&modify_cat
	{
		$sql2 = "SELECT cat_id, cat_title from categories ORDER BY date_added ASC";
		$this->send_query = $this->con->query($sql2);

		if (isset($this->send_query)) {
			while ($this->row = mysqli_fetch_array($this->send_query)) {
				if ($this->check_for_subcat($this->row['cat_id'])) {
					$this->temp = "button";
					$tooltip = 'data-toggle="tooltip" data-placement="top" title="Cannot delete the Category if it has Sub-categories. Click on Modify to delete Sub-categories."';
				} else {
					$this->temp = "a";
					$tooltip = '';
				}
				echo '
			    <div class="col-md-4">
			        <div class="card-shadow-primary border mb-3 card card-body primary-shadow">
			            <div class="card-header">
			                <h5 class="card-title">' . $this->row['cat_title'] . '</h5>
			            </div>
			            <div class="card-body">
			            
							<' . $this->temp . '  href="index?cat&modify_cat&del&mod=' . base64_encode($this->row['cat_id']) . '" class="btn btn-danger btn-icon-split delete-btn" ' . $tooltip . '>
								<span class="icon text-white-50">
								  <i class="fas fa-trash"></i>
								</span>
								<span class="text">Delete</span>
							</' . $this->temp . ' >
							
							<a href="index?cat&modify_cat&mod=' . base64_encode($this->row['cat_id']) . '" class="btn btn-success btn-icon-split success-btn">
								<span class="icon text-white-50">
								  <i class="fas fa-check"></i>
								</span>
								<span class="text">Modify</span>
							</a>
			            </div>           
			        </div>     
			    </div>
			    ';
			}
			// mysqli_stmt_close($this->send_query);
		}
	}

	public function delete_category()		//executes when cat is deleted in index?cat&modify_cat
	{
		if (isset($_GET['mod']) && isset($_GET['del'])) {
			$sql2 = "DELETE FROM categories WHERE cat_id=" . base64_decode($_GET['mod']) . " ";
			$this->send_query = $this->con->query($sql2);
			if ($this->send_query) {
				if ($this->con->affected_rows() >= 1) {
					$this->temp = 1;
				}
			}
		}
		if (isset($_GET['subcat'])) {
			redirect("index?cat&modify_cat&catdel");
			$this->temp = 1;
		}
	}

	public function display_catname_modify()		//displays cat name in index?cat&modify_cat&mod=MTEw
	{
		if (isset($_GET['mod'])) {
			$cat_id = base64_decode($_GET['mod']);
			$sql2 = "SELECT cat_title from categories WHERE cat_id = ?";
			$this->send_query = $this->con->prepare($sql2);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "i", $cat_id);
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_bind_result($this->send_query, $cat_title);
				if (mysqli_stmt_fetch($this->send_query)) {
					echo $cat_title;
				} else {
					redirect("index.php");
				}
				mysqli_stmt_close($this->send_query);
			}
		}
	}

	public function check_item_exists($id)
	{

		$temp = 0;
		$sub_cat_id = $id;
		$sql2 = "SELECT item_id FROM items WHERE sub_cat_id = " . $sub_cat_id;
		$send_query2 = $this->con->query($sql2);
		if (isset($send_query2)) {
			// mysqli_stmt_bind_param($send_query2, "i", $sub_cat_id);
			if (mysqli_num_rows($send_query2) >= 1) {
				$temp = 1;
			}
		}
		if ($temp == 1) {
			return 1;
		} else {
			return 0;
		}
	}

	public function display_subcat_in_modify()		//displays subcategories in text boxes in index?cat&modify_cat&mod=MTM3
	{
		$i = 1;
		$this->temp = 0;
		$cat_id = base64_decode($_GET['mod']);
		$sql2 = "SELECT sub_cat_id, sub_cat_title FROM subcategories WHERE cat_id = {$cat_id} ORDER BY date_added ASC";
		$this->send_query = $this->con->query($sql2);
		if (isset($this->send_query)) {
			// mysqli_stmt_execute($this->send_query);
			// mysqli_bind_result($this->send_query, $sub_cat_id, $sub_cat_title);
			// $this->check_item_exists($sub_cat_id);
			while ($row = mysqli_fetch_array($this->send_query)) {
				if ($this->check_item_exists($row['sub_cat_id'])) {
					$disabled = "disabled ";
					$tooltip = ' data-toggle="tooltip" data-placement="left" title="Cannot remove Sub-Category if an item exists under it. " ';
				} else {
					$disabled = "";
					$tooltip = ' data-toggle="tooltip" data-placement="left" title="Remove Sub-Category ' . $i . '" ';
				}
				echo '
	            <div class="form-row insert-content">
	                <div class="col-md-9">
	                    <label for="validationCustom01">Sub-Category ' . $i . '</label>
	                    <input type="text" class="form-control" id="validationCustom01" placeholder="Fries" name="subcat_title' . $row['sub_cat_id'] . '" value="' . $row['sub_cat_title'] . '" pattern="([A-Za-z ]){3,}" data-toggle="tooltip" data-placement="top" title="3 characters minimum" required>  
	                    <div class="valid-feedback">
	                        Looks good!
	                    </div>
	                    <div class="invalid-feedback">
	                        Please follow the requested format.
	                    </div>                        
	                </div>
	                <div class="col-md-3 del-btn">
	                	<span class="d-inline-block" ' . $tooltip . '>
	                    <a href="index?' . $_SERVER['QUERY_STRING'] . '&subcat=' . base64_encode($row['sub_cat_id']) . '" class="' . $disabled . 'btn btn-danger btn-circle delete-btn-circle">
	                    <i class="fas fa-trash"></i>
	                    </a> 
	                    </span>                       
	                </div>
	            </div>';
				$i++;
			}
			if (mysqli_num_rows($this->send_query) <= 0) {
				$this->temp = 1;
				setMessage("No Sub-categories found. ");
			}
		} else {
			setMessage("Something went wrong.");
		}
	}

	public function display_cat_description()		//index?cat&modify_cat&mod=MTM3 displays category description
	{
		$cat_id = base64_decode($_GET['mod']);
		$this->sql = "SELECT cat_desc FROM categories WHERE cat_id = ?";
		$this->send_query = $this->con->prepare($this->sql);
		if (isset($this->send_query)) {
			mysqli_stmt_bind_param($this->send_query, "i", $cat_id);
			mysqli_stmt_bind_result($this->send_query, $cat_desc);
			if (mysqli_stmt_execute($this->send_query)) {
				while (mysqli_stmt_fetch($this->send_query)) {
					echo $cat_desc;
				}
			}
			mysqli_stmt_close($this->send_query);
		}
	}

	public function delete_subcat()		//delete all button and delete icon beside every subcat index?cat&modify_cat&mod=MTM3
	{
		if (isset($_GET['mod']) && isset($_GET['delsc']) && base64_decode($_GET['delsc']) == "all") {
			$cat_id = base64_decode($_GET['mod']);
			$sql2 = "DELETE FROM subcategories WHERE cat_id = ?";
			$this->send_query = $this->con->prepare($sql2);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "i", $cat_id);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_affected_rows($this->send_query) >= 1) {
					setMessage(mysqli_stmt_affected_rows($this->send_query) . " Sub-categories deleted.");
				} else {
					setMessage("Cannot delete Sub-categories. One or many Sub-categories have items under them. ");
				}

				mysqli_stmt_close($this->send_query);
			}
		}
		if (isset($_GET['mod']) && isset($_GET['subcat'])) {
			$sub_cat_id = base64_decode($_GET['subcat']);
			$cat_id = base64_decode($_GET['mod']);
			$sql2 = "DELETE FROM subcategories WHERE cat_id = ? AND sub_cat_id = ?";
			$this->send_query = $this->con->prepare($sql2);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "ii", $cat_id, $sub_cat_id);
				mysqli_stmt_execute($this->send_query);
				if (mysqli_stmt_affected_rows($this->send_query) >= 1) {
					setMessage(mysqli_stmt_affected_rows($this->send_query) . " Sub-categories deleted.");
				}
				mysqli_stmt_close($this->send_query);
			}
		}
	}

	public function save_modify_subcat()		//index?cat&modify_cat&mod=MTM3 - updates the DB with new subcat when save btn is clicked
	{
		$i = 0;
		$this->temp = 0;
		date_default_timezone_set('Asia/Kolkata');
		$this->datetime = date("Y-m-d H:i:s");
		if (isset($_GET['mod']) && isset($_GET['cat']) && isset($_GET['modify_cat']) && isset($_POST['modify_subcat'])) {
			$cat_id = base64_decode($_GET['mod']);
			$sql2 = "SELECT sub_cat_id FROM subcategories WHERE cat_id = " . $cat_id;
			$this->send_query = $this->con->query($sql2);
			if (isset($this->send_query)) {
				while ($this->row = mysqli_fetch_array($this->send_query)) {
					if (isset($_POST['subcat_title' . $this->row['sub_cat_id']])) {
						$sub_cat_title =  $this->con->escape(clear_input($_POST['subcat_title' . $this->row['sub_cat_id']]));

						if (!preg_match("/^[a-z A-Z]*$/", $sub_cat_title)) {
							setMessage("Invalid format entered. Only text allowed.");
						} else {
							$sql2 = "UPDATE subcategories SET `sub_cat_title` = '$sub_cat_title', `date_modified` = '{$this->datetime}' WHERE `sub_cat_id` = " . $this->row['sub_cat_id'];
							$send_query2 = $this->con->query($sql2);
							if ($send_query2) {
								$this->temp = 1;
								$i = $i + $this->con->affected_rows();
							}
						}
					}
				}
			}
		}
		$this->temp == 1 ? setMessage($i . " records updated. ") : $this->temp = 0;
	}

	public function save_modify_cat($img) 		//index?cat&modify_cat&mod=MTM3 - updates the DB with new cat when save btn is clicked
	{
		// setMessage($img . " : image");
		$this->temp = 0;
		$imgmod = "";
		date_default_timezone_set('Asia/Kolkata');
		$this->datetime = date("Y-m-d H:i:s");
		if ($img != "notset") {
			$imgmod = substr($img, 3, strlen($img));
		} else {
			$sql2 = "SELECT icon_url FROM categories WHERE cat_id = " . base64_decode($_GET['mod']) . " ";
			$send_query2 = $this->con->query($sql2);
			if (isset($send_query2)) {
				while ($this->row = mysqli_fetch_array($send_query2)) {
					$imgmod = $this->row['icon_url'];
				}
			}
		}

		if (isset($_GET['mod']) && isset($_GET['cat']) && isset($_GET['modify_cat']) && isset($_POST['save_modify_cat'])) {
			$cat_title = $this->con->escape(clear_input($_POST['cat_title']));
			$cat_desc = $this->con->escape(clear_input($_POST['cat_desc']));
			if (!preg_match("/^[a-z A-Z]*$/", $cat_title)) {
				setMessage("Invalid format entered. Only text allowed.");
			} else {
				$cat_id = base64_decode($_GET['mod']);
				$sql2 = "UPDATE categories c, icons i SET c.icon_url = '{$imgmod}', c.cat_title = '{$cat_title}', c.cat_desc = '{$cat_desc}', c.date_modified = '{$this->datetime}' WHERE c.icon_url = i.icon_url AND c.cat_id = " . $cat_id;
				$this->send_query = $this->con->query($sql2);

				if ($this->send_query) {
					// mysqli_stmt_bind_param($this->send_query, "sssi", $cat_title, $this->datetime, $imgmod, $cat_id);
					// mysqli_stmt_execute($this->send_query);
					$this->temp = 1;
					// mysqli_stmt_close($this->send_query);
					unset($_GET['img']);
				} else {
					setMessage("0 records updated");
				}
			}
		}
		$this->temp == 1 ? setMessage("1 record updated. ") : $this->temp = 0;
	}

	public function dispay_subcat_dropdown()	//index?prod&add_prod - file name: modify_prod
	{
		if (isset($_GET['catid']) && !isset($_GET['modify_prod'])) {
			$cat_id = base64_decode($_GET['catid']);
			$this->sql = "SELECT sub_cat_id, sub_cat_title from subcategories WHERE cat_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "i", $cat_id);
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_bind_result($this->send_query, $sub_cat_id, $sub_cat_title);
				if (mysqli_stmt_fetch($this->send_query)) {
					do {
						echo '<option value="' . $sub_cat_id . '">' . $sub_cat_title . '</option>';
					} while (mysqli_stmt_fetch($this->send_query));
				} else {
					setMessage("Unable to retrieve subcategories");
					// redirect("index.php");
				}
				mysqli_stmt_close($this->send_query);
			}
		} else if (isset($_GET['modify_prod']) && isset($_GET['prod']) && $_GET['modify_prod'] == 2 && isset($_GET['id']) && isset($_GET['catid'])) {
			$this->get = 0;
			$item_id = base64_decode($_GET['id']);
			$id = base64_decode($_GET['catid']);
			$this->sql = "SELECT sub_cat_id, sub_cat_title FROM subcategories WHERE cat_id = " . $id;
			$this->send_query = $this->con->query($this->sql);
			if ($this->send_query) {
				$sql2 = "SELECT sub_cat_id FROM items WHERE item_id = " . $item_id;
				$send_query2 = $this->con->query($sql2);
				while ($row2 = mysqli_fetch_array($send_query2)) {
					$this->get = $row2['sub_cat_id'];
				}
				while ($this->row = mysqli_fetch_array($this->send_query)) {
					if ($this->row['sub_cat_id'] == $this->get) {
						$selected = "selected";
					} else {
						$selected = "";
					}
					echo '<option value="' . $this->row['sub_cat_id'] . '" ' . $selected . '>' . $this->row['sub_cat_title'] . '</option>';
				}
			}
		}
	}

	public function add_item()		//index?prod&add_prod - file name: modify_prod
	{
		$this->temp = 0;
		$this->get = 0;
		$cat_id = $item_price = $item_title = $item_id = $sub_cat_title = 0;
		date_default_timezone_set('Asia/Kolkata');
		$this->datetime = date("Y-m-d H:i:s");
		if (isset($_POST['add_prod_next'])) {
			date_default_timezone_set('Asia/Kolkata');
			$this->datetime = date("Y-m-d H:i:s");
			$cat_id = $this->con->escape(clear_input($_POST['cat_title']));
			$item_price = $this->con->escape(clear_input($_POST['item_price']));
			$item_title = $this->con->escape(clear_input($_POST['item_title']));
			!trim($_POST['item_id']) == "" ? $item_id = $this->con->escape(clear_input($_POST['item_id'])) : $item_id = 0;
			$this->temp = 1;
			$_SESSION['header'] = "prod&add_prod=2&catid=" . base64_encode($cat_id) . "&price=" . base64_encode($item_price) . "&title=" . base64_encode($item_title) . "&itid=" . base64_encode($item_id);

			redirect("index?prod&add_prod=2&catid=" . base64_encode($cat_id) . "&price=" . base64_encode($item_price) . "&title=" . base64_encode($item_title) . "&itid=" . base64_encode($item_id));
		}
		if ($_GET['add_prod'] == 2) {
			if (isset($_GET['catid']) && isset($_GET['price']) && isset($_GET['title']) && isset($_GET['itid']) && $_SESSION['header'] == $_SERVER['QUERY_STRING']) {
				$cat_id = $this->con->escape(clear_input(base64_decode($_GET['catid'])));
				$item_price = $this->con->escape(clear_input(base64_decode($_GET['price'])));
				$item_title = $this->con->escape(clear_input(base64_decode($_GET['title'])));
				$item_id = $this->con->escape(clear_input(base64_decode($_GET['itid'])));
				// $_SESSION['add_prod'] = 2;	
				if (isset($_POST['add_prod_publish'])) {
					$sub_cat_id = $this->con->escape(clear_input($_POST['sub_cat_title']));
					$status = isset($_POST['available_check']) ? 1 : 0;
					if (file_exists($_FILES['prod_image']['tmp_name']) || is_uploaded_file($_FILES['prod_image']['tmp_name'])) {
						$this->temp = 1;	//insert file to db

						$target_dir = "../img/items/";
						$target_file = $target_dir . basename($_FILES["prod_image"]["name"]);
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

						// Check if image file is a actual image or fake image

						$check = getimagesize($_FILES["prod_image"]["tmp_name"]);
						if ($check !== false) {
							// setMessage("File is an image - " . $check["mime"] . ".");
							$uploadOk = 1;
						} else {
							setMessage("File is not an image.");
							$uploadOk = 0;
						}

						// Check if file already exists
						if (file_exists($target_file)) {
							setMessage("File already exists!");
							$uploadOk = 0;
						}
						// Check file size
						// if ($_FILES["prod_image"]["size"] > 1048576) {
						//     setMessage("Your file is too large. Please upload a file below 1 MB.");
						//     $uploadOk = 0;
						// }
						// Allow certain file formats
						if (
							$imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
							&& $imageFileType != "gif"
						) {
							setMessage("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
							$uploadOk = 0;
						}
						// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
							setMessage("Your file was not uploaded.");
							// if everything is ok, try to upload file
						} else {
							if (move_uploaded_file($_FILES["prod_image"]["tmp_name"], $target_file)) {
								setMessage("The file " . basename($_FILES["prod_image"]["name"]) . " has been uploaded.");
							} else {
								setMessage("There was an error uploading your file. Please try again.");
							}
						}
					}
					if ($item_id == 0 && $this->temp == 0) {
						$this->sql = "INSERT INTO `items` (`item_title`, `cat_id`, `sub_cat_id`, `item_price`, `date_added`, `isAvailable`) VALUES (?, ?, ?, ?, ?, ?)";
						$this->send_query = $this->con->prepare($this->sql);
						mysqli_stmt_bind_param($this->send_query, "siidsi", $item_title, $cat_id, $sub_cat_id, $item_price, $this->datetime, $status);
						if (isset($this->send_query)) {
							if (mysqli_stmt_execute($this->send_query)) {
								if (isset($_SESSION['header'])) unset($_SESSION['header']);
								$_SESSION['header'] = "prod&add_prod=3&lid=" . base64_encode($this->con->last_id());
								mysqli_stmt_close($this->send_query);
								redirect("index?prod&add_prod=3&lid=" . base64_encode($this->con->last_id()));
							} else {
								mysqli_stmt_close($this->send_query);
								setMessage("Couldn't add the item. Please try again. " . $this->con->db_error());
							}
						}
					} else if ($item_id == 0 && $this->temp == 1 && $uploadOk == 1) {
						if (substr($target_file, 0, 3) == "../") {
							$target_file = substr($target_file, 3, strlen($target_file));
						}
						$this->sql = "INSERT INTO `items` (`item_title`, `cat_id`, `sub_cat_id`, `item_price`, `item_image`, `date_added`, `isAvailable`) VALUES (?, ?, ?, ?, ?, ?, ?)";
						$this->send_query = $this->con->prepare($this->sql);
						mysqli_stmt_bind_param($this->send_query, "siidssi", $item_title, $cat_id, $sub_cat_id, $item_price, $target_file, $this->datetime, $status);
						if (isset($this->send_query)) {
							if (mysqli_stmt_execute($this->send_query)) {
								if (isset($_SESSION['header'])) unset($_SESSION['header']);
								$_SESSION['header'] = "prod&add_prod=3&lid=" . base64_encode($this->con->last_id());
								mysqli_stmt_close($this->send_query);
								redirect("index?prod&add_prod=3&lid=" . base64_encode($this->con->last_id()));
							} else {
								mysqli_stmt_close($this->send_query);
								setMessage("Couldn't add the item. Please try again. " . $this->con->db_error());
							}
						}
					} else if ($item_id != 0 && $this->temp == 0) {
						$this->sql = "INSERT INTO `items` (`item_id`, `item_title`, `cat_id`, `sub_cat_id`, `item_price`, `date_added`, `isAvailable`) VALUES (?, ?, ?, ?, ?, ?, ?)";
						$this->send_query = $this->con->prepare($this->sql);
						mysqli_stmt_bind_param($this->send_query, "isiidsi", $item_id, $item_title, $cat_id, $sub_cat_id, $item_price, $this->datetime, $status);
						if (isset($this->send_query)) {
							if (mysqli_stmt_execute($this->send_query)) {
								if (isset($_SESSION['header'])) unset($_SESSION['header']);
								$_SESSION['header'] = "prod&add_prod=3&lid=" . base64_encode($this->con->last_id());
								mysqli_stmt_close($this->send_query);
								redirect("index?prod&add_prod=3&lid=" . base64_encode($this->con->last_id()));
							} else {
								mysqli_stmt_close($this->send_query);
								setMessage("Couldn't add the item. Please try again. " . $this->con->db_error());
							}
						}
					} else if ($item_id != 0 && $this->temp == 1 && $uploadOk == 1) {
						if (substr($target_file, 0, 3) == "../") {
							$target_file = substr($target_file, 3, strlen($target_file));
						}
						$this->sql = "INSERT INTO `items` (`item_id`, `item_title`, `cat_id`, `sub_cat_id`, `item_price`, `item_image`, `date_added`, `isAvailable`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
						$this->send_query = $this->con->prepare($this->sql);
						mysqli_stmt_bind_param($this->send_query, "isiidssi", $item_id, $item_title, $cat_id, $sub_cat_id, $item_price, $target_file, $this->datetime, $status);
						if (isset($this->send_query)) {
							if (mysqli_stmt_execute($this->send_query)) {
								if (isset($_SESSION['header'])) unset($_SESSION['header']);
								$_SESSION['header'] = "prod&add_prod=3&lid=" . base64_encode($this->con->last_id());
								mysqli_stmt_close($this->send_query);
								redirect("index?prod&add_prod=3&lid=" . base64_encode($this->con->last_id()));
							} else {
								mysqli_stmt_close($this->send_query);
								setMessage("Couldn't add the item. Please try again. " . $this->con->db_error());
							}
						}
					}
				}
			} else {
				redirect("index?prod&add_prod=1");
			}
		}
		if ($_GET['add_prod'] == 3 && isset($_GET['lid']) && $_SESSION['header'] == $_SERVER['QUERY_STRING']) {
			isset($_GET['lid']) ? setMessage("Item added with the ID: " . base64_decode($_GET['lid'])) : setMessage("Item added.");
		}
		// $_SESSION['header'] is unset in modify_prod.php
	}

	public function display_last_item_added()
	{
		if (isset($_GET['lid'])) {
			$lid = base64_decode($_GET['lid']);
			$this->sql = "SELECT item_id, item_title, c.cat_title, s.sub_cat_title, item_image, item_price FROM items i, categories c, subcategories s WHERE c.cat_id = i.cat_id AND s.sub_cat_id = i.sub_cat_id AND item_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "i", $lid);
				mysqli_stmt_execute($this->send_query);
				mysqli_stmt_bind_result($this->send_query, $item_id, $item_title, $cat_title, $sub_cat_title, $item_image, $item_price);
				if (mysqli_stmt_fetch($this->send_query)) {
					echo '
	                <div class="col-md-6">
	                    <h1 class="display-4">' . $item_title . '</h1>
	                    <p class="lead">Item ID: ' . $item_id . '</p>
	                    <p class="lead">Category: ' . $cat_title . '</p>
	                    <p class="lead">Sub-category: ' . $sub_cat_title . '</p>
	                    <p class="lead">Item Price: &#8377; ' . $item_price . '</p>
	                </div>
	                <div class="col-md-6">
	                    <!-- <h1 class="display-4">Fluid jumbotron</h1> -->
	                    <img src="../' . $item_image . '" class="img-fluid shadow item-added-image"><br>		                                      
	                </div>						
					';
				}
				mysqli_stmt_close($this->send_query);
			}
		}
	}

	public function display_items()			//displays all items in index?prod&view_prod - DATA TABLE REPORT
	{
		$this->sql = "SELECT item_id, item_title, item_image, item_price, c.cat_title, s.sub_cat_title, i.date_added, i.date_modified, i.isAvailable FROM items i, categories c, subcategories s WHERE c.cat_id = i.cat_id AND s.sub_cat_id = i.sub_cat_id";
		$this->send_query = $this->con->prepare($this->sql);
		if (isset($this->send_query)) {
			// mysqli_stmt_bind_param($this->send_query);
			mysqli_stmt_bind_result($this->send_query, $item_id, $item_title, $item_image, $item_price, $cat_title, $sub_cat_title, $date_added, $date_modified, $isAvailable);
			if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
				do {
					if ($isAvailable == 1) {
						$hide = '<td data-toggle="tooltip"  data-placement="top" title="" data-original-title="Mark ' . $item_title . ' as unavailable. ">
						<a href="index?prod&view_prod&itid=' . base64_encode($item_id) . '&status=' . base64_encode(0) . '" class="btn btn-warning btn-circle btn-sm warning-btn-circle">
							<i class="fas fa-minus"></i>
						</a>
						</td>
						';
						$hide_instead = '
						<p class="mb-0"><a href="index?prod&view_prod&itid=' . base64_encode($item_id) . '&status=' . base64_encode(0) . '">Click here</a> to hide the item instead.
						</p>';
					} else {
						$hide = '<td data-toggle="tooltip"  data-placement="top" title="" data-original-title="Mark ' . $item_title . ' as available. ">
						<a href="index?prod&view_prod&itid=' . base64_encode($item_id) . '&status=' . base64_encode(1) . '" class="btn btn-success btn-circle btn-sm success-btn-circle">
							<i class="fas fa-plus"></i>
						</a>
						</td>
						';
						$hide_instead = "";
					}
					echo '
	           		<tr>
                        <td><a data-toggle="tooltip"  data-placement="top" title="" data-original-title="Click to modify" href="index?prod&modify_prod=1&id=' . base64_encode($item_id) . '">' . $item_id . '</a></td>
                        <td><a data-toggle="tooltip"  data-placement="top" title="" data-original-title="Click to modify" href="index?prod&modify_prod=1&id=' . base64_encode($item_id) . '">' . $item_title . '</a></td>
                        <td><a data-toggle="tooltip"  data-placement="top" title="" data-original-title="Click to modify" href="index?prod&modify_prod=1&id=' . base64_encode($item_id) . '"><img class="img-fluid table-image" src="../' . $item_image . '"></a></td>
                        <td>&#8377;&nbsp;' . $item_price . '&nbsp;</td>
                        <td>' . $cat_title . '</td>
                        <td>' . $sub_cat_title . '</td>
                        <td>' . $date_added . '</td>
                        <td>' . $date_modified . '</td>
                        <td class="delete-item-btn" data-toggle="tooltip"  data-placement="top" title="" data-original-title="Delete ' . $item_title . '">
                        <button class="btn btn-danger btn-circle btn-sm delete-btn-circle" data-toggle="modal" data-target="#exampleModal' . $item_id . '">
	                    	<i class="fas fa-trash"></i>
	                    </button>
	                    </td>
						' . $hide . '                    
                    </tr>';

					//delete modal
					echo '
					<div class="modal fade" id="exampleModal' . $item_id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel' . $item_id . '" style="display: none;" aria-hidden="true">
					    <div class="modal-dialog" role="document">
					        <div class="modal-content">
					            <div class="modal-header">
					                <h5 class="modal-title" id="exampleModalLabel' . $item_id . '">Are you sure? This action is irreversible!</h5>
					                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                    <span aria-hidden="true">×</span>
					                </button>
					            </div>
					            <div class="modal-body">
					                <p class="mb-0">Do you want to permanently delete ' . $item_title . '?</p>
					                ' . $hide_instead . '
					            </div>
					            <div class="modal-footer">
									<a href="index?prod&view_prod&del=' . base64_encode($item_id) . '" class="btn btn-danger btn-icon-split delete-btn btn-padding">
									    <span class="icon text-white-50">
									    <i class="fas fa-trash"></i>
									    </span>
									    <span class="text">Delete</span>
									</a>
									<button class="btn btn-secondary btn-icon-split btn-padding gray-btn" data-dismiss="modal">
									    <span class="icon text-white-50">
									    <i class="fas fa-times"></i>
									    </span>
									    <span class="text">Close</span>
									</button>
					            </div>
					        </div>
					    </div>
					</div>';
				} while (mysqli_stmt_fetch($this->send_query));
			}
			mysqli_stmt_close($this->send_query);
		}
	}

	public function delete_product_view_page()		//index?prod&view_prod - DELETE BUTTON SMALL ICON
	{
		if (isset($_GET['prod']) && isset($_GET['view_prod']) && isset($_GET['del'])) {
			$item_id = base64_decode($_GET['del']);
			$this->sql = "DELETE FROM items WHERE item_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "i", $item_id);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_affected_rows($this->send_query) >= 1) {
					setMessage(mysqli_stmt_affected_rows($this->send_query) . " item deleted.");
				}
				mysqli_stmt_close($this->send_query);
			}
			unset($_GET['del']);
		}
	}
	public function hide_product_view_page()	//index?prod&view_prod - HIDE/UNHIDE BUTTON SMALL ICON
	{
		if (isset($_GET['prod']) && isset($_GET['view_prod']) && isset($_GET['status']) && isset($_GET['itid'])) {
			$item_id = base64_decode($_GET['itid']);
			$status = base64_decode($_GET['status']);
			$this->sql = "UPDATE items SET isAvailable = ? WHERE item_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "ii", $status, $item_id);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_affected_rows($this->send_query) >= 1) {
					$status == 1 ? $status_display = "Available" : $status_display = "Unavailable";
					setMessage(mysqli_stmt_affected_rows($this->send_query) . " item set as <strong>" . $status_display . "</strong>.");
				}
				mysqli_stmt_close($this->send_query);
			}
			unset($_GET['status']);
			unset($_GET['itid']);
		}
	}

	public function modify_item()
	{
		$this->temp = 0;
		$this->get = 0;
		$cat_id = $item_price = $item_title = $item_id = $sub_cat_title = 0;
		date_default_timezone_set('Asia/Kolkata');
		$this->datetime = date("Y-m-d H:i:s");
		if (isset($_POST['add_prod_next'])) {
			date_default_timezone_set('Asia/Kolkata');
			$this->datetime = date("Y-m-d H:i:s");
			$cat_id = $this->con->escape(clear_input($_POST['cat_title']));
			$item_price = $this->con->escape(clear_input($_POST['item_price']));
			$item_title = $this->con->escape(clear_input($_POST['item_title']));
			$item_id = base64_decode($_GET['id']);
			$_SESSION['header'] = "prod&modify_prod=2&catid=" . base64_encode($cat_id) . "&price=" . base64_encode($item_price) . "&title=" . base64_encode($item_title) . "&id=" . base64_encode($item_id);

			redirect("index?prod&modify_prod=2&catid=" . base64_encode($cat_id) . "&price=" . base64_encode($item_price) . "&title=" . base64_encode($item_title) . "&id=" . base64_encode($item_id));
		}
		if ($_GET['modify_prod'] == 2) {
			if (isset($_GET['catid']) && isset($_GET['price']) && isset($_GET['title']) && isset($_GET['id'])) {
				$cat_id = $this->con->escape(clear_input(base64_decode($_GET['catid'])));
				$item_price = $this->con->escape(clear_input(base64_decode($_GET['price'])));
				$item_title = $this->con->escape(clear_input(base64_decode($_GET['title'])));
				$item_id = $this->con->escape(clear_input(base64_decode($_GET['id'])));
				// $_SESSION['add_prod'] = 2;	
				if (isset($_POST['add_prod_publish'])) {
					$sub_cat_id = $this->con->escape(clear_input($_POST['sub_cat_title']));
					$status = isset($_POST['available_check']) ? 1 : 0;
					if (file_exists($_FILES['prod_image']['tmp_name']) || is_uploaded_file($_FILES['prod_image']['tmp_name'])) {
						$this->temp = 1;	//insert file to db

						$target_dir = "../img/items/";
						$target_file = $target_dir . basename($_FILES["prod_image"]["name"]);
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

						// Check if image file is a actual image or fake image

						$check = getimagesize($_FILES["prod_image"]["tmp_name"]);
						if ($check !== false) {
							// setMessage("File is an image - " . $check["mime"] . ".");
							$uploadOk = 1;
						} else {
							setMessage("File is not an image.");
							$uploadOk = 0;
						}

						// Check if file already exists
						if (file_exists($target_file)) {
							setMessage("File already exists!");
							$uploadOk = 0;
						}
						// Check file size
						if ($_FILES["prod_image"]["size"] > 1048576) {
							setMessage("Your file is too large. Please upload a file below 1 MB.");
							$uploadOk = 0;
						}
						// Allow certain file formats
						if (
							$imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
							&& $imageFileType != "gif"
						) {
							setMessage("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
							$uploadOk = 0;
						}
						// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
							setMessage("Your file was not uploaded.");
							// if everything is ok, try to upload file
						} else {
							if (move_uploaded_file($_FILES["prod_image"]["tmp_name"], $target_file)) {
								setMessage("The file " . basename($_FILES["prod_image"]["name"]) . " has been uploaded.");
							} else {
								setMessage("There was an error uploading your file. Please try again.");
							}
						}
					}
					if ($this->temp == 0) {
						$this->sql = "UPDATE `items` SET `item_title` = ?, `cat_id` = ?, `sub_cat_id` = ?, `item_price` = ?, `date_modified` = ?, `isAvailable` = ? WHERE `item_id` = ?";
						$this->send_query = $this->con->prepare($this->sql);
						mysqli_stmt_bind_param($this->send_query, "siidsii", $item_title, $cat_id, $sub_cat_id, $item_price, $this->datetime, $status, $item_id);
						if (isset($this->send_query)) {
							if (mysqli_stmt_execute($this->send_query)) {
								if (isset($_SESSION['header'])) unset($_SESSION['header']);
								$_SESSION['header'] = "prod&modify_prod=3&lid=" . base64_encode($item_id);
								mysqli_stmt_close($this->send_query);
								redirect("index?prod&modify_prod=3&lid=" . base64_encode($item_id));
							} else {
								mysqli_stmt_close($this->send_query);
								setMessage("Couldn't update item. Please try again. " . $this->con->db_error());
							}
						}
					} else if ($this->temp == 1 && $uploadOk == 1) {
						if (substr($target_file, 0, 3) == "../") {
							$target_file = substr($target_file, 3, strlen($target_file));
						}
						$this->sql = "UPDATE `items` SET `item_title` = ?, `cat_id` = ?, `sub_cat_id` = ?, `item_price` = ?, `date_modified` = ?, `isAvailable` = ?, `item_image` = ? WHERE `item_id` = ?";
						$this->send_query = $this->con->prepare($this->sql);
						mysqli_stmt_bind_param($this->send_query, "siidsisi", $item_title, $cat_id, $sub_cat_id, $item_price, $this->datetime, $status, $target_file, $item_id);
						if (isset($this->send_query)) {
							if (mysqli_stmt_execute($this->send_query)) {
								if (isset($_SESSION['header'])) unset($_SESSION['header']);
								$_SESSION['header'] = "prod&modify_prod=3&lid=" . base64_encode($item_id);
								mysqli_stmt_close($this->send_query);
								redirect("index?prod&modify_prod=3&lid=" . base64_encode($item_id));
							} else {
								mysqli_stmt_close($this->send_query);
								setMessage("Couldn't update item. Please try again. " . $this->con->db_error());
							}
						}
					}
				}
			} else {
				redirect("index?prod&view_prod");
			}
		}
		if ($_GET['modify_prod'] == 3 && isset($_GET['lid']) && $_SESSION['header'] == $_SERVER['QUERY_STRING']) {
			isset($_GET['lid']) ? setMessage("Item with the ID: " . base64_decode($_GET['lid']) . " is updated. ") : setMessage("Item updated.");
		}
		// $_SESSION['header'] is unset in view_prod.php
	}

	public function view_orders()	//index?view_orders
	{
		$this->check_status();
		$this->sql = "SELECT o.order_id, GROUP_CONCAT(i.item_title, '&nbsp;(x', op.quantity, ')' SEPARATOR '<br>') as `group_item_id`, o.amount, o.order_date, o.transaction_type, o.order_status FROM orders_received o, ordered_products op, items i WHERE o.order_id = op.order_id AND i.item_id = op.item_id GROUP BY order_id ORDER BY o.order_date DESC";
		$this->send_query = $this->con->prepare($this->sql);
		if (isset($this->send_query)) {
			// mysqli_stmt_bind_param($this->send_query);
			mysqli_stmt_bind_result($this->send_query, $order_id, $item_title, $amount, $order_date, $payment_mode, $order_status);
			if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
				do {
					if (strlen($order_status) > 24) {
						$order_status = substr($order_status, 0, 23);
						$order_status = $order_status . "...";
					}
					if ((!preg_match("/DELIVERED/mi", $order_status) && isset($_GET['new'])) || (!isset($_GET['new']) && !isset($_GET['delivered'])))		//DISPLAYS UNDEIVERED ORDERS(NEW ORDERS)
					{
						echo '
		           		<tr>
	                        <td><a data-toggle="tooltip"  data-placement="top" title="" data-original-title="Click to view address & payment details" href="index?view_orders&ordid=' . base64_encode($order_id) . '&ordstatus">' . $order_id . '</a></td>
	                        <td><a data-toggle="tooltip"  data-placement="top" title="" data-original-title="Click to view address & payment details" href="index?view_orders&ordid=' . base64_encode($order_id) . '&ordstatus">' . $item_title . '</a></td>
	                        <td>&#8377;&nbsp;' . $amount . '&nbsp;</td>
	                        <td>' . $order_date . '</td>
	                        <td>' . $payment_mode . '</td>
	                        <td><div class="badge badge-danger">' . $order_status . '</div></td>
	                        <td class="text-center">
								<div class="dropdown d-inline-block">

								    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-dark"></button>

								    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start">
								        <a href="index?view_orders&ordid=' . base64_encode($order_id) . '&status=' . base64_encode("confirmed") . '"><button type="button" tabindex="0" class="dropdown-item">Order Confirmed.</button></a>
								        <a href="index?view_orders&ordid=' . base64_encode($order_id) . '&status=' . base64_encode("transit") . '"><button type="button" tabindex="0" class="dropdown-item">On Transit.</button></a>
								        <a href="index?view_orders&ordid=' . base64_encode($order_id) . '&status=' . base64_encode("delivered") . '"><button type="button" tabindex="0" class="dropdown-item">Delivered.</button></a>							        
								    </div>
								</div> 
	                        </td>
	                    </tr>';
					}
					if (preg_match("/DELIVERED/mi", $order_status) && isset($_GET['delivered']))		//DISPLAYS DEIVERED ORDERS(OLD ORDERS)
					{
						echo '
		           		<tr>
	                        <td><a data-toggle="tooltip"  data-placement="top" title="" data-original-title="Click to view address & payment details" href="index?view_orders&ordid=' . base64_encode($order_id) . '&ordstatus">' . $order_id . '</a></td>
	                        <td><a data-toggle="tooltip"  data-placement="top" title="" data-original-title="Click to view address & payment details" href="index?view_orders&ordid=' . base64_encode($order_id) . '&ordstatus">' . $item_title . '</a></td>
	                        <td>&#8377;&nbsp;' . $amount . '&nbsp;</td>
	                        <td>' . $order_date . '</td>
	                        <td>' . $payment_mode . '</td>
	                        <td><div class="badge badge-danger">' . $order_status . '</div></td>
	                        <td class="text-center">
								<div class="dropdown d-inline-block">

								    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-dark"></button>

								    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start">
								        <a href="index?view_orders&ordid=' . base64_encode($order_id) . '&status=' . base64_encode("confirmed") . '"><button type="button" tabindex="0" class="dropdown-item">Order Confirmed.</button></a>
								        <a href="index?view_orders&ordid=' . base64_encode($order_id) . '&status=' . base64_encode("transit") . '"><button type="button" tabindex="0" class="dropdown-item">On Transit.</button></a>
								        <a href="index?view_orders&ordid=' . base64_encode($order_id) . '&status=' . base64_encode("delivered") . '"><button type="button" tabindex="0" class="dropdown-item">Delivered.</button></a>							        
								    </div>
								</div> 
	                        </td>
	                    </tr>';
					}
				} while (mysqli_stmt_fetch($this->send_query));
			}
			mysqli_stmt_close($this->send_query);
		}
	}

	public function check_status()	//view_orders.php - called in the previous function
	{
		$this->datetime = date("Y-m-d H:i:s");
		if (isset($_GET['status']) && isset($_GET['ordid'])) {
			if (base64_decode($_GET['status']) == "confirmed") {
				$order_status = "ORDER CONFIRMED. FOOD IS BEING PREPARED.";
			} else if (base64_decode($_GET['status']) == "transit") {
				$order_status = "ON TRANSIT. YOUR ORDER IS ON THE WAY.";
			} else if (base64_decode($_GET['status']) == "delivered") {
				$order_status = "ORDER DELIVERED. ENJOY!";
			}

			$order_id = base64_decode($_GET['ordid']);

			$this->sql = "UPDATE `orders_received` SET `order_status` = ?, `order_modified` = ? WHERE `order_id` = ?";
			$this->send_query = $this->con->prepare($this->sql);
			mysqli_stmt_bind_param($this->send_query, "ssi", $order_status, $this->datetime, $order_id);
			if (isset($this->send_query)) {
				if (mysqli_stmt_execute($this->send_query)) {
					mysqli_stmt_close($this->send_query);
					redirect("index?view_orders&new=1");
				} else {
					mysqli_stmt_close($this->send_query);
				}
			}
		} else
			return 0;
	}

	public function view_payment_details()	//index?view_orders&ordid=MzU4MDcyMjU=&ordstatus
	{
		if (isset($_GET['view_orders']) && isset($_GET['ordstatus']) && isset($_GET['ordid'])) {
			$order_id = base64_decode($_GET['ordid']);
			$this->sql = "SELECT o.order_id, o.order_payment_id, o.txnid, o.txnstatus, o.banktxnid, o.bankname, o.checksumhash, GROUP_CONCAT(i.item_title, '&nbsp;(x', op.quantity, ')' SEPARATOR '<br>') as `group_item_id` FROM order_payment o, ordered_products op, items i WHERE o.order_id = op.order_id AND i.item_id = op.item_id AND o.order_id = ? GROUP BY o.order_id ORDER BY o.order_payment_id DESC";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "i", $order_id);
				mysqli_stmt_bind_result($this->send_query, $order_id, $order_payment_id, $txnid, $txnstatus, $banktxnid, $bankname, $checksumhash, $item_title);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
					do {
						echo '
		           		<tr>
	                        <td>' . $txnid . '</td>
	                        <td>' . $txnstatus . '</td>
	                        <td>' . $banktxnid . '</td>
	                        <td>' . $bankname . '</td>
	                        <td>' . $checksumhash . '</td>
	                    </tr>';
					} while (mysqli_stmt_fetch($this->send_query));
				}
				mysqli_stmt_close($this->send_query);
			}
		}
	}

	public function view_items_payment_details()	//index?view_orders&ordid=MzU4MDcyMjU=&ordstatus
	{
		if (isset($_GET['view_orders']) && isset($_GET['ordstatus']) && isset($_GET['ordid'])) {
			$order_id = base64_decode($_GET['ordid']);
			$this->sql = "SELECT op.order_id, GROUP_CONCAT(i.item_title, '&nbsp;(x', op.quantity, ')' SEPARATOR '<br>') as `group_item_id` FROM ordered_products op, items i WHERE i.item_id = op.item_id AND op.order_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "i", $order_id);
				mysqli_stmt_bind_result($this->send_query, $order_id, $item_title);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
					do {
						echo '
						<div class="row mb-4">
						    <div class="col-lg-6">
								<div class="card shadow mb-4">
							        
									<a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
									  <h6 class="m-0 font-weight-bold text-primary">Order #</h6>
									</a>
									
									<div class="collapse show" id="collapseCardExample" style="">
									  <div class="card-body">
									  ' . $order_id . '
									  </div>
									</div>
								</div>
							</div>

						    <div class="col-lg-6">
								<div class="card shadow mb-4">
							        
									<a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
									  <h6 class="m-0 font-weight-bold text-primary">Items</h6>
									</a>
									
									<div class="collapse show" id="collapseCardExample" style="">
									  <div class="card-body">
									  ' . $item_title . '
									  </div>
									</div>
								</div>
							</div>
						</div>
						';
					} while (mysqli_stmt_fetch($this->send_query));
				}
				mysqli_stmt_close($this->send_query);
			}
		}
	}

	public function display_delivery_info()		//index?view_orders&ordid=MzU4MDcyMjU=&ordstatus
	{
		if (isset($_GET['view_orders']) && isset($_GET['ordstatus']) && isset($_GET['ordid'])) {
			$order_id = base64_decode($_GET['ordid']);
			$this->sql = "SELECT c.first_name, c.last_name, c.email, a.address_line_1, a.address_line_2, a.city, a.state, a.pin, a.contact_number, a.alternative_contact_number, c.customer_id, o.transaction_type, o.amount FROM customers c, customer_contact a, orders_received o WHERE o.customer_id = c.customer_id AND a.customer_id = c.customer_id AND o.order_id = ?";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "i", $order_id);
				mysqli_stmt_bind_result($this->send_query, $first_name, $last_name, $email, $address_line_1, $address_line_2, $city, $state, $pin, $contact_number, $alternative_contact_number, $customer_id, $transaction_type, $amount);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
					if ($transaction_type == "CASH") {
						$cash_to_collect = '<h6 class="m-0 font-weight-bold text-primary">Cash to collect: &#8377;&nbsp;' . $amount . '</h6>';
					} else {
						$cash_to_collect = "";
					}
					do {
						echo '
			          	<div class="row">
							<div class="col-lg-6">
								<div class="jumbotron jumbotron-fluid">
								  <div class="container">
								  	<h6 class="m-0 font-weight-bold text-primary">Customer info: </h6>
								    <h1 class="display-8">' . $first_name . " " . $last_name . '</h1>
								    <p class="lead">Email ID: ' . $email . '</p>
								    <p class="lead">Contact Number 1: ' . $contact_number . '</p>
								    <p class="lead">Contact Number 2: ' . $alternative_contact_number . '</p>
								  </div>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="jumbotron jumbotron-fluid">
									<div class="container">
										<h6 class="m-0 font-weight-bold text-primary">Deliver to: </h6>
										<h1 class="display-8">' . $city . ", " . $pin . '</h1>
										<p class="lead">' . $address_line_1 . '</p>
										<p class="lead">' . $address_line_2 . '</p>
										<p class="lead">' . $city . ", " . $state . '</p>
										' . $cash_to_collect . '
									</div>
								</div>
							</div>
						</div>						
						';
					} while (mysqli_stmt_fetch($this->send_query));
				}
				mysqli_stmt_close($this->send_query);
			}
		}
	}

	public function display_customers()			//displays all customers in index?view_logins
	{
		if (isset($_GET['logins']) && isset($_GET['cust'])) {
			$this->sql = "SELECT l.email, c.first_name, c.last_name, l.date_added, l.date_modified, c.login_access, c.customer_id FROM login_info l, customers c WHERE c.email = l.email";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				// mysqli_stmt_bind_param($this->send_query);
				mysqli_stmt_bind_result($this->send_query, $this->email, $first_name, $last_name, $date_added, $date_modified, $login_access, $customer_id);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
					do {
						if ($this->email != "guest@swadesh.com") {
							echo '
			           		<tr>
		                        <td><a>' . $this->email . '</a></td>
		                        <td><a>' . $first_name . " " .  $last_name . '</a></td>
		                        <td>' . $date_added . '</td>
		                        <td>' . $date_modified . '</td>
				                <td data-toggle="tooltip"  data-placement="top" title="" data-original-title="Delete ' . $first_name . '">
				                    <button class="btn btn-danger btn-circle btn-sm delete-btn-circle" data-toggle="modal" data-target="#exampleModal' . $customer_id . '">
				                        <i class="fas fa-trash"></i>
				                    </button>
				                </td>                        
		                    </tr>';

							//delete modal
							echo '
							<div class="modal fade" id="exampleModal' . $customer_id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel' . $customer_id . '" style="display: none;" aria-hidden="true">
							    <div class="modal-dialog" role="document">
							        <div class="modal-content">
							            <div class="modal-header">
							                <h5 class="modal-title" id="exampleModalLabel' . $customer_id . '">Are you sure? This action is irreversible!</h5>
							                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							                    <span aria-hidden="true">×</span>
							                </button>
							            </div>
							            <div class="modal-body">
							                <p class="mb-0">Do you want to permanently delete ' . $first_name . " " . $last_name . '?</p>	
							            </div>
							            <div class="modal-footer">
											<a href="index?logins&cust&del=' . base64_encode($customer_id) . '" class="btn btn-danger btn-icon-split delete-btn btn-padding">
											    <span class="icon text-white-50">
											    <i class="fas fa-trash"></i>
											    </span>
											    <span class="text">Delete</span>
											</a>
											<button class="btn btn-secondary btn-icon-split btn-padding gray-btn" data-dismiss="modal">
											    <span class="icon text-white-50">
											    <i class="fas fa-times"></i>
											    </span>
											    <span class="text">Close</span>
											</button>
							            </div>
							        </div>
							    </div>
							</div>';
						}
					} while (mysqli_stmt_fetch($this->send_query));
				}
				mysqli_stmt_close($this->send_query);
			}
		}
		if (isset($_GET['logins']) && isset($_GET['admin'])) {
			$this->sql = "SELECT l.email, a.first_name, a.last_name, l.date_added, l.date_modified, a.admin_id FROM login_info l, admin a WHERE a.email = l.email";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_result($this->send_query, $this->email, $first_name, $last_name, $date_added, $date_modified, $admin_id);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_store_result($this->send_query)) {
					while (mysqli_stmt_fetch($this->send_query)) {
						if (mysqli_stmt_num_rows($this->send_query) > 1) {
							$delete_button = '
			                <td data-toggle="tooltip"  data-placement="top" title="" data-original-title="Delete ' . $first_name . '">
			                    <button class="btn btn-danger btn-circle btn-sm delete-btn-circle" data-toggle="modal" data-target="#exampleModal' . $admin_id . '">
			                        <i class="fas fa-trash"></i>
			                    </button>
			                </td>
							';
						} else {
							$delete_button = '
			                <td data-toggle="tooltip"  data-placement="top" title="" data-original-title="This admin cannot be removed. There has to be atleast 1 existing admin. ">
			                    <button class="btn btn-danger btn-circle btn-sm delete-btn-circle">
			                        <i class="fas fa-trash"></i>
			                    </button>
			                </td>
							';
						}
						echo '
		           		<tr>
	                        <td><a>' . $this->email . '</a></td>
	                        <td><a>' . $first_name . " " .  $last_name . '</a></td>
	                        <td>' . $date_added . '</td>
	                        <td>' . $date_modified . '</td>
	                        ' . $delete_button . '                        
	                    </tr>';

						//delete modal
						echo '
						<div class="modal fade" id="exampleModal' . $admin_id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel' . $admin_id . '" style="display: none;" aria-hidden="true">
						    <div class="modal-dialog" role="document">
						        <div class="modal-content">
						            <div class="modal-header">
						                <h5 class="modal-title" id="exampleModalLabel' . $admin_id . '">Are you sure? This action is irreversible!</h5>
						                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                    <span aria-hidden="true">×</span>
						                </button>
						            </div>
						            <div class="modal-body">
						                <p class="mb-0">Do you want to permanently delete ' . $first_name . " " . $last_name . '?</p>	
						            </div>
						            <div class="modal-footer">
										<a href="index?logins&admin&del=' . base64_encode($admin_id) . '" class="btn btn-danger btn-icon-split delete-btn btn-padding">
										    <span class="icon text-white-50">
										    <i class="fas fa-trash"></i>
										    </span>
										    <span class="text">Delete</span>
										</a>
										<button class="btn btn-secondary btn-icon-split btn-padding gray-btn" data-dismiss="modal">
										    <span class="icon text-white-50">
										    <i class="fas fa-times"></i>
										    </span>
										    <span class="text">Close</span>
										</button>
						            </div>
						        </div>
						    </div>
						</div>';
					}
				}
				mysqli_stmt_free_result($this->send_query);
				mysqli_stmt_close($this->send_query);
			}
		}
		if (isset($_GET['logins']) && isset($_GET['staff'])) {
			$this->sql = "SELECT l.email, s.first_name, s.last_name, l.date_added, l.date_modified, s.staff_id FROM login_info l, staff s WHERE s.email = l.email";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				// mysqli_stmt_bind_param($this->send_query);
				mysqli_stmt_bind_result($this->send_query, $this->email, $first_name, $last_name, $date_added, $date_modified, $staff_id);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
					do {
						echo '
		           		<tr>
	                        <td><a>' . $this->email . '</a></td>
	                        <td><a>' . $first_name . " " .  $last_name . '</a></td>
	                        <td>' . $date_added . '</td>
	                        <td>' . $date_modified . '</td>
			                <td data-toggle="tooltip"  data-placement="top" title="" data-original-title="Delete ' . $first_name . '">
			                    <button class="btn btn-danger btn-circle btn-sm delete-btn-circle" data-toggle="modal" data-target="#exampleModal' . $staff_id . '">
			                        <i class="fas fa-trash"></i>
			                    </button>
			                </td>                        
	                    </tr>';

						//delete modal
						echo '
						<div class="modal fade" id="exampleModal' . $staff_id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel' . $staff_id . '" style="display: none;" aria-hidden="true">
						    <div class="modal-dialog" role="document">
						        <div class="modal-content">
						            <div class="modal-header">
						                <h5 class="modal-title" id="exampleModalLabel' . $staff_id . '">Are you sure? This action is irreversible!</h5>
						                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                    <span aria-hidden="true">×</span>
						                </button>
						            </div>
						            <div class="modal-body">
						                <p class="mb-0">Do you want to permanently delete ' . $first_name . " " . $last_name . '?</p>	
						            </div>
						            <div class="modal-footer">
										<a href="index?logins&staff&del=' . base64_encode($staff_id) . '" class="btn btn-danger btn-icon-split delete-btn btn-padding">
										    <span class="icon text-white-50">
										    <i class="fas fa-trash"></i>
										    </span>
										    <span class="text">Delete</span>
										</a>
										<button class="btn btn-secondary btn-icon-split btn-padding gray-btn" data-dismiss="modal">
										    <span class="icon text-white-50">
										    <i class="fas fa-times"></i>
										    </span>
										    <span class="text">Close</span>
										</button>
						            </div>
						        </div>
						    </div>
						</div>';
					} while (mysqli_stmt_fetch($this->send_query));
				}
				mysqli_stmt_close($this->send_query);
			}
		}
	}

	public function delete_logins()
	{
		if (isset($_GET['logins']) && isset($_GET['del'])) {
			$customer_id = base64_decode($_GET['del']);
			if (isset($_GET['cust'])) {
				$this->sql = "DELETE customers, login_info FROM customers INNER JOIN login_info ON customers.email = login_info.email WHERE customers.customer_id = ?";
				$this->send_query = $this->con->prepare($this->sql);
				if (isset($this->send_query)) {
					mysqli_stmt_bind_param($this->send_query, "i", $customer_id);
					if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_affected_rows($this->send_query) >= 1) {
						setMessage("1 customer removed.");
						unset($_GET['del']);
					}
				}
			}
			if (isset($_GET['admin'])) {
				$this->sql = "DELETE admin, login_info FROM admin INNER JOIN login_info ON admin.email = login_info.email WHERE admin.admin_id = ?";
				$this->send_query = $this->con->prepare($this->sql);
				if (isset($this->send_query)) {
					mysqli_stmt_bind_param($this->send_query, "i", $customer_id);
					if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_affected_rows($this->send_query) >= 1) {
						setMessage("1 admin removed.");
						unset($_GET['del']);
					}
				}
				mysqli_stmt_close($this->send_query);
			}
			if (isset($_GET['staff'])) {
				$this->sql = "DELETE staff, login_info FROM staff INNER JOIN login_info ON staff.email = login_info.email WHERE staff.staff_id = ?";
				$this->send_query = $this->con->prepare($this->sql);
				if (isset($this->send_query)) {
					mysqli_stmt_bind_param($this->send_query, "i", $customer_id);
					if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_affected_rows($this->send_query) >= 1) {
						setMessage("1 staff removed.");
						unset($_GET['del']);
					}
				}
				mysqli_stmt_close($this->send_query);
			}
		}
	}

	public function add_zipcode()
	{
		if (isset($_POST['add_zipcode'])) {

			$this->get = 1;
			$pincode = $_POST['pincode'];
			$this->sql = "INSERT INTO `pincodes` (`pin_codes`, `available`) VALUES (?, ?)";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "ii", $pincode, $this->get);
				if (mysqli_stmt_execute($this->send_query)) {
					setMessage("Pincode " . $pincode . " has been added. Now customers can select " . $pincode . " as their delivery location!.");
				} else {
					setMessage("Pincode " . $pincode . " couldn't be added. ");
				}
				mysqli_stmt_close($this->send_query);
			}
		}
	}

	public function remove_zip_code()
	{
		if (isset($_GET['zip']) && isset($_GET['modify']) && isset($_GET['del'])) {
			$pincode = base64_decode($_GET['del']);
			$this->sql = "DELETE FROM pincodes WHERE pin_codes = ?";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "i", $pincode);
				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_affected_rows($this->send_query) >= 1) {
					setMessage("1 pincode removed (" . $pincode . "). ");
					unset($_GET['del']);
				}
			}
			mysqli_stmt_close($this->send_query);
		}
	}

	public function display_zip_code()
	{
		$this->sql = "SELECT pin_codes FROM pincodes";
		$this->send_query = $this->con->prepare($this->sql);
		if (isset($this->send_query)) {
			// mysqli_stmt_bind_param($this->send_query);
			mysqli_stmt_bind_result($this->send_query, $pincode);
			if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
				do {
					echo '
	           		<tr>
                        <td>' . $pincode . '</td>
		                <td data-toggle="tooltip"  data-placement="top" title="" data-original-title="Delete ' . $pincode . '">
		                    <button class="btn btn-danger btn-circle btn-sm delete-btn-circle" data-toggle="modal" data-target="#exampleModal' . $pincode . '">
		                        <i class="fas fa-trash"></i>
		                    </button>
		                </td>                        
                    </tr>';

					//delete modal
					echo '
					<div class="modal fade" id="exampleModal' . $pincode . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel' . $pincode . '" style="display: none;" aria-hidden="true">
					    <div class="modal-dialog" role="document">
					        <div class="modal-content">
					            <div class="modal-header">
					                <h5 class="modal-title" id="exampleModalLabel' . $pincode . '">Are you sure? This action is irreversible!</h5>
					                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                    <span aria-hidden="true">×</span>
					                </button>
					            </div>
					            <div class="modal-body">
					                <p class="mb-0">Do you want to permanently delete the Pin Code ' . $pincode . '?</p>	
					            </div>
					            <div class="modal-footer">
									<a href="index?zip&modify&del=' . base64_encode($pincode) . '" class="btn btn-danger btn-icon-split delete-btn btn-padding">
									    <span class="icon text-white-50">
									    <i class="fas fa-trash"></i>
									    </span>
									    <span class="text">Delete</span>
									</a>
									<button class="btn btn-secondary btn-icon-split btn-padding gray-btn" data-dismiss="modal">
									    <span class="icon text-white-50">
									    <i class="fas fa-times"></i>
									    </span>
									    <span class="text">Close</span>
									</button>
					            </div>
					        </div>
					    </div>
					</div>';
				} while (mysqli_stmt_fetch($this->send_query));
			}
			mysqli_stmt_close($this->send_query);
		}
	}

	public function insert_admin()
	{
		if (isset($_POST['add_admin'])) {
			$this->flag = 0;
			$lname = $_POST['lname'];
			$fname = $_POST['fname'];
			$this->email = $_POST['email'];
			$password = $_POST['password'];
			$password = md5($password);
			$this->datetime = date("Y-m-d H:i:s");

			$this->sql = "INSERT INTO `login_info` (`email`, `password`, `date_added`) VALUES (?, ?, ?)";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "sss", $this->email, $password, $this->datetime);
				if (mysqli_stmt_execute($this->send_query)) {
					$this->flag = 1;
				} else {
					$this->flag = 0;
					setMessage("New admin couldn't be added." . $this->con->db_error());
				}
				mysqli_stmt_close($this->send_query);
			}
			if ($this->flag === 1) {
				$this->sql = "INSERT INTO `admin` (`first_name`, `last_name`, `email`) VALUES (?, ?, ?)";
				$this->send_query = $this->con->prepare($this->sql);
				if (isset($this->send_query)) {
					mysqli_stmt_bind_param($this->send_query, "sss", $fname, $lname, $this->email);
					if (mysqli_stmt_execute($this->send_query)) {
						setMessage("New admin (" . $fname . " " . $lname . ") added.");
					} else {
						setMessage("New admin couldn't be added.");
					}
					mysqli_stmt_close($this->send_query);
				}
			}
		}
	}

	public function insert_staff()
	{
		if (isset($_POST['add_staff'])) {
			$this->flag = 0;
			$lname = $_POST['lname'];
			$fname = $_POST['fname'];
			$this->email = $_POST['email'];
			$password = $_POST['password'];
			$password = md5($password);
			$this->datetime = date("Y-m-d H:i:s");

			$this->sql = "INSERT INTO `login_info` (`email`, `password`, `date_added`) VALUES (?, ?, ?)";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "sss", $this->email, $password, $this->datetime);
				if (mysqli_stmt_execute($this->send_query)) {
					$this->flag = 1;
				} else {
					$this->flag = 0;
					setMessage("New staff couldn't be added." . $this->con->db_error());
				}
				mysqli_stmt_close($this->send_query);
			}
			if ($this->flag === 1) {
				$this->sql = "INSERT INTO `staff` (`first_name`, `last_name`, `email`, `login_access`) VALUES (?, ?, ?, ?)";
				$this->send_query = $this->con->prepare($this->sql);
				if (isset($this->send_query)) {
					mysqli_stmt_bind_param($this->send_query, "sssi", $fname, $lname, $this->email, $this->flag);
					if (mysqli_stmt_execute($this->send_query)) {
						setMessage("New staff (" . $fname . " " . $lname . ") added.");
					} else {
						setMessage("New staff couldn't be added.");
					}
					mysqli_stmt_close($this->send_query);
				}
			}
		}
	}
	public function login()
	{
		if (isset($_POST['login_submit'])) {
			if (isset($_SESSION['ADMIN'])) {
				unset($_SESSION['ADMIN']);
			}
			$this->temp = 1;
			$isLogin = 0;
			$this->email = $this->con->escape($_POST['email']);
			$pass = md5($this->con->escape($_POST['pass']));

			$this->sql = "SELECT a.first_name, a.last_name, a.admin_id FROM admin a, login_info l WHERE a.email = l.email AND l.email = ? AND l.password = ?";
			$this->send_query = $this->con->prepare($this->sql);

			mysqli_stmt_bind_param($this->send_query, "ss", $this->email, $pass);
			mysqli_stmt_bind_result($this->send_query, $this->fname, $this->lname, $admin_id);

			if (isset($this->send_query) && mysqli_stmt_execute($this->send_query)) {
				while (mysqli_stmt_fetch($this->send_query)) {
					$isLogin = 1;
				}
				mysqli_stmt_close($this->send_query);
				if (!$isLogin) {
					setMessage("The email and password combination didn't match. Please try again. ");
				} else {
					$_SESSION['ADMIN'] = array('NAME' => $this->fname . " " . $this->lname, 'EMAIL' => $this->email, 'ADMINID' => $admin_id);
					redirect("index");
				}
			}
		}
	}
	public function changePassword()
	{
		if (isset($_GET['changePassword']) && isset($_POST['change_pass'])) {
			$this->get = 0;
			preg_match("/(admin\/index.php)$/", $_SERVER['PHP_SELF']) ? $this->email = $_SESSION['ADMIN']['EMAIL'] : $this->email = $_SESSION['STAFF']['EMAIL'];
			$this->datetime = date("Y-m-d H:i:s");
			$currentPass = md5(trim($_POST['current_pass']));
			$newPass = md5(trim($_POST['new_pass']));
			$newPassRepeat = md5(trim($_POST['new_pass_repeat']));

			$this->sql = "SELECT `password` FROM login_info WHERE email = ?";
			$this->send_query = $this->con->prepare($this->sql);
			if (isset($this->send_query)) {
				mysqli_stmt_bind_param($this->send_query, "s", $this->email);
				mysqli_stmt_bind_result($this->send_query, $password);

				if (mysqli_stmt_execute($this->send_query) && mysqli_stmt_fetch($this->send_query)) {
					if ($currentPass === $password) {
						$this->get = 1;
					} else {
						$this->get = 0;
						setMessage("Entered current password is wrong. Please try again. ");
					}
				} else {
					setMessage("Query failed. ");
				}
				mysqli_stmt_close($this->send_query);
			}
			if ($this->get === 1 && $newPass == $newPassRepeat) {

			} else if ($this->get === 1 && $newPass != $newPassRepeat) {
				setMessage("The entered new passwords don't match. Please try again. ");
			}
		}
	}
}
