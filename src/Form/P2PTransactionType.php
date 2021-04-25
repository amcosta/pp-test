<?php

namespace App\Form;

use App\Entity\P2PTransaction;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class P2PTransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', MoneyType::class, ['required' => true])
            ->add('payee_id', EntityType::class, [
                'required' => true,
                'class' => User::class,
                'property_path' => 'payee',
                'invalid_message' => 'Payee not found'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => P2PTransaction::class,
            'csrf_protection' => false,
        ]);
    }
}
