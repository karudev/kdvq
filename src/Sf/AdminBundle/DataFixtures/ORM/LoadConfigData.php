<?php

namespace Sf\AdminBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sf\AdminBundle\Entity\Config;

class LoadConfigData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $config = new Config();
        $config->setName('contact_mail_fr');
        $config->setValue('contact_fr@test.fr');
        $manager->persist($config);


        $config = new Config();
        $config->setName('contact_mail_en');
        $config->setValue('contact_en@test.fr');
        $manager->persist($config);

      /*  $config = new Config();
        $config->setName('smtp');
        $config->setValue('smtp@test.fr');
        $manager->persist($config);

        $config = new Config();
        $config->setName('port');
        $config->setValue('25');
        $manager->persist($config);
*/
        $config = new Config();
        $config->setName('subject_fr');
        $config->setValue('Demande de devis');
        $manager->persist($config);

        $config = new Config();
        $config->setName('subject_en');
        $config->setValue('Quote request');
        $manager->persist($config);

        $config = new Config();
        $config->setName('web_agency_address');
        $config->setValue('11, rue felix faure');
        $manager->persist($config);
        
        $config = new Config();
        $config->setName('web_agency_city_country');
        $config->setValue('92600 Asnière sur Seine, France');
        $manager->persist($config);

        $config = new Config();
        $config->setName('web_agency_phone');
        $config->setValue('+33 6 85 74 88 14');
        $manager->persist($config);

        $manager->flush();
    }

}
?>
