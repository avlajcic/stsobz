<?php

namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameMatchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('homeClub', EntityType::class, array(
            'class' => 'AppBundle\Entity\Club',
            'choice_label' => 'name',
            'multiple' => false,
            'required' => true,
            'label' => 'Domaći klub'
        ))->add('awayClub', EntityType::class, array(
            'class' => 'AppBundle\Entity\Club',
            'choice_label' => 'name',
            'multiple' => false,
            'required' => true,
            'label' => 'Gostujući klub'
        ))->add('round', EntityType::class, array(
            'class' => 'AppBundle\Entity\Round',
            'choice_label' => function($round){
                return $round->getName() . '-' . $round->getSeason()->getName() . '-' . $round->getLeague()->getName();
            },
            'multiple' => false,
            'required' => true,
            'label' => 'Kolo'
        ))->add('homeClubScore', NumberType::class, array(
            'required' => true,
            'label' => 'Rezultat domaćeg kluba'
        ))->add('awayClubScore', NumberType::class, array(
            'required' => true,
            'label' => 'Rezultat gostujućeg kluba'
        ))->add('file', FileType::class, array(
            'label' => 'Datoteka',
            'required' => false,
            'empty_data' => $options['file']
        ))->add('submitBtn', SubmitType::class, array(
            'label' => 'Spremi'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired('file');
    }
}