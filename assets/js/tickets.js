export let renderTickets = () => {

    let deleteProducts = document.querySelectorAll(".delete-product");
    let deleteAllProducts = document.querySelector(".delete-all-products");
    let chargeTicket = document.querySelector(".charge-ticket");

    deleteProducts.forEach(deleteProduct => {

        deleteProduct.addEventListener("click", (event) => {
            
            let sendPostRequest = async () => { // llamada async va con un await
                
                let data = {}; //JSON llamada al servidor enviando datos
                data["route"] = 'deleteProduct';
                data["ticket_id"] = deleteProduct.dataset.ticket;
                data["table_id"] = deleteProduct.dataset.table;

    
                let response = await fetch('web.php', {
                    headers: {
                        'Accept': 'application/json',
                    },
                    method: 'DELETE',
                    body: JSON.stringify(data)
                })
                .then(response => {
                collectcharge

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

    deleteAllProducts.addEventListener("click", (event) => {
        
        let sendPostRequest = async () => { 
            
            let data = {};
            data["route"] = 'deleteAllProducts';
            data["table_id"] = deleteAllProducts.dataset.table;

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

    chargeTicket.addEventListener("click", (event) => {
        
        let sendPostRequest = async () => { 
            
            let data = {};
            data["route"] = 'chargeTicket';
            data["table_id"] = chargeTicket.dataset.table;
            data["metodo_pago"] = chargeTicket.dataset.metodopago;
            

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

            })
            .catch ( error =>  {
                console.log(JSON.stringify(error));
            });
        };
        
        sendPostRequest();
    });
};