<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class soap extends HO_Site {

    public function __construct() {
        parent::__construct();

        $this->load->library("Nusoap_lib");
    }

    public function index() {
        $this->client = new soapclient(site_url('services'), FALSE/* array('soap_version'   => SOAP_1_2) */);
        $result = $this->client->call('hello', array('name' => 'boroo !'));
        
        if ($this->client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        } else {
            $err = $this->client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                echo '<h2>Result</h2><pre>';
                print_r($result);
                echo '</pre>';
            }
        }
    }

}
