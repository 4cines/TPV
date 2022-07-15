export let renderAdminTable = () => {

    let deleteTableButtons = document.querySelectorAll('.delete-table-button');
    let deleteTableModal = document.querySelector('.delete-table-modal');
    let editButtons = document.querySelectorAll('.edit-table-button');

    document.addEventListener("renderAdminTable",( event =>{
        renderAdminTable();
    }), {once: true});

    deleteTableButtons.forEach(deleteTableButton => {

        deleteTableButton.addEventListener("click", (event) => { 
                
            deleteTableModal.dataset.id = deleteTableButton.dataset.id;//en el boton de eliminar contiene el id y lo igualas al boton del modal para eliminar
            
        }); 
    });

    if(deleteTableModal) {
        
        deleteTableModal.addEventListener("click", (event) => {

            let sendPostRequest = async () => {
                        
                let data = {};
                data["route"] = deleteTableModal.dataset.route;
                data["id"] = deleteTableModal.dataset.id;

                console.log(data['id']);
               

                let response = await fetch('web.php', {
                    headers: {
                        'Accept': 'application/json',
                    },
                    method: 'DELETE',
                    body: JSON.stringify(data)
                })
                .then(response => {
                
                    if (!response.ok) throw response;

                    return response.json();
                })
                .then(json => {

                    document.querySelector("[data-element='" + json.id + "']").remove(); // cada registro tiene un data-element, de esta forma se puede identificar
                })
                .catch ( error =>  {
                    console.log(error);
                });
            };

            sendPostRequest();

        });
    }

    editButtons.forEach(editButton => {

        editButton.addEventListener("click", (event) => {
                
            let sendPostRequest = async () => {
                        
                let data = {};
                data["route"] = editButton.dataset.route;
                data["id"] = editButton.dataset.id;

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
  
                    Object.entries(json.element).forEach(([key, value]) => {
                        
                        if(document.getElementsByName(key).length > 0){ // name del input del .php
                            document.getElementsByName(key)[0].value = value; // [0] para poder acceder a los valores. Es standar
                        }
                    });
                })
                .catch ( error =>  {
                    console.log(error);
                });
            };

            sendPostRequest();
            
        }); 
    });
};