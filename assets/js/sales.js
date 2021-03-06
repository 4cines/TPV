export let renderSales = () => {

    let chargeTickets = document.querySelectorAll(".charge-ticket");
    let ticketContainer = document.querySelector(".list-group");
    let totals = document.querySelector(".totals");

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
                    let products = ticketContainer.querySelectorAll('li:not(.add-product-layout)');

                    ticketContainer.querySelector('.no-products').classList.remove('d-none');
    
                    totals.querySelector('.iva-percent').innerHTML = '';
                    totals.querySelector('.base').innerHTML = 0;
                    totals.querySelector('.iva').innerHTML = 0;
                    totals.querySelector('.total').innerHTML = 0;
    
                    products.forEach(product => {
                        product.remove();
                    });
                })
                .catch ( error =>  {
                    console.log(JSON.stringify(error));
                });
            };
            
            sendPostRequest();

        });

    });

}