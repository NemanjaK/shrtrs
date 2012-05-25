<?php

    /**
     * @author    Nemanja Krivokapic <nemanja.krivokapic@codeanvil.co>
     * @copyright CodeAnvil© 2012
     */
    class Hashify {

        private $ci;
        private $db;

        public function __construct () {
            $this->ci = &get_instance();
            $this->db = $this->ci->db;
            $this->ci->load->helper( 'hash' );
            $this->ci->load->model( 'hash_model' );
        }

        public function shorten ( $url ) {
            // Check if it`s already in hashify
            $sha1_url = sha1( $url );
            $alreadyShortened = $this->db
                ->where( 'sha1_url', $sha1_url )
                ->get( 'hashify' )
                ->result_array();

            // Check if it happend that sha1 was duplicated!
            if ( count( $alreadyShortened ) > 1 ) {
                $hash = $this->db
                    ->where( 'sha1_url', $sha1_url )
                    ->where( 'full_url', $url )
                    ->limit( 1 )
                    ->get( 'hashify' )
                    ->row();
            } else if ( count( $alreadyShortened ) === 1 ) {
                $hash = $alreadyShortened[0]['hash'];
            } else {
                $hash = $this->getFreeHash();
                $insert = array(
                    'hash'     => $hash,
                    'full_url' => $url,
                    'sha1_url' => sha1( $url )
                );

                $this->db->insert( 'hashify', $insert );
            }

            return $hash;
        }

        private function getFreeHash () {
            $hash = $this->db
                ->where( 'in_use', Hash_model::HASH_IN_USE_NO )
                ->limit( 1 )
                ->get( 'hash' )
                ->row( 'hash' );

            // Check if no more hash is avalaible?
            if ( empty( $hash ) === true ) {
                do {
                    $this->ci->hash_model->reset();
                    $hash = $this->generateNew();
                    $this->ci->hash_model->setHash( $hash );
                    $unique = $this->ci->hash_model->validate();
                } while ( $unique === false );
            } else {
                $this->ci->hash_model->load( $hash );
            }

            $this->ci->hash_model->setInUse( Hash_model::HASH_IN_USE_YES );
            $this->ci->hash_model->save();

            return $hash;
        }

        public function generateNew ( $length = 10 ) {
            $code = '';
            for ( $j = 0; $j < $length; $j++ ) {
                $characters = array_merge( range( 0, 9 ), array( 'a', 'z' ) );

                shuffle( $characters );

                $code .= array_pop( $characters );
            }

            return $code;
        }

    }
