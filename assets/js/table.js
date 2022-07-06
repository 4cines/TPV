export let renderTable = () => {

    let tableColors = document.querySelectorAll(".table-colors");

    tableColors.forEach(tableColor => {

       tableColor.addEventListener("click", (event) => {
            
            let sendPostRequest = async () => { // llamada async va con un await
                
                let data = {}; //JSON llamada al servidor enviando datos
                data["route"] = 'tableColors';
                data["table_state"] = tableColors.dataset.table;
    
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
        

};