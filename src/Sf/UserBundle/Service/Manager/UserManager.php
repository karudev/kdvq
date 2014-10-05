<?php

namespace Sf\UserBundle\Service\Manager;

use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;
use FOS\UserBundle\Model\UserInterface;

class UserManager extends BaseUserManager {

    public $container;

    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * Updates a user.
     *
     * @param UserInterface $user
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     */
    public function updateUser(UserInterface $user) {

        $em = $this->container->get('doctrine')->getManager();
        $repo = $em->getRepository('SfUserBundle:User');





        # Vérification of email
        if ($repo->checkEmail($user)) {
            $error = $this->container->get('translator')->trans('Cette email existe déja', array(), 'SfFrontBundle');
            return array('success' => false, 'message' => $error);
        }




        $user->setUsername($user->getEmail());
        $tokenGenerator = $this->container->get('fos_user.util.token_generator');
        $user->setConfirmationToken($tokenGenerator->generateToken());
        
        $userMail = clone $user;
        if (count($user->getAddresses())) {
            foreach ($user->getAddresses() as $ad) {
                $ad->setAccount($user);
                $em->persist($ad);
                $em->flush();
            }
        }







        $this->container->get('fos_user.user_manager')->updateUser($user, true);
        $this->container->get('sf_user.mail_helper')->activeAccount($userMail);

        $message = $this->container->get('translator')->trans('Votre compte a été crée, veuillez l\'activer depuis l\'email que vous avez reçu', array(), 'SfFrontBundle');
        $this->container->get('session')->getFlashBag()->add('success', $message);
        return array('success' => true);
    }

}
