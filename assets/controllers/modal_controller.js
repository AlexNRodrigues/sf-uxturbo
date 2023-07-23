import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';

export default class extends Controller {

    connect() {
        console.log("Modal controller connected");
    }

    close() {
        this.element.remove()
        this.modalTurboFrame.src = null
        document.getElementById('btn-contact-inbox').click();
    }

    escClose(event) {
        if (event.key === 'Escape') this.close()
    }

    get modalTurboFrame() {
        return document.querySelector("turbo-frame[id='modal']")
    }
}