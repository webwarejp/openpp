<?php
/**
 * Created by PhpStorm.
 * User: epson
 * Date: 14/12/08
 * Time: 19:23
 */

namespace Application\Sonata\NewsBundle\Admin;

use Sonata\NewsBundle\Admin\PostAdmin as BasePostAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use \Sonata\AdminBundle\Admin\FieldDescriptionInterface;

class PostAdmin extends BasePostAdmin{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Post', array(
                'class' => 'col-md-8'
            ))
            ->add('author', 'sonata_type_model_list', array(), array('admin_code' => 'application.sonata.user.admin.user'))
            ->add('title')
            ->add('abstract', null, array('attr' => array('rows' => 5)))
            ->add('content', 'sonata_formatter_type', array(
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field'   => 'contentFormatter',
                'source_field'   => 'rawContent',
                'source_field_options'      => array(
                    'horizontal_input_wrapper_class' => $this->getConfigurationPool()->getOption('form_type') == 'horizontal' ? 'col-lg-12': '',
                    'attr' => array('class' => $this->getConfigurationPool()->getOption('form_type') == 'horizontal' ? 'span10 col-sm-10 col-md-10': '', 'rows' => 20)
                ),
                'ckeditor_context'     => 'news',
                'target_field'   => 'content',
                'listener'       => true,
            ))
            ->end()
            ->with('Status', array(
                'class' => 'col-md-4'
            ))
            ->add('enabled', null, array('required' => false))
            ->add('image', 'sonata_type_model_list', array('required' => false), array(
                'link_parameters' => array(
                    'context' => 'news'
                )
            ))

            ->add('publicationDateStart', 'sonata_type_datetime_picker', array('dp_side_by_side' => true))
            ->add('commentsCloseAt', 'sonata_type_datetime_picker', array('dp_side_by_side' => true))
            ->add('commentsEnabled', null, array('required' => false))
            ->add('commentsDefaultStatus', 'sonata_news_comment_status', array('expanded' => true))
            ->end()

            ->with('Classification', array(
                'class' => 'col-md-4'
            ))
            ->add('tags', 'sonata_type_model_autocomplete', array(
                'model_manager' => $this->getModelManager(),
                'property' => 'name',
                'multiple' => 'true'
            ))
            ->add('collection', 'sonata_type_model_list', array( 'required' => false))
            ->end()
        ;
    }
} 