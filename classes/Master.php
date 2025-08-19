<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');
class Master extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}

	function save_package()
	{
		extract($_POST);
		$data = "";

		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description', 'category'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}

		// Handle category as JSON
		$categories = isset($_POST['category']) ? $_POST['category'] : array();
		$category_json = json_encode($categories);
		if (!empty($data)) $data .= ",";
		$data .= " `category`='{$category_json}' ";

		if (empty($id)) {
			$sql = "INSERT INTO `packages` set {$data} ";
			$save = $this->conn->query($sql);
			$id = $this->conn->insert_id;
		} else {
			$sql = "UPDATE `packages` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}

		if ($save) {
			if (isset($_FILES['img']) && count($_FILES['img']['tmp_name']) > 0) {
				if (!is_dir(base_app . 'uploads/package_' . $id)) {
					mkdir(base_app . 'uploads/package_' . $id);
				}
				$upload_path = 'uploads/package_' . $id;
				$this->conn->query("UPDATE `packages` set `upload_path`='{$upload_path}' where id = '{$id}' ");
				foreach ($_FILES['img']['tmp_name'] as $k => $v) {
					move_uploaded_file($_FILES['img']['tmp_name'][$k], base_app . $upload_path . '/' . $_FILES['img']['name'][$k]);
				}
			}

			if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
				$video_path = 'uploads/video_' . $id . '/';
				if (!is_dir(base_app . $video_path)) {
					mkdir(base_app . $video_path, 0777, true);
				}
				$video_directory = 'uploads/video_' . $id;
				$this->conn->query("UPDATE `packages` set `upload_path_video`='{$video_directory}' where id = '{$id}' ");
				$video_filename = time() . '_' . $_FILES['video']['name'];
				$video_full_path = $video_path . $video_filename;
				if (move_uploaded_file($_FILES['video']['tmp_name'], base_app . $video_full_path)) {
					// Video uploaded successfully
				}
			}

			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}




	function delete_p_img()
	{
		extract($_POST);
		if (is_file($path)) {
			if (unlink($path)) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'unlink file failed.';
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'unlink file failed. File do not exist.';
		}
		return json_encode($resp);
	}


	function delete_p_video()
	{

		extract($_POST);


		$fullPath = $path;
		if (strpos($path, base_app) !== 0) {
			$fullPath = base_app . $path;
		}


		error_log("Attempting to delete video at: " . $fullPath);


		if (is_file($fullPath)) {

			if (unlink($fullPath)) {

				$resp['status'] = 'success';
			} else {

				$resp['status'] = 'failed';
				$resp['message'] = 'Could not delete file. Check permissions.';
				$resp['error'] = error_get_last();
			}
		} else {

			$resp['status'] = 'failed';
			$resp['message'] = 'File does not exist at path: ' . $fullPath;
		}

		return json_encode($resp);
	}

	function delete_package()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `packages` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			if (is_dir(base_app . 'uploads/package_' . $id)) {
				$file = scandir(base_app . 'uploads/package_' . $id);
				foreach ($file as $img) {
					if (in_array($img, array('..', '.')))
						continue;
					unlink(base_app . 'uploads/package_' . $id . '/' . $img);
				}
				rmdir(base_app . 'uploads/package_' . $id);
			}
			$this->settings->set_flashdata('success', "Location Details successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function book_tour()
	{
		extract($_POST);
		$data = " user_id = '" . $this->settings->userdata('id') . "' ";
		foreach ($_POST as $k => $v) {
			$data .= ", `{$k}` = '{$v}' ";
		}
		$save = $this->conn->query("INSERT INTO `book_list` set $data");
		if ($save) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_book_status()
	{
		extract($_POST);
		$update = $this->conn->query("UPDATE `book_list` set `status` = '{$status}' where id ='{$id}' ");
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Book successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function register()
	{
		extract($_POST);
		$resp = array();

		if (empty($firstname) || empty($lastname) || empty($username) || empty($password)) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'All fields are required.';
			return json_encode($resp);
		}


		$check = $this->conn->query("SELECT * FROM users WHERE username = '{$username}'")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Username already exists';
			return json_encode($resp);
		}


		$hashed_password = md5($password);


		$sql = "INSERT INTO users (firstname, lastname, username, password) 
            VALUES (?, ?, ?, ?)";
		$stmt = $this->conn->prepare($sql);
		if ($stmt === false) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Database error: ' . $this->conn->error;
			return json_encode($resp);
		}

		$stmt->bind_param("ssss", $firstname, $lastname, $username, $hashed_password);

		if ($stmt->execute()) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Something went wrong during registration';
		}

		$stmt->close();

		return json_encode($resp);
	}






	function update_account()
	{
		extract($_POST);
		$resp = [];

		$check = $this->conn->query("SELECT * FROM `users` WHERE `username` = '{$username}' AND `id` != {$id}")->num_rows;
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Username already taken.";
			return json_encode($resp);
		}


		if (!empty($password)) {

			$stmt = $this->conn->prepare("SELECT `password` FROM `users` WHERE `id` = ?");
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$stored_password = $result->fetch_assoc()['password'];
			$stmt->close();


			if (md5($cpassword) !== $stored_password) {
				$resp['status'] = 'failed';
				$resp['msg'] = "Current Password is Incorrect";
				return json_encode($resp);
			}

			$_POST['password'] = md5($password);
		}


		if (isset($_POST['preference']) && is_array($_POST['preference'])) {
			$_POST['preference'] = implode(',', $_POST['preference']);
		} else {
			$_POST['preference'] = '';
		}


		$data = "";
		foreach ($_POST as $k => $v) {
			if ($k == 'cpassword' || ($k == 'password' && empty($v))) {
				continue;
			}
			if (!empty($data)) {
				$data .= ", ";
			}
			$v = $this->conn->real_escape_string($v);
			$data .= " `{$k}`='{$v}' ";
		}


		$save = $this->conn->query("UPDATE `users` SET $data WHERE id = {$id}");
		if ($save) {

			foreach ($_POST as $k => $v) {
				if ($k != 'cpassword') {
					$this->settings->set_userdata($k, $v);
				}
			}
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}

		return json_encode($resp);
	}



	function save_inquiry()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!empty($data)) $data .= ",";
			$data .= " `{$k}`='{$v}' ";
		}
		$save = $this->conn->query("INSERT INTO `inquiry` set $data");
		if ($save) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function rate_review()
	{
		extract($_POST);
		$review = addslashes(htmlentities($review));
		$user_id = $_SESSION['userdata']['id'] ?? 0;
		$date_created = date('Y-m-d H:i:s');
		if ($user_id == 0) {
			return json_encode(['status' => 'failed', 'error' => 'User not logged in.']);
		}
		$check = $this->conn->query("SELECT id FROM `rate_review` WHERE package_id = '$package_id' AND user_id = '$user_id'");
		if ($check->num_rows > 0) {
			$save = $this->conn->query("UPDATE `rate_review` SET rate='$rate', review='$review', date_created='$date_created' 
								  WHERE package_id='$package_id' AND user_id='$user_id'");
		} else {
			$save = $this->conn->query("INSERT INTO `rate_review` (`package_id`, `user_id`, `rate`, `review`, `date_created`) 
								  VALUES ('$package_id', '$user_id', '$rate', '$review', '$date_created')");
		}
		if ($save) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}

		return json_encode($resp);
	}
	function delete_inquiry()
	{
		$del = $this->conn->query("DELETE FROM `inquiry` where id='{$_POST['id']}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", "Inquiry Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_review()
	{
		$del = $this->conn->query("DELETE FROM `rate_review` where id='{$_POST['id']}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", "Feedback Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_booking()
	{
		$del = $this->conn->query("DELETE FROM `book_list` where id='{$_POST['id']}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", "Booking Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function save_policy()
	{
		extract($_POST);
		$policy = addslashes(htmlentities($policy));
		$check = $this->conn->query("SELECT id FROM `system_info` WHERE meta_field = 'policy'");
		if ($check->num_rows > 0) {
			$save = $this->conn->query("UPDATE `system_info` SET meta_value = '$policy' WHERE meta_field = 'policy'");
		} else {
			$save = $this->conn->query("INSERT INTO `system_info` (meta_field, meta_value) VALUES ('policy', '$policy')");
		}
		if ($save) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function delete_highlight()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `highlights` WHERE id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', 'Highlight successfully deleted.');
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function get_highlights($package_id)
	{
		$sql = "SELECT h.id, h.highlight, u.name, h.date_created 
				FROM `highlights` h 
				LEFT JOIN `users` u ON h.user_id = u.id
				WHERE h.package_id = '{$package_id}' ORDER BY h.date_created DESC";
		$result = $this->conn->query($sql);

		$highlights = [];
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$highlights[] = $row;
			}
		}

		return $highlights;
	}
	function save_comment()
	{
		extract($_POST);

		$resp = [];


		if (!isset($_SESSION['userdata']['id']) || !$_SESSION['userdata']['id']) {
			echo json_encode(['status' => 'failed', 'error' => 'User not logged in.']);
			exit;
		}

		$user_id = $_SESSION['userdata']['id'];
		$comment = addslashes(htmlentities($comment ?? ''));
		$package_id = $package_id ?? 0;
		$parent_id = isset($parent_id) ? $parent_id : NULL;

		$sql = "INSERT INTO `comments` (`package_id`, `user_id`, `comment`, `parent_id`) 
            VALUES ('$package_id', '$user_id', '$comment', " . ($parent_id ? "'$parent_id'" : "NULL") . ")";

		$save = $this->conn->query($sql);

		if ($save) {
			$resp['status'] = 'success';
			$resp['comment_id'] = $this->conn->insert_id;
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}

		echo json_encode($resp);
		exit;
	}



	function delete_comment()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `comments` where id='{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success", "Comment Deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function get_comments($package_id)
	{
		$sql = "SELECT c.*, CONCAT(u.firstname, ' ', u.lastname) as name 
            FROM `comments` c 
            INNER JOIN `users` u ON c.user_id = u.id
            WHERE c.package_id = '{$package_id}' 
            ORDER BY c.date_created ASC";

		$result = $this->conn->query($sql);
		$comments = [];

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$comments[] = $row;
			}
		}

		return $comments;
	}
	function save_emergency_contact()
	{
		extract($_POST);
		$resp = [];


		$fields = ['name', 'phone_number', 'address', 'description', 'lat', 'lng', 'status'];
		$data = [];
		foreach ($fields as $field) {
			$data[$field] = isset($_POST[$field]) ? $_POST[$field] : '';
		}

		foreach ($data as $key => $value) {
			$data[$key] = $this->conn->real_escape_string($value);
		}


		if (empty($id)) {

			$sql = "INSERT INTO `emergency_contacts` (`name`, `phone_number`, `address`, `description`, `lat`, `lng`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$stmt = $this->conn->prepare($sql);
			if ($stmt === false) {
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occurred: " . $this->conn->error;
				echo json_encode($resp);
				exit;
			}
			$stmt->bind_param("sssssss", $data['name'], $data['phone_number'], $data['address'], $data['description'], $data['lat'], $data['lng'], $data['status']);
		} else {

			$sql = "UPDATE `emergency_contacts` SET `name`=?, `phone_number`=?, `address`=?, `description`=?, `lat`=?, `lng`=?, `status`=? WHERE `id`=?";
			$stmt = $this->conn->prepare($sql);
			if ($stmt === false) {
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occurred: " . $this->conn->error;
				echo json_encode($resp);
				exit;
			}
			$stmt->bind_param("sssssssi", $data['name'], $data['phone_number'], $data['address'], $data['description'], $data['lat'], $data['lng'], $data['status'], $id);
		}

		$save = $stmt->execute();

		if ($save) {
			$resp['status'] = 'success';
			if (empty($id)) {
				$resp['msg'] = "Emergency contact successfully added.";
				$this->settings->set_flashdata('success', "Emergency contact successfully added.");
			} else {
				$resp['msg'] = "Emergency contact successfully updated.";
				$this->settings->set_flashdata('success', "Emergency contact successfully updated.");
			}
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occurred: " . $stmt->error;
		}

		$stmt->close();
		echo json_encode($resp);
		exit;
	}

	function delete_emergency_contact()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `emergency_contacts` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Emergency contact successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function get_emergency_contacts()
	{
		$query = $this->conn->query("SELECT * FROM `emergency_contacts` WHERE status = 1 ORDER BY name ASC");
		$contacts = array();

		while ($row = $query->fetch_assoc()) {
			$contacts[] = $row;
		}

		return $contacts;
	}
	// Category management functions
	function save_category()
	{
		global $conn;
		extract($_POST);

		$data = " name = '$name' ";
		$data .= ", description = '$description' ";

		if (empty($id)) {
			$sql = "INSERT INTO categories SET $data";
		} else {
			$sql = "UPDATE categories SET $data WHERE id = $id";
		}

		$save = $conn->query($sql);

		if ($save) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $conn->error;
		}

		return json_encode($resp);
	}
    	function save_preferences()
    {
        extract($_POST);
        $resp = array();
        $user_id = $this->settings->userdata('id');
        if (!$user_id) {
            $resp['status'] = 'failed';
            $resp['msg'] = 'User not logged in.';
            return json_encode($resp);
        }
        $preferences = isset($preferences) ? json_encode($preferences) : '[]';
        $sql = "UPDATE users SET preference = ?, preferences_set = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            $resp['status'] = 'failed';
            $resp['msg'] = 'Database error: ' . $this->conn->error;
            return json_encode($resp);
        }
        $stmt->bind_param("si", $preferences, $user_id);
        if ($stmt->execute()) {
            $resp['status'] = 'success';
            $resp['redirect'] = 'index.php';
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = 'Failed to save preferences';
        }
        $stmt->close();
        return json_encode($resp);
    }

	function get_category()
	{
		global $conn;
		extract($_POST);

		$sql = "SELECT * FROM categories WHERE id = $id";
		$qry = $conn->query($sql);

		$resp['status'] = 'success';
		$resp['data'] = $qry->fetch_assoc();

		return json_encode($resp);
	}

	function delete_category()
	{
		global $conn;
		extract($_POST);

		$delete = $conn->query("DELETE FROM categories WHERE id = $id");

		if ($delete) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $conn->error;
		}

		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_package':
		echo $Master->save_package();
		break;
	case 'delete_p_video':
		echo $Master->delete_p_video();
		break;
	case 'delete_package':
		echo $Master->delete_package();
		break;
	case 'delete_p_img':
		echo $Master->delete_p_img();
		break;
	case 'book_tour':
		echo $Master->book_tour();
		break;
	case 'update_book_status':
		echo $Master->update_book_status();
		break;
	case 'save_preferences':
        echo $Master->save_preferences();
        break;
	case 'save_emergency_contact':
		echo $Master->save_emergency_contact();
		break;
	case 'delete_emergency_contact':
		echo $Master->delete_emergency_contact();
		break;
	case 'register':
		echo $Master->register();
		break;
	case 'update_account':
		echo $Master->update_account();
		break;
	case 'save_inquiry':
		echo $Master->save_inquiry();
		break;
	case 'rate_review':
		echo $Master->rate_review();
		break;

	case 'delete_inquiry':
		echo $Master->delete_inquiry();
		break;
	case 'delete_booking':
		echo $Master->delete_booking();
		break;
	case 'delete_highlight':
		echo $Master->delete_highlight();
		break;
	case 'save_policy':
		echo $Master->save_policy();
		break;
	case 'save_comment':
		echo $Master->save_comment();
		break;
	case 'delete_comment':
		echo $Master->delete_comment();
		break;
	case 'delete_review':
		echo $Master->delete_review();
		break;
	case 'save_category':
		echo $Master->save_category();
		break;
	case 'get_category':
		echo $Master->get_category();
		break;
	case 'delete_category':
		echo $Master->delete_category();
		break;
	default:
		// echo $sysset->index();
		break;
}
