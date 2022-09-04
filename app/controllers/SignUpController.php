<?php

namespace App\Controllers;

use App\Models\DatabaseModel;
use Exception;
use PDOException;

class SignUpController extends Controller {

    private ?string $errorMessage = null;

    public function load(): void {
        $path = $this->getPath();
        if (count($path) != 0) {
            throw new Exception("Requested directory does not exist.");
        }
        if (count($_POST) == 0) {
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/app/views/SignUpView.php");
            return;
        }
        $this->errorMessage = self::getPostRequestError();
        if (is_null($this->errorMessage)) {
            try {
                $model = new DatabaseModel();
                $model->addUser($_POST["email"], $_POST["username"], $_POST["password"]);
            } catch (PDOException $e) {
                throw new Exception($e->getMessage());
            }
            session_start();
            $_SESSION["username"] = $_POST["username"];
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/app/views/IndexView.php");
        } else {
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/app/views/SignUpView.php");
        }
    }

    private static function getPostRequestError(): ?string {
        if (!isset($_POST["email"], $_POST["username"], $_POST["password"], $_POST["confirm"])) {
            return "Please fill out the entire form!";
        }
        static $emailFormat = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";
        $email = $_POST["email"];
        if (!preg_match($emailFormat, $email)) {
            return "Please enter a valid email!";
        }
        $username = $_POST["username"];
        If (strlen($username) < 3) {
            return "Your username must be at least 3 characters!";
        }
        if (strlen($username) > 30) {
            return "Your username can be at most 30 characters!";
        }
        static $usernameFormat = "/^[a-z\d_-]+$/i";
        if (!preg_match($usernameFormat, $username)) {
            return "Your username can only contain letters, numbers, underscores and dashes!";
        }
        $password = $_POST["password"];
        if (strlen($password) < 10) {
            return "We require your password to be at least 10 characters!";
        }
        static $digits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $containsDigit = false;
        foreach ($digits as $digit) {
            if (str_contains($password, $digit)) {
                $containsDigit = true;
                break;
            }
        }
        if (!$containsDigit) {
            return "We require your password to contain at least one digit!";
        }
        static $specialCharacters = array('#', '$', '%', '&', '!', '?');
        $containsChar = false;
        foreach ($specialCharacters as $char) {
            if (str_contains($password, $char)) {
                $containsChar = true;
                break;
            }
        }
        if (!$containsChar) {
            return "Password must contain at least one of \"" . implode($specialCharacters) . "\"!";
        }
        $confirm = $_POST["confirm"];
        if ($confirm !== $password) {
            return "Passwords don't match!";
        }
        return null;
    }
}
