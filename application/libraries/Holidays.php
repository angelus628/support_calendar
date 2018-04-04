<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Bogota');

class Holidays {
    protected $webservice;
    protected $months;
    protected $holidays;

    public function __construct($params){
        $this->webservice = "http://www.cuandoenelmundo.com/calendario/colombia/{$params['date']}";
        $this->holidays    = array();
        $this->months      = array(
            'enero'      => 'jan',
            'febrero'    => 'feb',
            'marzo'      => 'mar',
            'abril'      => 'apr',
            'mayo'       => 'may',
            'junio'      => 'jun',
            'julio'      => 'jul',
            'agosto'     => 'aug',
            'septiembre' => 'sept',
            'octubre'    => 'oct',
            'noviembre'  => 'nov',
            'diciembre'  => 'dec',
        );
    }

    public function get_holidays()
    {
        $page     = file_get_contents($this->webservice);
        $dom      = new DOMDocument;
        $dom->loadHTML($page);
        $tables   = $dom->getElementsByTagName('table');
        $count    = 0;

        foreach($tables as $table) {
            if (!$table->hasAttribute('class')) {
               continue;
            }

            $class = explode(' ', $table->getAttribute('class'));

            if (in_array('hdays', $class)) {
                $trs = $table->getElementsByTagName('tr');
                foreach($trs as $tr){
                    $tds  = $tr->getElementsByTagName('td');
                    $value = 0;
                    foreach($tds as $td){
                        if($value >= 2) { $value = 0; continue; }

                        if(isset($this->holidays[$count])) $this->holidays[$count] .= ' ' . $this->months[trim($td->nodeValue)] . ' ' . date('Y');
                        else $this->holidays[$count] = trim($td->nodeValue);

                        $value++;
                    }
                    $count++;
                }
            }
        }

        return $this->holidays;
    }
}
