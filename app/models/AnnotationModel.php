<?php

namespace App\Models;

class AnnotationModel {

    private readonly string $annotationId;
    private readonly string $songId;
    private readonly int $annotationStart;
    private readonly int $annotationLength;
    private readonly string $annotation;
    private readonly string $annotationType;

    public function __construct(string $annotationId, string $songId, int $annotationStart, int $annotationLength, string $annotation, string $annotationType) {
        $this->annotationId = $annotationId;
        $this->songId = $songId;
        $this->annotationStart = $annotationStart;
        $this->annotationLength = $annotationLength;
        $this->annotation = $annotation;
        $this->annotationType = $annotationType;
    }

    public function getAnnotationId(): string {
        return $this->annotationId;
    }

    public function getSongId(): string {
        return $this->songId;
    }

    public function getAnnotationStart(): int {
        return $this->annotationStart;
    }

    public function getAnnotationLength(): int {
        return $this->annotationLength;
    }

    public function getAnnotation(): string {
        return $this->annotation;
    }

    public function getAnnotationType(): string {
        return $this->annotationType;
    }
}
