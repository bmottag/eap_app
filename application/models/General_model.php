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
				$this->db->select('U.*, CONCAT(U.first_name, " " , U.last_name) name, R.*, T.*');
				if (array_key_exists("idUser", $arrData)) {
					$this->db->where('U.id_user', $arrData["idUser"]);
				}
				if (array_key_exists("idRol", $arrData)) {
					$this->db->where('U.fk_id_rol', $arrData["idRol"]);
				}
				if (array_key_exists("administradores", $arrData)) {
					$valores = array(1, 2);
					$this->db->where_in('U.fk_id_rol', $valores);
				}
				if (array_key_exists("state", $arrData)) {
					$this->db->where('U.state', $arrData["state"]);
				}
				$this->db->join('param_user_type T', 'T.id_type = U.fk_id_type', 'INNER');
				$this->db->join('param_rol R', 'R.id_rol = U.fk_id_rol', 'INNER');
				$this->db->order_by("U.first_name, U.last_name", "ASC");
				$query = $this->db->get("user U");

				if ($query->num_rows() >= 1) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Payroll list
		 * Modules: Dashboard - Payroll
		 * @since 3/4/2018
		 */
		public function get_payroll($arrData) 
		{
				$rol = $this->session->userdata['rol'];
				$idUser = $this->session->userdata['id'];
			
				$this->db->select('P.*, id_user, CONCAT(U.first_name, " " , U.last_name) employee, log_user, J.project_name');
				$this->db->join('user U', 'U.id_user = P.fk_id_user', 'INNER');
				$this->db->join('project J', 'J.id_project = P.fk_id_project', 'INNER');
				
				if (array_key_exists("idUser", $arrData) && $arrData["idUser"] != 'x') {
					$this->db->where('U.id_user', $arrData["idUser"]);
				}
				if (array_key_exists("idProject", $arrData) && $arrData["idProject"] != 'x') {
					$this->db->where('fk_id_project', $arrData["idProject"]);
				}elseif($rol == 2 && !array_key_exists("idUser", $arrData)){
					$this->db->where('J.fk_id_user_foreman', $idUser);
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
		 * Get listado de proyectos en los que trabajo el usuario en los ultimos 30 dias
		 * @since 13/4/2018
		 */
		public function get_proyect_list($arrData)
		{		
				$rol = $this->session->userdata['rol'];
				$idUser = $this->session->userdata['id'];
		
				$this->db->select('distinct(fk_id_project), project_name');
				$this->db->join('user U', 'U.id_user = P.fk_id_user', 'INNER');
				$this->db->join('project J', 'J.id_project = P.fk_id_project', 'INNER');

				if (array_key_exists("idUser", $arrData) && $arrData["idUser"] != 'x') {
					$this->db->where('U.id_user', $arrData["idUser"]);
				}else{
					//si no envian usuario es porque es un foreman o un administrador
					//entonces se filtra desde primer dia del año en curso
					$year = date('Y');
					$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));
					
					$this->db->where('P.start >=', $firstDay);
				}
				$this->db->order_by('J.project_name', 'asc');
				
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
				$rol = $this->session->userdata['rol'];
				$idUser = $this->session->userdata['id'];
				
				$this->db->select('P.*, C.company_name, C.id_company, CONCAT(U.first_name, " " , U.last_name) foreman');
				$this->db->join('param_company C', 'C.id_company = P.fk_id_company', 'INNER');
				$this->db->join('user U', 'U.id_user = P.fk_id_user_foreman', 'INNER');
				
				if (array_key_exists("idProject", $arrData)) {
					$this->db->where('id_project', $arrData["idProject"]);
				}
				if (array_key_exists("state", $arrData)) {
					$this->db->where('project_state', $arrData["state"]);
				}
				//si es un foreman entonces se filtra la lista de proyectos asignados a ese foreman
				if($rol == 2){
					$this->db->where('P.fk_id_user_foreman', $idUser);
				}
				
				$this->db->where('id_project !=', 0);

				$this->db->order_by("project_name", "ASC");
				$query = $this->db->get("project P");

				if ($query->num_rows() >= 1) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * QR CODE list
		 * @since 6/4/2018
		 */
		public function get_qr_code($arrData) 
		{
				$this->db->select('Q.*, id_user, CONCAT(U.first_name, " " , U.last_name) name');
				$this->db->join('user U', 'U.id_user = Q.fk_id_user', 'LEFT');
				
				if (array_key_exists("idQRCode", $arrData)) {
					$this->db->where('id_qr_code', $arrData["idQRCode"]);
				}
				
				$this->db->order_by('id_qr_code', 'asc');
				
				$query = $this->db->get('param_qr_code Q');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de usuarios que no tienen QR CODE asignado
		 * @since  6/4/2018
		 */
		public function user_without_qrcode()
		{	
				$sql = "SELECT U.id_user, CONCAT(U.first_name, ' ' , U.last_name) name";
				$sql.= " FROM user U";
				$sql.= " WHERE U.id_user NOT IN ( SELECT fk_id_user FROM param_qr_code Q WHERE fk_id_user IS NOT NULL)";
				$sql.= " AND U.state = 1";
				
				$query = $this->db->query($sql);
				
				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Consulta menu
		 * @since 10/04/2018
		 */
		public function get_menu() 
		{
				$rol = $this->session->userdata['rol'];
				
				$sql = "SELECT * 
						FROM param_menu_permisos P
						INNER JOIN param_menu M ON M.id_menu = P.fk_id_menu
						WHERE P.fk_id_rol = " . $rol . "
						ORDER BY M.orden DESC";
				$query = $this->db->query($sql);
				return $query->result_array();
		}
		
		/**
		 * Consulta lista de enlaces para un menu y un rol especifico
		 * @param idMenu
		 * @since 10/04/2018
		 */
		public function get_enlaces($idMenu) 
		{
				$sql = "SELECT * FROM param_menu_links L
						WHERE L.fk_id_menu = " . $idMenu . "
						ORDER BY L.orden";

				$query = $this->db->query($sql);
				if ($query->num_rows() >= 1) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * PERIOD
		 * @since 26/4/2018
		 */
		public function get_period($arrData) 
		{				
				if (array_key_exists("idPeriod", $arrData)) {
					$this->db->where('id_period', $arrData["idPeriod"]);
				}
				
				$this->db->order_by('id_period', 'desc');
				
				if (array_key_exists("limit", $arrData)) {
					$query = $this->db->get('payroll_period', $arrData["limit"]);
				}else{
					$query = $this->db->get('payroll_period');
				}				

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * PAYROLL PROJECT PERIOD
		 * @since 26/4/2018
		 */
		public function get_project_period($arrData) 
		{				
				if (array_key_exists("idUser", $arrData)) {
					$this->db->where('fk_id_user', $arrData["idUser"]);
				}
				if (array_key_exists("idProject", $arrData)) {
					$this->db->where('fk_id_project', $arrData["idProject"]);
				}
				if (array_key_exists("idPeriod", $arrData)) {
					$this->db->where('fk_id_period', $arrData["idPeriod"]);
				}
				
				$this->db->order_by('id_project_period', 'desc');
				
				$query = $this->db->get('payroll_project_period');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * PAYROLL TOTAL PERIOD
		 * @since 2/5/2018
		 */
		public function get_total_period($arrData) 
		{				
				if (array_key_exists("idUser", $arrData)) {
					$this->db->where('fk_id_user', $arrData["idUser"]);
				}
				if (array_key_exists("idPeriod", $arrData)) {
					$this->db->where('fk_id_period', $arrData["idPeriod"]);
				}
				
				$this->db->order_by('id_total_period', 'desc');
				
				$query = $this->db->get('payroll_total_period');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de programacion
		 * @since 2/7/2018
		 */
		public function get_programming($arrData) 
		{
			$this->db->select("P.*, U.*, X.project_name, C.company_name");
			if (array_key_exists("idUser", $arrData)) {
				$this->db->where('P.fk_id_user', $arrData["idUser"]);
			}
			if (array_key_exists("idProgramming", $arrData)) {
				$this->db->where('P.id_programming', $arrData["idProgramming"]);
			}
			if (array_key_exists("fecha", $arrData)) {
				$this->db->where('P.date_programming', $arrData["fecha"]);
			}
			if (array_key_exists("estado", $arrData)) {
				$this->db->where('P.state', $arrData["estado"]);
			}
			
			$this->db->join('user U', 'U.id_user = P.fk_id_user', 'INNER');
			$this->db->join('project X', 'X.id_project = P.fk_id_project', 'INNER');
			$this->db->join('param_company C', 'C.id_company = X.fk_id_company', 'INNER');
							
			$this->db->order_by("P.date_programming DESC"); 
			$query = $this->db->get("programming P");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else
				return false;
		}
		
		/**
		 * Lista trabajadores para una programacion
		 * @since 4/7/2018
		 */
		public function get_programming_workers($arrData) 
		{
			$this->db->select();
			if (array_key_exists("idUser", $arrData)) {
				$this->db->where('P.fk_id_programming_user', $arrData["idUser"]);
			}
			if (array_key_exists("idProgramming", $arrData)) {
				$this->db->where('P.fk_id_programming', $arrData["idProgramming"]);
			}
			
			$this->db->join('programming_users U', 'U.id_programming_users = P.fk_id_programming_user', 'INNER');
							
			$this->db->order_by("U.full_name ASC"); 
			$query = $this->db->get("programming_worker P");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else
				return false;
		}
		
		/**
		 * Active User list
		 * @since 4/7/2018
		 */
		public function get_programming_user_list($arrData) 
		{
				$this->db->select();
				if (array_key_exists("idUser", $arrData)) {
					$this->db->where('U.id_programming_users', $arrData["idUser"]);
				}
				$this->db->order_by("U.full_name", "ASC");
				$query = $this->db->get("programming_users U");

				if ($query->num_rows() >= 1) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de skills para un trabajador
		 * @since 5/7/2018
		 */
		public function get_programming_skills($arrData) 
		{
			$this->db->select();
			if (array_key_exists("idWorker", $arrData)) {
				$this->db->where('P.fk_id_programming_user', $arrData["idWorker"]);
			}
			if (array_key_exists("idSkill", $arrData)) {
				$this->db->where('P.fk_id_programming_skill', $arrData["idSkill"]);
			}
			
			$this->db->join('programming_skills S', 'S.id_programming_skill = P.fk_id_programming_skill', 'INNER');
							
			$this->db->order_by("S.skill ASC"); 
			$query = $this->db->get("programming_users_skills P");

			if ($query->num_rows() >= 1) {
				return $query->result_array();
			} else
				return false;
		}
	
		

}