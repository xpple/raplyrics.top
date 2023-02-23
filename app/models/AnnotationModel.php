<?php

namespace App\Models;

readonly class AnnotationModel {

    public string $annotationId;
    public string $songId;
    public int $annotationStart;
    public int $annotationLength;
    public string $annotation;
    public string $annotationType;

    public function __construct(string $annotationId, string $songId, int $annotationStart, int $annotationLength, string $annotation, string $annotationType) {
        $this->annotationId = $annotationId;
        $this->songId = $songId;
        $this->annotationStart = $annotationStart;
        $this->annotationLength = $annotationLength;
        $this->annotation = $annotation;
        $this->annotationType = $annotationType;
    }
}
