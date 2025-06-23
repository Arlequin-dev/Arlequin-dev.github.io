  import alerts from './sweetAlerts.js';
  document.getElementById("usuario").addEventListener("click", function() {
      window.location.href = "login.html";
    });
     document.getElementById("enviar").addEventListener("click", function() {
      fetch('api.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          accion: "crear",
          nombre: document.getElementById("name").value,
          rol: "socio", 
          email: document.getElementById("email").value,
          pswd: document.getElementById("pwd").value, 
          tel: document.getElementById("tel").value
        })
      })
      .then(response => response.json())
      .then(dato => {
       if(dato.success){
        alerts.success("Usuario creado correctamente", "Éxito");
         document.getElementById("name").value = ""; 
        document.getElementById("email").value = ""; 
        document.getElementById("pwd").value = ""; 
        document.getElementById("tel").value = ""; 
       }else{
         alerts.error("Error al crear el usuario: " + dato.error, "Error");
       }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }); 