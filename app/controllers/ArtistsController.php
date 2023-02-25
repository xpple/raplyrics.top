<?php

namespace App\Controllers;

use App\Models\ArtistModel;
use App\Models\DatabaseModel;
use Exception;

class ArtistsController extends Controller {

    private ArtistModel $artist;

    public function load(): void {
        $path = $this->getPath();
        if (count($path) == 0) {
            require realpath($_SERVER['DOCUMENT_ROOT']) . "/app/views/ArtistsView.php";
            return;
        }
        $artistDirectory = array_shift($path);
        if (count($path) == 0) {
            $model = new DatabaseModel();
            $this->artist = $model->getArtist($artistDirectory);
            require realpath($_SERVER['DOCUMENT_ROOT']) . "/app/views/SingleArtistView.php";
            return;
        }
        throw new Exception("Requested directory does not exist.");
    }
}
