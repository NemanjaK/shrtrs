<?php
    /**
     *
     * @author    Nemanja Krivokapic <nemanja.krivokapic@codeanvil.co>
     * @copyright CodeAnvil© 2012
     */
    class MY_Controller extends CI_Controller {

        public function __construct() {
            parent::__construct();

            $this->prepareCSRF();
        }

        public function _assign($key, $val) {
            $this->load->vars(array($key => $val));
        }

        public function prepareCSRF () {
            $token['name'] = $this->security->get_csrf_token_name();
            $token['value'] = $this->security->get_csrf_hash();

            $this->_assign( 'csrf_token', $token );
        }
    }
