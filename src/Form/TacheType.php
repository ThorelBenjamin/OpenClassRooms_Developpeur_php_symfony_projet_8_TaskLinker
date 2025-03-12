<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Etiquette;
use App\Entity\Projet;
use App\Entity\Statut;
use App\Entity\Tache;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $tache = $options['data'];
        $builder
            ->add('titre', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Titre de la tâche',
            ])
            ->add('description' , TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('deadline', \Symfony\Component\Form\Extension\Core\Type\DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
                'required' => false,
            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'libelle',
                'choices' => $tache->getProjet()->getStatuts(),
                'label' => 'Statut',
            ])
            ->add('employe', EntityType::class, [
                'class' => Employe::class,
                'choice_label' => function (Employe $employe) {
                    return $employe->getPrenom() . ' ' . $employe->getNom();
                },
                'label' => 'Membre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
