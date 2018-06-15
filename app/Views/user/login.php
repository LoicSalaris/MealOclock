<?php $this->layout('layout') ?>

<div class="container">
    <h1>Connexion</h1>
    <div class="row">
        <div class="alert alert-danger" id="errorsDiv" role="alert" style="display:none;">
            
        </div>
        
        <form class="col-md-6 m-auto" action="" method="post" id="formLogin">
          <div class="form-group">
            <label for="exampleInputEmail1">Adresse email</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Adresse email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Mot de passe</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
