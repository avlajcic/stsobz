<?php

namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LeagueType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
            'required' => true,
            'label' => 'Ime'
        ))->add('clubs', EntityType::class, array(
            'class' => 'AppBundle\Entity\Club',
            'choice_label' => 'name',
            'multiple' => true,
            'required' => false,
            'label' => 'Klubovi'
        ))->add('submitBtn', SubmitType::class, array(
            'label' => 'Spremi'
        ));
    }
}