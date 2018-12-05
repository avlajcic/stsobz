<?php

namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ClubType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
            'required' => true,
            'label' => 'Ime'
        ))->add('league', EntityType::class, array(
            'class' => 'AppBundle\Entity\League',
            'choice_label' => 'name',
            'multiple' => false,
            'required' => true,
            'label' => 'Liga'
        ))->add('submitBtn', SubmitType::class, array(
            'label' => 'Spremi'
        ));
    }
}