<?php


namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FoodAdmin extends AbstractAdmin
{

    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('restaurant')
            ->add('name')
            ->add('healthScore')
            ->add('shortName')
            ->add('isDailyItem')
            ->add('isMainMeal')
            ->add('price')
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('restaurant')
            ->add('name')
            ->add('healthScore')
            ->add('shortName')
            ->add('isDailyItem')
            ->add('isMainMeal')
            ->add('price')
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('restaurant')
            ->addIdentifier('name')
            ->add('isDailyItem')
            ->add('isMainMeal')
            ->add('price')
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     *
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('restaurant')
            ->add('name')
            ->add('isDailyItem')
            ->add('isMainMeal')
        ;
    }

}