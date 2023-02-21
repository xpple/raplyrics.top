<?php

namespace App\Controllers;

use App\Models\DatabaseModel;
use App\Models\SongModel;
use Exception;

class SongsController extends Controller {

    private SongModel $song;
    private array $annotations;

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
            $this->annotations = $model->getAnnotations($this->song->getSongId());
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/../app/views/SingleSongView.php");
            return;
        }
        throw new Exception("Requested directory does not exist.");
    }
}
