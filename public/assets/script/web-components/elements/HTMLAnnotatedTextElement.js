import {AnnotationManager} from "../../annotation/AnnotationManager.js";

const template = document.createElement('template');
template.innerHTML = `
<style>
    ::slotted(*) {
        cursor: pointer;
    }
    :host {
        white-space: normal;
    }
    :host(:hover) {
        text-decoration: underline;
    }
</style>
<slot name="text"></slot>`

export class HTMLAnnotatedTextElement extends HTMLElement {

    static #template = template;

    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
        this.shadowRoot.appendChild(HTMLAnnotatedTextElement.#template.content.cloneNode(true));
    }

    connectedCallback() {
        this.addEventListener('click', () => {
            AnnotationManager.setAnnotation(this.querySelector("template").innerHTML);
        });
    }

    disconnectedCallback() {
        this.removeEventListener('click', () => {
            AnnotationManager.setAnnotation(this.querySelector("template").innerHTML);
        });
    }
}
