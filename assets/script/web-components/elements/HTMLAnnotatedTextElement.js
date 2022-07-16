const template = document.createElement('template');
template.innerHTML = `
<style>
    mark {
        cursor: pointer;
    }
    #annotation {
        display: none;
        
        position: fixed;
        padding: 5px;
        width: 300px;
        background-color: yellow;
        border-radius: 15px;
    }
</style>
<mark id="toggle-annotation">
    <slot name="text"></slot>
</mark>
<div id="annotation">
    <slot name="annotation"></slot>
</div>
`

class HTMLAnnotatedTextElement extends HTMLElement {

    static #template = template;

    #showAnnotation = false;

    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
        this.shadowRoot.appendChild(HTMLAnnotatedTextElement.#template.content.cloneNode(true));
    }

    toggleAnnotation() {
        this.#showAnnotation = !this.#showAnnotation;
        const annotation = this.shadowRoot.getElementById("annotation");
        if (this.#showAnnotation) {
            annotation.style.display = 'block';
        } else {
            annotation.style.display = 'none';
        }
    }

    connectedCallback() {
        this.shadowRoot.getElementById("toggle-annotation").addEventListener('click', () => this.toggleAnnotation());
    }

    disconnectedCallback() {
        this.shadowRoot.getElementById("toggle-annotation").removeEventListener('click', () => this.toggleAnnotation());
    }
}

window.customElements.define("annotated-text", HTMLAnnotatedTextElement);
