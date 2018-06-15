<?php

namespace MealOclock\Models;

use MealOclock\Database;
use PDO;

// abstract = Classe abstraite
// => interdiction d'instancier cette classe
abstract class CoreModel {
    // Si je factorise des propriétés, je factorise aussi leurs Getters & Setters
    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $status;
    /**
     * @var string
     */
    protected $date_inserted;
    /**
     * @var string
     */
    protected $date_updated;
    
    // Méthode permettant de gérer la sauvegarde en BDD
    // elle va détecter seul si elle insère ou met à jour
    public function save() {
      // Si on a un id => alors la ligne existe dans la table
      // => on met à jour
      if ($this->id > 0) {
        $retour = $this->update();
        return $retour;
      }
      // Sinon, la ligne n'existe pas dans la table
      // => on insère dans la table
      else {
        return $this->insert();
      }
    }

    // Déclaration de la méthode en "static"
    // car elle n'est pas liée à l'objet courant ($this)
    // mais à la classe en "général"
    public static function find($id) {
        // static::TABLE_NAME pour récupérer la constante sur un des enfants
      $sql = '
          SELECT *
          FROM '.static::TABLE_NAME.'
          WHERE id = :id';
      // Je prépare ma requête
      $pdoStatement = Database::getPDO()->prepare($sql);
      
      // Je "bind" les données/token/jeton de ma requête
      $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);
      
      // J'exécute ma requête
      $pdoStatement->execute();

      // Je récupère LE résultat
      // le self => reference à la classe où se trouve la methode
      // le static => reference à la classe ou est appellée la methode
      // @author Sonia 404
      $result = $pdoStatement->fetchObject(static::class);

      return $result;
    }

    // Méthode permettant de retourner toutes les lignes de la table
    // Déclaration de la méthode en "static"
    // car elle n'est pas liée à l'objet courant ($this)
    // mais à la classe en "général"
    public static function findAll() {
        // $this-> = objet courant
        // self:: = classe dans laquelle est écrit le mot-clé self
        // static:: = classe depuis laquelle est appelé la méthode (classe courante)
        // @author Grumpy-Céline
        // echo 'le code est sur la classe : '.self::class.'<br>';
        // echo 'on va faire le fetch sur : '.static::class.'<br>';
        $sql = "
            SELECT *
            FROM ".static::TABLE_NAME."
        ";
        // Utilisation de notre classe Database pour se connecter à la database
        $pdo = Database::getPDO();

        // exécution de la requête
        $pdoStatement = $pdo->query($sql);

        // Je veux récupérer tous les résultats sous forme de tableau d'objet CommunityModel
        // on doit préciser le FQCN de la classe
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, static::class);

        // On retourne les résultats
        return $results;
    }
    
    public function delete() {
        $sql = '
            DELETE FROM '.static::TABLE_NAME.'
            WHERE id = :id
        ';
        // Je prépare
        $pdoStatement = Database::getPDO()->prepare($sql);
        
        // Je fais mes "binds"
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        // j'exécute la requête préparée
        $affectedRows = $pdoStatement->execute();
        
        return $affectedRows;
    }
    
    // Je suis une classe abstraite, je ne travaille pas, ce sont mes enfants qui bossent pour moi
    // Et en plus, je peux donner des ordres à mes enfants !
    
    // Ordre : mon enfant, définit une méthode "insert"
    protected abstract function insert();
    
    // Ordre : mon enfant, définit une méthode "update"
    protected abstract function update();

    /**
     * Get the value of Id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    // PAS de setId !

    /**
     * Get the value of Status
     *
     * @return int
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set the value of Status
     *
     * @param int status
     */
    public function setStatus($status) {
        if (!empty($status)) {
            $this->status = $status;
        }
    }

    /**
     * Get the value of Date Inserted
     *
     * @return string
     */
    public function getDateInserted() {
        return $this->date_inserted;
    }

    /**
     * Get the value of Date Updated
     *
     * @return string
     */
    public function getDateUpdated() {
        return $this->date_updated;
    }
}
