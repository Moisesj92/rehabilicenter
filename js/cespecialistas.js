//Declarar Variables
	if (typeof(tabControl) == "undefined") {
			 var tabControl = 0;
		};



	

	//Tab Horarios
	var formCH = document.getElementById("idConsultarHorario_frm");
	var btnEnviarFormCH = document.getElementById("enviarConsultarHorario_frm");

		//campos FormCH
		var esp = document.getElementById("especialista");
		var fei = document.getElementById("idFechaInicial");
		var fef	= document.getElementById("idFechaFinal");	

	//Tab Asignaciones
	var formCP = document.getElementById("idConsultarPaciente_frm");
	var btnEnviarFormCP = document.getElementById("enviarConsultarPaciente_frm");

	var formAP = document.getElementById("idAsignacion_frm");
	var btnEnviarFormAP = document.getElementById("eviarIdAsignacion_frm");

		//Campos formCP
		var pac = document.getElementById("paciente");

		//Campos formAP (Asignar paciente)
		var idc = document.getElementById("idConsulta");
		var sI = document.getElementById("sesionInicial");
		var sF = document.getElementById("sesionFinal");
		var esp1 = document.getElementById("especialista1");
		var hor = document.getElementById("horario");






	//Tab Nuevo Especialista
	var formNE = document.getElementById("idNuevoEspecialista_frm");
	var btnEnviarFormNE= document.getElementById("enviaridNuevoEspecialista_frm");

		//campos formNE
		var ide = document.getElementById("identificacion");
		var tlf = document.getElementById("telf");
		var nom = document.getElementById("nombre");
		var ape = document.getElementById("apellido");
		var cor = document.getElementById("correo");

		//Div Campos formNE
		var divIde = document.getElementById("divIdentificacion");
		var divTlf = document.getElementById("divTelf");
		var divNom = document.getElementById("divNombre");
		var divApe = document.getElementById("divApellido");
		var divCor = document.getElementById("divCorreo");


	//Variables para las funciones de validacion
		var verificar = true;
		var compatible = false;

	//Expresiones reguales

		//Expresion regular para un numero de 3 o mas digitos
		var regNumero = /^[0-9][0-9]{1,}[0-9]$/;
		//Expresior regular para nombre con acentos y Ñ
		var regNombre = /^[A-Za-zÑñÁáÉéÍíÓóÚú][A-Za-zÑñÁáÉéÍíÓóÚú]{1,}[A-Za-zÑñÁáÉéÍíÓóÚú]$/;
		//Expresion regular para un numero de telefono
		var regNumeroTlf = /^[0-9][0-9]{1,3}-{1}[0-9]{1,}[0-9]$/;


//Definir funciones
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
	
	//Tab Horarios
	function validarFormCH()
	{
		verificar = true;

		if (esp.value == 0) 
		{
			esp.focus();
			verificar = false;
		}
		else if (!fei.value) 
		{
			fei.focus();
			verificar = false;
		}

		if (verificar == true) 
		{
			//alert("listo");
			document.consultarHorario_frm.submit();
			btnEnviarFormCH.disabled = true;
		}
		else
		{
			alert("Parece que falta algun dato o los datos introducidos no son correcto");
		}
	}

	//Tab Asignaciones
	function validarFormCP ()
	{
		verificar = true;

		//verificar que los campos no esten vacios
		if(pac.value == 0)
		{
			pac.focus();
			verificar = false;
		}

		if (verificar == true) 
		{
			document.consultarPaciente_frm.submit();
			btnEnviarFormCP.disabled = true;
		}
		else
		{
			alert("Debes selecionar un paciente para consultar");
		}
	}

	function validarFormAP ()
	{
		verificar = true;

		if (idc.value == 0)
		{
			idc.focus();
			verificar = false;
		}
		else if ( !sI.value ) 
		{
			sI.focus();
			verificar = false;
		}
		else if (!sF.value)
		{
			sF.focus();
			verificar = false;
		}
		else if (sI.value > sF.value) 
		{
			sI.value = 1;
			sF.value = 1;
			sI.focus();
			verificar = false;
		}	
		else if (esp1.value == 0)
		{
			esp1.focus();
			verificar = false;
		}
		else if (hor.value == 0)
		{
			hor.focus();
			verificar = false;
		}

		if (verificar == true) 
		{
			//alert("listo");
			document.asignacion_frm.submit();
			btnEnviarFormAP.disabled = true;
		}
		else
		{
			alert("Parece que falta algun dato o los datos introducidos no son correcto");
		}
	}


	//Tab Nuevo Especialista
	function validarFormNE()
	{
		verificar = true;
		//verificar q los campos no esten vacios
		if (!ide.value) {
			ide.focus();
			verificar = false;
		}
		else if (!tlf.value) {
			tlf.focus();
			verificar = false;
		}
		else if (!nom.value) {
			nom.focus();
			verificar = false;
		}
		else if (!ape.value) {
			ape.focus();
			verificar = false;
		}
		else if (!cor.value) {
			cor.focus();
			verificar = false;
		}

		//validar que los datos coincidan con la expresion regular
			validarFormDinamico(regNumero, ide, divIde);
			validarFormDinamico(regNumeroTlf, tlf, divTlf);
			validarFormDinamico(regNombre, nom, divNom);
			validarFormDinamico(regNombre, ape, divApe);

		if (verificar == true && compatible == true) 
			{
				//alert("listo");
				document.nuevoEspecialista_frm.submit();
				btnEnviarFormNE.disabled = true;
			}
		else
			{
				alert("Parece que falta algun dato o los datos introducidos no son correcto");
			}


	}

	//Funcion para confirmar eliminación
        function eliminar( ide )
        {
            
            var respuesta = confirm("¿Realmente desea elimanar este especialista?");
            if(respuesta == true){
                window.location="php/cespecialistas.php?id_eliminar=" + ide;
            }
            else
            {
                alert("Operación Cancelada");
            }        
        }





//Definir Eventos

	//Validar Formularios con ONKEYUP
	ide.onkeyup = function(){
		validarFormDinamico(regNumero, ide, divIde);	
	}

	tlf.onkeyup = function(){
		validarFormDinamico(regNumeroTlf, tlf, divTlf);
	}

	nom.onkeyup = function(){
		validarFormDinamico(regNombre, nom, divNom);
	}

	ape.onkeyup = function(){
		validarFormDinamico(regNombre, ape, divApe);
	}



	//Funciones al cargar la pagina
	window.onload = function()
	{
		
		//activar la tab que quiero por nombre
		//$('.nav-tabs a[href="#menu1"]').tab('show');
		//activar la tab que quiero por el arreglo de posiciones
		$('.nav-tabs li:eq('+ tabControl +') a').tab('show');


		//tab Horarios
		btnEnviarFormCH.onclick = validarFormCH;
		
		//tab Asignaciones
		btnEnviarFormCP.onclick = validarFormCP;

		btnEnviarFormAP.onclick = validarFormAP;

		//tab Nuevo Especialista
		btnEnviarFormNE.onclick = validarFormNE;

		//Bloqueos de formularios
		if (tabControl == 3) 
		{
			btnEnviarFormAP.disabled = false;
		}
		else
		{
			btnEnviarFormAP.disabled = true;	
		}

	}