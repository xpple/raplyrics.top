import {HTMLAnnotatedTextElement} from "./web-components/elements/HTMLAnnotatedTextElement.js";

window.customElements.define("annotated-text", HTMLAnnotatedTextElement);

for (let option of document.getElementsByClassName("option")) {
    option.addEventListener('click', () => {
        let searchParameters = new URLSearchParams(window.location.search);
        searchParameters.set("annotationType", option.innerText);
        window.location.search = searchParameters.toString();
    });
}
