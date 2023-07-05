<?php

class CustomMySql {

	
	public function __construct(CI_DB_mysqli_result $cI_DB_mysqli_result, C_frontend $_self, $table='cmscontent', $fields = ['short_desc','content'])
	{
		// parent::__construct();
		$this->cI_DB_mysqli_result = $cI_DB_mysqli_result;
		$this->self = $_self;
		$this->fields = $fields;
		$this->table = $table;
	}

	public function row($n = 0, $type = 'object')
	{
		$result = $this->cI_DB_mysqli_result->row();

        if ($result) {
            $cmscontent_languages = $this->self->queries->fetch_records($this->table . "_languages", " AND ".$this->table."_id = {$result->id}")->result_array();
            replace_data_for_lang($result, $this->self->data['content_languages'], $cmscontent_languages, $this->fields, SessionHelper::_get_session('LANG_CODE'));

            if (property_exists($result, $n)) {
                return $result->{$n};
            } else {
                return $result;
            }
        }else{
			show_404();
		}
	}

	public function num_rows()
	{
		return $this->cI_DB_mysqli_result->num_rows();
	}

	public function result($type = 'object')
	{
		return $this->cI_DB_mysqli_result->result($type);
	}
	
}