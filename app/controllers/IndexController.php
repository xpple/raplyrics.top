<?php

namespace App\Controllers;

use Exception;

class IndexController extends Controller {

    public function load(): void {
        $path = $this->getPath();
        if (count($path) == 0) {
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/../app/views/IndexView.php");
            return;
        }
        $topDir = array_shift($path);
        switch ($topDir) {
            case "artists":
                $controller = new ArtistsController($path);
                $controller->load();
                break;
            case "search":
                $controller = new SearchController($path);
                $controller->load();
                break;
            case "songs":
                $controller = new SongsController($path);
                $controller->load();
                break;
            default:
                throw new Exception("Requested directory does not exist.");
        }
    }
}
