<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("payroll_model");
		$this->load->helper('form');
    }
	
	/**
	 * Form add payroll
     * @since 3/4/2018
     * @author BMOTTAG
	 */
	public function index()
	{			
		$this->load->model("general_model");
		//project list - (active's items)
		$arrParam = array(
			"table" => "project",
			"order" => "project_name",
			"column" => "project_state",
			"id" => 1
		);
		$data['project'] = $this->general_model->get_basic_search($arrParam);
		
		//search for the last payroll record
		$arrParam = array(
			"idUser" => $this->session->userdata("id"),
			"limit" => 1
		);			
		$data['information'] = $this->general_model->get_payroll($arrParam);

		$view = 'form_add_payroll';
		
		//if the last record doesn't have finish time
		if($data['information'] && $data['information'][0]['finish'] == 0){
			$view = 'form_end_payroll';
		}
		
		$data["view"] = $view;
		$this->load->view("layout", $data);
	}
	
	/**
	 * Save payroll
     * @since 3/4/2018
     * @author BMOTTAG
	 */
	public function savePayroll()
	{			
		$hour = date("G:i");
		
		$start = date('Y-m-d G:i:s');
		$startXXX = strtotime($start);
						
		$ajusteStart = $this->calcular_hora_inicio_ajustada($startXXX);//calculo la hora ajustada por arriba cada 30 minutos
		
		$arrParam = array(
			"start" => $start,
			"ajusteStart" => $ajusteStart
		);
		
		if ($this->payroll_model->savePayroll($arrParam)) {
			$this->session->set_flashdata('retornoExito', 'have a nice shift, you started at ' . $hour . '.');
		} else {
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
		}

		redirect("/dashboard",'refresh');
	}
	
	/**
	 * Update finish time payroll
     * @since 4/4/2018
     * @author BMOTTAG
	 */
	public function updatePayroll()
	{	
		$finish = date('Y-m-d G:i:s');
		$finishXXX = strtotime($finish);
						
		$ajusteFinish = $this->calcular_hora_fin_ajustada($finishXXX);//calculo la hora ajustada final por abajo cada 15 minutos
		
		$arrParam = array(
			"finish" => $finish,
			"ajusteFinish" => $ajusteFinish
		);
	
		if ($this->payroll_model->updatePayroll($arrParam)) 
		{
			//calculo de total de horas trabajadas, valor total y se guarda en la base de datos
			$idPayroll = $this->input->post('hddIdentificador');
			$calculo = $this->calcular_datos($idPayroll);//metodo para calcular horas y sacar el valor total
		
			//busco el periodo sino existe lo creo y guarda el id del periodo en la tabla payroll
			$periodo = $this->buscar_periodo($idPayroll);//metodo para calcular horas y sacar el valor total
			
			//llevo control del horas por proyecto por periodo en la tabla PAYROLL_PROJECT_PERIOD
			//se va sumando las horas por proyecto
			$total = $this->total_proyecto($idPayroll);
			
			//llevo control del horas por periodo en la tabla PAYROLL_TOTAL_PERIOD
			//se va sumando las horas por PERIODO PARA CADA USUARIO y se saca el todal en CAD
			$totalUsuario = $this->total_user($idPayroll);
		
			$hour = date("G:i");
			if ($calculo) {
				$this->session->set_flashdata('retornoExito', 'have a good night, you finished at ' . $hour . '.');
			}else{
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> bad at math.');
			}
			
		} else {
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
		}

		redirect("/dashboard",'refresh');
	}
	
	/**
	 * calculo la hora ajustada por arriba cada 30 minutos
     * @since 21/4/2018
     * @author BMOTTAG
	 */
	public function calcular_hora_inicio_ajustada($start)
	{					
		$fecha = date( 'Y-m-j' , $start );
		$hora = date( 'H' , $start );
		$minutos = date( 'i' , $start );

		//calcular hora inicial con el ajuste de redondear por arriba a cada 30 min
		if($minutos == 0){
			$ajusteStart = $fecha .  " " . $hora . ":" . $minutos;
			$ajusteStart = date("Y-m-j H:i:s", strtotime($ajusteStart));
		}elseif($minutos <= 30){
			$minutos = 30;
			$ajusteStart = $fecha .  " " . $hora . ":" . $minutos;
			$ajusteStart = date("Y-m-j H:i:s", strtotime($ajusteStart));
		}else{
			//si es mas de los 30 minutos enotnces redondeamos a la siguiente hora
			$minutos = 0;
			$ajusteStart = $fecha .  " " . $hora . ":" . $minutos;
			$ajusteStart = date("Y-m-j H:i:s", strtotime($ajusteStart));
			
			$ajusteStart = strtotime ( '+1 hour' , strtotime ( $ajusteStart ) ) ;//le sumo una hora
			$ajusteStart = date("Y-m-j H:i:s", $ajusteStart);
		}
		
		return $ajusteStart;
	}
	
	/**
	 * calculo la hora final ajustada por abajo cada 15 minutos
     * @since 21/4/2018
     * @author BMOTTAG
	 */
	public function calcular_hora_fin_ajustada($finish)
	{					
		$fecha = date( 'Y-m-j' , $finish );
		$hora = date( 'H' , $finish );
		$minutos = date( 'i' , $finish );

		//calcular hora final con el ajuste de redondear por abajo cada 15 min
		if($minutos < 15)
		{
			$minutos = 0;
			$ajusteFinish = $fecha .  " " . $hora . ":" . $minutos;
		}elseif($minutos >= 15 && $minutos < 30){
			$minutos = 15;
			$ajusteFinish = $fecha .  " " . $hora . ":" . $minutos;
		}elseif($minutos >= 30 && $minutos < 45){
			$minutos = 30;
			$ajusteFinish = $fecha .  " " . $hora . ":" . $minutos;
		}else{
			//si es mas de los 30 minutos enotnces redondeamos a la siguiente hora
			$minutos = 45;
			$ajusteFinish = $fecha .  " " . $hora . ":" . $minutos;
			
		}
		$ajusteFinish = date("Y-m-j H:i:s", strtotime($ajusteFinish));
		
		return $ajusteFinish;
	}
	
	/*
	 ************************
	 ************************
	 ** METODOS PARA EL FOREMAN
	 ************************
	 ************************
	 */
	 
	/**
	 * Search by daterange
     * @since 4/4/2018
     * @author BMOTTAG
	 */
    public function search($modulo) 
	{
			if (empty($modulo) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			$this->load->model("general_model");			

			switch ($modulo) {
				case 'payroll':
					$data["titulo"] = "<i class='fa fa-book fa-fw'></i> PAYROLL REPORT";
					break;
				case 'payrollByAdmin':
					$data["titulo"] = "<i class='fa fa-book fa-fw'></i> PAYROLL REPORT";
					//workers list
					$arrParam = array('state' => 1);
					$data['userList'] = $this->general_model->get_user_list($arrParam);//users list
					
					//project list
					$arrParam = array('state' => 1);
					$data['projectList'] = $this->general_model->get_project($arrParam);
					break;
			}
			
			$data["view"] = "form_search";
			
			//Si envian los datos del filtro entonces lo direcciono a la lista respectiva con los datos de la consulta
			if($this->input->post('datetimepicker_from')){
				$data['from'] =  $this->input->post('datetimepicker_from');
				
				//le sumo un dia al dia final para que ingrese ese dia en la consulta
				$data['to'] = date('Y-m-d',strtotime ( '+1 day ' , strtotime ( $this->input->post('datetimepicker_to') ) ) );
				
				$data['user'] =  $this->input->post('user');
				$data['user'] = $data['user']==''?'x':$data['user'];
				
				$data['project'] =  $this->input->post('project');
				$data['project'] = $data['project']==''?'x':$data['project'];
				
				$arrParam = array(
					"from" => $data['from'],
					"to" => $data['to'],
					"idUser" => $data['user'],
					"idProject" => $data['project']
				);

				switch ($modulo) {
					case 'payroll':
						$data['info'] = $this->general_model->get_payroll($arrParam);
						$data["view"] = "list_payroll";
						$data["modulo"] = $modulo;
						break;
					case 'payrollByAdmin':
						$data['info'] = $this->general_model->get_payroll($arrParam);
						$data["view"] = "list_payroll";
						$data["modulo"] = $modulo;
						break;
				}
				
			}

			$this->load->view("layout", $data);
    }
	
    /**
     * Cargo modal- formulario para editar las horas de los empleados
     * @since 5/4/2018
     */
    public function cargarModalHours() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$this->load->model("general_model");

			//busco inicio y fin para calcular horas de trabajo y guardar en la base de datos
			//START search info for the task
			$arrParam = array(
				"idPayroll" => $this->input->post('idPayroll')
			);
			$data['information'] = $this->general_model->get_payroll($arrParam);
			//END of search				
						
			$this->load->view("modal_hours_worker", $data);
    }
	
	/**
	 * Save payroll hours
     * @since 5/4/2018
     * @author BMOTTAG
	 */
	public function savePayrollHour()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$fechaStart = $this->input->post('start_date');
			$fechaFinish = $this->input->post('finish_date');
			
			$horaStart = $this->input->post('hora_inicio');
			$horaStart = date("H:i:s", strtotime($horaStart));
			
			$horaFinish = $this->input->post('hora_final');
			$horaFinish = date("H:i:s", strtotime($horaFinish));
			
			$fechaStart = $fechaStart . " " . $horaStart;
			$fechaFinish = $fechaFinish . " " . $horaFinish; 
	
			$startXXX = strtotime($fechaStart);
			$finishXXX = strtotime($fechaFinish);
						
			$ajusteStart = $this->calcular_hora_inicio_ajustada($startXXX);//calculo la hora ajustada por arriba cada 30 minutos
								
			$ajusteFinish = $this->calcular_hora_fin_ajustada($finishXXX);//calculo la hora ajustada final por abajo cada 15 minutos
			
			$arrParam = array(
				"start" => $fechaStart,
				"ajusteStart" => $ajusteStart,
				"finish" => $fechaFinish,
				"ajusteFinish" => $ajusteFinish
			);
			
			if ($this->payroll_model->savePayrollHour($arrParam)) 
			{
				//como se esta editando tengo que ver el valor de total de WORKING HOURS anterior para hacer el ajuste
				//en la tabla de payroll_project_period
				//si la fecha final es 0 entonces no hay calculos y se puede hacer normal
				//si es diferente de 0 entonces si hay informacion
				$this->load->model("general_model");
				$idPayroll = $this->input->post('hddIdentificador');
				$arrParam = array("idPayroll" => $idPayroll);			
				$infoPayrollAnterior = $this->general_model->get_payroll($arrParam);
				$workingHoursAnteriores = $infoPayrollAnterior[0]['working_hours'];
				
				//calculo de total de horas trabajadas, valor total y se guarda en la base de datos
				$calculo = $this->calcular_datos($idPayroll);//metodo para calcular horas y sacar el valor total
				
				//busco el periodo sino existe lo creo y guarda el id del periodo en la tabla payroll
				$periodo = $this->buscar_periodo($idPayroll);//metodo para calcular horas y sacar el valor total
				
				//llevo control del horas por proyecto por periodo en la tabla PAYROLL_PROJECT_PERIOD
				//se va sumando las horas por proyecto y se saca el todal en CAD
				$total = $this->total_proyecto($idPayroll, $workingHoursAnteriores);
			
				$hour = date("G:i");
				if ($calculo) {
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', 'You have update the payroll hour');
				}else{
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> bad at math.');
				}
				
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }
	
	/**
	 * Add payroll
     * @since 18/4/2018
     * @author BMOTTAG
	 */
	public function payroll_advanced()
	{
			$data['information'] = FALSE;
			
			$this->load->model("general_model");
			$arrParam = array("state" => 1);
			$data['userList'] = $this->general_model->get_user_list($arrParam);//listado de usuarios
			
			//project list - (active's items)
			$arrParam = array(
				"table" => "project",
				"order" => "project_name",
				"column" => "project_state",
				"id" => 1
			);
			$data['project'] = $this->general_model->get_basic_search($arrParam);
		
			$data["view"] = "form_payroll_advanced";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar payroll
     * @since 18/4/2018
	 */
	public function save_payroll_advanced()
	{			
			header('Content-Type: application/json');
			
			$idPayroll = $this->input->post('hddId');

			$msj = "You have add a Payroll!!";
			if ($idPayroll != '') {
				$msj = "You have update the Payroll!!";
			}	
			
			$fechaStart = $this->input->post('start_date');
			$fechaFinish = $this->input->post('finish_date');
			
			$horaStart = $this->input->post('hora_inicio');
			$horaStart = date("H:i:s", strtotime($horaStart));
			
			$horaFinish = $this->input->post('hora_final');
			$horaFinish = date("H:i:s", strtotime($horaFinish));
			
			$fechaStart = $fechaStart . " " . $horaStart;
			$fechaFinish = $fechaFinish . " " . $horaFinish; 
			
			$startXXX = strtotime($fechaStart);
			$finishXXX = strtotime($fechaFinish);
						
			$ajusteStart = $this->calcular_hora_inicio_ajustada($startXXX);//calculo la hora ajustada por arriba cada 30 minutos
								
			$ajusteFinish = $this->calcular_hora_fin_ajustada($finishXXX);//calculo la hora ajustada final por abajo cada 15 minutos
			
			$arrParam = array(
				"start" => $fechaStart,
				"ajusteStart" => $ajusteStart,
				"finish" => $fechaFinish,
				"ajusteFinish" => $ajusteFinish
			);

			if ($idPayroll = $this->payroll_model->savePayrollAdvanced($arrParam)) 
			{
				//calculo de total de horas trabajadas, valor total y se guarda en la base de datos
				$calculo = $this->calcular_datos($idPayroll);//metodo para calcular horas y sacar el valor total
				
				//busco el periodo sino existe lo creo y guarda el id del periodo en la tabla payroll
				$periodo = $this->buscar_periodo($idPayroll);//metodo para calcular horas y sacar el valor total
				
				//llevo control del horas por proyecto por periodo en la tabla PAYROLL_PROJECT_PERIOD
				//se va sumando las horas por proyecto y se saca el todal en CAD
				$total = $this->total_proyecto($idPayroll);
			
				if ($calculo) {
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', $msj);
				}else{
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> bad at math.');
				}
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help, contact the Admin.');
			}
			
			echo json_encode($data);
    }
	 
	/**
	 * Calculo de horas trabajadas y valor total y se guarda en la base dedatos
     * @since 24/4/2018
	 */
    function calcular_datos($idPayroll) 
	{
			//info for the payroll
			$this->load->model("general_model");
			$arrParam = array("idPayroll" => $idPayroll);			
			$infoPayroll = $this->general_model->get_payroll($arrParam);
			
			$dteStart = new DateTime($infoPayroll[0]['adjusted_start']);
			$dteEnd   = new DateTime($infoPayroll[0]['adjusted_finish']);
			
			$dteDiff  = $dteStart->diff($dteEnd);
			$workingTime = $dteDiff->format("%R%a days %H:%I:%S");//days hours:minutes:seconds
		
			//START hours calculation
			$minutes = (strtotime($infoPayroll[0]['adjusted_finish'])-strtotime($infoPayroll[0]['adjusted_start']))/60;
			$minutes = abs($minutes);  
			$minutes = round($minutes);
	
			$hours = $minutes/60;
			$hours = round($hours,2);
			
			$justHours = intval($hours);
			$decimals=$hours-$justHours; 

			//Ajuste de los decimales para redondearlos a .25 / .5 / .75
			if($decimals<0.12){
				$transformation = 0;
			}elseif($decimals>=0.12 && $decimals<0.37){
				$transformation = 0.25;
			}elseif($decimals>=0.37 && $decimals<0.62){
				$transformation = 0.5;
			}elseif($decimals>=0.62 && $decimals<0.87){
				$transformation = 0.75;
			}elseif($decimals>=0.87){
				$transformation = 1;
			}
			$workingHours = $justHours + $transformation;
			//FINISH hours calculation
			
			$arrParam = array(
				"idPayroll" => $idPayroll,
				"workingTime" => $workingTime,
				"workingHours" => $workingHours
			);

			if ($this->payroll_model->updateWorkingTimePayroll($arrParam)) {
				return TRUE;
			}else{
				return FALSE;
			}
    }
	
	/**
	 * Busco a que periodo pertenece y se guarda el id periodo en la tabla de payroll
     * @since 26/4/2018
	 */
    function buscar_periodo($idPayroll) 
	{
			//info for the payroll
			$this->load->model("general_model");
			$arrParam = array("idPayroll" => $idPayroll);			
			$infoPayroll = $this->general_model->get_payroll($arrParam);//informacion del payroll
			
			$start = strtotime($infoPayroll[0]['adjusted_start']);
			$fechaStart = date( 'Y-m-j' , $start );
			
			$arrParam = array("limit" => 1);	
			$infoPeriod = $this->general_model->get_period($arrParam);//lista de periodos los ultimos 2
			
			
			//valido si la fecha esta dentro del ultimo periodo
			
			$fechaStart = date_create($fechaStart);
			$periodoIni = date_create($infoPeriod[0]['date_start']);
			$periodoFin = date_create($infoPeriod[0]['date_finish']);
			
			if($fechaStart >= $periodoIni && $fechaStart <= $periodoFin) {
				//esta dentro del periodo entonces saco el id del periodo
				$idPeriod = $infoPeriod[0]['id_period'];
				
				
			}else{
				//no esta dentro del periodo entonces se debe generar el nuevo periodo
				//fecha inicial del siguiente period se le suma un dia a la fecha final del periodo anterior
				//fecha final del siguiente periodo se le suma 14 dias a la fecha final del periodo anterior				
				$periodoIniNew = date('Y-m-d', strtotime ( '+1 day ' , strtotime ( $infoPeriod[0]['date_finish'] ) ) );//le sumo un dia 
				$periodoFinNew = date('Y-m-d',strtotime ( '+14 day ' , strtotime ( $infoPeriod[0]['date_finish'] ) ) );//le sumo 14 dias
				
				//guardo el nuevo periodo y saco el id guardado
				$arrParam = array(
					"periodoIniNew" => $periodoIniNew,
					"periodoFinNew" => $periodoFinNew
				);

				$idPeriod = $this->payroll_model->savePeriod($arrParam);				
			}
		
			//guardo el id en la tabla payroll			
			$arrParam = array(
				"table" => "payroll",
				"primaryKey" => "id_payroll",
				"id" => $idPayroll,
				"column" => "fk_id_period",
				"value" => $idPeriod
			);
			$this->load->model("general_model");
			
			//guardo el id en la tabla payroll	
			if ($this->general_model->updateRecord($arrParam)) {
				return TRUE;
			}else{
				return FALSE;
			}
    }
	
	/**
	 * Calculo de total de horas trabajadas por un usuario en un proyecto en un periodo
     * @since 26/4/2018
	 */
    function total_proyecto($idPayroll, $workingHoursAnteriores = 0 ) 
	{
			//info for the payroll
			$this->load->model("general_model");
			$arrParam = array("idPayroll" => $idPayroll);			
			$infoPayroll = $this->general_model->get_payroll($arrParam);//informacion del payroll
			
			$idUser = $infoPayroll[0]['fk_id_user'];
			$idProject = $infoPayroll[0]['fk_id_project'];
			$idPeriod = $infoPayroll[0]['fk_id_period'];			
			$workingHours = $infoPayroll[0]['working_hours'];

			//buscar informacion anterior en la tabla PAYROLL_PROJECT_PERIOD
			$arrParamFiltro = array(
				"idUser" => $idUser,
				"idProject" => $idProject,
				"idPeriod" => $idPeriod
			);
			$infoProjectPeriod = $this->general_model->get_project_period($arrParamFiltro);
			
			if($infoProjectPeriod){
				$totalHorasAnterior = $infoProjectPeriod[0]['total_hours'];
				$idProjectPeriod = $infoProjectPeriod[0]['id_project_period'];
			}else{
				$totalHorasAnterior = 0;
				$idProjectPeriod = '';
			}

			//numero de horas totales para este proyecto
			$totalHorasNuevo = $totalHorasAnterior + $workingHours - $workingHoursAnteriores; //suma total anterior mas el nuevo registro -las horas que tenia antes si se esta editando el registro

			
			//guardo informacion en la base de datos
			$arrParam = array(
				"idProjectPeriod" => $idProjectPeriod,
				"idUser" => $idUser,
				"idProject" => $idProject,
				"idPeriod" => $idPeriod,
				"hotalHoras" => $totalHorasNuevo
			);

			if ($this->payroll_model->updatePayrollProjectPeriod($arrParam)) {
				return TRUE;
			}else{
				return FALSE;
			}
    }
	
	/**
	 * Calculo de total de horas trabajadas por un usuario en un periodo
     * @since 2/5/2018
	 */
    function total_user($idPayroll, $workingHoursAnteriores = 0 ) 
	{
			//info for the payroll
			$this->load->model("general_model");
			$arrParam = array("idPayroll" => $idPayroll);			
			$infoPayroll = $this->general_model->get_payroll($arrParam);//informacion del payroll
			
			$idUser = $infoPayroll[0]['fk_id_user'];
			$idPeriod = $infoPayroll[0]['fk_id_period'];			
			$workingHours = $infoPayroll[0]['working_hours'];

			//buscar informacion anterior en la tabla PAYROLL_TOTAL_PERIOD
			$arrParamFiltro = array(
				"idUser" => $idUser,
				"idPeriod" => $idPeriod
			);
			$infoTotalPeriod = $this->general_model->get_total_period($arrParamFiltro);
			
			if($infoTotalPeriod){
				$totalHorasAnterior = $infoTotalPeriod[0]['total_hours'];
				$idTotalPeriod = $infoTotalPeriod[0]['id_total_period'];
			}else{
				$totalHorasAnterior = 0;
				$idTotalPeriod = '';
			}
			
			//***** REVISAR QUE TIPO DE USUARIO ES ******
			//si es subcontractor el totla es mas el 5% de GST del subtotal
			//si es casual es el mismo valor
			//si es payroll se debe hacer calculo
						
			//buscar informacion del usuario
			$arrParam = array("idUser" => $infoPayroll[0]['fk_id_user']);
			$infoUser = $this->general_model->get_user_list($arrParam);	

			$tipoUsuario = $infoUser[0]['fk_id_type'];
			$valorHora = $infoUser[0]['hora_real_cad'];
			$valorHoraLMIA = $infoUser[0]['hora_contrato_cad'];
			$noHorasMaximo = $infoUser[0]['no_horas_max'];
			
			//numero de horas totales para este periodo
			$totalHorasNuevo = $totalHorasAnterior + $workingHours - $workingHoursAnteriores; //suma total anterior mas el nuevo registro menos las horas que tenia antes si se esta editando el registro

			$lessMaxHours = 0;
			$overMaxHours = 0;
			$casualAmount = 0;
			$GST = 0;
			switch ($tipoUsuario) {
				case 1://subcontractor: el total se le suma el 5% del GST del subtotal					
					$grossAmount = $totalHorasNuevo * $valorHora;//subtotal: total horas proyecto por el valor de la hora
					$GST = 0.05 * $grossAmount;
					$valorTotal = $grossAmount + $GST;
					break;
				case 2://casual: si horas mayor a $numeroMaximoHoras entonces se se pagan el resto por casual
					$lessMaxHours = $totalHorasNuevo;
					if($totalHorasNuevo > $noHorasMaximo){
						$lessMaxHours = $noHorasMaximo;
						$overMaxHours = $totalHorasNuevo - $noHorasMaximo;
					}
				
					$grossAmount = $lessMaxHours * $valorHora;
					$casualAmount = $overMaxHours * $valorHora;
					$valorTotal = $grossAmount + $casualAmount;
					break;
				case 3://payroll:
					$lessMaxHours = $totalHorasNuevo;
					if($totalHorasNuevo > $noHorasMaximo){
						$lessMaxHours = $noHorasMaximo;
						$overMaxHours = $lessMaxHours - $noHorasMaximo;
					}
								
					/* Revisar que se hace con LMIA
					if($valorHoraLMIA > 0){
						$conversionHours = $lessMaxHours * $valorHora / $valorHoraLMIA;
						$grossAmount = $conversionHours * $valorHoraLMIA;
					}
					*/

					$grossAmount = $lessMaxHours * $valorHoraLMIA;
					$casualAmount = $overMaxHours * $valorHoraLMIA;
					$valorTotal = $grossAmount + $casualAmount;
					break;
			}
			
			//guardo informacion en la base de datos
			$arrParam = array(
				"idTotalPeriod" => $idTotalPeriod,
				"idUser" => $idUser,
				"idPeriod" => $idPeriod,
				"hotalHoras" => $totalHorasNuevo,
				"valorHora" => $valorHora,
				"valorHoraLMIA" => $valorHoraLMIA,
				"noHorasMaximo" => $noHorasMaximo,
				"lessMaxHours" => $lessMaxHours,
				"overMaxHours" => $overMaxHours,
				"grossAmount" => $grossAmount,
				"casualAmount" => $casualAmount,
				"GST" => $GST,
				"valorTotal" => $valorTotal
			);

			if ($this->payroll_model->updatePayrollTotalPeriod($arrParam)) {
				return TRUE;
			}else{
				return FALSE;
			}
    }
	 
	 
	
}