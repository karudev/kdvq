<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sf\AdminBundle\Entity\Invoice;

class InvoiceController extends Controller {

  
    public function dowloadAction(Invoice $invoice) {
        if($this->getUser()->hasRole('ROLE_ADMIN') == false && $this->getUser() != $invoice->getAccount()){
           return $this->redirect($this->generateUrl('fos_user_security_logout'));
        }
       
        require(__DIR__ . '/../Service/html2pdf/html2pdf.class.php');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('SfUserBundle:User')->findOneByRole('ROLE_ADMIN');
        $addressAdmin = $em->getRepository('SfUserBundle:Address')->getPriorityAddress($user);
        
        $details = $em->getRepository('SfAdminBundle:ProductModel')->getProductModelsGroupByRef(null,null,$invoice);
       
     // print_r($details); die();
        
        $html = $this->get('templating')->render('SfAdminBundle:Invoice:download.html.twig', 
                array('invoice' => $invoice,
                    'details' => $details,
                'addressAdmin' => $addressAdmin));

        try {
            $html2pdf = new \HTML2PDF('P', 'A4', 'fr');
            $html2pdf->writeHTML($html);
            $html2pdf->Output('Facture_'.$invoice->getNumber() . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        die();
    }

}
