<?php
/**
 * Created by PhpStorm.
 * User: pierrick
 * Date: 09/10/18
 * Time: 00:11
 */

namespace App\DataFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ProgrammationCircuit;

class LoadProgrammationCircuitData extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $circuit=$this->getReference('andalousie-circuit');
        $programmationCircuit=new ProgrammationCircuit();
        $programmationCircuit->setDateDepart(new \DateTime('2019-01-23T14:00:00'));
        $programmationCircuit->setNombrePersonnes(100);
        $programmationCircuit->setPrix(1100);
        $programmationCircuit->setCircuit($circuit);
        $circuit->addProgrammationCircuit($programmationCircuit);
        $manager->persist($programmationCircuit);

        $circuit=$this->getReference('vietnam-circuit');
        $programmationCircuit=new ProgrammationCircuit();
        $programmationCircuit->setDateDepart(new \DateTime('2018-12-12T08:00:00'));
        $programmationCircuit->setNombrePersonnes(50);
        $programmationCircuit->setPrix(1500);
        $programmationCircuit->setCircuit($circuit);
        $circuit->addProgrammationCircuit($programmationCircuit);
        $manager->persist($programmationCircuit);
        $manager->persist($circuit);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LoadCircuitData::class
        );
    }
}