<?php

namespace App\Models;

readonly class SongModel {

    public string $songId;
    public string $songTitle;
    public string $artistId;
    public string $artistName;
    public string $artistDirectory;
    public string $songCoverImage;
    public string $songDescription;
    public string $songLyrics;
    public string $songDirectory;

    public function __construct(string $songId, string $songTitle, string $artistId, string $artistName, string $artistDirectory, string $songCoverImage, string $songDescription, string $songLyrics, string $songDirectory) {
        $this->songId = $songId;
        $this->songTitle = $songTitle;
        $this->artistId = $artistId;
        $this->artistName = $artistName;
        $this->artistDirectory = $artistDirectory;
        $this->songCoverImage = $songCoverImage;
        $this->songDescription = $songDescription;
        $this->songLyrics = $songLyrics;
        $this->songDirectory = $songDirectory;
    }
}
