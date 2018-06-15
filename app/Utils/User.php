<?php

// @author Malycia
namespace MealOclock\Utils;

// Classe servant de librairie de fonctions
class User {
  public static function isConnected() {
    return !empty($_SESSION['user']);
  }
  
  public static function getUser() {
    if (self::isConnected()) {
        return $_SESSION['user'];
    }
    return false;
  }
  
  public static function setUser($userModel) {
      if (is_object($userModel)) {
          $_SESSION['user'] = $userModel;
      }
  }
  
  public static function isMember() {
    if (self::isConnected()) {
        return $_SESSION['user']->getRoleId() == 2;
    }
    return false;
  }
  
  public static function isAdmin() {
    if (self::isConnected()) {
        return $_SESSION['user']->getRoleId() == 1;
    }
    return false;
  }
  public static function logout() {
      // Je supprime uniquement la variable user qui me sert pour la connexion
      unset($_SESSION['user']);
      
      // Je peux aussi supprimer toutes les données en session
      session_unset();
      
      // Je peux aussi supprimer la sesssion complète (mais agit comme session_unset)
      session_destroy();
  }
}
