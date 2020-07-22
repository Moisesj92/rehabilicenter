// Declarar Variables
	if (typeof(tabControl) == "undefined") {
			var tabControl = 0;
		};
	if (typeof(modificar) == "undefined") {
			var modificar = false;
		};
	if (typeof(reingreso) == "undefined") {
			var reingreso = false;
		};
	if (typeof(fechaConsulta) == "undefined") {
			var fechaConsulta = new Date("01/01/2000");
		};

	//Fecha de la consulta a media noche
	var fecha1 = new Date(fechaConsulta.getFullYear(), fechaConsulta.getMonth(), fechaConsulta.getDate());

	//Fecha Actual
	var hoy = new Date("09/19/2016");
	var hoy12 = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate()); //Obtener fecha de actual con hora de media noche

	// debug fecha alert(fecha1.getTime()+"-"+hoy12.getTime());

	//tab Paciente	
	var form1 = document.getElementById("idPacienteNuevo_frm");
	var btnEnviarForm1 = document.getElementById("enviarPacienteNuevo_frm");

	var form4 = document.getElementById("idReingreso_frm");
	var btnEnviarForm4 = document.getElementById("enviarReingreso_frm");

	//campos del formulario y sus Divs Padres
	var ide = document.getElementById("identificacion");
	var nom = document.getElementById("nombre");
	var ape = document.getElementById("apellido");
	var eda = document.getElementById("edad");
	var tlf = document.getElementById("telefono");
	var crr = document.getElementById("correo");
	var tdp = document.getElementById("tipoDePago");
	var ent = document.getElementById("entidad");
	var ddp = document.getElementById("documentoDePago");

	var pacA = document.getElementById("pacientesAlta");

	var divIde = document.getElementById("divIdentificacion");
	var divNom = document.getElementById("divNombre");
	var divApe = document.getElementById("divApellido");
	var divEda = document.getElementById("divEdad");
	var divTlf = document.getElementById("divTelefono");
	var divCrr = document.getElementById("divCorreo");
	var divEnt = document.getElementById("divEntidad");

	//tab Nueva Consulta
	var form2 = document.getElementById("idBuscarPaciente_frm");
	var btnEnviarForm2 = document.getElementById("enviarBuscarPaciente_frm");
	var form3 = document.getElementById("idConsultaNueva_frm");
	var btnEnviarForm3 = document.getElementById("enviarConsultaNueva_frm");
	var btnAgregarFisio = document.getElementById("idAgregarFisio");
	var btnAgregarExamen = document.getElementById("idAgregarExamen");
	var btnAgregarFarmaco = document.getElementById("idAgregarFarmaco");
	var btnRemoverFisio = document.getElementById("idRemoverFisio");
	var btnRemoverExamen = document.getElementById("idRemoverExamen");
	var btnRemoverFarmaco = document.getElementById("idRemoverFarmaco"); 

	//campos del formulario y sus Divs Padres
	var ide1 = document.getElementById("identificacion1");
	var inf = document.getElementById("informe");
	var dia = document.getElementById("diagnostico");
	var exaF = document.getElementById("examenFisico");

	var fI = document.getElementById("fechaInicio");
	var nS = document.getElementById("numeroSesiones");
	var exa = document.getElementById("examen");
	var selectFarmaco = document.getElementById("selectFarmaco");
	var hor = document.getElementById("horas");
	var dias = document.getElementById("dias");

	var divIde1 = document.getElementById("divIdentificacion1");

	//Tab Resumen
	var form5 = document.getElementById("idBuscarPaciente1_frm");
	var btnEnviarForm5 = document.getElementById("enviarBuscarPaciente1_frm");

	//Campos de Formularios y sus divs padre
	var ide2 = document.getElementById("identificacion2");

	var divIde2 = document.getElementById("divIdentificacion2");

	//Variables para las funciones de validacion
		var verificar = true;
		//Variable para compatibilidad de datos
		var compatible = false;
		//Expresion regular para un numero de 3 o mas digitos
		var regNumero = /^[0-9][0-9]{1,}[0-9]$/;
		//Expresion regular para un numero de 2 digitos
		var regNumeroDos = /^[0-9][0-9]$/;
		//Expresion regular para un numero de telefono
		var regNumeroTlf = /^[0-9][0-9]{1,3}-{1}[0-9]{1,}[0-9]$/;
		//Expresior regular para nombre con acentos y Ñ
		var regNombre = /^[A-Za-zÑñÁáÉéÍíÓóÚú][A-Za-zÑñÁáÉéÍíÓóÚú]{1,}[A-Za-zÑñÁáÉéÍíÓóÚú]$/;

	
// Declarar Funciones

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

	//Tab  Paciente--Nuevo
	function validarForm1()
	{
		verificar = true;
		//verificar q los campos no esten vacios
		if (!ide.value) {
			ide.focus();
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
		else if (!eda.value) {
			eda.focus();
			verificar = false;
		}
		else if (!tlf.value) {
			tlf.focus();
			verificar = false;
		}
		else if (!crr.value) {
			crr.focus();
			verificar = false;
		}
		else if (tdp.value == 0){
			tdp.focus();
			verificar = false;
		}
		else if (!ent.value){
			ent.focus();
			verificar = false;
		}
		else if (!ddp.value){
			ddp.focus();
			verificar = false;
		}
		//verificar q los campos coincidan con los valores
		validarFormDinamico(regNumero, ide, divIde);
		validarFormDinamico(regNombre, nom, divNom);
		validarFormDinamico(regNombre, ape, divApe);
		validarFormDinamico(regNumeroDos, eda, divEda);
		validarFormDinamico(regNumeroTlf, tlf, divTlf);

		if (verificar == true && compatible == true) 
			{
				//alert("listo");
				document.pacienteNuevo_frm.submit();
				btnEnviarForm1.disabled = true;
			}
		else
			{
				alert("Parece que falta algun dato o los datos introducidos no son correcto");
			}
	}
	//Tab  Paciente--Modificar
	
	function llenarform1M()
	{
		ide.setAttribute("readonly", "");
		tdp.value = valortdp;

		var inputMH = document.createElement("input");
		inputMH.type = "hidden";
		inputMH.id = "modificarPaciente";
		inputMH.name = "modificarPaciente_h";
		inputMH.value = true;

		form1.appendChild(inputMH);

	}
	
	//Tab  Paciente--Reingreso
	
	function llenarform1R()
	{
		ide.setAttribute("readonly", "");
		nom.setAttribute("readonly", "");
		ape.setAttribute("readonly", ""); 
		eda.setAttribute("readonly", ""); 
		tlf.setAttribute("readonly", ""); 
		crr.setAttribute("readonly", "");

		var inputRH = document.createElement("input");
		inputRH.type = "hidden";
		inputRH.id = "reingresarPaciente";
		inputRH.name = "reingresarPaciente_h";
		inputRH.value = true;

		form1.appendChild(inputRH);

	}

	function validarForm4()
	{
		verificar = true;

		if (pacA.value == 0) 
		{
			pacA.focus();
			verificar = false;
		}

		if(verificar == true)
		{
			document.reingreso_frm.submit();
			btnEnviarForm4.disabled = true;
		}
		else
		{
			alert("Debes Seleccionar un paciente primero");
		}


	}



	//tab Consulta--Nueva

	function validarForm2()
	{
		verificar = true;
		//verificar q los campos no esten vacios
		if (!ide1.value) {
			ide1.focus();
			verificar = false;
		}
		//verificar q los campos coincidan con los valores
		validarFormDinamico(regNumero, ide1, divIde1);
		if (verificar == true && compatible == true) 
			{
				//alert("listo");
				document.buscarPaciente_frm.submit();
				btnEnviarForm2.disabled = true;
			}
		else
			{
				alert("Parece que falta algun dato o los datos introducidos no son correcto");
			}
	} 

	//Añadir inputs dinamicos
	var contadorFisio = 0;
	var contadorExamenes = 0;
	var contadorFarmacos = 0;
	var limite = 5;

	function addAllInputs(divName, fecha, numero, examen, farmaco, horas, dias)
	{
		if (contadorFisio == 1 && divName == "divFisio") 
		{
			alert("el limite de fisioterapias por consulta es" + contadorFisio);

		}
		else if (contadorExamenes == limite && divName == "divExamenes")  
		{
			alert("Haz Alcansado el limite de examenes");
		}
		else if (contadorFarmacos == limite && divName == "divFarmacos")  
		{
			alert("Haz Alcansado el limite de medicinas por consulta");
		}
		else 
		{
			switch(divName) 
			{
				case 'divFisio':
					var divForm = document.createElement("div");
					divForm.classList.add("row");
					divForm.id = "rowFisio" + (contadorFisio + 1);


					var divCol = document.createElement("div");
					divCol.classList.add("col-xs-6","col-md-5","col-md-offset-1");

					var divCol1 = document.createElement("div");
					divCol1.classList.add("col-xs-6", "col-md-5");


					var numeroSesiones = document.createElement("div");
					numeroSesiones.classList.add("form-group");

					var inputNS = document.createElement("input");
					inputNS.type = "number";
					inputNS.id = "numeroSesiones" + (contadorFisio + 1);
					inputNS.name = "numeroSesionesArry[]";
					inputNS.value = numero;
					inputNS.setAttribute("min","5");
					inputNS.setAttribute("max","30");
					inputNS.setAttribute("step","5");
					inputNS.setAttribute("readonly", "");
					inputNS.classList.add("form-control");

					var labelInputNS = document.createElement("label");
					labelInputNS.setAttribute("for", "numeroSesiones" + (contadorFisio+1));
					var contenidoLabelInputNS = document.createTextNode("Sesiones - " + (contadorFisio + 1));
					labelInputNS.appendChild(contenidoLabelInputNS);


					var fechaInicio = document.createElement("div");
					fechaInicio.classList.add("form-group");


					var inputFI = document.createElement("input");
					inputFI.type = "text";
					inputFI.id = "fechaInicio" + (contadorFisio + 1);
					inputFI.name = "fechaInicioArry[]";
					inputFI.value = fecha;
					inputFI.setAttribute("readonly", "");
					inputFI.classList.add("form-control");

					var labelInputFI = document.createElement("label");
					labelInputFI.setAttribute("for","fechaInicio" + (contadorFisio + 1));
					var contenidoLabelInputFI = document.createTextNode("Inicio - " + (contadorFisio + 1));
					labelInputFI.appendChild(contenidoLabelInputFI);


					numeroSesiones.appendChild(labelInputNS);
					numeroSesiones.appendChild(inputNS);

					fechaInicio.appendChild(labelInputFI);
					fechaInicio.appendChild(inputFI);

					divCol.appendChild(fechaInicio);
					divCol1.appendChild(numeroSesiones);
					divForm.appendChild(divCol);
					divForm.appendChild(divCol1);

					contadorFisio ++;

				break;
				case 'divExamenes':
					var divForm = document.createElement("div");
					divForm.classList.add("row");
					divForm.id = "rowExamen" + (contadorExamenes + 1);


					var divCol = document.createElement("div");
					divCol.classList.add("col-xs-12","col-md-10","col-md-offset-1");


					var examendiv = document.createElement("div");
					examendiv.classList.add("form-group");


					var label = document.createElement("label");
					label.setAttribute('for', 'examen'+ (contadorExamenes + 1));
					var contenido = document.createTextNode("Examen - " + (contadorExamenes + 1));
					label.appendChild(contenido);

					var input = document.createElement("input");
					input.type = 'text';
					input.id = 'examen'+ (contadorExamenes + 1);
					input.name = 'examenesArry[]';
					input.value = examen;
					input.setAttribute("readonly", "");
					input.classList.add("form-control");

					examendiv.appendChild(label);
					examendiv.appendChild(input);

					divCol.appendChild(examendiv);
					divForm.appendChild(divCol);

					contadorExamenes ++;
				break;
				case 'divFarmacos':

					var divForm = document.createElement("div");
					divForm.classList.add("row");
					divForm.id = "rowFarmaco" + (contadorFarmacos + 1);

					var divCol = document.createElement("div");
					divCol.classList.add("col-xs-12","col-md-6");

					var divCol1 = document.createElement("div");
					divCol1.classList.add("col-xs-12","col-md-3");

					var divCol2 = document.createElement("div");
					divCol2.classList.add("col-xs-12","col-md-3");

					var complejoActivo = document.createElement("div");
					complejoActivo.classList.add("form-group");

					var inputCA = document.createElement("input");
					inputCA.type = "text";
					inputCA.id = "complejoActivo" + (contadorFarmacos + 1);
					inputCA.name = "complejoActivoArry[]";
					inputCA.value = farmaco;
					inputCA.setAttribute("readonly", "");
					inputCA.classList.add("form-control");

					var labelInputCA = document.createElement("label");
					labelInputCA.setAttribute('for','complejoActivo ' + (contadorFarmacos + 1));
					var contenidoLabelInputCA = document.createTextNode("Farmaco - " + (contadorFarmacos + 1));
					labelInputCA.appendChild(contenidoLabelInputCA);


					var intervaloH = document.createElement("div");
					intervaloH.classList.add("form-group");

					var inputNIH = document.createElement("input");
					inputNIH.type = "number";
					inputNIH.id = "intervaloH" + (contadorFarmacos + 1);
					inputNIH.name = "intervaloHArry[]";
					inputNIH.value = horas;
					inputNIH.setAttribute("readonly", "");
					inputNIH.classList.add("form-control");

					var labelInputH = document.createElement("label");
					labelInputH.setAttribute ('for','intervaloH' + (contadorFarmacos + 1));
					var contenidoLabelInputH = document.createTextNode("Horas");
					labelInputH.appendChild(contenidoLabelInputH);

					var intervaloD = document.createElement("div");
					intervaloD.classList.add("form-group");

					var inputNID = document.createElement("input");
					inputNID.type = "number";
					inputNID.id = "intervaloD" + (contadorFarmacos + 1);
					inputNID.name = "intervaloDArry[]";
					inputNID.value = dias;
					inputNID.setAttribute("readonly", "");
					inputNID.classList.add("form-control");

					var labelInputD = document.createElement("label");
					labelInputD.setAttribute ('for','intervaloD' + (contadorFarmacos + 1));
					var contenidoLabelInputD = document.createTextNode("Días");
					labelInputD.appendChild(contenidoLabelInputD);

					complejoActivo.appendChild(labelInputCA);
					complejoActivo.appendChild(inputCA);
					divCol.appendChild(complejoActivo);

					intervaloH.appendChild(labelInputH);
					intervaloH.appendChild(inputNIH);
					divCol1.appendChild(intervaloH);

					intervaloD.appendChild(labelInputD);
					intervaloD.appendChild(inputNID);
					divCol2.appendChild(intervaloD);

					divForm.appendChild(divCol);
					divForm.appendChild(divCol1);
					divForm.appendChild(divCol2);

					contadorFarmacos ++;
					
				break;
			}
			document.getElementById(divName).appendChild(divForm);

		}
	}


	function remAllInputs(divName)
	{
		if (contadorFisio == 0 && contadorExamenes == 0 && contadorFarmacos == 0)  
		{
			alert("No se puede Borar");
		}
		else
		{
			switch(divName)
			{
				case 'divFisio':
					var remover = document.getElementById("rowFisio"+contadorFisio);
					remover.parentNode.removeChild(remover);
					contadorFisio --;
				break;
				case 'divExamenes':
					var remover = document.getElementById("rowExamen"+contadorExamenes);
					remover.parentNode.removeChild(remover);
					contadorExamenes --;
				break;
				case 'divFarmacos':
					var remover = document.getElementById("rowFarmaco"+contadorFarmacos);
					remover.parentNode.removeChild(remover);
					contadorFarmacos --;
				break;
			}
		}
	}



		function validarForm3()
	{
		verificar = true;
		//verificar q los campos no esten vacios
		if (!inf.value) {
			inf.focus();
			verificar = false;
		}
		else if (!exaF.value) {
			exaF.focus();
			verificar = false;
		}
		else if (!dia.value) {
			dia.focus();
			verificar = false;
		}
		
		if (verificar == true) 
			{
				//alert("listo");
				document.consultaNueva_frm.submit();
				btnEnviarForm3.disabled = true;
			}
		else
			{
				alert("Parece que falta algun dato o los datos introducidos no son correcto");
			}
	} 

	//tab Consulta--Modificar
	function llenarform3()
	{
		//ide1.value = "";
		ide1.setAttribute("readonly", "");
		btnEnviarForm2.disabled = true;

		var inputMH = document.createElement("input");
		inputMH.type = "hidden";
		inputMH.id = "modificarConsulta";
		inputMH.name = "modificarConsulta_h";
		inputMH.value = true;

		form3.appendChild(inputMH);

	}	


	//tab Resumen--Buscar

	function validarForm5 ()
	{
		verificar = true;
		//verificar que los campos no esten vacios
		if (!ide2.value) 
		{
			verificar = false
			ide2.focus();
		}
		//verificar q los campos coincidan con los valores
		validarFormDinamico(regNumero, ide2, divIde2);

		if (verificar == true && compatible == true) 
		{	
			document.buscarPaciente1_frm.submit();
			btnEnviarForm5.disabled = true;
		}
		else
		{
			alert("Por Favor Introduzca la Cedula de Identidad del paciente que desea Buscar");
		}

	}


	//Esta funcion solo sirve para tablas con filas de un solo nivel por ahora
	/*
    function doSearch(tabla, searchTerm) {
        var tableReg = document.getElementById(tabla);
        var searchText = document.getElementById(searchTerm).value.toLowerCase();
        for (var i = 1; i < tableReg.rows.length; i++) {
    			var cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
	            var found = false;
	            for (var j = 0; j < cellsOfRow.length && !found; j++) {
	                var compareWith = cellsOfRow[j].innerHTML.toLowerCase();
	                if (searchText.length == 0 || (compareWith.indexOf(searchText) > -1)) {
	                    found = true;
	                }
	            }
	            if (found) {
	                tableReg.rows[i].style.display = '';
	            } else {
	                tableReg.rows[i].style.display = 'none';
	            }
        }
    }
    */



//Definir Eventos
	//tab Paciente Nuevo
	ide.onkeyup = function(){
		validarFormDinamico(regNumero, ide, divIde);	
	}

	nom.onkeyup = function(){
		validarFormDinamico(regNombre, nom, divNom);
	}

	ape.onkeyup = function(){
		validarFormDinamico(regNombre, ape, divApe);
	}

	eda.onkeyup = function(){
		validarFormDinamico(regNumeroDos, eda, divEda);
	}
	tlf.onkeyup = function(){
		validarFormDinamico(regNumeroTlf, tlf, divTlf);
	}

	//Tab Nueva Consulta
	ide1.onkeyup = function(){
		validarFormDinamico(regNumero, ide1, divIde1);	
	}

	btnAgregarFisio.onclick = function(){
		if (!fI.value || !nS.value || (fI.value == 0) || (nS.value == 0)) 
			{
				alert("Debese elegir la fecha de inicio y el numero de sesiones de la fisioterapia");
				fI.focus();
			}
		else
			{
				addAllInputs('divFisio', fI.value, nS.value, null, null, null, null);
				fI.value = null;
				nS.value = null;
			}
		
	}
	btnAgregarExamen.onclick = function(){
		if (!exa.value) 
			{
				alert("Debe proporcionar el nombre del examen antes de agragarlo a la consulta");
				exa.focus();
			}
		else
			{
				addAllInputs('divExamenes', null, null, exa.value , null, null, null);
				exa.value = null;
			}	
		
	}
	btnAgregarFarmaco.onclick = function(){

		
		if (selectFarmaco.value == 0) 
			{
				alert("Porfavor elija un principio activo antes de agregar el farmaco");
				selectFarmaco.focus();
			}
		else
			{
				addAllInputs('divFarmacos', null, null, null, selectFarmaco.value, hor.value, dias.value);
				selectFarmaco.value = 0;
				hor.value = 0;
				dias.value = 0;
			}
		
	}
	btnRemoverFisio.onclick = function(){
		if (contadorFisio == 0)
			{
				alert("No se pueden borrar las fisioterapias ya que no hay ninguna añadida");
			}
		else
			{
				remAllInputs('divFisio');
			}	
	}
	btnRemoverExamen.onclick = function(){
		if (contadorExamenes == 0)
			{
				alert("No se pueden borrar los Examenes ya que no hay ninguno añadido");
			}
		else
			{
				remAllInputs('divExamenes');
			}	
	}
	btnRemoverFarmaco.onclick = function(){
		if (contadorFarmacos == 0)
			{
				alert("No se pueden borrar los Tratamientos farmacologicos ya que no hay ninguno añadido");
			}
		else
			{
				remAllInputs('divFarmacos');
			}	
	}

	//tab Resumen
	ide2.onkeyup = function (){
		validarFormDinamico(regNumero, ide2, divIde2);	
	}

	window.onload = function(){

		

		//activar la tab que quiero por nombre
		//$('.nav-tabs a[href="#menu1"]').tab('show');
		//activar la tab que quiero por el arreglo de posiciones
		$('.nav-tabs li:eq('+ tabControl +') a').tab('show');

		//tab Nuevo Pacinte
		btnEnviarForm1.onclick = validarForm1;
		if (modificar == true && tabControl == 1) 
		{
			llenarform1M()
		}
		else if (modificar == false && reingreso == true && tabControl == 1)
		{
			llenarform1R()
		}
		else if (modificar == true && tabControl == 2)
		{
			inf.disabled = false;
			dia.disabled = false;
			exaF.disabled = false;
			btnAgregarFisio.disabled = false;
			btnAgregarExamen.disabled = false;
			btnAgregarFarmaco.disabled = false;
			btnRemoverFisio.disabled = false;
			btnRemoverExamen.disabled = false;
			btnRemoverFarmaco.disabled = false;

			btnEnviarForm3.disabled = false;

			llenarform3();
		}
		btnEnviarForm4.onclick = validarForm4;

		//tab Nueva Consulta
		btnEnviarForm2.onclick = validarForm2;
		btnEnviarForm3.onclick = validarForm3;

		//tab Resumen
		btnEnviarForm5.onclick = validarForm5;


		//si no se ha consultado ningun paciente
		if ( typeof(pacienteExiste) == "undefined" || typeof(pacienteEstatus) == "undefined") 
		{
			inf.disabled = true;
			dia.disabled = true;
			exaF.disabled = true;
			btnAgregarFisio.disabled = true;
			btnAgregarExamen.disabled = true;
			btnAgregarFarmaco.disabled = true;
			btnRemoverFisio.disabled = true;
			btnRemoverExamen.disabled = true;
			btnRemoverFarmaco.disabled = true;

			btnEnviarForm3.disabled = true;

			pacienteEstatus = 0;
			pacienteExiste = false;

		}
		//Si el paciente necesita la consulta de diagnostico Y acaba de ingresar
		else if (pacienteExiste == true && pacienteEstatus == 1 && fecha1.getTime() == hoy12.getTime() )
		{
			inf.disabled = false;
			dia.disabled = false;
			exaF.disabled = false;
			btnAgregarFisio.disabled = false;
			btnAgregarExamen.disabled = false;
			btnAgregarFarmaco.disabled = false;
			btnRemoverFisio.disabled = false;
			btnRemoverExamen.disabled = false;
			btnRemoverFarmaco.disabled = false;

			btnEnviarForm3.disabled = false;

		}
		//Si el paciente esta en tratamiento y toca la consulta de control hoy
		else if (pacienteExiste == true && pacienteEstatus == 2 && fecha1.getTime() == hoy12.getTime())
		{
			inf.disabled = false;
			dia.disabled = false;
			exaF.disabled = false;
			btnAgregarFisio.disabled = false;
			btnAgregarExamen.disabled = false;
			btnAgregarFarmaco.disabled = false;
			btnRemoverFisio.disabled = false;
			btnRemoverExamen.disabled = false;
			btnRemoverFarmaco.disabled = false;

			btnEnviarForm3.disabled = false;
		}
		//si el paciente existe sin importar el estatus, no hay que modificar y la fecha de hy no es igual a la fecha de la consulta (estatus predefinido)
		else if (pacienteExiste == true && pacienteEstatus != 0 && modificar == false && fecha1.getTime() != hoy12.getTime())
		{
			inf.disabled = true;
			dia.disabled = true;
			exaF.disabled = true;
			btnAgregarFisio.disabled = true;
			btnAgregarExamen.disabled = true;
			btnAgregarFarmaco.disabled = true;
			btnRemoverFisio.disabled = true;
			btnRemoverExamen.disabled = true;
			btnRemoverFarmaco.disabled = true;

			btnEnviarForm3.disabled = true;
		}
		//si el paciente no existe
		else if (pacienteExiste == false)
		{
			inf.disabled = true;
			dia.disabled = true;
			exaF.disabled = true;
			btnAgregarFisio.disabled = true;
			btnAgregarExamen.disabled = true;
			btnAgregarFarmaco.disabled = true;
			btnRemoverFisio.disabled = true;
			btnRemoverExamen.disabled = true;
			btnRemoverFarmaco.disabled = true;

			btnEnviarForm3.disabled = true;

		}

	}

