<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Codeqr_model extends CI_Model {

	    		
		/**
		 * Add/Edit QR CODE
		 * @since 23/7/2017
		 */
		public function saveQRCode($encryption) 
		{
				$idQRCode = $this->input->post('hddId');
				$value = $this->input->post('qr_code');
				
				$data = array(
					'value_qr_code' => $this->input->post('qr_code'),
					'image_qr_code' => 'images/qrcode/' . $value . ".png",
					'encryption' => $encryption,
					'qr_code_state' => $this->input->post('state')
				);
				
				//verificar que traiga datos de usuario de lo contrario no guarde nada
				$user = $this->input->post('user');
				if($user != ''){
					$data['fk_id_user'] = $this->input->post('user');
				}
				
				//revisar si es para adicionar o editar
				if ($idQRCode == '') {
					$query = $this->db->insert('param_qr_code', $data);
					$idQRCode = $this->db->insert_id();				
				} else {
					$this->db->where('id_qr_code', $idQRCode);
					$query = $this->db->update('param_qr_code', $data);
				}
				if ($query) {
					return $idQRCode;
				} else {
					return false;
				}
		}
				
		/**
		 * Verify if the qrcode already exist
		 * @author BMOTTAG
		 * @since  6/4/2018
		 */
		public function verifyQRCode($arrData) 
		{
				$value = $this->input->post('qr_code');
				if (array_key_exists("idQRCode", $arrData)) {
					$this->db->where('id_qr_code !=', $arrData["idQRCode"]);
				}	
				
				$this->db->where("value_qr_code", $value);
				$query = $this->db->get("param_qr_code");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}	
	
		
		
		
		
	    
	}