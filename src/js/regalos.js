(function(){
  const grafica = document.getElementById('regalos-grafica');
  
  if(grafica){
      const ctx = document.getElementById('regalos-grafica');
    
      obtenerRegalos()
      async function obtenerRegalos(){
        const url = `/api/regalos`;

        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
      
        new Chart(ctx, {
            //tipo de grafico
            type: 'bar',
            data: {
              //detalle inferior
              //labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
              labels: resultado.map( regalo => regalo.nombre),
              datasets: [{
                //titulo chico superior
                label: 'cantidad',
                //valores
                //data: [12, 19, 3, 5, 2, 3],
                data: resultado.map( regalo => regalo.total),
                backgroundColor: [
                    '#84cc16',
                    '#ea580c',
                    '#22d3ee',
                    '#a855f7',
                    '#ef4444',
                    '#14b8a6',
                    '#db2777',
                    '#e11d48',
                    '#7e22ce'
                ],
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              },
              plugins: {
                legend: {
                    display: false
                }
              }
            }
          });
    
      }
  }

})();