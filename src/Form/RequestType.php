<?php

namespace App\Form;

use App\Config\StatusEnum;
use App\Entity\Request;
use Doctrine\Common\Annotations\Annotation\Enum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RequestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Заголовок'])
            ->add('text', TextareaType::class, ['label' => 'Текст'])
        ;

        /* Если заявка уже существуетя, то дается возможность менять её статус */
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $request = $event->getData();
            $form = $event->getForm();

            if ($request->getId()) {
                $form->add('status', ChoiceType::class, [
                    'choices'  => StatusEnum::choices(),
                    'label' => 'Статус',
                ]);
            }

            $form->add('save', SubmitType::class, ['label' => 'Сохранить']);
        });
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Request::class,
        ]);
    }
}