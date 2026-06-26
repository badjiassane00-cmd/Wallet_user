<?php
require_once 'controller.php';

function afficherMenu():void{
    echo "\n** Menu Distributeur **\n";
    echo "1 - Creer Wallet\n";
    echo "2 - Faire Depot\n";
    echo "3 - Faire Retrait\n";
    echo "4 - Lister les Transactions\n";
    echo "0 - Quitter\n";
}

$choix=-1;

while($choix!=0){
    afficherMenu();
    $choix=readline('Veuillez faire un choix : ');

    if($choix==1){
        gererCreationWallet();
    }elseif($choix==2){
        gererDepot();
    }elseif($choix==3){
        gererRetrait();
    }elseif($choix==4){
        gererListeTransactions();
    }elseif($choix==0){
        echo "Merci et a bientot\n";
    }else{
        echo "Choix invalide, veuillez reessayer\n";
    }
}
?>