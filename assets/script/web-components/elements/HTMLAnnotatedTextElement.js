import {AnnotationManager} from "../../annotation/AnnotationManager.js";

const template = document.createElement('template');
template.innerHTML = `
<style>
    #text {
        cursor: pointer;
    }
</style>
<mark id="text" part="text"><slot name="text"></slot></mark>`

export class HTMLAnnotatedTextElement extends HTMLElement {

    static #template = template;

    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
        this.shadowRoot.appendChild(HTMLAnnotatedTextElement.#template.content.cloneNode(true));
    }

    connectedCallback() {
        this.shadowRoot.getElementById("text").addEventListener('click', () => {
            AnnotationManager.setAnnotation(this.querySelector("template").innerHTML);
        });
    }

    disconnectedCallback() {
        this.shadowRoot.getElementById("text").removeEventListener('click', () => {
            AnnotationManager.setAnnotation(this.querySelector("template").innerHTML);
        });
    }
}
