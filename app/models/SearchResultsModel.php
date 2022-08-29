<?php

namespace App\Models;

class SearchResultsModel {

    public readonly array $artistResults;
    public readonly array $songResults;
    public readonly array $lyricResults;

    /**
     * @param ArtistModel[] $artistResults
     * @param SongModel[] $songResults
     * @param SongModel[] $lyricResults
     */
    public function __construct(array $artistResults = array(), array $songResults = array(), array $lyricResults = array()) {
        $this->artistResults = $artistResults;
        $this->songResults = $songResults;
        $this->lyricResults = $lyricResults;
    }
}
