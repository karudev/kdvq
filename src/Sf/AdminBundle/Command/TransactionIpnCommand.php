<?php

namespace Sf\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TransactionIpnCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('fg:transaction:ipn')
                ->setDescription('Simule Ipn')
                ->addArgument('payment_status', InputArgument::REQUIRED)
                ->addArgument('mc_gross', InputArgument::REQUIRED)
                ->addArgument('mc_currency', InputArgument::REQUIRED)
                ->addArgument('tax', InputArgument::REQUIRED)
                ->addArgument('shipping', InputArgument::REQUIRED)
                ->addArgument('receiver_email', InputArgument::REQUIRED)
                ->addArgument('token', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

////////// PARAMS
// Complétez $url avec l'url cible (l'url de la page que vous voulez télécharger)
        $url = "http://dev.fridging:8888/app_dev.php/transaction/ipn";

// Complétez le tableau associatif $postFields avec les variables qui seront envoyées par POST au serveur
        $postFields = array(
            'payment_status' => $input->getArgument('payment_status'),
            'mc_gross' => $input->getArgument('mc_gross'),
            'mc_currency' => $input->getArgument('mc_currency'),
            'tax' => $input->getArgument('tax'),
            'shipping' => $input->getArgument('shipping'),
            'receiver_email' => $input->getArgument('receiver_email'),
            'custom' => $input->getArgument('token'),
            'fridging_command' => true
        );
        
     


// Tableau contenant les options de téléchargement
        $options = array(
            CURLOPT_URL => $url, // Url cible (l'url de la page que vous voulez télécharger)
            CURLOPT_RETURNTRANSFER => true, // Retourner le contenu téléchargé dans une chaine (au lieu de l'afficher directement)
            CURLOPT_HEADER => false, // Ne pas inclure l'entête de réponse du serveur dans la chaine retournée
            CURLOPT_FAILONERROR => true, // Gestion des codes d'erreur HTTP supérieurs ou égaux à 400
            CURLOPT_POST => true, // Effectuer une requête de type POST
            CURLOPT_POSTFIELDS => $postFields // Le tableau associatif contenant les variables envoyées par POST au serveur
        );

////////// MAIN
// Création d'un nouvelle ressource cURL
        $CURL = curl_init();
// Erreur suffisante pour justifier un die()
        if (empty($CURL)) {
            die("ERREUR curl_init : Il semble que cURL ne soit pas disponible.");
        }

        // Configuration des options de téléchargement
        curl_setopt_array($CURL, $options);

        // Exécution de la requête
        $content = curl_exec($CURL);            // Le contenu téléchargé est enregistré dans la variable $content. Libre à vous de l'afficher.

        print_r($content);
       

        // Si il s'est produit une erreur lors du téléchargement
        if (curl_errno($CURL)) {
            // Le message d'erreur correspondant est affiché
            echo "ERREUR curl_exec : " . curl_error($CURL);
        }

// Fermeture de la session cURL
        curl_close($CURL);
    }

}
