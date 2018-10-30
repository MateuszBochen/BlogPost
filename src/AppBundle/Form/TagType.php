<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 29.10.18
 * Time: 21:47
 */

namespace AppBundle\Form;

use AppBundle\DataTransformer\StringTagToArrayTransformer;
use AppBundle\Entity\BlogPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TagType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tags', TextType::class);
            // ->addModelTransformer(new StringTagToArrayTransformer());

        $builder->get('tags')->addModelTransformer(new StringTagToArrayTransformer());

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => BlogPost::class,
            'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'blog_post_tag';
    }
}
