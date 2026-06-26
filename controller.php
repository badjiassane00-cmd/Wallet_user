<?php
require_once 'services.php';

function saisirWallet():array{
    $wallet=['client'=>'','telephone'=>'','code'=>'','solde'=>0];
    $wallet['client']=readline('Veuillez saisir un client : ');
    $wallet['telephone']=readline('Veuillez saisir un telephone : ');
    $wallet['code']=readline('Veuillez saisir un code : ');
    $wallet['solde']=(int)readline('Veuillez saisir un solde initial : ');
    return $wallet;
}

function afficherWallets(array $wallets):void{
    echo "\nListe des wallets\n";
    foreach($wallets as $wallet){
        echo 'Titulaire : '.$wallet['client']."\n";
        echo 'Telephone : '.$wallet['telephone']."\n";
        echo 'Code : '.$wallet['code']."\n";
        echo 'Solde : '.$wallet['solde']."\n";
        echo "------------------------\n";
    }
}

function afficherTransactions(array $transactions,array $wallets):void{
    if(count($transactions)==0){
        echo "Aucune transaction trouvee\n";
        return;
    }

    foreach($transactions as $transaction){
        $indexClient=$transaction['indexClient'];
        echo 'Type : '.$transaction['type']."\n";
        echo 'Montant : '.$transaction['montant']."\n";
        echo 'Frais : '.$transaction['frais']."\n";
        echo 'Titulaire : '.$wallets[$indexClient]['client']."\n";
        echo 'Telephone : '.$wallets[$indexClient]['telephone']."\n";
        echo "------------------------\n";
    }
}

function afficherTransactionsParTelephone(array $transactions,array $wallets,string $telephone):void{
    $trouve=false;

    foreach($transactions as $transaction){
        $indexClient=$transaction['indexClient'];
        if($wallets[$indexClient]['telephone']==$telephone){
            $trouve=true;
            echo 'Type : '.$transaction['type']."\n";
            echo 'Montant : '.$transaction['montant']."\n";
            echo 'Frais : '.$transaction['frais']."\n";
            echo 'Titulaire : '.$wallets[$indexClient]['client']."\n";
            echo 'Telephone : '.$wallets[$indexClient]['telephone']."\n";
            echo "------------------------\n";
        }
    }

    if(!$trouve){
        echo "Aucune transaction pour ce numero\n";
    }
}

function gererCreationWallet():void{
    $newWallet=saisirWallet();
    $resultat=creerWalletService($newWallet);
    echo $resultat['message']."\n";

    if($resultat['success']){
        $wallets=getWallets();
        afficherWallets($wallets);
    }
}

function gererDepot():void{
    $telephone=readline('Veuillez saisir le telephone du wallet : ');
    $montant=(int)readline('Veuillez saisir le montant du depot : ');
    $resultat=faireDepotService($telephone,$montant);
    echo $resultat['message']."\n";

    if($resultat['success']){
        $wallets=getWallets();
        $indexWallet=trouverIndexWalletParTelephone($telephone);
        echo 'Nouveau solde : '.$wallets[$indexWallet]['solde']."\n";
    }
}

function gererRetrait():void{
    $telephone=readline('Veuillez saisir le telephone du wallet : ');
    $montant=(int)readline('Veuillez saisir le montant du retrait : ');
    $resultat=faireRetraitService($telephone,$montant);
    echo $resultat['message']."\n";

    if($resultat['success']){
        $wallets=getWallets();
        $indexWallet=trouverIndexWalletParTelephone($telephone);
        echo 'Nouveau solde : '.$wallets[$indexWallet]['solde']."\n";
    }
}

function gererListeTransactions():void{
    $transactions=listerTransactionsService();
    $wallets=getWallets();
    echo "1 - Toutes les transactions\n";
    echo "2 - Transactions par telephone\n";
    $choix=readline('Votre choix : ');

    if($choix==1){
        afficherTransactions($transactions,$wallets);
    }elseif($choix==2){
        $telephone=readline('Veuillez saisir le telephone : ');
        afficherTransactionsParTelephone($transactions,$wallets,$telephone);
    }else{
        echo "Choix invalide, veuillez reessayer\n";
    }
}
?>