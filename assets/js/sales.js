export let renderSales = () => {

    let chargeTickets = document.querySelectorAll(".charge-ticket");
    let ticketContainer = document.querySelector(".list-group");
    let totals = document.querySelector(".totals");
    let exportSaleToExcel = document.querySelector(".export-sale-to-excel");

    if(exportSaleToExcel) {

        exportSaleToExcel.addEventListener("click", (event) => {
                
            let sendPostRequest = async () => {
                
                let data = {};  //JASON llamada al servidor enviando datos
                data["route"] = 'exportSaleToExcel';
                data["sale_id"] = exportSaleToExcel.dataset.sale;

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
                    console.log(error);
                });
            };

            sendPostRequest();
        }); 
    }

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

    let exportSaleToPdf = document.querySelector(".export-sale-to-pdf");

    if(exportSaleToPdf) {

        exportSaleToPdf.addEventListener("click", (event) => {
                
            let sendPostRequest = async () => {
                
                let data = {};
                data["route"] = 'exportSaleToPdf';
                data["sale_id"] = exportSaleToExcel.dataset.sale;

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
                    console.log(error);
                });
            };

            sendPostRequest();
        }); 
    }

}