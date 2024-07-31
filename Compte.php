<?php

require_once 'dbconfig.php';

class Compte {
    private $code;
    private $nom;
    private $prenom;
    private $solde;
    private $datecreation;

    public function __construct($code, $nom, $prenom, $solde, $datecreation) {
        $this->code = $code;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->solde = $solde;
        $this->datecreation = $datecreation;
    }

    public function getCode() {
        return $this->code;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getSolde() {
        return $this->solde;
    }

    public function getDatecreation() {
        return $this->datecreation;
    }



}

?>
