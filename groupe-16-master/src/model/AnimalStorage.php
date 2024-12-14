<?php
interface AnimalStorage{
    //Renvoie une instance de Animal ayant pour identifiant celui passé en argument
    public function read($id);

    //Renvoie un tableau associatif identifiant => animal
    public function readAll();

    /**
     * Cette méthode prend un objet de type `Animal` et l'ajoute à la base de données. Elle retourne
     * l'identifiant de l'animal nouvellement créé.
     * 
     * @param Animal $a L'animal à ajouter à la base de données.
     * @return int L'identifiant de l'animal créé.
     */
    public function create(Animal $a);

    /**
     * Supprime l'animal correspondant à l'identifiant donné dans la base de données.
     * @param int $id L'identifiant de l'animal à supprimer.
     * @return bool `true` si la suppression a été effectuée, sinon `false` si l'animal n'a pas été trouvé.
     */
    public function delete($id);

        /**
     * Met à jour l'animal d'identifiant donné dans la base de données.
     * @param int $id L'identifiant de l'animal à mettre à jour.
     * @param Animal $a L'animal contenant les nouvelles informations pour la mise à jour.
     * @return bool `true` si la mise à jour a été effectuée, sinon `false` si l'animal n'a pas été trouvé.
     */
    public function update($id, Animal $a);



}   
?>