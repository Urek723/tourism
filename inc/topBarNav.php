<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tupi Tourism Information System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #mainNav {
            background-color: #333;
        }
        .navbar-brand .text-warning {
            color: #ffc107 !important;
        }
        .nav-link {
            color: #fff !important;
        }
        .nav-link:hover {
            color: #ffc107 !important;
        }
        .modal-content {
            border-radius: 10px;
            overflow: hidden;
        }
        .modal-header {
            border-bottom: none;
            padding: 1.5rem;
            background: #333;
            color: white;
        }
        .auth-container {
            padding: 2rem;
        }
        .auth-input {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 1rem;
            transition: border-color 0.3s ease;
        }
        .auth-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        .auth-btn {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .auth-btn:hover {
            background-color: #0056b3;
        }
        .auth-link {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .auth-link:hover {
            text-decoration: underline;
        }
        .form-section {
            display: none;
        }
        .form-section.active {
            display: block;
        }
        #chatbot-widget {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 9999;
}
#chatbot-toggle {
    background: #1877f2;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
    font-size: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
#chatbot-window {
    display: none;
    position: absolute;
    bottom: 70px;
    right: 0;
    width: 320px;
    max-height: 400px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.25);
    overflow: hidden;
    flex-direction: column;
}
#chatbot-header {
    background: #1877f2;
    color: #fff;
    padding: 12px 16px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
#chatbot-close {
    background: none;
    border: none;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
}
#chatbot-messages {
    padding: 16px;
    height: 220px;
    overflow-y: auto;
    font-size: 15px;
    background: #f8f9fa;
}
#chatbot-input-area {
    display: flex;
    border-top: 1px solid #eee;
    background: #fff;
}
#chatbot-input {
    flex: 1;
    border: none;
    padding: 10px;
    font-size: 15px;
    outline: none;
    background: #fff;
}
#chatbot-send {
    background: #1877f2;
    color: #fff;
    border: none;
    padding: 0 18px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 0 0 16px 0;
}
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-shrink" id="mainNav">
        <div class="container-fluid">
            <a class="navbar-brand" href="./"><span class="text-warning">Tupi Tourism Information System</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?php echo $page != 'home' ? './' : '' ?>">Home</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="./?page=packages" id="featured-link">Featured</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $page != 'home' ? './' : '' ?>#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $page != 'home' ? './' : '' ?>#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="./?page=policy">Policy</a></li>
                    <li class="nav-item"><a class="nav-link" href="./?page=contacts">Helpline</a></li>
                    <?php if (isset($_SESSION['userdata'])) : ?>
                        <li class="nav-item"><a class="nav-link" href="./?page=edit_account"><i class="fa fa-user"></i> Hi, <?php echo $_settings->userdata('firstname'); ?>!</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fa fa-sign-out-alt"></i></a></li>
                    <?php else : ?>
                        <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#authModal" id="login_btn">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login/Register Modal -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authModalLabel">Welcome to Tupi Tourism</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body auth-container">
                    <div class="form-section login-section active" id="loginSection">
                        <form id="login-form">
                            <div class="mb-3">
                                <input type="text" class="form-control auth-input" name="username" placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control auth-input" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn auth-btn">Log In</button>
                            <div class="text-center mt-3">
                                <a href="#" class="auth-link" onclick="shiftToRegister()">Create New Account</a>
                            </div>
                        </form>
                    </div>
                    <div class="form-section register-section" id="registerSection">
                        <form id="registration">
                            <div class="mb-3">
                                <input type="text" class="form-control auth-input" name="firstname" placeholder="First Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control auth-input" name="lastname" placeholder="Last Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control auth-input" name="username" placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control auth-input" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn auth-btn">Sign Up</button>
                            <div class="text-center mt-3">
                                <a href="#" class="auth-link" onclick="shiftToLogin()">Back to Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- chatbot -->
     <div id="chatbot-widget">
    <button id="chatbot-toggle" title="Chat with us">
        <i class="fa fa-comments"></i>
    </button>
    <div id="chatbot-window">
        <div id="chatbot-header">
            Chatbot
            <button id="chatbot-close">&times;</button>
        </div>
        <div id="chatbot-messages">
            <div><b>Bot:</b> Hi! How can I help you today?</div>
        </div>
        <div id="chatbot-input-area">
            <input type="text" id="chatbot-input" placeholder="Type your message..." autocomplete="off" />
            <button id="chatbot-send"><i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function shiftToRegister() {
            document.getElementById('loginSection').classList.remove('active');
            document.getElementById('registerSection').classList.add('active');
            document.getElementById('authModalLabel').textContent = 'Create New Account';
        }

        function shiftToLogin() {
            document.getElementById('registerSection').classList.remove('active');
            document.getElementById('loginSection').classList.add('active');
            document.getElementById('authModalLabel').textContent = 'Welcome to Tupi Tourism';
        }
        document.getElementById('chatbot-toggle').onclick = function() {
    document.getElementById('chatbot-window').style.display = 'flex';
    this.style.display = 'none';
};
document.getElementById('chatbot-close').onclick = function() {
    document.getElementById('chatbot-window').style.display = 'none';
    document.getElementById('chatbot-toggle').style.display = 'flex';
};
document.getElementById('chatbot-send').onclick = sendChatbotMessage;
document.getElementById('chatbot-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') sendChatbotMessage();
});
function sendChatbotMessage() {
    var input = document.getElementById('chatbot-input');
    var msg = input.value.trim();
    if (!msg) return;
    var messages = document.getElementById('chatbot-messages');
    messages.innerHTML += '<div><b>You:</b> ' + msg + '</div>';
    input.value = '';
    messages.scrollTop = messages.scrollHeight;
    // Dummy bot reply
    setTimeout(function() {
        messages.innerHTML += '<div><b>Bot:</b> Sorry, I am just a demo!</div>';
        messages.scrollTop = messages.scrollHeight;
    }, 700);
}

        $(function() {
            var isLoggedIn = <?php echo isset($_SESSION['userdata']) ? 'true' : 'false'; ?>;

            $('#featured-link').click(function(e) {
                if (!isLoggedIn) {
                    e.preventDefault();
                    $('#authModal').modal('show');
                }
            });

            $('#login_btn').click(function(e) {
                e.preventDefault();
                $('#authModal').modal('show');
            });

            $('#registration').submit(function(e) {
                e.preventDefault();
                start_loader();
                $('.err-msg').remove();
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=register",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    error: err => {
                        console.log(err);
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    },
                    success: function(resp) {
                        if (typeof resp === 'object' && resp.status === 'success') {
                            alert_toast("Account successfully registered", 'success');
                            $('#registration')[0].reset();
                            setTimeout(shiftToLogin, 2000);
                            end_loader();
                        } else if (resp.status === 'failed' && resp.msg) {
                            $('<div>').addClass("alert alert-danger err-msg").text(resp.msg).prependTo('#registration');
                            end_loader();
                        } else {
                            console.log(resp);
                            alert_toast("An error occurred", 'error');
                            end_loader();
                        }
                    }
                });
            });

            $('#login-form').submit(function(e) {
                e.preventDefault();
                start_loader();
                $('.err-msg').remove();
                $.ajax({
                    url: _base_url_ + "classes/Login.php?f=login_user",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    error: err => {
                        console.log(err);
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    },
                    success: function(resp) {
                        end_loader();
                        if (typeof resp === 'object' && resp.status === 'success') {
                            if (resp.preferences_set) {
                                window.location.href = _base_url_ + resp.redirect;
                            } else {
                                Swal.fire({
                                    title: 'Login Successful!',
                                    text: "Set your preferences to get better recommendations.",
                                    icon: 'success',
                                    showCancelButton: true,
                                    confirmButtonText: 'Set Preferences',
                                    cancelButtonText: 'Skip for Now',
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = _base_url_ + "/?page=edit_account";
                                    } else {
                                        window.location.href = _base_url_ + "index.php";
                                    }
                                });
                            }
                        } else if (resp.status === 'incorrect') {
                            $('<div>').addClass("alert alert-danger err-msg").text("Incorrect Credentials.").prependTo('#login-form');
                            end_loader();
                        } else {
                            console.log(resp);
                            alert_toast("An error occurred", 'error');
                            end_loader();
                        }
                    }
                });
            });

            // Navbar shrink on scroll
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('#mainNav').addClass('navbar-shrink');
                } else {
                    $('#mainNav').removeClass('navbar-shrink');
                }
            });

            // Prevent navbar interference with modal
            $('#authModal').on('show.bs.modal', function() {
                $('body').css('overflow', 'hidden');
                $('#mainNav').css('z-index', '1000');
            }).on('hidden.bs.modal', function() {
                $('body').css('overflow', 'auto');
                $('#mainNav').css('z-index', '');
            });

            // Navbar shrinking effect on collapse/expand
            $('#navbarResponsive').on('show.bs.collapse', function() {
                $('#mainNav').addClass('navbar-shrink');
            });
            $('#navbarResponsive').on('hidden.bs.collapse', function() {
                if ($('body').offset().top === 0) {
                    $('#mainNav').removeClass('navbar-shrink');
                }
            });
        });
    </script>
</body>
</html>