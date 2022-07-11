export let renderSales = () => {

    let chargeTickets = document.querySelectorAll(".charge-ticket");

    chargeTickets.forEach(chargeTicket => {

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

    });

}