export let renderTickets = () => {

    let deleteProducts = document.querySelectorAll(".delete-product");


    deleteProducts.forEach(deleteProduct => {

        deleteProduct.addEventListener("click", (event) => {
            
            let sendPostRequest = async () => { // llamada async va con un await
                
                let data = {}; //JSON llamada al servidor enviando datos
                data["route"] = 'deleteProduct';
                data["ticket_id"] = deleteProduct.dataset.ticket;
    
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
    
                })
                .catch ( error =>  {
                    console.log(JSON.stringify(error));
                });
            };
    
            sendPostRequest();
        }); 
    });
};