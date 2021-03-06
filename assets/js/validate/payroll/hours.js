$( document ).ready( function () {
	
jQuery.validator.addMethod("validacion", function(value, element, param) {
	
	var start_date = $('#start_date').val();
	var start_hour = $('#hora_inicio').val();
	var finish_date = $('#hora_final').val();
	var finish_hour = $('#finish_hour').val();
	
	var hddfechaInicio = $('#hddfechaInicio').val();
	var hddhoraInicio = $('#hddhoraInicio').val();
	var hddfechaFin = $('#hddfechaFin').val();
	var hddhoraFin = $('#hddhoraFin').val();

	
	if (hddfechaInicio == start_date &&  hddhoraInicio == start_hour &&  hddfechaFin == finish_date &&  hddhoraFin == finish_hour) {
		return false;
	}else{
		return true;
	}
}, "One of the field have to be different.");

	$("#observation").convertirMayuscula();
	
	$( "#formWorker" ).validate( {
		rules: {
			start_date:	 			{ required: true },
			hora_inicio: 			{ required: true },
			finish_date:			{ required: true },
			hora_final:		 		{ required: true },
			observation:	 		{ required: true, validacion:true }
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );
			error.insertAfter( element );

		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-6" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-6" ).addClass( "has-success" ).removeClass( "has-error" );
		},
		submitHandler: function (form) {
			return true;
		}
	});
	
	$("#btnSubmit").click(function(){		
	
		if ($("#formWorker").valid() == true){
		
				//Activa icono guardando
				$('#btnSubmitWorker').attr('disabled','-1');
				$("#div_error").css("display", "none");
				$("#div_load").css("display", "inline");
			
				$.ajax({
					type: "POST",	
					url: base_url + "payroll/savePayrollHour",	
					data: $("#formWorker").serialize(),
					dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
                                            
						if( data.result == "error" )
						{
							$("#div_load").css("display", "none");
							$('#btnSubmitWorker').removeAttr('disabled');							
							return false;
						} 

						if( data.result )//true
						{	                                                        
							$("#div_load").css("display", "none");
							$('#btnSubmitWorker').removeAttr('disabled');

							var url = base_url + "payroll/search/payrollByAdmin";
							$(location).attr("href", url);
						}
						else
						{
							alert('Error. Reload the web page.');
							$("#div_load").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnSubmitWorker').removeAttr('disabled');
						}	
					},
					error: function(result) {
						alert('Error. Reload the web page.');
						$("#div_load").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnSubmitWorker').removeAttr('disabled');
					}
					
		
				});	
		
		}//if			
	});
});