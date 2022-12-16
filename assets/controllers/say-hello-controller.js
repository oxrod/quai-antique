import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['name', 'output'];

    greet() {
        if (this.nameTarget.value === "") {
            this.outputTarget.textContent = "I can't greet someone that does not exist !";
            this.outputTarget.className = "text-danger";
        } else {
            this.outputTarget.className = "text-success";
            this.outputTarget.textContent = `Hello, ${this.nameTarget.value}`;
        }
    }
}