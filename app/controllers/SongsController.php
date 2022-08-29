<?php

namespace App\Controllers;

use App\Models\DatabaseModel;
use App\Models\SongModel;
use Exception;

class SongsController extends Controller {

    private SongModel $song;

    public function load(): void {
        $path = $this->getPath();
        if (count($path) == 0) {
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/../app/views/SongsView.php");
            return;
        }
        $artistDirectory = array_shift($path);
        if (count($path) == 0) {
            header("Location: /artists/$artistDirectory/", true, 301);
            return;
        }
        $songDirectory = array_shift($path);
        if (count($path) == 0) {
            $model = new DatabaseModel();
            $this->song = $model->getSong($artistDirectory, $songDirectory);
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/../app/views/SingeSongView.php");
            return;
        }
        throw new Exception("Requested directory does not exist.");
    }
}
