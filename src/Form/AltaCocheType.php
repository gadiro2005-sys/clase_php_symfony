<?php

namespace App\Form;

use App\Entity\Coche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AltaCocheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marca', TextType::class, [
                'label' => 'Marca del coche',
                'attr' => [
                    'placeholder' => 'Marca del coche. Ej: Renault',
                    'data-sb-validations' => "required"
                ],
            ])
            ->add('modelo', TextType::class, [
                'label' => 'Modelo del coche',
                'attr' => [
                    'placeholder' => 'Modelo del coche. Ej: Clio',
                    'data-sb-validations' => "required"
                ],
            ])
            ->add('potencia', IntegerType::class, [
                'label' => 'Potencia del coche',
                'attr' => [
                    'placeholder' => 'Potencia del coche. Ej: 120',
                    'data-sb-validations' => "required"
                ],
            ])
            ->add('imagen', FileType::class, [
                'label' => 'Sube una imagen del coche',
                'attr' => [
                    'placeholder' => 'Imagen del coche: Max:2MB',
                    'data-sb-validations' => "required"
                ],

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,

                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File(
                        maxSize: '2048k',
                        extensions: ['jpg', 'jpeg', 'png'],
                        extensionsMessage: 'Por favor suba una imagen con extensión válida.',
                    )
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coche::class,
        ]);
    }
}
