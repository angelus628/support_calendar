<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_ALL, 'es_ES');

class Calendar extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{
		$this->load->model('user_model');
		$this->load->helper('url');

		$data = array(
			'today'	 		=> strftime('%A %d de %B de %G'),
			'first_day'  	=> strtotime(date('Ym01')),
			'last_day'  	=> strtotime(date('Ym' . cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')))),
			'first_of_week' => strftime('%w', strtotime(date('Ym01'))) + 1,
			'users'     	=> $this->user_model->get_users(),
		);

		$data['calendar'] = $this->create_calendar($data);

		$this->load->view('layout/header', $data);
		$this->load->view('support/calendar', $data);
		$this->load->view('layout/footer', $data);
	}

	public function holidays(){
		$this->load->library('holidays', array('date' => date('Y')));
		return $this->holidays->get_holidays();
	}

	protected function create_calendar($data){
		$today = date('d');
		$count = 1;
		$table = '<table class="table table-bordered">
			<thead class="thead-dark">
				<tr>
					<th>Domingo</th>
					<th>Lunes</th>
					<th>Martes</th>
					<th>Miércoles</th>
					<th>Jueves</th>
					<th>Viernes</th>
					<th>Sábado</th>
				</tr>
			</thead>
			<tbody>
				<tr class="bg-success">';

		for($i = 1; $count <= date('d', $data['last_day']); $i++){
			if($i < $data['first_of_week']){
				$count = 1;
				$table .= '<td></td>';
				continue;
			}

			//Si el dia es hoy, se rezalta con un color diferente
			$table .= ($count == $today)? '<td class="bg-primary">' : '<td>';
			$table .= $count . '</td>';

			if($i % 7 === 0){
				$table .= '</tr><tr class="bg-success">';
			}

			$count++;
		}

		$table  = preg_replace('/<tr class="bg-success">$/', '', $table);
		$table .= '</tbody>
		</table>';

		return $table;
	}
}
