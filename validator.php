<?php
require_once 'repository.php';

function estChaineVide(string $valeur):bool{
    return trim($valeur)=='';
}

function estTelephoneValide(string $telephone):bool{
    if(estChaineVide($telephone)){
        return false;
    }

    if(strlen($telephone)!=9){
        return false;
    }

    for($index=0;$index<strlen($telephone);$index++){
        if($telephone[$index]<'0' || $telephone[$index]>'9'){
            return false;
        }
    }

    return true;
}

function estMontantPositifOuNul(int $montant):bool{
    return $montant>=0;
}

function estMontantStrictementPositif(int $montant):bool{
    return $montant>0;
}

function estTelephoneUnique(string $telephone):bool{
    return trouverIndexWalletParTelephone($telephone)==-1;
}

function estCodeUnique(string $code):bool{
    return trouverIndexWalletParCode($code)==-1;
}

function walletExiste(string $telephone):bool{
    return trouverIndexWalletParTelephone($telephone)!=-1;
}

function codeSecretValide(string $code):bool{
    if(estChaineVide($code)){
        return false;
    }

    return true;
}

function soldeSuffisant(int $solde,int $montant,int $frais):bool{
    return $solde>=($montant+$frais);
}
?>