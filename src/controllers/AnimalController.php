<?php
require_once(__DIR__ . '/../models/Animal.php');


class AnimalController
{
  private $animalModel;

  public function __construct($pdo)
  {
    $this->animalModel = new Animal($pdo);
  }

  // List animals by habitat
  public function list($habitat_id)
  {
    return $this->animalModel->getAnimalsByHabitat($habitat_id);
  }

  // Show  animal
  public function show($animal_id)
  {
    $animal = $this->animalModel->getAnimalById($animal_id);
    require_once(__DIR__ . '/../src/views/animal/show.php');
  }

  // Create  animal
  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'prenom' => $_POST['prenom'],
        'etat' => $_POST['etat'],
        'genre' => $_POST['genre'],
        'age' => $_POST['age'],
        'race_id' => $_POST['race_id'],
        'habitat_id' => $_POST['habitat_id']
      ];
      $this->animalModel->createAnimal($data);
      header('Location: index.php?controller=animal&action=list');
    } else {
      require_once(__DIR__ . '/../src/views/animal/create.php');
    }
  }

  // Edit  animal
  public function edit($animal_id)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'prenom' => $_POST['prenom'],
        'etat' => $_POST['etat'],
        'genre' => $_POST['genre'],
        'age' => $_POST['age'],
        'race_id' => $_POST['race_id'],
        'habitat_id' => $_POST['habitat_id']
      ];
      $this->animalModel->updateAnimal($animal_id, $data);
      header('Location: index.php?controller=animal&action=list');
    } else {
      $animal = $this->animalModel->getAnimalById($animal_id);
      require_once(__DIR__ . '/../src/views/animal/edit.php');
    }
  }

  // Delete  animal
  public function delete($animal_id)
  {
    $this->animalModel->deleteAnimal($animal_id);
    header('Location: index.php?controller=animal&action=list');
  }
}
