export let renderAdminForm = () => {

    let adminForm = document.querySelector('.admin-form');
    let createFormButton = document.querySelector('.create-form-button');
    let sendFormButton = document.querySelector('.send-form-button');
    let createLayout = document.querySelector('.create-layout');
    let tableContainer = document.querySelector('tbody');

    if(createFormButton) {
        
        createFormButton.addEventListener("click", (event) => {
            adminForm.reset(); // resetar el formulario para añadir una mesa, botón "añadir mesa" de la vista
        });
    }

    if(sendFormButton) {

        sendFormButton.addEventListener("click", (event) => {

            event.preventDefault();  //comportamiento por defecto del botón (llamada GET), nosotros lo enviamos por POST, de ahí esta línea
                
            let sendPostRequest = async () => {
                
                let data = {}; // crear JSON
                let formData = new FormData(adminForm); // formData: objeto nativo de JS y por () indicas el formulario. Después hay que pasar el formData a JSON para el servidor
                formData.append("route", adminForm.dataset.route); // = data["route"] = 'addProduct'; 

                formData.forEach(function(value, key){ //transformaos el FormData a JSON 
                    data[key] = value; // se le crea un bucle para que le adjudique una clave (campo bbdd) a cada valor (valor a introducir)
                });

                let response = await fetch('web.php', {
                    headers: {
                        'Accept': 'application/json',
                    },
                    method: 'POST',
                    body: JSON.stringify(data)
                })
                .then(response => {
                
                    if (!response.ok) throw response;

                    return response.json();
                })
                .then(json => {

                    if(json.id == "") { //si la id viene vacía 

                        let newElement = createLayout.cloneNode(true); // clonar la plantilla linea 78 admin-mesas.php
                        newElement.classList.remove('d-none', 'create-layout'); // se le quita la invisibilidad y el formato formulario de admin-mesa.php
                        newElement.dataset.element = json.newElement.id; // el elemento creado le meto la id para poder localizarlo 

                        newElement.querySelector('.delete-table-button').dataset.id = json.newElement.id; // coger la id del clonado para poder eliminarlo

                        Object.entries(json.newElement).forEach(([key, value]) => { 
                            // json.newElement es el ultimo registro de la tabla $query
                            // json es un objeto
                            if(newElement.querySelector("." + key)){ 
                                newElement.querySelector("." + key).innerHTML = value;
                            } // bucle para insertar los valores y claves que has añadido para que el js lo meta en el HTML
                        });

                        tableContainer.appendChild(newElement); // añadir dentro de la tabla lo clonado 

                        document.dispatchEvent(new CustomEvent('renderAdminTable'));

                    }else{

                        let element = document.querySelector("[data-element='" + json.id + "']");

                        Object.entries(json.newElement).forEach(([key, value]) => {
                            if(element.querySelector("." + key)){
                                element.querySelector("." + key).innerHTML = value;
                            }
                        });

                        document.dispatchEvent(new CustomEvent('renderAdminTable'));
                    }
                })
                .catch ( error =>  {
                    console.log(error);
                });
            };

            sendPostRequest();
        }); 
    }
    
};