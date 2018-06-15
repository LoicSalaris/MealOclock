<?php

namespace MealOclock\Models;

// J'importe les classes se trouvant dans un autre namespace
use MealOclock\Database;
use PDO;

/* Règles :
  - 1 table = 1 model
  - 1 champ = 1 propriété
*/
class CommunityModel extends CoreModel implements \JsonSerializable {
  // Je crée une propriété pour chaque champ/colonne de la table
  private $name;
  private $slug;
  private $description;
  private $image;
  
  // Constante attachée à ma classe
  // pas de "static", c'est implicite
  const TABLE_NAME = 'community';

  /* CRUD sur la table 'community'
  Create => insert()
  Read => find()
  Update => update()
  Delete => delete()
  */
 
    // Je surcharge (override) la méthode findAll pour ne prendre que les lignes avec status = 1
    public static function findAll() {
        // J'appelle la méthode "parent" afin de récupérer les résultats
        // $this-> = objet courant
        // self:: = classe dans laquelle est écrit le mot-clé self
        // static:: = classe depuis laquelle est appelé la méthode (classe courante)
        // parent:: = classe parente
        // @author Grumpy-Céline
        $results = parent::findAll(); // parent => CoreModel
        // echo '<h3>TEST $results</h3>';
        // dump($results);
        
        // J'initialise le tableau que je vais retournée
        $newResults = array();
        foreach ($results as $currentCommunityModel) {
            // Je n'ajoute au retour que si status = 1
            if ($currentCommunityModel->status == 1) {
                $newResults[] = $currentCommunityModel;
            }
        }
        
        return $newResults;
    }
    
    // Challenge E07
    // la méthode récupérant une liste des communautés dont l'utilisateur est "membre"
    public static function findAllByUserId($userId) {
        $sql = '
            SELECT community.*
            FROM user
            INNER JOIN community_has_user ON community_has_user.user_id = user.id
            INNER JOIN community ON community_has_user.community_id = community.id
            WHERE user.id = :userId
        ';
        // Je prépare ma requête
        $pdoStatement = Database::getPDO()->prepare($sql);
        
        // Je fais mes "binds"
        $pdoStatement->bindValue(':userId', $userId, PDO::PARAM_INT);
        
        // Exécution de la requête
        $pdoStatement->execute();
        
        // Je récupère les résultats sous forme de tableau d'objets
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }

  // Méthode privée car seule la méthode save() va l'utiliser
  protected function insert() {
    $sql = "
      INSERT INTO ".self::TABLE_NAME." (name, slug, description, image, status, date_inserted, date_updated)
      VALUES (
        :name,
        :slug,
        :descriptionToto,
        :image,
        :status,
        NOW(),
        NOW()
      )
    ";
    // Je prépare ma requête
    $pdoStatement = Database::getPDO()->prepare($sql);
    
    // Je fais mes "binds"
    $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
    $pdoStatement->bindValue(':slug', $this->slug, PDO::PARAM_STR);
    $pdoStatement->bindValue(':descriptionToto', $this->description, PDO::PARAM_STR);
    $pdoStatement->bindValue(':image', $this->image, PDO::PARAM_STR);
    $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
    
    // Exécution de la requête
    $affectedRows = $pdoStatement->execute();

    return $affectedRows;
  }

  // Méthode privée car seule la méthode save() va l'utiliser
  protected function update() {
    $sql = "
        UPDATE ".self::TABLE_NAME."
        SET name = :name,
        slug = :slug,
        description = :description,
        image = :image,
        status = :status,
        date_updated = NOW()
        WHERE id = :id
    ";
    // Je prépare ma requête
    $pdoStatement = Database::getPDO()->prepare($sql);

    // Je fais mes "binds"
    $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
    $pdoStatement->bindValue(':slug', $this->slug, PDO::PARAM_STR);
    $pdoStatement->bindValue(':description', $this->description, PDO::PARAM_STR);
    $pdoStatement->bindValue(':image', $this->image, PDO::PARAM_STR);
    $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
    $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

    // J'exécute ma requête
    $affectedRows = $pdoStatement->execute();

    return $affectedRows;
  }
  
  public function jsonSerialize() {
      return get_object_vars($this);
  }
  
 /**
  * Returns if slug already exists
  *
  * @param string $slug
  * @return bool
  */
 public function slugExists($slug) {
   // TODO
 }

  // Getters
  public function getName() {
    return $this->name;
  }
  public function getSlug() {
    return $this->slug;
  }
  public function getDescription() {
    return $this->description;
  }
  public function getImage() {
    return $this->image;
  }

  // Setters
  public function setName($name) {
    // Dans un setter, je peux tester la valeur qu'on veut affecter à la propriété
    // ici une valeur "string" non vide
    if (is_string($name) && !empty($name)) {
      $this->name = $name;
    }
  }
  public function setSlug($slug) {
    if (is_string($slug) && !empty($slug)) {
      $this->slug = $slug;
    }
  }
  public function setDescription($description) {
    if (is_string($description) && !empty($description)) {
      $this->description = $description;
    }
  }
  public function setImage($image) {
    if (is_string($image) && !empty($image)) {
      $this->image = $image;
    }
  }
}
