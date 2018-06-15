<?php

namespace MealOclock\Models;

// J'importe les classes qui se trouvent dans un autre namespace
use MealOclock\Database;
use PDO;

class UserModel extends CoreModel {
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $presentation;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $picture;
    /**
     * @var int
     */
    protected $role_id;
    
    // Constante attachée à ma classe
    // pas de "static", c'est implicite
    const TABLE_NAME = 'user';
    
    // Challenge E07
    // la méthode récupérant une liste des communautés dont l'utilisateur est "membre"
    public function getCommunities() {
        return CommunityModel::findAllByUserId($this->id);
    }
    
    public static function findByEmailOrUsername($emailOrUsername) {
        $sql = '
            SELECT *
            FROM '.self::TABLE_NAME.'
            WHERE email = :emailOrUsername
            OR username = :emailOrUsername
            LIMIT 1
        ';
        $pdoStatement = Database::getPDO()->prepare($sql);
        
        $pdoStatement->bindValue(':emailOrUsername', $emailOrUsername, PDO::PARAM_STR);
        
        $pdoStatement->execute();
        
        // JE n'ai qu'un résultat => fetchObject
        $result = $pdoStatement->fetchObject(self::class);
        
        return $result;
    }
    
    protected function insert() {
        $sql = '
            INSERT INTO '.self::TABLE_NAME.'
            (`username`, `presentation`, `email`, `password`, `picture`, `status`, `date_inserted`, `date_updated`, `role_id`)
            VALUES
            (:username, :presentation, :email, :password, :picture, :status, NOW(), NOW(), :roleId)
        ';
        // Je prépare
        $pdoStatement = Database::getPDO()->prepare($sql);
        
        // Je "bind"
        $pdoStatement->bindValue(':username', $this->username , PDO::PARAM_STR);
        $pdoStatement->bindValue(':presentation', $this->presentation , PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $this->email , PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password , PDO::PARAM_STR);
        $pdoStatement->bindValue(':picture', $this->picture , PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':roleId', $this->role_id, PDO::PARAM_INT);
        
        // J'exécute la requete
        $affectedRows = $pdoStatement->execute();
        
        // Je récupère l'id auto-incrémenté
        // et je l'affecte à la propriété id
        $this->id = Database::getPDO()->lastInsertId();
        
        return $affectedRows;
    }
    
    protected  function update() {
        $sql = '
            UPDATE '.self::TABLE_NAME.'
            SET `username` = :username,
            `presentation` = :presentation,
            `email` = :email,
            `password` = :password,
            `picture` = :picture,
            `status` = :status,
            `date_updated` = NOW(),
            `role_id` = :roleId
            WHERE id = :id
        ';
        // Je prépare
        $pdoStatement = Database::getPDO()->prepare($sql);
        
        // Je "bind"
        $pdoStatement->bindValue(':username', $this->username , PDO::PARAM_STR);
        $pdoStatement->bindValue(':presentation', $this->presentation , PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $this->email , PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password , PDO::PARAM_STR);
        $pdoStatement->bindValue(':picture', $this->picture , PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':roleId', $this->role_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        // J'exécute la requete
        $affectedRows = $pdoStatement->execute();
        
        return $affectedRows;
    }
    
    

    /**
    * Get the value of Username
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set the value of Username
     *
     * @param string username
     */
    public function setUsername($username) {
        if (!empty($username)) {
            $this->username = $username;
        }
    }

    /**
     * Get the value of Presentation
     *
     * @return string
     */
    public function getPresentation() {
        return $this->presentation;
    }

    /**
     * Set the value of Presentation
     *
     * @param string presentation
     */
    public function setPresentation($presentation) {
        if (!empty($presentation)) {
            $this->presentation = $presentation;
        }
    }

    /**
     * Get the value of Email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set the value of Email
     *
     * @param string email
     */
    public function setEmail($email) {
        if (!empty($email)) {
            $this->email = $email;
        }
    }

    /**
     * Get the value of Password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set the value of Password
     *
     * @param string password
     */
    public function setPassword($password) {
        if (!empty($password)) {
            $this->password = $password;
        }
    }

    /**
     * Get the value of Picture
     *
     * @return string
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * Set the value of Picture
     *
     * @param string picture
     */
    public function setPicture($picture) {
        if (!empty($picture)) {
            $this->picture = $picture;
        }
    }

    /**
     * Get the value of Role Id
     *
     * @return int
     */
    public function getRoleId() {
        return $this->role_id;
    }

    /**
     * Set the value of Role Id
     *
     * @param int role_id
     */
    public function setRoleId($role_id) {
        if (!empty($role_id)) {
            $this->role_id = $role_id;
        }
    }

}
