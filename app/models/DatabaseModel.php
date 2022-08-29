<?php

namespace App\Models;

use PDO;
use PDOException;

class DatabaseModel {

    private readonly PDO $conn;

    public function __construct() {
        try {
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/../app/login-data.php");
            $conn = new PDO("mysql:host=$server;port=$port;dbname=$dbname;charset=UTF8", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_NUM);
        } catch (PDOException) {
            die("Connection error.");
        }
    }

    public function getArtist(string $artistDirectory): ?ArtistModel {
        $statement = $this->conn->prepare("SELECT HEX(artist_id) as artist_id, artist_name, artist_icon, artist_directory FROM artists WHERE artist_directory = :artist_directory");
        $statement->execute(array("artist_directory" => $artistDirectory));
        $result = $statement->fetchAll();

        if (count($result) != 1) {
            return null;
        }
        $artistEntry = $result[0];
        return new ArtistModel(...$artistEntry);
    }

    public function getSong(string $artistDirectory, string $songDirectory): ?SongModel {
        $statement = $this->conn->prepare("SELECT HEX(song_id) as song_id, song_title, HEX(songs.artist_id) as artist_id, artist_name, artist_directory, song_cover_image, song_description, song_lyrics, song_directory FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE artist_directory = :artist_directory AND song_directory = :song_directory");
        $statement->execute(array("artist_directory" => $artistDirectory, "song_directory" => $songDirectory));
        $result = $statement->fetchAll();

        if (count($result) != 1) {
            return null;
        }
        $songEntry = $result[0];
        return new SongModel(...$songEntry);
    }

    public function getSearchResults(string $searchQuery): SearchResultsModel {
        $searchQuery = rawurldecode($searchQuery);
        $statement = $this->conn->prepare("SELECT HEX(artist_id) as artist_id, artist_name, artist_icon, artist_directory FROM artists WHERE INSTR(artist_name, :search_query) > 0");
        $statement->execute(array("search_query" => $searchQuery));
        $artistResults = $statement->fetchAll();
        $statement = $this->conn->prepare("SELECT HEX(song_id) as song_id, song_title, HEX(songs.artist_id) as artist_id, artist_name, artist_directory, song_cover_image, song_description, song_lyrics, song_directory FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE INSTR(song_title, :search_query) > 0");
        $statement->execute(array("search_query" => $searchQuery));
        $songResults = $statement->fetchAll();
        $statement = $this->conn->prepare("SELECT HEX(song_id) as song_id, song_title, HEX(songs.artist_id) as artist_id, artist_name, artist_directory, song_cover_image, song_description, song_lyrics, song_directory FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE CHAR_LENGTH(:search_query) > 5 AND INSTR(song_lyrics, :search_query) > 0");
        $statement->execute(array("search_query" => $searchQuery));
        $lyricResults = $statement->fetchAll();
        $artistResults = array_map(function ($artistEntry) {
            return new ArtistModel(...$artistEntry);
        }, $artistResults);
        $songResults = array_map(function ($songEntry) {
            return new SongModel(...$songEntry);
        }, $songResults);
        $lyricResults = array_map(function ($lyricEntry) {
            return new SongModel(...$lyricEntry);
        }, $lyricResults);
        return new SearchResultsModel($artistResults, $songResults, $lyricResults);
    }
}
