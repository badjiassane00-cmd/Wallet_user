<?php
require_once 'repository.php';
require_once 'validator.php';

function calculerFraisRetrait(int $montant):int{
    if($montant<=10000){
        return 200;
    }

    if($montant<=100000){
        return 500;
    }

    $frais=(int)($montant*0.01);
    if($frais>5000){
        $frais=5000;
    }

    return $frais;
}

function creerWalletService(array $newWallet):array{
    if(estChaineVide($newWallet['client'])){
        return ['success'=>false,'message'=>'Nom du client obligatoire'];
    }

    if(!estTelephoneValide($newWallet['telephone'])){
        return ['success'=>false,'message'=>'Numero de telephone invalide'];
    }

    if(!estTelephoneUnique($newWallet['telephone'])){
        return ['success'=>false,'message'=>'Ce numero existe deja'];
    }

    if(!estMontantPositifOuNul($newWallet['solde'])){
        return ['success'=>false,'message'=>'Le solde initial doit etre positif ou nul'];
    }

    if(!codeSecretValide($newWallet['code'])){
        return ['success'=>false,'message'=>'Code secret obligatoire'];
    }

    if(!estCodeUnique($newWallet['code'])){
        return ['success'=>false,'message'=>'Ce code secret existe deja'];
    }

    ajouterWallet($newWallet);
    return ['success'=>true,'message'=>'Wallet cree avec succes'];
}

function faireDepotService(string $telephone,int $montant):array{
    if(!walletExiste($telephone)){
        return ['success'=>false,'message'=>'Le wallet est introuvable'];
    }

    if(!estMontantStrictementPositif($montant)){
        return ['success'=>false,'message'=>'Le montant du depot doit etre strictement positif'];
    }

    $indexWallet=trouverIndexWalletParTelephone($telephone);
    $wallets=getWallets();
    $nouveauSolde=$wallets[$indexWallet]['solde']+$montant;
    mettreAJourSoldeWallet($indexWallet,$nouveauSolde);
    ajouterTransaction(['type'=>'depot','montant'=>$montant,'frais'=>0,'indexClient'=>$indexWallet]);

    return ['success'=>true,'message'=>'Depot effectue avec succes'];
}

function faireRetraitService(string $telephone,int $montant):array{
    if(!walletExiste($telephone)){
        return ['success'=>false,'message'=>'Le wallet est introuvable'];
    }

    if(!estMontantStrictementPositif($montant)){
        return ['success'=>false,'message'=>'Le montant du retrait doit etre strictement positif'];
    }

    $indexWallet=trouverIndexWalletParTelephone($telephone);
    $wallets=getWallets();
    $wallet=$wallets[$indexWallet];
    $frais=calculerFraisRetrait($montant);

    if(!soldeSuffisant($wallet['solde'],$montant,$frais)){
        return ['success'=>false,'message'=>'Solde insuffisant pour effectuer ce retrait'];
    }

    $nouveauSolde=$wallet['solde']-($montant+$frais);
    mettreAJourSoldeWallet($indexWallet,$nouveauSolde);
    ajouterTransaction(['type'=>'retrait','montant'=>-$montant,'frais'=>$frais,'indexClient'=>$indexWallet]);

    return ['success'=>true,'message'=>'Retrait effectue avec succes'];
}

function listerTransactionsService():array{
    return getTransactions();
}
?>