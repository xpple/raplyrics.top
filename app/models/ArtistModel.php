<?php

namespace App\Models;

class ArtistModel {

    private readonly string $artistId;
    private readonly string $artistName;
    private readonly string $artistIcon;
    private readonly string $artistDirectory;

    public function __construct(string $artistId, string $artistName, string $artistIcon, string $artistDirectory) {
        $this->artistId = $artistId;
        $this->artistName = $artistName;
        $this->artistIcon = $artistIcon;
        $this->artistDirectory = $artistDirectory;
    }

    public function getArtistId(): string {
        return $this->artistId;
    }

    public function getArtistName(): string {
        return $this->artistName;
    }

    public function getArtistIcon(): string {
        return $this->artistIcon;
    }

    public function getArtistDirectory(): string {
        return $this->artistDirectory;
    }
}
