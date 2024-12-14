<?php
    
    class AnimalStorageStub implements AnimalStorage{

        private $animalsTab = array();
        public function __construct(){

            $this->animalsTab[42] = new Animal("Médor", "chien", 23);        
            $this->animalsTab[83] = new Animal("Félix", "chat", 2);        
            $this->animalsTab[128] = new Animal("Denver", "dinosaure", 1);
        }

        public function read($id){
            return $this->animalsTab[$id] ?? null;
        }

        public function readAll():array{
            return $this->animalsTab;
        }     

        public function create(Animal $a){
            //throw new Exception("Méthode 'create' non implémentée dans AnimalStorageStub.");
            $this->animalsTab[$a->getNom()] = $a;
        }

        public function delete($id){
            throw new Exception("Méthode 'delete' non implémentée dans AnimalStorageStub.");
        }

        public function update($id, Animal $a){
            throw new Exception("Méthode 'update' non implémentée dans AnimalStorageStub.");
        }

    }
?>