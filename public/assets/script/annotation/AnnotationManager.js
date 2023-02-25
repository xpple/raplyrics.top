export class AnnotationManager {
    static #annotationContainer = document.getElementById("current-annotation");

    static setAnnotation(annotatedText) {
        AnnotationManager.#annotationContainer.innerHTML = annotatedText.querySelector("template").innerHTML;
        AnnotationManager.#annotationContainer.style.top = annotatedText.getBoundingClientRect().top + window.scrollY + "px";
    }
}
