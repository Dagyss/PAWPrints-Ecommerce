class AppLoader {
    constructor() {

        document.addEventListener("DOMContentLoaded", () => {
		    PAW.cargarScript("DragDrop", "js/components/drag_drop.js", () => {	
				let dragDrop = new DragDrop();
			});
		}
        );
    }
}

let appLoader = new AppLoader();