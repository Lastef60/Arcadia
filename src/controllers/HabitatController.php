<?php

require_once(__DIR__ . '/../models/Habitat.php');
require_once(__DIR__ . '/../models/Database.php');

class HabitatController
{
    private $habitatModel;

    // Injecter la connexion PDO dans le constructeur
    public function __construct($pdo)
    {
        $this->habitatModel = new Habitat($pdo);
    }

    // Afficher tous les habitats
    public function list()
    {
        $habitats = $this->habitatModel->getAll(); // Obtenir tous les habitats
        require_once(__DIR__ . '/../views/habitat/list.php'); // Charger la vue pour afficher les habitats
    }

    // Afficher les détails d'un habitat et ses animaux
    public function show($id)
    {
        $habitat = $this->habitatModel->getById($id);
        require_once(__DIR__ . '/../views/habitat/show.php'); // Vue des détails d'un habitat
    }

    // Créer un nouvel habitat
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $description = $_POST['description'];
            $commentaire = $_POST['commentaire_habitat'];
            $this->habitatModel->create($nom, $description, $commentaire);
            header('Location: /habitats'); // Rediriger après création
        } else {
            require_once(__DIR__ . '/../views/habitat/create.php'); // Charger la vue pour créer un habitat
        }
    }

    // Mettre à jour un habitat
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $description = $_POST['description'];
            $commentaire = $_POST['commentaire_habitat'];
            $this->habitatModel->update($id, $nom, $description, $commentaire);
            header('Location: /habitats'); // Rediriger après mise à jour
        } else {
            $habitat = $this->habitatModel->getById($id);
            require_once(__DIR__ . '/../views/habitat/edit.php'); // Charger la vue pour éditer un habitat
        }
    }

    // Méthode pour éditer un habitat
    public function edit($id)
    {
        // Afficher le formulaire d'édition d'un habitat
        $habitat = $this->habitatModel->getById($id);
        require_once(__DIR__ . '/../views/habitat/edit.php');
    }

    // Supprimer un habitat
    public function delete($id)
    {
        $this->habitatModel->delete($id);
        header('Location: /habitats'); // Rediriger après suppression
    }

    // Méthode pour mettre à jour un commentaire d'un habitat
    public function updateComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['habitat_id'])) {
            $habitatId = $_POST['habitat_id'];
            $commentaire = $_POST['commentaire_habitat'];

            $this->habitatModel->updateComment($habitatId, $commentaire);
            header('Location: /employe.php'); // Rediriger après mise à jour
        } else {
            echo "<p>Requête invalide. Veuillez soumettre le formulaire avec les informations nécessaires.</p>";
        }
    }
}
