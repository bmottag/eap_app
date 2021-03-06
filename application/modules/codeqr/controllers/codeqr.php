<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Codeqr extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("codeqr_model");
		$this->load->helper('form');
    }

	/**
	 * QR CODE
     * @since 6/4/2018
     * @author BMOTTAG
	 */
	public function index()
	{		
			$this->load->model("general_model");
			$arrParam = array();
			$data['info'] = $this->general_model->get_qr_code($arrParam);
			
			$data["view"] = 'qr_code';
			$this->load->view("layout", $data);
	}	
	
    /**
     * Cargo modal - formulario qr code
     * @since 6/4/2018
     */
    public function cargarModalQrcode() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$idQRCode = $this->input->post("idQRCode");	
			
			$this->load->model("general_model");
			$data['usuarios'] = $this->general_model->user_without_qrcode();//listado usuarios sin codigo QR
			
			if ($idQRCode != 'x') {
				$arrParam = array(
					"idQRCode" => $idQRCode
				);
				$data['information'] = $this->general_model->get_qr_code($arrParam);
			}
			
			$this->load->view("qr_code_modal", $data);
    }
	
	/**
	 * Update QR code
     * @since 6/4/2018
     * @author BMOTTAG
	 */
	public function save_qr_code()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idQRCode = $this->input->post('hddId');
			
			$msj = "You have add a new QR Code!!";
			if ($idQRCode != '') {
				$msj = "You have update a QR Code!!";
			}
			
			//verificar si ya existe el valor para el codigo
			$arrParam = array(
				"idQRCode" => $idQRCode
			);
			$result_qrcode = $this->codeqr_model->verifyQRCode($arrParam);
			
			if ($result_qrcode) {
				$data["result"] = "error";
				$data["mensaje"] = " Error. The QR code value already exist.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> The QR code value already exist.');
			} else {
		
				$pass = $this->generaPass();//clave para colocarle al codigo QR
				
				$value = $this->input->post('qr_code');
				$encryption = $value . $pass;
				$rutaImagen = "images/qrcode/" . $value . ".png";
				$valorQRcode = base_url("login/qrcodeLogin/" . $encryption);
						
				if ($idQRCode = $this->codeqr_model->saveQRCode($encryption)) 
				{
					//INCIO - genero imagen con la libreria y la subo 
					$this->load->library('ciqrcode');

					$params['data'] = $valorQRcode;
					$params['level'] = 'H';
					$params['size'] = 10;
					$params['savename'] = FCPATH.$rutaImagen;
									
					$this->ciqrcode->generate($params);
					//FIN - genero imagen con la libreria y la subo 				
					
					$data["result"] = true;
					$data["idRecord"] = $idQRCode;
					
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$data["result"] = "error";
					$data["idRecord"] = "";
					
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				}
				
			}

			echo json_encode($data);
    }
	
	public function generaPass()
	{
			//Se define una cadena de caractares. Te recomiendo que uses esta.
			$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
			//Obtenemos la longitud de la cadena de caracteres
			$longitudCadena=strlen($cadena);
			 
			//Se define la variable que va a contener la contraseña
			$pass = "";
			//Se define la longitud de la contraseña, en mi caso 30, pero puedes poner la longitud que quieras
			$longitudPass=30;
			 
			//Creamos la contraseña
			for($i=1 ; $i<=$longitudPass ; $i++){
				//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
				$pos=rand(0,$longitudCadena-1);
			 
				//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
				$pass .= substr($cadena,$pos,1);
			}
			return $pass;
	}
	
    /**
     * actualizamos el campo usuario del codigo QR
     */
    public function update_usuario($idQRCode) 
	{
			if (empty($idQRCode) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			//actualizamos el campo usuario de QR CODE
			$arrParam = array(
				"table" => "param_qr_code",
				"primaryKey" => "id_qr_code",
				"id" => $idQRCode,
				"column" => "fk_id_user",
				"value" => ""
			);

			$this->load->model("general_model");

			if ($this->general_model->updateRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'The user was deleted.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			redirect(base_url('codeqr'), 'refresh');
    }
	

	
}