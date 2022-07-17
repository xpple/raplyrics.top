export class AnnotationManager {
    static #currentAnnotation = null;
    static #annotationSection = document.querySelector("section#annotation");

    static setAnnotation(annotation) {
        AnnotationManager.#currentAnnotation = annotation;
        AnnotationManager.#annotationSection.innerHTML = annotation;
    }
}
