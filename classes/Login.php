<?php
require_once '../config.php';

class Login extends DBConnection {
    private $settings;

    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        ini_set('error_log', 'C:/xampp/htdocs/tourism/logs/error.log'); // Adjusted for XAMPP
        error_reporting(E_ALL);
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function index() {
        echo "<h1>Access Denied</h1> <a href='" . base_url . "'>Go Back.</a>";
    }

    public function login() {
        extract($_POST);
        $qry = "SELECT * FROM users WHERE username = ? AND password = md5(?) AND type = 1";
        $stmt = $this->conn->prepare($qry);
        if (!$stmt) {
            return json_encode(array('status' => 'failed', 'message' => 'Query preparation failed: ' . $this->conn->error));
        }
        $stmt->bind_param("ss", $username, $password);
        if (!$stmt->execute()) {
            return json_encode(array('status' => 'failed', 'message' => 'Query execution failed: ' . $stmt->error));
        }
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            foreach ($result->fetch_array() as $k => $v) {
                if (!is_numeric($k) && $k != 'password') {
                    $this->settings->set_userdata($k, $v);
                }
            }
            $this->settings->set_userdata('login_type', 1);
            return json_encode(array('status' => 'success', 'redirect' => '../admin/index.php'));
        } else {
            return json_encode(array('status' => 'incorrect', 'message' => 'Invalid admin credentials.'));
        }
    }

    public function login_user() {
        extract($_POST);
        $qry = "SELECT *, preferences_set FROM users WHERE username = ? AND password = md5(?) AND type = 0";
        $stmt = $this->conn->prepare($qry);
        if (!$stmt) {
            return json_encode(array('status' => 'failed', 'message' => 'Query preparation failed: ' . $this->conn->error));
        }
        $stmt->bind_param("ss", $username, $password);
        if (!$stmt->execute()) {
            return json_encode(array('status' => 'failed', 'message' => 'Query execution failed: ' . $stmt->error));
        }
        $result = $stmt->get_result();
        $resp = array();

        if ($result->num_rows > 0) {
            $user = $result->fetch_array();
            $resp['status'] = 'success';
            $resp['redirect'] = '/index.php';
            $resp['preferences_set'] = $user['preferences_set'] == 1 ? true : false;

            foreach ($user as $k => $v) {
                if (!is_numeric($k) && $k != 'password') {
                    $this->settings->set_userdata($k, $v);
                }
            }
            $this->settings->set_userdata('login_type', 0);
        } else {
            $resp['status'] = 'incorrect';
            $resp['message'] = 'Invalid user credentials.';
        }

        if ($this->conn->error) {
            $resp['status'] = 'failed';
            $resp['_error'] = $this->conn->error;
        }

        return json_encode($resp);
    }

    public function logout() {
        if ($this->settings->sess_des()) {
            return json_encode(array('status' => 'success', 'redirect' => '../admin/login.php'));
        } else {
            return json_encode(array('status' => 'failed', 'message' => 'Failed to destroy session.'));
        }
    }
}

$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();

switch ($action) {
    case 'login':
        echo $auth->login();
        break;
    case 'login_user':
        echo $auth->login_user();
        break;
    case 'logout':
        echo $auth->logout();
        break;
    default:
        echo $auth->index();
        break;
}
?>