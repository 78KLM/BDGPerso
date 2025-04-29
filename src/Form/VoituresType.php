<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Voitures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Formulaire pour la création et l'édition des voitures
 * 
 * Ce formulaire permet de gérer les informations des voitures, y compris
 * les images associées et les caractéristiques techniques
 */
class VoituresType extends AbstractType
{
    /**
     * Construction du formulaire
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Informations générales de la voiture
        $builder
            ->add('prixV') // Prix de la voiture
            ->add('stock') // Quantité en stock
            ->add('description') // Description/nom du modèle
            
            // Caractéristiques techniques
            ->add('vitesse') // Vitesse maximale en km/h
            ->add('acceleration') // Temps d'accélération 0-100 km/h
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'type',
                'label' => 'État de la voiture'
            ])
            
            // Gestion des images
            // Image principale de la voiture
            ->add('image', FileType::class, [
                'label' => 'Image 1 de la voiture',
                'mapped' => false, // Ce champ n'est pas directement mappé à l'entité
                'required' => false, // L'image n'est pas obligatoire lors de l'édition
                'constraints' => [
                    new File([
                        'maxSize' => '2048k', // Taille maximale de 2Mo
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG)',
                    ])
                ],
            ])
            // Image secondaire de la voiture
            ->add('image2', FileType::class, [
                'label' => 'Image 2 de la voiture',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG)',
                    ])
                ],
            ])
            // Image tertiaire de la voiture
            ->add('image3', FileType::class, [
                'label' => 'Image 3 de la voiture',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG)',
                    ])
                ],
            ])
            
            // Autres caractéristiques techniques
            ->add('annee') // Année de fabrication
            ->add('chevaux') // Puissance en chevaux
            ->add('moteur') // Type de moteur
            ->add('carburant') // Type de carburant
            ->add('boiteAuto') // Boîte automatique (true) ou manuelle (false)
            ->add('conso') // Consommation en L/100km
            ->add('Co2') // Émissions de CO2 en g/km
        ;
    }

    /**
     * Configuration des options du formulaire
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voitures::class, // Lie le formulaire à l'entité Voitures
        ]);
    }
}
