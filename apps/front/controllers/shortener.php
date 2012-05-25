<?php
    /**
     *
     * @author    Nemanja Krivokapic <nemanja.krivokapic@codeanvil.co>
     * @copyright CodeAnvil© 2012
     *
     * @property Redis $redis
     */
    class Shortener extends MY_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->library('hashify');
        }

        public function index() {
            $this->load->view('shortener');
        }

        public function process_shorty() {
            // Fetch full url from GET
            $url = $this->input->post('full_url');

            $url = urldecode($url);

            // Validate URL
            $url = filter_var($url, FILTER_SANITIZE_URL);
            if($url === false) {
                redirect($_SERVER['HTTP_REFERER']);
            }

            $hash = $this->hashify->shorten($url);
            echo site_url($hash);
        }
    }
