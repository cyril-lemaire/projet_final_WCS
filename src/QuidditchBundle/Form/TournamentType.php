<?php

namespace QuidditchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournamentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$choices = [];
    	for($i = 2; $i <= 512; $i *= 2) {
    		$choices[$i] = $i;
		}
        $builder
			->add('date')
			->add('nbTeams', ChoiceType::class, array(
				'choices' => $choices,
			))
		;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QuidditchBundle\Entity\Tournament'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'quidditchbundle_tournament';
    }


}
