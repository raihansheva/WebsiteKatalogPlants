<?php
session_start();

unset($_SESSION['show_modal']);
unset($_SESSION['error']);
unset($_SESSION['errorRegis']);

echo json_encode(['status' => 'ok']);
