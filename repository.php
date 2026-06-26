<?php
$wallets=[
    0=>['client'=>'Baila Wane','telephone'=>'771001010','code'=>'1234','solde'=>0],
    1=>['client'=>'Hawa Baila Wane','telephone'=>'782345678','code'=>'0000','solde'=>100000]
];

$transactions=[
    0=>['type'=>'depot','montant'=>1000,'frais'=>0,'indexClient'=>0],
    1=>['type'=>'retrait','montant'=>-5000,'frais'=>200,'indexClient'=>0]
];

function ajouterWallet(array $newWallet):void{
    global $wallets;
    $wallets[]=$newWallet;
}

function trouverIndexWalletParTelephone(string $telephone):int{
    global $wallets;

    foreach($wallets as $index=>$wallet){
        if($wallet['telephone']==$telephone){
            return $index;
        }
    }

    return -1;
}

function trouverIndexWalletParCode(string $code):int{
    global $wallets;

    foreach($wallets as $index=>$wallet){
        if($wallet['code']==$code){
            return $index;
        }
    }

    return -1;
}

function mettreAJourSoldeWallet(int $indexWallet,int $nouveauSolde):void{
    global $wallets;
    $wallets[$indexWallet]['solde']=$nouveauSolde;
}

function ajouterTransaction(array $transaction):void{
    global $transactions;
    $transactions[]=$transaction;
}

function getWallets():array{
    global $wallets;
    return $wallets;
}

function getTransactions():array{
    global $transactions;
    return $transactions;
}
?>