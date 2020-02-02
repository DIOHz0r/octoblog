<?php

namespace App\Form;

use App\Entity\Comentario;
use App\Entity\Post;
use App\Entity\Usuario;
use App\Form\Types\EntityHiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ComentarioType extends AbstractType
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mensaje', TextareaType::class)
            ->add('post', EntityHiddenType::class, ['class' => Post::class])
            ->add('padre', EntityHiddenType::class, ['class' => Comentario::class])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $post = $event->getData();
            if (!$post || null === $post->getId()) {
                $post->setFecha(new \DateTime());
                $post->setAutor($this->security->getUser());
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comentario::class,
        ]);
    }
}
