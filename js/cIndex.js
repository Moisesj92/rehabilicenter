//Declarar Variables
	var us	= document.getElementById("usuario");
	var pw	= document.getElementById("clave");
	var btne = document.getElementById("btn_enviar");

//Declarar Funciones

		function validarForm()
		{
			var verificar = true;
			//Nos aseguramos de que los campos no se encuentre vacios
			if(!us.value)
			{
				us.focus();
				verificar = false;
			}
			else if (!pw.value) 
			{
				pw.focus();
				verificar = false;
			}

			if(verificar==true)
				{
					document.login_frm.submit();
				}
		}

//Asignar Eventos

window.onload = function()
	{
		btne.onclick = validarForm;
	}