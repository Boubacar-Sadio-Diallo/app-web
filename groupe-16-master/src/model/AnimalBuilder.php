<?php
class AnimalBuilder {
    // Déclaration des constantes de référence
    const NAME_REF = 'nom';
    const SPECIES_REF = 'espece';
    const AGE_REF = 'age';
    const IMAGE_REF = 'image';
    protected $data;
    protected $errors;

    public function __construct($data = null) {
        $this->data = $data;
        $this->errors = array();
    }

    // Accesseur pour l'attribut $data
    public function getData() {
        return $this->data;
    }

    // Accesseur pour l'attribut $error
    public function getError() {
        return $this->errors;
    }

    /* Crée une nouvelle instance de Animal avec les données fournies.
     * Si toutes ne sont pas présentes, une exception est lancée. */
    public function createAnimal() {
        if (!key_exists(self::NAME_REF, $this->data) || 
            !key_exists(self::SPECIES_REF, $this->data) || 
            !key_exists(self::AGE_REF, $this->data) 
            ) {
            throw new Exception("Missing fields for Animal creation");
            // $fileName = $_FILES['image']['name'];
            // $tmp_name = $_FILES['image']['tmp_name'];
        }
        // $imagePath = null;
        // if (key_exists(self::IMAGE_REF,$this->data)) {
        //     // Validation de l'image
        //     if (!$this->validateImage($this->data[self::IMAGE_REF])) {
        //         throw new Exception("Invalid image");
        //     }
        //     $imagePath = $this->handleImageUpload($this->data[self::IMAGE_REF]);
            
        // }
        //echo "no error";
        return new Animal($this->data[self::NAME_REF], $this->data[self::SPECIES_REF], $this->data[self::AGE_REF]);
    }

    //Valider le format $, la taille de l'image
    // private function validateImage($image) {
    //     $validTypes = ['image/jpeg', 'image/png', 'image/gif']; // Types valides
    //     $maxSize = 2000000; // Taille maximale 2MB

    //     if ($image['size'] > $maxSize) {
    //         $this->errors[self::IMAGE_REF] = "L'image ne doit pas dépasser 2MB.";
    //         return false;
    //     }

    //     if (!in_array($image['type'], $validTypes)) {
    //         $this->errors[self::IMAGE_REF] = "Le fichier doit être une image JPEG, PNG ou GIF.";
    //         return false;
    //     }

    //     return true;
    // }

    // //On recupère le chemain de l'image
    // private function handleImageUpload($image) {
    //     $targetDir = "./uploads/"; // Répertoire où les images seront stockées
    //     $targetFile = $targetDir . basename($image['name']); // Chemin du fichier
    //     $imagePath = $targetFile; // Sauvegarder le chemin du fichier

    //     // Déplacer l'image vers le répertoire cible
    //     if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
    //         $this->errors[self::IMAGE_REF] = "Erreur lors de l'upload de l'image.";
    //         return null;
    //     }

    //     return $imagePath;
    // }

    public function isValid() {
        $this->errors = array();  // Réinitialiser les erreurs
        
        // Validation du nom
        if (!key_exists(self::NAME_REF, $this->data) || $this->data[self::NAME_REF] === "") {
            $this->errors[self::NAME_REF] = "Le nom de l'animal est requis.";
        } else if (mb_strlen($this->data[self::NAME_REF], 'UTF-8') > 30) {
            $this->errors[self::NAME_REF] = "Le nom de l'animal ne doit pas dépasser 30 caractères.";
        }
    
        // Validation de l'espèce
        if (!key_exists(self::SPECIES_REF, $this->data) || $this->data[self::SPECIES_REF] === "") {
            $this->errors[self::SPECIES_REF] = "L'espèce de l'animal est requise.";
        }
    
        // Validation de l'âge
        if (!key_exists(self::AGE_REF, $this->data) || !is_numeric($this->data[self::AGE_REF]) || $this->data[self::AGE_REF] <= 0) {
            $this->errors[self::AGE_REF] = "L'âge doit être un nombre positif.";
        }
        // Retourner true si aucune erreur, sinon false
        return count($this->errors) === 0;
    }
}
