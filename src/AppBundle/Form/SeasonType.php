<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SeasonType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
            'required' => true,
            'label' => 'Ime'
        ))->add('active', CheckboxType::class, array(
            'required' => false,
            'label' => 'Aktivna'
        ))->add('submitBtn', SubmitType::class, array(
            'label' => 'Spremi'
        ));
    }
}