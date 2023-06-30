<?php
namespace App\Doctrine\Listener;

use App\Entity\Matiere;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class MatiereSlugListener
{
    public function __construct(private SluggerInterface $slugger)
    {
        
    }

    // doctrine.event_listener
    // public function prePersist(LifecycleEventArgs $event)
    // {
    //     $matiere = $event->getObject();
    //     if($matiere instanceof Matiere) {
    //         $matiere->setSlug($this->slugger->slug($matiere->getLibelle())->lower());
    //     }
    // }
    
    // public function preUpdate(LifecycleEventArgs $event)
    // {
        
    // }

    // doctrine.orm.entity_listener
    public function prePersist(Matiere $matiere)
    {
            $matiere->setSlug($this->slugger->slug($matiere->getLibelle())->lower());
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        
    }
}