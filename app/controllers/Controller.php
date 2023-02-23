<?php

namespace App\Controllers;

use Exception;

abstract class Controller {

    private readonly array $path;

    public function __construct(array $path = array()) {
        $this->path = $path;
    }

    public function getPath(): array {
        return $this->path;
    }

    /**
     * @throws Exception
     */
    abstract public function load(): void;
}
