<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Data_Scraper extends C_frontend
{


	public function __construct()
	{
		parent::__construct();

		$this->data													= $this->default_data();
	}


	public function index()
	{

		$form = "<h2>Enter blow details to scrape data from tables by column name</h2>
		<h4>Multiple Table/Column names saperated by qouma ',' (given same columns will be searched in all tables given in input)</h4>
		<form action=\" " . base_url('data_scraper/scrape') . "\" method=\"post\">
		Tables: <input type=\"text\" name=\"tables\">
		Columns: <input type=\"text\" name=\"columns\">
		<button type=\"submit\">Submit</button>
		</form>";

		die($form);
	}

	public function scrape()
	{
		$tables = $this->input->post('tables');
		$columns = $this->input->post('columns');

		$form = "
		<form action=\" " . base_url('data_scraper/export') . "\" method=\"post\">
		<input type=\"hidden\" name=\"tables\" value=\" " . $tables . "\">
		<input type=\"hidden\" name=\"columns\" value=\" " . $columns . "\">
		<button type=\"submit\">Export</button>
		</form>";

		$data = $this->fetch_data($tables, $columns);
		// echo "<pre>";
		// print_r ($data);
		// echo "</pre>";
		$this->strip_data($data);
		echo $form;

		exit;
	}

	public function export()
	{
		$tables = $this->input->post('tables');
		$columns = $this->input->post('columns');

		$data = $this->fetch_data($tables, $columns);

		header("Content-Type: application/vnd.ms-word");
		header("Expires: 0");
		header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
		header("Content-disposition: attachment; filename=\"imamiamedics_content.doc\"");

		$this->strip_data($data);
		exit;
	}

	private function fetch_data($tables, $columns)
	{
		$explodedTables = explode(",", $tables);
		$explodedColumns = explode(",", $columns);
		$explodedColumns[] = "id";

		$data = null;
		foreach ($explodedTables as $key => $table) {
			$this->db->select($explodedColumns);
			$this->db->from($table);
			$data[$key] = $this->db->get()->result();
			$data[$key]['table'] = $table;
		}
		return $data;
	}

	private function strip_data($arrs)
	{
		foreach ($arrs as $key => $arr) {
			echo ("<h3>START OF: " . $arr['table'] . "</h3>");
			foreach ($arr as $k => $v) {
				$keys = array_keys((array) $v);

				if (isset($v->id)) {
					foreach ($keys as $k => $i) {
						echo ("<p>Col(" . $i . ") - " . strip_tags($v->$i) . "</p>");
					}
				}
			}
			echo ("<h3>END OF: " . $arr['table'] . "</h3>");
		}
	}
}
