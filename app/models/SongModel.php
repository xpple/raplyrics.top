<?php

namespace App\Models;

class SongModel {

    private readonly string $songId;
    private readonly string $songTitle;
    private readonly string $artistId;
    private readonly string $artistName;
    private readonly string $artistDirectory;
    private readonly string $songCoverImage;
    private readonly string $songDescription;
    private readonly string $songLyrics;
    private readonly string $songDirectory;

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

    public function getSongId(): string {
        return $this->songId;
    }

    public function getSongTitle(): string {
        return $this->songTitle;
    }

    public function getArtistId(): string {
        return $this->artistId;
    }

    public function getArtistName(): string {
        return $this->artistName;
    }

    public function getArtistDirectory(): string {
        return $this->artistDirectory;
    }

    public function getSongCoverImage(): string {
        return $this->songCoverImage;
    }

    public function getSongDescription(): string {
        return $this->songDescription;
    }

    public function getSongLyrics(): string {
        return $this->songLyrics;
    }

    public function getSongDirectory(): string {
        return $this->songDirectory;
    }
}
