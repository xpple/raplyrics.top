export class AnnotationManager {
    static #currentAnnotation = null;
    static #annotationSection = document.querySelector("div#annotation");

    static setAnnotation(annotation) {
        AnnotationManager.#currentAnnotation = annotation;
        AnnotationManager.#annotationSection.innerHTML = annotation;
    }
}
