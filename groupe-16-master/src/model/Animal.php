<?php
class Animal {

    private $nom;
    private $espece;
    private $age;
    private $imagePath; // Nouveau attribut pour le chemin de l'image
    
    public function __construct($nom, $espece, $age, $imagePath=null){
        $this->nom = $nom;
        $this->espece = $espece;
        $this->age = $age;
        $this->imagePath = $imagePath; // Initialisation du chemin de l'image
    }
    
    // Accesseur pour le nom
    public function getNom(): String {
        return $this->nom;  
    }
    
    // Accesseur pour l'espèce
    public function getEspece() {
        return $this->espece;
    }
    
    // Accesseur pour l'âge
    public function getAge() {
        return $this->age;
    }
    
    // Accesseur pour le chemin de l'image
    public function getImagePath() {
        return $this->imagePath;
    }
    
    // Modificateur pour le chemin de l'image
    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
    }
    }
    