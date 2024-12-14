<?php
set_include_path("./src");
require_once('Router.php');
require_once('model/AnimalBuilder.php');

class View{
    const NAME_REF = 'nom';
    const SPECIES_REF = 'espece';
    const AGE_REF = 'age';
    const IMAGE_REF = 'image';

    private $title;
    private $content;
    private $router ;
    private $menu;
    private $feedback;

    public function __construct($router, $feedback){
        $this->router = $router;
        $this->feedback = $feedback;
    }
    //Recupérer le menu
    public function getMenu(){
        $menu = array(
            "Accueil" => $this->router->homePage(),
            "Liste Animal" => $this->router->setOfAnimal(),
            "Créer un nouvel Animal" => $this->router->getAnimalCreationURL()
        );
        return $menu;
    }
    //Set tittle of the pages
    public function setTitle(string $title):void{
        $this->title = $title;
    }

    //Set content of the page
    public function setContent(string $content):void{
        $this->content = $content;
    }
    
	
    public function render(){
        //Vaildé par w3c
        echo "
        <!DOCTYPE smil PUBLIC '-//W3C//DTD SMIL 2.0//EN' 'http://www.w3.org/TR/2001/REC-SMIL20-20010904/smil20.dtd'>
        <smil>
            <head>
                <meta name='generator' content='HTML Tidy for HTML5 for Linux version 5.6.0'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <meta http-equiv='Content-Type' content='application/smil+xml; charset=UTF-8'>
                <title>" . htmlspecialchars($this->title) . "</title>
            </head>
            <body>
                <p>" . $this->renderMenu() . "</p>
                <p><h1>" . htmlspecialchars($this->title) . "</h1></p>
                <p>" . htmlspecialchars($this->feedback) . "</p>
                <p>" . $this->content . "</p>
            </body>
        </smil>
        ";
    }
    
        //Méthode pour afficher le menu sous forme de lien
        private function renderMenu(){
            
            foreach($this->getMenu() as $text => $url){
                echo '<a href="'.htmlspecialchars($url).'" style="color: #fff; background-color: #007bff; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block;">
                ' . htmlspecialchars($text) . '
              </a>';            }
           
        }

        public function prepareTestPage(): void{
            $this->title = "Mon Premier Site";
            $this->content = "Je suis hyper :)";
        }
        /* Une fonction pour échapper les caractères spéciaux de HTML,
	* car celle de PHP nécessite trop d'options. */
        public static function htmlesc($str) {
            return htmlspecialchars($str,
                /* on échappe guillemets _et_ apostrophes : */
                ENT_QUOTES
                /* les séquences UTF-8 invalides sont
                * remplacées par le caractère �
                * au lieu de renvoyer la chaîne vide…) */
                | ENT_SUBSTITUTE
                /* on utilise les entités HTML5 (en particulier &apos;) */
                | ENT_HTML5,
                'UTF-8');
        }
        
        // Méthode pour afficher le formulaire de création d'un animal
        public function prepareAnimalCreationPage(AnimalBuilder $animalBuilder) {
            $this->title = 'Ajouter un nouvel Animal';
            
            // Récupération des données et des erreurs de l'AnimalBuilder
            $data = $animalBuilder->getData();
            $errors = $animalBuilder->getError();  // On récupère toutes les erreurs
            
            // Pré-remplir les valeurs des champs avec les données
            $nom = self::htmlesc($data[AnimalBuilder::NAME_REF] ?? '');  // Utilisation de la constante NAME_REF
            $espece = self::htmlesc($data[AnimalBuilder::SPECIES_REF] ?? '');  // Utilisation de la constante SPECIES_REF
            $age = self::htmlesc($data[AnimalBuilder::AGE_REF] ?? '');  // Utilisation de la constante AGE_REF
            $image = self::htmlesc($data[AnimalBuilder::IMAGE_REF] ?? '');  // Champ image

            // Ouverture du formulaire
            $res = '<!DOCTYPE html>';
            $res .= '<html lang="fr">';
            $res .= '<head>';
            $res .= '<meta charset="UTF-8">';
            $res .= '<title>' . htmlspecialchars($this->title) . '</title>';
            $res .= '</head>';
            $res .= '<body>';
            
            //$res .= '<form method="POST" action="' . htmlspecialchars($this->router->getAnimalSaveURL()) . '">';
            $res .= '<form method="POST" action="' . htmlspecialchars($this->router->getAnimalSaveURL()) . '" enctype="multipart/form-data">';
            
            // Champ pour le nom de l'animal
            $res .= '<p><label for="' . htmlspecialchars(AnimalBuilder::NAME_REF) . '">Nom de l\'animal:</label>';
            $res .= '<input type="text" id="' . htmlspecialchars(AnimalBuilder::NAME_REF) . '" name="' . htmlspecialchars(AnimalBuilder::NAME_REF) . '" value="' . htmlspecialchars($nom) . '">';
            
            // Affichage de l'erreur pour le champ "Nom", s'il y en a une
            if (array_key_exists(AnimalBuilder::NAME_REF, $errors) && $errors[AnimalBuilder::NAME_REF] !== null) {
                $res .= ' <span class="error" style="color: red;">' . htmlspecialchars($errors[AnimalBuilder::NAME_REF]) . '</span>';
            }
            $res .= '</p>';
            
            // Champ pour l'espèce de l'animal
            $res .= '<p><label for="' . htmlspecialchars(AnimalBuilder::SPECIES_REF) . '">Espèce de l\'animal:</label>';
            $res .= '<input type="text" id="' . htmlspecialchars(AnimalBuilder::SPECIES_REF) . '" name="' . htmlspecialchars(AnimalBuilder::SPECIES_REF) . '" value="' . htmlspecialchars($espece) . '">';
            
            // Affichage de l'erreur pour le champ "Espèce", s'il y en a une
            if (array_key_exists(AnimalBuilder::SPECIES_REF, $errors) && $errors[AnimalBuilder::SPECIES_REF] !== null) {
                $res .= ' <span class="error" style="color: red;">' . htmlspecialchars($errors[AnimalBuilder::SPECIES_REF]) . '</span>';
            }
            $res .= '</p>';
            
            // Champ pour l'âge de l'animal
            $res .= '<p><label for="' . htmlspecialchars(AnimalBuilder::AGE_REF) . '">Âge de l\'animal:</label>';
            $res .= '<input type="number" id="' . htmlspecialchars(AnimalBuilder::AGE_REF) . '" name="' . htmlspecialchars(AnimalBuilder::AGE_REF) . '" min="0" value="' . htmlspecialchars($age) . '">';
            
            // Affichage de l'erreur pour le champ "Âge", s'il y en a une
            if (array_key_exists(AnimalBuilder::AGE_REF, $errors) && $errors[AnimalBuilder::AGE_REF] !== null) {
                $res .= ' <span class="error" style="color: red;">' . htmlspecialchars($errors[AnimalBuilder::AGE_REF]) . '</span>';
            }
            $res .= '</p>';
            
            // Champ pour l'image de l'animal
            $res .= '<p><label for="' . htmlspecialchars(AnimalBuilder::IMAGE_REF) . '">Image de l\'animal:</label>';
            $res .= '<input type="file" id="' . htmlspecialchars(AnimalBuilder::IMAGE_REF) . '" name="' . htmlspecialchars(AnimalBuilder::IMAGE_REF) . '">';
            if (array_key_exists(AnimalBuilder::IMAGE_REF, $errors)) {
                $res .= ' <span class="error" style="color: red;">' . htmlspecialchars($errors[AnimalBuilder::IMAGE_REF]) . '</span>';
            }
            $res .= '</p>';

            // Bouton de soumission
            $res .= '<p><input type="submit" value="Créer l\'animal"></p>';
            
            // Fermeture du formulaire
            $res .= '</form>';
            
            $res .= '</body>';
            $res .= '</html>';
            
            $this->content = $res;
}
        
        public function prepareAnimalPage($name, $species,$age,$image){
            $this->title = "Information sur ".$name;
            $this->content = htmlspecialchars($name).' est un animal de l\'espèce '.htmlspecialchars($species).' agé de '.htmlspecialchars($age);
            $this->content .= "<p><img src='" . htmlspecialchars($image) . "' alt='Image de " . htmlspecialchars($species) . "' /></p>";
        }
       
            //A revoir pour le content
        public function displayAnimalCreationSuccess($id){
            $url = $this->router->getAnimalURL($id);
            $this->router->POSTredirect($url,'L\'animal a été ajouté avec succès!');
        }

        //Affichage du message d'erreur
        public function prepareUnexpectedErrorPage(){
        $this->title = 'Error';
        $this->content = 'something went wrong';
        }
        
        //GET non charger dans l'URL
        public function prepareUnknownAnimalPage(){
            $this->title = 'Error';
            $this->content = 'No defined action';
        }
        public function prepareUnexpectedErrorCreation(){
            $this->title = 'Error';
            $this->content = 'at least one field is incorrect';
        }

        public function prepareListPage($tableau){
                $this->title = 'Liste des Animaux';
                $this->content = '<ul>';
            foreach($tableau as $cle => $valeur){
                $animalUrl=$this->router->getAnimalUrl($cle);
                // Récupérez le chemin de l'image de l'animal
                $imagePath = $valeur->getImagePath();
                // Si une image existe, on l'affiche
                $imageTag = '';
                if ($imagePath) {
                    // Affiche l'image, vous pouvez ajuster les dimensions ici si nécessaire
                    $imageTag = '<img src="' . htmlspecialchars($imagePath) . '" alt="Image de ' . htmlspecialchars($valeur->getNom()) . '" style="width: 50px; height: 50px; margin-right: 10px;">';
                }

                // Affichez l'élément de la liste avec l'image et le nom de l'animal
                $this->content .= '<li><a href="' . htmlspecialchars($animalUrl) . '">' . $imageTag . htmlspecialchars($valeur->getNom()) . '</a></li>';
            }
            $this->content.='</ul>';
        }

        public function prepareDebugPage($variable) {
            $this->title = 'Debug';
            $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
        }

        

}