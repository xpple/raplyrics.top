import {HTMLAnnotatedTextElement} from "./web-components/elements/HTMLAnnotatedTextElement.js";

window.customElements.define("annotated-text", HTMLAnnotatedTextElement);

for (const option of document.getElementsByClassName("option")) {
    ['click', 'touchend'].forEach((e) => {
        option.addEventListener(e, () => {
            let searchParameters = new URLSearchParams(window.location.search);
            searchParameters.set("annotationType", option.innerText);
            window.location.search = searchParameters.toString();
        });
    });
}
