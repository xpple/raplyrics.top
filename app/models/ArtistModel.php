<?php

namespace App\Models;

readonly class ArtistModel {

    public string $artistId;
    public string $artistName;
    public string $artistIcon;
    public string $artistDirectory;

    public function __construct(string $artistId, string $artistName, string $artistIcon, string $artistDirectory) {
        $this->artistId = $artistId;
        $this->artistName = $artistName;
        $this->artistIcon = $artistIcon;
        $this->artistDirectory = $artistDirectory;
    }
}
