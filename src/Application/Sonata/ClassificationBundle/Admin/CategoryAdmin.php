<?php
/**
 * Created by PhpStorm.
 * User: epson
 * Date: 12/31/14
 * Time: 5:16 AM
 */

namespace Application\Sonata\ClassificationBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\ClassificationBundle\Admin\CategoryAdmin as BaseCategoryAdmin;

class CategoryAdmin extends BaseCategoryAdmin{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-6'))
            ->add('enabled', null, array('required' => false))
            ->add('name')
            ->add('description', 'textarea', array('required' => false))
            ->end()
            ->with('Options', array('class' => 'col-md-6'))
            ->add('position', 'integer', array('required' => false, 'data' => 0))
            ->add('parent', 'sonata_category_selector', array(
                'category'      => $this->getSubject() ?: null,
                'model_manager' => $this->getModelManager(),
                'class'         => $this->getClass(),
                'required'      => false
            ))
            ->end()
        ;

        if (interface_exists('Sonata\MediaBundle\Model\MediaInterface')) {
            $formMapper
                ->with('General')
                ->add('media', 'sonata_type_model_list',
                    array('required' => false),
                    array(
                        'link_parameters' => array(
                            'provider' => 'sonata.media.provider.image',
                            'context'  => 'sonata_category',
                        )
                    )
                )
                ->end();
        }

    }

} 