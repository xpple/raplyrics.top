export class AnnotationManager {
    static #currentAnnotation = null;
    static #annotationContainer = document.getElementById("current-annotation");

    static setAnnotation(annotation) {
        AnnotationManager.#currentAnnotation = annotation;
        AnnotationManager.#annotationContainer.innerHTML = annotation;
        AnnotationManager.#annotationContainer.style.top = window.innerHeight / 2 + window.scrollY + "px";
    }
}
