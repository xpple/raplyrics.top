<?php

namespace App\Models;

readonly class SearchResultsModel {

    public array $artistResults;
    public array $songResults;
    public array $lyricResults;

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
}
