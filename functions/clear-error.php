<?php
session_start();

unset($_SESSION['error']);
unset($_SESSION['just_logged_out']);

http_response_code(204);
exit;
