<?php

namespace MealOclock\Models;

// J'importe la classe Database
use MealOclock\Database;
use PDO;

class EventModel extends CoreModel {
    // Les propriétés du EventModel
    // Rappel : 1 champ = 1 propriété
    
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var float
     */
    private $price;
    /**
     * @var string
     */
    private $date_event;
    /**
     * @var string
     */
    private $address;
    /**
     * @var string
     */
    private $zipcode;
    /**
     * @var string
     */
    private $city;
    /**
     * @var int
     */
    private $nb_guests;
    /**
     * 1 => true, 2 => false
     * @var int
     */
    private $is_virtual;
    /**
     * @var string
     */
    private $virtual_address;
    /**
     * @var int
     */
    private $community_id;
    /**
     * @var int
     */
    private $user_id;
    
    // nom de la table, sous forme de constante
    const TABLE_NAME = 'event';
    
    // pas de $this => méthode static
    public static function getNextFive() {
        $sql = '
            SELECT *
            FROM '.self::TABLE_NAME.'
            WHERE status = 1
            AND date_event >= NOW()
            ORDER BY date_event ASC
            LIMIT 5
        ';
        // ->query() car pas de variables dans ma requete
        $pdoStatement = Database::getPDO()->query($sql);
        
        // Je récupère les résutlats sous forme de tableau d'EventModel
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $results;
    }
    
    protected  function insert() {
        $sql = '
            INSERT INTO '.self::TABLE_NAME.'
            (`title`, `description`, `price`, `date_event`, `address`, `zipcode`, `city`, `nb_guests`, `is_virtual`, `virtual_address`, `status`, `date_inserted`, `date_updated`, `community_id`, `user_id`)
            VALUES
            (:title,:description,:price,:date,:address,:zipcode,:city,:guests, :isVirtual, :virtualAddress, :status, NOW(), NOW(), :communityId, :userId)
        ';
        // Je prépare
        $pdoStatement = Database::getPDO()->prepare($sql);
        
        // Je "bind"
        $pdoStatement->bindValue(':title', $this->title , PDO::PARAM_STR);
        $pdoStatement->bindValue(':description', $this->description, PDO::PARAM_STR);
        // TODO tester si une valeur décimale est acceptée
        $pdoStatement->bindValue(':price', $this->price, PDO::PARAM_INT);
        $pdoStatement->bindValue(':date', $this->date_event, PDO::PARAM_STR);
        $pdoStatement->bindValue(':address', $this->address, PDO::PARAM_STR);
        $pdoStatement->bindValue(':zipcode', $this->zipcode, PDO::PARAM_STR);
        $pdoStatement->bindValue(':city', $this->city, PDO::PARAM_STR);
        $pdoStatement->bindValue(':guests', $this->nb_guests, PDO::PARAM_INT);
        $pdoStatement->bindValue(':isVirtual', $this->is_virtual, PDO::PARAM_INT);
        $pdoStatement->bindValue(':virtualAddress', $this->virtual_address, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':communityId', $this->community_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':userId', $this->user_id, PDO::PARAM_INT);
        
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
            SET `title` = :title,
            `description` = :description,
            `price` = :price,
            `date_event` = :date,
            `address` = :address,
            `zipcode` = :zipcode,
            `city` = :city,
            `nb_guests` = :guests,
            `is_virtual` = :isVirtual,
            `virtual_address` = :virtualAddress,
            `status` = :status,
            `date_updated` = NOW(),
            `community_id` = :communityId,
            `user_id` = :userId
            WHERE id = :id
        ';
        // Je prépare
        $pdoStatement = Database::getPDO()->prepare($sql);
        
        // Je "bind"
        $pdoStatement->bindValue(':title', $this->title , PDO::PARAM_STR);
        $pdoStatement->bindValue(':description', $this->description, PDO::PARAM_STR);
        // TODO tester si une valeur décimale est acceptée
        $pdoStatement->bindValue(':price', $this->price, PDO::PARAM_INT);
        $pdoStatement->bindValue(':date', $this->date_event, PDO::PARAM_STR);
        $pdoStatement->bindValue(':address', $this->address, PDO::PARAM_STR);
        $pdoStatement->bindValue(':zipcode', $this->zipcode, PDO::PARAM_STR);
        $pdoStatement->bindValue(':city', $this->city, PDO::PARAM_STR);
        $pdoStatement->bindValue(':guests', $this->nb_guests, PDO::PARAM_INT);
        $pdoStatement->bindValue(':isVirtual', $this->is_virtual, PDO::PARAM_INT);
        $pdoStatement->bindValue(':virtualAddress', $this->virtual_address, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':communityId', $this->community_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':userId', $this->user_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        // J'exécute la requete
        $affectedRows = $pdoStatement->execute();
        
        return $affectedRows;
    }

    /**
     * Get the formatted value of Date Event
     *
     * @return string
     */
    public function getFormattedDateEvent() {
        // Je convertie en timestamp
        $timestamp = strtotime($this->date_event);
        // Je retourne la date formaté selon le pattern FR
        return date('d/m/Y', $timestamp);
    }

    // *** GETTERS & SETTERS ***

    /**
     * Get the value of Title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set the value of Title
     *
     * @param string title
     */
    public function setTitle($title) {
        if (!empty($title)) {
            $this->title = $title;
        }
    }

    /**
     * Get the value of Description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set the value of Description
     *
     * @param string description
     */
    public function setDescription($description) {
        if (!empty($description)) {
            $this->description = $description;
        }
    }

    /**
     * Get the value of Price
     *
     * @return float
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set the value of Price
     *
     * @param float price
     */
    public function setPrice($price) {
        if (!empty($price)) {
            $this->price = $price;
        }
    }

    /**
     * Get the value of Date Event
     *
     * @return string
     */
    public function getDateEvent() {
        return $this->date_event;
    }

    /**
     * Set the value of Date Event
     *
     * @param string date_event
     */
    public function setDateEvent($date_event) {
        if (!empty($date_event)) {
            $this->date_event = $date_event;
        }
    }

    /**
     * Get the value of Address
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set the value of Address
     *
     * @param string address
     */
    public function setAddress($address) {
        if (!empty($address)) {
            $this->address = $address;
        }
    }

    /**
     * Get the value of Zipcode
     *
     * @return string
     */
    public function getZipcode() {
        return $this->zipcode;
    }

    /**
     * Set the value of Zipcode
     *
     * @param string zipcode
     */
    public function setZipcode($zipcode) {
        if (!empty($zipcode)) {
            $this->zipcode = $zipcode;
        }
    }

    /**
     * Get the value of City
     *
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set the value of City
     *
     * @param string city
     */
    public function setCity($city) {
        if (!empty($city)) {
            $this->city = $city;
        }
    }

    /**
     * Get the value of Nb Guests
     *
     * @return int
     */
    public function getNbGuests() {
        return $this->nb_guests;
    }

    /**
     * Set the value of Nb Guests
     *
     * @param int nb_guests
     */
    public function setNbGuests($nb_guests) {
        if (!empty($nb_guests)) {
            $this->nb_guests = $nb_guests;
        }
    }

    /**
     * Get the value of Is Virtual
     *
     * @return bool
     */
    public function getIsVirtual() {
        return $this->is_virtual;
    }

    /**
     * Set the value of Is Virtual
     *
     * @param bool is_virtual
     */
    public function setIsVirtual($is_virtual) {
        if (!empty($is_virtual)) {
            $this->is_virtual = $is_virtual;
        }
    }

    /**
     * Get the value of Virtual Adress
     *
     * @return string
     */
    public function getVirtualAdress() {
        return $this->virtual_address;
    }

    /**
     * Set the value of Virtual Adress
     *
     * @param string virtual_address
     */
    public function setVirtualAdress($virtual_address) {
        if (!empty($virtual_address)) {
            $this->virtual_address = $virtual_address;
        }
    }

    /**
     * Get the value of Community Id
     *
     * @return int
     */
    public function getCommunityId() {
        return $this->community_id;
    }

    /**
     * Set the value of Community Id
     *
     * @param int community_id
     */
    public function setCommunityId($community_id) {
        if (!empty($community_id)) {
            $this->community_id = $community_id;
        }
    }

    /**
     * Get the value of User Id
     *
     * @return int
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * Set the value of User Id
     *
     * @param int user_id
     */
    public function setUserId($user_id) {
        if (!empty($user_id)) {
            $this->user_id = $user_id;
        }
    }

}
