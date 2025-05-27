
class DragDrop {

    constructor() {
        this.inputFile = document.querySelector("#portada");
        this.dropArea = document.querySelector(".drop-area");
        this.output = document.querySelector(".output-area");
        this.dropAreaText = this.dropArea.querySelector('p');
        this.init();
    }

    init() {
        this.dropArea.addEventListener("dragover", (e) => {
            e.preventDefault();
            e.stopPropagation();
        });

        this.dropArea.addEventListener("drop", (e) => {
            e.preventDefault();
            const image = e.dataTransfer.files[0];
            if (!image || !image.type.match("image")) 
                return;
            this.show(image);
            //this.delete();
            this.inputFile.files = e.dataTransfer.files
        });

        this.dropArea.addEventListener("dragenter", (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.dropArea.classList.add("drag-over");
        });

        this.dropArea.addEventListener("dragleave", (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.dropArea.classList.remove("drag-over");
        });

    }

    show(image) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const imageHTML = `<div class="image-uploaded"><img src="${e.target.result}" alt="Imagen de Portada cargada"></div>`;
            this.output.innerHTML = imageHTML;
        };
        reader.readAsDataURL(image);
    }

    delete() {
        if (this.dropArea) {
            this.dropArea.parentNode.removeChild(this.dropArea);
        }
    }
}