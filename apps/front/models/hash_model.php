<?php
    /**
     * @author    Nemanja Krivokapic <nemanja.krivokapic@codeanvil.co>
     * @copyright CodeAnvil© 2012
     */
    class Hash_model extends CI_Model {

        const HASH_IN_USE_YES = 'yes';
        const HASH_IN_USE_NO = 'no';

        /**
         * @var string 10 char long alphanumeric only
         */
        private $hash;
        /**
         * @var enum [yes,no]
         */
        private $in_use;

        /**
         * @var int
         */
        private $id;

        /**
         * @var string Description of an error
         */
        private $error;

        /**

         */
        public function __construct () {
            parent::__construct();
        }

        /**
         * Validate if the given hash can be used!
         *
         * @return bool
         */
        public function validate () {
            // Assume it`s not a valid hash
            $valid = false;

            // Check if there is any hash at all
            if ( !isset( $this->hash ) || empty( $this->hash ) ) {
                $this->setError( 'Hash is missing' );
            } else {
                // Check if it is unique
                $queryRes = $this->db
                    ->where( 'hash', $this->hash )
                    ->limit( 1 )
                    ->get( 'hash' )
                    ->row();

                if ( !empty( $queryRes ) ) {
                    $this->setError( 'Already exists' );
                } else {
                    $valid = true;
                }
            }

            return $valid;
        }

        /**
         * Saving new or existing one hash
         *
         * @return mixed
         */
        public function save () {

            $id = $this->getId();

            $record = array(
                'hash'      => $this->getHash(),
                'in_use'    => $this->getInUse()
            );

            if ( isset( $id ) ) {
                // We are doing update
                $this->db
                    ->where( 'id', $id )
                    ->update( 'hash', $record );
            } else {
                // Inserting new one
                $this->db->insert( 'hash', $record );
            }

            return;
        }

        public function load($hash) {
            $hash = $this->db->where('hash', $hash)
                             ->limit(1)
                             ->get('hash')
                             ->row();

            $result = false;
            if(!empty($hash)) {
                $this->setHash($hash->hash);
                $this->setId($hash->id);
                $this->setInUse($hash->in_use);
                $result = true;
            }

            return $result;
        }

        public function reset() {
            $this->setHash(null);
            $this->setId(null);
            $this->setInUse(null);
        }

        // ******************* SETTERS AND GETTERS ******************************* //

        /**
         * @param $hash
         */
        public function setHash ( $hash ) {
            $this->hash = $hash;
        }

        /**
         * @return mixed
         */
        public function getHash () {
            return $this->hash;
        }

        /**
         * @param $in_use
         */
        public function setInUse ( $in_use ) {
            $this->in_use = $in_use;
        }

        /**
         * @return mixed
         */
        public function getInUse () {
            return $this->in_use;
        }

        /**
         * @param $error
         */
        public function setError ( $error ) {
            $this->error = $error;
        }

        /**
         * @return mixed
         */
        public function getError () {
            return $this->error;
        }

        /**
         * @param int $id
         */
        private function setId ( $id ) {
            $this->id = $id;
        }

        /**
         * @return int
         */
        public function getId () {
            return $this->id;
        }


    }
