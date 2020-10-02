<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('city')
            ->add('adress', null, [
                'label' => 'Address'
            ])
            ->add('postal_code', null, [
                'label' => 'Postal'
            ])
            ->add('sold')
            //->add('created_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
    
    /**Faire sortir la valeur en premier a la place de la clé dans le array de Property::Heat */
    private function getChoices()
    {
        $choices = Property::HEAT;

        $outpout = [];

        foreach($choices as $k => $value) {
            $outpout[$value] = $k;
        }
        return $outpout;
    }
}
