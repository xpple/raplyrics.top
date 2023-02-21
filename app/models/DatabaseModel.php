<?php

namespace App\Models;

use PDO;
use PDOException;

class DatabaseModel {

    private readonly PDO $conn;

    public function __construct() {
        try {
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/../app/login-data.php");
            $this->conn = new PDO("mysql:host=$server;port=$port;dbname=$dbname;charset=UTF8", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_NUM);
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

    /**
     * @return AnnotationModel[]
     */
    public function getAnnotations(string $songId): array {
        $statement = $this->conn->prepare("SELECT annotation_id, song_id, annotation_start, annotation_length, annotation, annotation_type FROM annotations WHERE HEX(song_id) = :song_id ORDER BY annotation_start");
        $statement->execute(array("song_id" => $songId));
        $annotationResults = $statement->fetchAll();

        return array_map(fn($annotationEntry) => new AnnotationModel(...$annotationEntry), $annotationResults);
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
        $artistResults = array_map(fn($artistEntry) => new ArtistModel(...$artistEntry), $artistResults);
        $songResults = array_map(fn($songEntry) => new SongModel(...$songEntry), $songResults);
        $lyricResults = array_map(fn($lyricEntry) => new SongModel(...$lyricEntry), $lyricResults);
        return new SearchResultsModel($artistResults, $songResults, $lyricResults);
    }

    public function addUser(string $email, string $username, string $password): void {
        require realpath($_SERVER['DOCUMENT_ROOT'] . "/../app/pepper.php");
        $password_peppered = hash_hmac("sha256", $password, $pepper);
        $password_hashed = password_hash($password_peppered, PASSWORD_BCRYPT);
        $statement = $this->conn->prepare("INSERT INTO users (user_password, user_email, user_name) VALUES (:user_password, :user_email, :user_name)");
        $statement->execute(array("user_password" => $password_hashed, "user_email" => $email, "user_name" => $username));
    }
}
