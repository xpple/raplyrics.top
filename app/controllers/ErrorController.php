<?php

namespace App\Controllers;

use Exception;

class ErrorController extends Controller {

    private Exception $cause;

    public function load(): void {
        require dirname($_SERVER['DOCUMENT_ROOT']) . "/app/views/ErrorView.php";
    }

    public function setCause(Exception $cause) {
        $this->cause = $cause;
    }
}
