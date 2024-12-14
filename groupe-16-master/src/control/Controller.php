<?php
set_include_path("./src");
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");
require_once("model/AnimalBuilder.php");
require_once("model/AnimalStorageMySQL.php");

class Controller {
    private $view;
    //private $animalsTab = array();
    private $storage;

    public function __construct($router,$view,$storage) {
        // Initialisation de la vue
        $this->view = $view;
        $this->storage = $storage;
        
    }

    public function showInformation($id) {
            $animal = $this->storage->read($id);
            if($animal){
            // Passer le nom, l'espèce et l'âge de l'animal à la vue
            $this->view->prepareAnimalPage($animal->getNom(),$animal->getEspece(),$animal->getAge(),$animal->getImagePath());
        } else {
            // Si l'animal n'est pas trouvé, afficher la page "animal inconnu"
            $this->view->prepareUnknownAnimalPage();
        }
    }
    //demander à la vue de préparer le formulaire
    public function createNewAnimal(){
        $animal = new AnimalBuilder();
        $this->view->prepareAnimalCreationPage($animal);
    }

    public function saveNewAnimal(array $data) {
        // Création de l'AnimalBuilder avec les données
        $animalBuilder = new AnimalBuilder($data);
        // Vérification de la validité des données
        if ($animalBuilder->isValid()) {
                //var_dump($_FILES);
                //var_dump($data);
            // Gestion de l'upload de l'image
            if (key_exists('image',$_FILES) && $_FILES['image']['error'] == 0) {
                //var_dump($_FILES,'image');
                //// Appel de la méthode validateImage pour traiter le fichier uploadé
                // if ($animalBuilder->validateImage($_FILES['image_path'])) {
                    //L'image a été correctement uploadée, on peut créer l'animal
                    $tmpName=$_FILES['image']['tmp_name'];
                    $fileName = basename($_FILES['image']['name']);
                    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                    
                    //if(!in_array($fileExt,['jpg','jpeeg','png','gif']) || !exif_imagetype($tmpName)){
                      //  $this->view->prepareAnimalCreationPage($animalBuilder);
                        //echo "la";
                    //}
                    //créer un nom unique pour le fichier
                    $newFileName = uniqid() . $fileName;
                    $directoy = "uploads/";

                    if(!is_dir($directoy)){
                        mkdir($directoy,0755,true);
                    }
                    $destination = $directoy . $newFileName;

                    //echo $newFileName;

                    $animal = $animalBuilder->createAnimal();
                    if(move_uploaded_file($tmpName,$destination)){
                        $animal = new Animal(
                            $animal->getNom(),
                            $animal->getEspece(),
                            $animal->getAge(),
                            "uploads/" . $newFileName
                        );

                       //s echo "./uploads/ ". $newFileName;
                    }else{
                        echo "ici";
                    }
                    //die("deplacement echou\é");

                    
                    // Ajout de l'animal dans la base de données
                    $animalId = $this->storage->create($animal);
                    // Réinitialisation de l'AnimalBuilder
                    $animalBuilder = null;
                    
                    // Affichage de la page de succès
                    $this->view->displayAnimalCreationSuccess($animalId);
                // } else {
                //     // Si l'image est invalide, on retourne l'erreur
                //     $this->view->prepareAnimalCreationPage($animalBuilder);
                // }
            } else {
                // Si aucun fichier n'a été envoyé ou s'il y a une erreur
                $this->view->prepareAnimalCreationPage($animalBuilder);
            }
        } else {
            // Les données sont invalides, on affiche le formulaire avec les erreurs
            $this->view->prepareAnimalCreationPage($animalBuilder);
        }
    }
    
    
    

    
    //Affiche le menu
    public function homePage(){
        $this->view->prepareTestPage();
    }
    //Pour montrer la liste des animaux
    public function showList(){
        $animal = $this->storage->readAll();
        if($animal){
            $this->view->prepareListPage($animal);
        }else{
            $this->view->prepareUnexpectedErrorPage();
        }
    }

    public function prepareUnknownActionPage(): void {
        // Appel de la méthode settingGET sur la vue
        $this->view->settingGET();
    }
}
?>
