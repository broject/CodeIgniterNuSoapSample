<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class services extends HO_Site {

    function __construct() {
        parent::__construct();

        $soap_method = "hello";
        $soap_name = 'services';
        $soap_urn = 'urn:' . $soap_name;

        $this->load->library("Nusoap_lib");
        $this->server = new soap_server();
        $this->server->configureWSDL($soap_name, $soap_urn);
        $this->server->wsdl->schemaTargetNamespace = $soap_urn;

        $this->server->register($soap_method, // method name
                array('name' => 'xsd:string'), // input parameters
                array('return' => 'xsd:string'), // output parameters
                $soap_urn, // namespace
                $soap_urn . '#' . $soap_method, // soapaction
                'rpc', // style
                'encoded', // use
                'Says hello to the caller' // documentation
        );
    }

    /**
     * Хэрэв services?wsdl гэж QUERY_STRING тэй бичвэл XML харна*/
    function index() {
        function hello($name) {
            return 'Hello, ' . $name;
        }

        $this->server->service(file_get_contents("php://input"));
    }

}
