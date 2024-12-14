<?php
// On suppose que la classe Animal est déjà définie quelque part dans votre projet
require_once('AnimalStorage.php');  // ajustez le chemin en fonction de votre structure de projet
class AnimalStorageMySQL implements AnimalStorage {
    private $pdo;

    // Constructeur qui initialise l'instance PDO pour se connecter à la base de données MySQL
    public function __construct($pdo) {
       $this->pdo = $pdo;
    }

    public function read($id) {
        // Requête SQL pour récupérer un animal par ID
        $rq = "SELECT * FROM `animals` WHERE `id` = :id";
        
        // Préparer la requête
        $stmt = $this->pdo->prepare($rq);
        
        // Remplir les paramètres de la requête préparée
        $data = array(":id" => $id);  
    
        // Exécuter la requête préparée
        $stmt->execute($data);
        
        // Récupérer le résultat
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Si aucun résultat n'est trouvé, retourner null
        if (!$row) {
            return null;  // Aucun animal trouvé
        }
        
        // Si la ligne est valide, extrayez les données
        $nom = key_exists('name', $row) ? $row['name'] : "";
        $espece = key_exists('species', $row) ? $row['species'] : "";
        $age = key_exists('age', $row) ? $row['age'] : "";
        $imagePath = key_exists('image_path', $row) ? $row['image_path'] : "";
    
        // Créez un objet Animal avec les données récupérées
        $animaux = new Animal($nom, $espece, $age, $imagePath);  // Adapter le constructeur de l'animal si nécessaire
        return $animaux;
    }
    
    

    // Méthode qui lira tous les animaux
    public function readAll() {
        //Requête SQL incorrecte
            $stmt = $this->pdo->query('SELECT * FROM `animals` ');
            $stmt->setFetchMode(PDO::FETCH_ASSOC); // 
             
            $animaux = [];

        // Parcourir les résultats et créer des objets Animal
        while ($row = $stmt->fetch()) {
            $nom = key_exists('name',$row) ? $row['name'] : "";
            $espece = key_exists("species",$row) ? $row["species"] : "";
            $age = key_exists("age",$row) ? $row["age"] : "";
            $imagePath = key_exists("image_path",$row) ? $row["image_path"] : "";
            // On crée un nouvel objet Animal avec les données récupérées
            // Supposons que la classe Animal ait un constructeur acceptant ces paramètres
            $animal = new Animal($nom, $espece, $age, $imagePath);  // Adapter selon les colonnes de votre table
            $animaux[$row['id']] = $animal; // Ajouter l'objet à notre tableau
        }   
        return $animaux;
    }
    
    public function create(Animal $a) {
        // Requête SQL pour insérer un nouvel animal dans la base de données
        $rq = "INSERT INTO `animals` (name, species, age, image_path) VALUES (:name, :species, :age, :image_path)";
    
        // Préparer la requête
        $stmt = $this->pdo->prepare($rq);
    
        // Lier les paramètres à la requête préparée
        $data = array(
            ":name" => $a->getNom(),  // On suppose que la classe Animal a une méthode getNom()
            ":species" => $a->getEspece(),  // Pareil pour getEspece()
            ":age" => $a->getAge(),  // Et pour getAge()
            ":image_path" => $a->getImagePath()
        );
    
        // Exécuter la requête préparée
        
            $stmt->execute($data);
    
            // Récupérer l'ID de l'animal inséré (auto-incrementé)
            $animalId = $this->pdo->lastInsertId();
    
            // Retourner l'ID de l'animal créé ou un message de succès
            return $animalId;  // L'ID de l'animal nouvellement inséré
        
    }
    
    public function getAllAnimals() {
        $stmt = $this->pdo->query("SELECT id, nom, image_path FROM animaux");
        $animals = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $animal = new Animal($row['id'], $row['name'],$row['image_path']);
            $animals[] = $animal;
        }

        return $animals;
    }

    // Méthode pour récupérer un animal par son ID
    public function getAnimalById($id) {
        $stmt = $this->pdo->prepare("SELECT name,species,age,image_path FROM animaux WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Animal($row['name'], $row['species'], $row['age'], $row['image_path']);
        }

        return null;
    }
    // Méthode qui supprime un animal à partir de son identifiant
    public function delete($id) {
        throw new Exception("not yet implemented");
    }

    // Méthode qui met à jour un animal à partir de son identifiant
    public function update($id, Animal $a) {
        throw new Exception("not yet implemented");
    }
}
?>
