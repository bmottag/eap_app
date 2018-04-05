<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Clase para consultas generales a una tabla
 */
class General_model extends CI_Model {

		/**
		 * Consulta BASICA A UNA TABLA
		 * @param $TABLA: nombre de la tabla
		 * @param $ORDEN: orden por el que se quiere organizar los datos
		 * @param $COLUMNA: nombre de la columna en la tabla para realizar un filtro (NO ES OBLIGATORIO)
		 * @param $VALOR: valor de la columna para realizar un filtro (NO ES OBLIGATORIO)
		 * @since 8/11/2016
		 */
		public function get_basic_search($arrData) {
			if ($arrData["id"] != 'x')
				$this->db->where($arrData["column"], $arrData["id"]);
			$this->db->order_by($arrData["order"], "ASC");
			$query = $this->db->get($arrData["table"]);

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else
				return false;
		}
		
		/**
		 * Update field in a table
		 * @since 25/5/2017
		 */
		public function updateRecord($arrDatos) {
				$data = array(
					$arrDatos ["column"] => $arrDatos ["value"]
				);
				$this->db->where($arrDatos ["primaryKey"], $arrDatos ["id"]);
				$query = $this->db->update($arrDatos ["table"], $data);
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Delete Record
		 * @since 25/5/2017
		 */
		public function deleteRecord($arrDatos) 
		{
				$query = $this->db->delete($arrDatos ["table"], array($arrDatos ["primaryKey"] => $arrDatos ["id"]));
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Active User list
		 * @since 25/3/2018
		 */
		public function get_user_list($arrData) 
		{
			if (array_key_exists("idUser", $arrData)) {
				$this->db->where('U.id_user', $arrData["idUser"]);
			}
			if (array_key_exists("idRol", $arrData)) {
				$this->db->where('U.fk_id_rol', $arrData["idRol"]);
			}
			if (array_key_exists("state", $arrData)) {
				$this->db->where('U.state', $arrData["state"]);
			}
			$this->db->join('param_rol R', 'R.id_rol = U.fk_id_rol', 'INNER');
			$this->db->order_by("U.first_name, U.last_name", "ASC");
			$query = $this->db->get("user U");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else
				return false;
		}
		
		/**
		 * Payroll list
		 * Modules: Dashboard - Payroll
		 * @since 3/4/2018
		 */
		public function get_payroll($arrData) 
		{
			$this->db->select('P.*, id_user, CONCAT(U.first_name, " " , U.last_name) employee, log_user, J.project_name');
			$this->db->join('user U', 'U.id_user = P.fk_id_user', 'INNER');
			$this->db->join('project J', 'J.id_project = P.fk_id_project', 'INNER');
			
			if (array_key_exists("idUser", $arrData) && $arrData["idUser"] != 'x') {
				$this->db->where('U.id_user', $arrData["idUser"]);
			}
			if (array_key_exists("idProject", $arrData) && $arrData["idProject"] != 'x') {
				$this->db->where('fk_id_project', $arrData["idProject"]);
			}
			if (array_key_exists("idPayroll", $arrData)) {
				$this->db->where('id_payroll', $arrData["idPayroll"]);
			}
			if (array_key_exists("from", $arrData)) {
				$this->db->where('start >=', $arrData["from"]);
			}				
			if (array_key_exists("to", $arrData)) {
				$this->db->where('start <=', $arrData["to"]);
			}
			
			$this->db->order_by('id_payroll', 'desc');
			
			if (array_key_exists("limit", $arrData)) {
				$query = $this->db->get('payroll P', $arrData["limit"]);
			}else{
				$query = $this->db->get('payroll P');
			}

			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
		}
		
		/**
		 * Project list
		 * @since 4/4/2018
		 */
		public function get_project($arrData) 
		{
			if (array_key_exists("idProject", $arrData)) {
				$this->db->where('id_project', $arrData["idProject"]);
			}
			if (array_key_exists("state", $arrData)) {
				$this->db->where('project_state', $arrData["state"]);
			}
			$this->db->where('id_project !=', 0);

			$this->db->order_by("project_name", "ASC");
			$query = $this->db->get("project");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else
				return false;
		}
	
		

}