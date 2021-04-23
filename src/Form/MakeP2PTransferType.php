<?php

namespace App\Form;

use App\DTO\MakeP2PTransferRequest;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MakeP2PTransferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('payee_id', EntityType::class, [
                'required' => true,
                'class' => User::class,
                'property_path' => 'payee',
            ])
            ->add('amount', MoneyType::class, ['required' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MakeP2PTransferRequest::class,
            'csrf_protection' => false,
        ]);
    }
}
