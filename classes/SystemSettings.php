<?php
if (!class_exists('DBConnection')) {
	require_once('../config.php');
	require_once('DBConnection.php');
}
class SystemSettings extends DBConnection
{
	public function __construct()
	{
		parent::__construct();
	}
	function check_connection()
	{
		return ($this->conn);
	}
	function load_system_info()
	{
		// if(!isset($_SESSION['system_info'])){
		$sql = "SELECT * FROM system_info";
		$qry = $this->conn->query($sql);
		while ($row = $qry->fetch_assoc()) {
			$_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
		}
		// }
	}
	function update_system_info()
	{
		$sql = "SELECT * FROM system_info";
		$qry = $this->conn->query($sql);
		while ($row = $qry->fetch_assoc()) {
			if (isset($_SESSION['system_info'][$row['meta_field']])) unset($_SESSION['system_info'][$row['meta_field']]);
			$_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
		}
		return true;
	}
	function update_settings_info()
	{
		$data = "";
		foreach ($_POST as $key => $value) {
			if (!in_array($key, array("about_us", "privacy_policy")))
				if (isset($_SESSION['system_info'][$key])) {
					$value = str_replace("'", "&apos;", $value);
					$qry = $this->conn->query("UPDATE system_info set meta_value = '{$value}' where meta_field = '{$key}' ");
				} else {
					$qry = $this->conn->query("INSERT into system_info set meta_value = '{$value}', meta_field = '{$key}' ");
				}
		}
		if (isset($_POST['about_us'])) {
			file_put_contents('../about.html', $_POST['about_us']);
		}
		if (isset($_POST['privacy_policy'])) {
			file_put_contents('../privacy_policy.html', $_POST['privacy_policy']);
		}
		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = 'uploads/' . strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../' . $fname);
			if (isset($_SESSION['system_info']['logo'])) {
				$qry = $this->conn->query("UPDATE system_info set meta_value = '{$fname}' where meta_field = 'logo' ");
				if (is_file('../' . $_SESSION['system_info']['logo'])) unlink('../' . $_SESSION['system_info']['logo']);
			} else {
				$qry = $this->conn->query("INSERT into system_info set meta_value = '{$fname}',meta_field = 'logo' ");
			}
		}

		// Handle multiple cover images for carousel
		if (isset($_FILES['cover']) && count($_FILES['cover']['tmp_name']) > 0) {
			// Create directory for cover images if it doesn't exist
			$cover_path = 'uploads/cover_images';
			if (!is_dir('../' . $cover_path)) {
				mkdir('../' . $cover_path, 0777, true);
			}

			// Store the path of uploaded images
			$cover_images = array();

			// Process each uploaded cover image
			foreach ($_FILES['cover']['tmp_name'] as $k => $v) {
				if ($_FILES['cover']['tmp_name'][$k] != '') {
					$fname = $cover_path . '/' . time() . '_' . $_FILES['cover']['name'][$k];
					if (move_uploaded_file($_FILES['cover']['tmp_name'][$k], '../' . $fname)) {
						$cover_images[] = $fname;
					}
				}
			}

			// Convert array to JSON for storage
			if (!empty($cover_images)) {
				$cover_json = json_encode($cover_images);

				if (isset($_SESSION['system_info']['cover'])) {
					// Delete old cover images if they exist
					$old_covers = json_decode($_SESSION['system_info']['cover'], true);
					if (is_array($old_covers)) {
						foreach ($old_covers as $old_cover) {
							if (is_file('../' . $old_cover)) {
								unlink('../' . $old_cover);
							}
						}
					} else if (is_file('../' . $_SESSION['system_info']['cover'])) {
						// Handle case where cover was previously a single image
						unlink('../' . $_SESSION['system_info']['cover']);
					}

					// Update the database
					$qry = $this->conn->query("UPDATE system_info set meta_value = '{$cover_json}' where meta_field = 'cover' ");
				} else {
					// Insert if no cover exists yet
					$qry = $this->conn->query("INSERT into system_info set meta_value = '{$cover_json}', meta_field = 'cover' ");
				}
			}
		}

		$update = $this->update_system_info();
		$flash = $this->set_flashdata('success', 'System Info Successfully Updated.');
		if ($update && $flash) {
			return true;
		}
	}
	function set_userdata($field = '', $value = '')
	{
		if (!empty($field) && !empty($value)) {
			$_SESSION['userdata'][$field] = $value;
		}
	}
	function userdata($field = '')
	{
		if (!empty($field)) {
			if (isset($_SESSION['userdata'][$field]))
				return $_SESSION['userdata'][$field];
			else
				return null;
		} else {
			return false;
		}
	}
	function set_flashdata($flash = '', $value = '')
	{
		if (!empty($flash) && !empty($value)) {
			$_SESSION['flashdata'][$flash] = $value;
			return true;
		}
	}
	function chk_flashdata($flash = '')
	{
		if (isset($_SESSION['flashdata'][$flash])) {
			return true;
		} else {
			return false;
		}
	}
	function flashdata($flash = '')
	{
		if (!empty($flash)) {
			$_tmp = $_SESSION['flashdata'][$flash];
			unset($_SESSION['flashdata']);
			return $_tmp;
		} else {
			return false;
		}
	}
	function sess_des()
	{
		if (isset($_SESSION['userdata'])) {
			unset($_SESSION['userdata']);
			return true;
		}
		return true;
	}
	function info($field = '')
	{
		if (!empty($field)) {
			if (isset($_SESSION['system_info'][$field]))
				return $_SESSION['system_info'][$field];
			else
				return false;
		} else {
			return false;
		}
	}
	function set_info($field = '', $value = '')
	{
		if (!empty($field) && !empty($value)) {
			$_SESSION['system_info'][$field] = $value;
		}
	}
}
$_settings = new SystemSettings();
$_settings->load_system_info();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'update_settings':
		echo $sysset->update_settings_info();
		break;
	default:
		break;
}
