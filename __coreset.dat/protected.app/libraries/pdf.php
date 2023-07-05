<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH . '/third-party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf extends Dompdf
{

    public function __construct()
    {
        // die("Asdfasdf");
        parent::__construct();
    }

    protected function ci()
    {
        return get_instance();
    }
}
