<?php

namespace App\Controllers;

use Exception;

class IndexController extends Controller {

    public function load(): void {
        $path = $this->getPath();
        if (count($path) == 0) {
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/app/views/IndexView.php");
            return;
        }
        $topDir = array_shift($path);
        switch ($topDir) {
            case "artists":
                (new ArtistsController($path))->load();
                break;
            case "search":
                (new SearchController($path))->load();
                break;
            case "songs":
                (new SongsController($path))->load();
                break;
            case "sign-up":
                (new SignUpController($path))->load();
                break;
            case "sign-in":
                (new SignInController($path))->load();
                break;
            default:
                throw new Exception("Requested directory does not exist.");
        }
    }
}
