    document.getElementById("usuario").addEventListener("click", function() {
      window.location.href = "login.html";
    });
      function enviar() {
      fetch('api.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          accion: "crear",
          nombre: document.getElementById("name").value,
          email: document.getElementById("email").value,
          pswd: document.getElementById("pwd").value, 
          tel: document.getElementById("tel").value
        })
      })
      .then(response => response.json())
      .then(dato => {
        document.getElementById("name").value = ""; 
        document.getElementById("email").value = ""; 
        document.getElementById("pwd").value = ""; 
        document.getElementById("tel").value = ""; 
        alert("Datos enviados")
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }