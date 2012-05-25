<?php
    /**
     * @author    Nemanja Krivokapic <nemanja.krivokapic@codeanvil.co>
     * @copyright CodeAnvil© 2012
     */
    class Hashgenerator extends MY_Controller {

        public function __construct () {
            parent::__construct();
            $this->load->library('hashify');
        }

        public function generate ( $count = 10000 ) {
            // Method for filling generated HASH
            for ( $i = 0; $i < $count; $i++ ) {
                // Generate valid one!
                $validHash = false;
                while ( $validHash !== true ) {
                    $hash = $this->hashify->generateNew();
                    $this->hash_model->reset();
                    $this->hash_model->setHash($hash);
                    $validHash = $this->hash_model->validate();
                }

                $this->hash_model->setInUse(Hash_model::HASH_IN_USE_NO);
                $this->hash_model->save();
            }
        }

    }
