<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('username')
			->add('email')
			->add('plainPassword', RepeatedType::class, [
				'type' => PasswordType::class,
				'invalid_message' => 'The password fields must match',
				'required' => true,
				'first_options' => ['label' => 'Password'],
				'second_options' => ['label' => 'Repeat password']
			])
			->add('register', SubmitType::class);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults(array(
			'data_class' => User::class,
		));
	}
}