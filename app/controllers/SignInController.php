<?php

namespace App\Controllers;

use Exception;

class SignInController extends Controller {

    public function load(): void {
        $path = $this->getPath();
        if (count($path) != 0) {
            throw new Exception("Requested directory does not exist.");
        }
        if (session_status() == PHP_SESSION_ACTIVE) {
            require realpath($_SERVER['DOCUMENT_ROOT']) . "/app/views/IndexView.php";
        }
    }
}
