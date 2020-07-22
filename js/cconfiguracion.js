//Declarar Las variables
	//Variables Generales
		//Control De Pestañas
		if (typeof(tabControl) == "undefined") {
			 var tabControl = 0;
		};

		if (typeof(modificar) == "undefined") {
			 var modificar = false;
		};

		//compatible
		compatible = false;

		//Expresiones Regulares

		//Expresion regular para un numero de 3 o mas digitos
		var regNumero = /^[0-9][0-9]{1,}[0-9]$/;
		//Expresior regular para nombre con acentos y Ñ y espacions de guiones
		var regNombre = /^[A-Za-zÑñÁáÉéÍíÓóÚú][A-Za-zÑñÁáÉéÍíÓóÚú]{1,}[A-Za-zÑñÁáÉéÍíÓóÚú]$/;
		//Expresion regular para un numero de telefono
		var regNumeroTlf = /^[0-9][0-9]{1,3}-{1}[0-9]{1,}[0-9]$/;


	//Tab Modulo Paciente

		//Declarar valos de la variable para el formulario type Hidden de control si esta no esta definida
		if (typeof(idTdp) == "undefined") {
			 var idTdp = false;
		};
		//Formularios Tipo de pago
		var formTdp = document.getElementById("idManejarTdp_frm");
		var btnEnviarFormTdp = document.getElementById("enviarManejarTdp_frm");
		var btnLimpiarFormTdp = document.getElementById("limpiarManejarTdp_frm");

			//Campos Del Formulario
			var nomTdp = document.getElementById("nombreTdp");
			var desTdp = document.getElementById("descTdp");

			//Div Padres de los Campos
			var divNomTdp = document.getElementById("divNombreTdp");



		//Declarar valos de la variable para el formulario type Hidden de control si esta no esta definida
		if (typeof(idFar) == "undefined") {
			 var idFar = false;
		};
		//Formulario Farmaco
		var formFar = document.getElementById("idManejarFarmacos_frm");
		var btnEnviarFormFar = document.getElementById("enviarManejarFarmacos_frm");
		var btnLimpiarFormFar = document.getElementById("limpiarManejarFarmacos_frm");

			//campos del Formulario
			var complejoFar = document.getElementById("complejoActivo");
			var nomFar = document.getElementById("nombreComercial");
			var desFar = document.getElementById("descFarmaco");

			//Divs Padres de los campos
			var divComplejoFar = document.getElementById("divComplejoActivo");


//Declarar las Funciones
	//Funciones Generales
		//Validar forms dinamicamente segun el valor de los input
		function validarFormDinamico (expReg, input, divPadre)
		{
			//verificar que el valor sea el definido por la expresion regular
			if (!expReg.exec(input.value))
			{
				divPadre.classList.remove('has-success');
				divPadre.classList.add('has-error');
				//alert(expReg + " -- " + input + " -- " + divPadre + " -- " + input.value);
				input.focus();
				compatible = false;
			}
			else if (expReg.exec(input.value)) 
			{
				divPadre.classList.remove('has-error');
				divPadre.classList.add('has-success');
				compatible = true;
			}
		}


	//Tab Modulo Paciente
		//Llenar formTdp
		function llenarFormTdp( tdp )
		{
			if (tdp == 1) 
			{
				var inputMH = document.createElement("input");
				inputMH.type = "hidden";
				inputMH.id = "modificarTdp";
				inputMH.name = "modificarTdp_h";
				inputMH.value = true;

				formTdp.appendChild(inputMH);
			}
			else if (tdp == 0)
			{
				var inputEH = document.createElement("input");
				inputEH.type = "hidden";
				inputEH.id = "eliminarTdp";
				inputEH.name = "eliminarTdp_h";
				inputEH.value = true;

				formTdp.appendChild(inputEH);
			}
			

			var inputIH = document.createElement("input");
			inputIH.type = "hidden";
			inputIH.id = "idTdp";
			inputIH.name = "idTdp_h";
			inputIH.value = idTdp;

			formTdp.appendChild(inputIH);
		}


		//Llenar FormFar
		function llenarFormFar (farmaco)
		{
			if (farmaco == 1) 
			{
				var inputMH = document.createElement("input");
				inputMH.type = "hidden";
				inputMH.id = "modificarFar";
				inputMH.name = "modificarFar_h";
				inputMH.value = true;

				formFar.appendChild(inputMH);

			}
			else if (farmaco == 0)
			{
				var inputEH = document.createElement("input");
				inputEH.type = "hidden";
				inputEH.id = "eliminarFar";
				inputEH.name = "eliminarFar_h";
				inputEH.value = true;

				formFar.appendChild(inputEH);

			}

			var inputIFarH = document.createElement("input");
			inputIFarH.type = "hidden";
			inputIFarH.id = "idFar";
			inputIFarH.name = "idFar_h";
			inputIFarH.value = idFar;

			formFar.appendChild(inputIFarH);
		}



		//validar FormTdp
		function validarFormTdp ()
		{
			var verificar = true;

			if (!nomTdp.value) 
			{
				verificar = false;
				nomTdp.focus();
			}
			else if (!descTdp.value)
			{
				verificar = false;
				desTdp.focus();
			}

			//Validar Expresion Regular
			validarFormDinamico(regNombre, nomTdp, divNomTdp);


			if (verificar == true && compatible == true)
			{
				//alert("listo");
				document.manejarTdp_frm.submit();
				btnEnviarFormTdp.disabled = true;
			}
			else
			{
				alert("Parece que falta algun dato o los datos introducidos no son correctos");
			}
		}

		//Validar FormFar
		function validarFormFar ()
		{
			var verificar = true;
			
			if(!complejoFar.value)
			{
				verificar = false;
				complejoFar.focus();
			}
			else if(!nomFar.value)
			{
				verificar = false;
				nomFar.focus();
			}
			else if(!desFar.value)
			{
				verificar = false;
				desFar.focus();
			}

			//Validar Expresion Regular
			validarFormDinamico(regNombre, complejoFar, divComplejoFar);

			if (verificar == true && compatible == true)
			{
				//alert("listo");
				document.manejarFarmacos_frm.submit();
				btnEnviarFormFar.disabled = true;
			}
			else
			{
				alert("Parece que falta algun dato o los datos introducidos no son correctos");
			}


		}

//Definir los Eventos



	//Eventos con pagina cargada
	window.onload = function()
	{

		//activar la tab que quiero por nombre
		//$('.nav-tabs a[href="#menu1"]').tab('show');
		//activar la tab que quiero por el arreglo de posiciones
		$('.nav-tabs li:eq('+ tabControl +') a').tab('show');


		//Tab Modulo Paciente
			//Formularios
			nomTdp.onkeyup = function()
			{
				validarFormDinamico(regNombre, nomTdp, divNomTdp);	
			}


			complejoFar.onkeyup = function()
			{
				validarFormDinamico(regNombre, complejoFar, divComplejoFar);	
			}

			btnEnviarFormTdp.onclick = validarFormTdp;
			btnEnviarFormFar.onclick = validarFormFar;


			//Botones
			if (tabControl == 1 && modificar == "tdp1") 
			{
				llenarFormTdp(1);
				btnLimpiarFormTdp.disabled = true;
			}
			else if (tabControl == 1 && modificar == "tdp0")
			{
				
				llenarFormTdp(0);
				nomTdp.setAttribute("readonly", "");
				desTdp.setAttribute("readonly", "");
				btnLimpiarFormTdp.disabled = true;
			}
			else if (tabControl == 1 && modificar == "far1")
			{

				llenarFormFar(1);
				btnLimpiarFormFar.disabled = true;

			}
			else if (tabControl == 1 && modificar == "far0")
			{

				llenarFormFar(0);
				complejoFar.setAttribute("readonly","");
				nomFar.setAttribute("readonly","");
				desFar.setAttribute("readonly","");
				btnLimpiarFormFar.disabled = true;

			}

		//
		




	}