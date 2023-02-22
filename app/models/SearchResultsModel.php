<?php

namespace App\Models;

class SearchResultsModel {

    private readonly array $artistResults;
    private readonly array $songResults;
    private readonly array $lyricResults;

    /**
     * @param ArtistModel[] $artistResults
     * @param SongModel[] $songResults
     * @param SongModel[] $lyricResults
     */
    public function __construct(array $artistResults = [], array $songResults = [], array $lyricResults = []) {
        $this->artistResults = $artistResults;
        $this->songResults = $songResults;
        $this->lyricResults = $lyricResults;
    }

    public function getArtistResults(): array {
        return $this->artistResults;
    }

    public function getSongResults(): array {
        return $this->songResults;
    }

    public function getLyricResults(): array {
        return $this->lyricResults;
    }
}
