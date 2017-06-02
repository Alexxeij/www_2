<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\BlogPost;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class BlogPostAdmin extends AbstractAdmin
{
protected function configureFormFields(FormMapper $formMapper)
{
    {

        $formMapper
            ->tab('Post')
            ->with('Content')
            // ...
        ->end()
        // ...
        ->end()

        ->tab('Publish Options')
        // ...
        ->end()
    ;

        $formMapper
            ->with('Content',array('class' => 'col-md-9'))
            ->add('title', 'text')
            ->add('body', 'textarea')
            ->end()

            ->with('Meta data',array('class' => 'col-md-3'))
            ->add('category', 'sonata_type_model', array(
                'class' => 'AppBundle\Entity\Category',
                'property' => 'name',
            ))
            ->end()
        ;

        $formMapper
            ->add('title', 'text')
            ->add('body', 'textarea')
            ->add('category', 'entity', array(
                'class' => 'AppBundle\Entity\Category',
                'property' => 'name'))
         ->add('category', 'sonata_type_model', array(
        'class' => 'AppBundle\Entity\Category',
        'property' => 'name'))
        ;
    }
}

protected function configureListFields(ListMapper $listMapper)
{

    $listMapper
        ->addIdentifier('title')
        ->add('category.name')
        ->add('draft')
    ;
}

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('category', null, array(), 'entity', array(
                'class'    => 'AppBundle\Entity\Category',
                'choice_label' => 'name',
            ))
        ;
    }

    public function toString($object)
    {
        return $object instanceof BlogPost
            ? $object->getTitle()
            : 'Blog Post';
    }

}

