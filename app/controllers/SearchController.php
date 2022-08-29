<?php

namespace App\Controllers;

use App\Models\DatabaseModel;
use App\Models\SearchResultsModel;
use Exception;

class SearchController extends Controller {

    private string $searchQuery;
    private SearchResultsModel $searchResults;

    public function load(): void {
        $path = $this->getPath();
        if (count($path) == 0) {
            $this->searchResults = new SearchResultsModel();
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/../app/views/SearchView.php");
            return;
        }
        $this->searchQuery = array_shift($path);
        if (count($path) == 0) {
            $model = new DatabaseModel();
            $this->searchResults = $model->getSearchResults($this->searchQuery);
            require realpath($_SERVER['DOCUMENT_ROOT'] . "/../app/views/SearchView.php");
            return;
        }
        throw new Exception("Requested directory does not exist.");
    }
}
