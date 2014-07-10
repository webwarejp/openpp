<?php
namespace Acme\HelpBundle\Form;

use Acme\HelpBundle\Form\DataTransformer\ConfirmTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class ContactType extends AbstractType
{
    private $security_context;

    public function __construct( $session)
    {
        $this->session = $session;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$entityManager = $options['em'];
        //$form = $options['form'];
        //var_dump($form);die();
        //$transformer = new ConfirmTransformer($entityManager, $form);
        $builder
                ->add('username', 'text', array('label' => 'お名前', 'required' => true))
                ->add('mailaddress', 'repeated', array(
                    'type' => 'email',
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options' => array('label' => 'メールアドレス'),
                    'second_options' => array('label' => 'Repeat メールアドレス'),
                ))
                ->add('body', 'textarea', array('label' => 'お問い合わせ', 'required' => true))
                ->add('gender', 'choice', array(
                    'choices' => array('m' => 'Male', 'f' => 'Female'),
                    'required' => false,
                    'label' => '性別',
                    'expanded' => true,
                    'multiple' => false,
                    'empty_value' => false))
                ->add('availability', 'choice', array(
                    'label' => '希望時間',
                    'choices' => array(
                        'morning' => 'Morning',
                        'afternoon' => 'Afternoon',
                        'evening' => 'Evening',
                    ),
                    'multiple' => true,))
                ->add('league', 'choice', array(
                    'label' => 'リーグ',
                    'choices' => array(
                        'central' => 'セントラル',
                        'pacific' => 'パシフィック'
                    ),
                    'mapped' => false
                    ))
                ->add('team', 'entity', array(
                'label' => 'チーム',
                'class' => 'AcmeHelpBundle:Team',
                'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.league = :league')
                            ->setParameter('league', 'セントラル')
                            ->orderBy('u.id', 'ASC');
                    },
            ))
            ->addEventListener(FormEvents::POST_SUBMIT,array($this, 'onPostSubmit'));
                //->addViewTransformer($transformer);
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\HelpBundle\Entity\Contact'
        ))->setRequired(array(
           // 'em',
           // 'form'
        ))->setAllowedTypes(array(
            //'em' => 'Doctrine\Common\Persistence\ObjectManager',
           // 'form' => 'Acme\HelpBundle\Form\ContactType'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_helpbundle_contact';
    }

    public function onPostSubmit(FormEvent $event)
    {
        $contact = $event->getData();
        $form = $event->getForm();

        if (!$contact) {
            return;
        }

        foreach ($form->getIterator() as $name => $child) {
            $config = $child->getConfig();
            $options = $config->getOptions();
            $array[$name]['type'] = $config->getType()->getName();
            //label
            //getCompound
            if ($config->getType()->getName() === 'repeated') {
                $array[$name]['label'] = $options['first_options']['label'];
                $array[$name]['value'] = $child->getData();
            } else {
                $array[$name]['label'] = $options["label"];
                $array[$name]['value'] = $child->getData();
            }

            //choices
            //getCompound
            if ($config->getType()->getName() === 'choice') {
                if ($options['multiple'] == true) {
                    $choices = array_intersect(array_flip($options['choices']), $child->getData());
                    $array[$name]['value'] = array_keys($choices);
                } else {
                    if (isset($options['choices'][$child->getData()])) {
                        $array[$name]['value'] = $options['choices'][$child->getData()];
                    } else {
                        $array[$name]['value'] = null;
                    }
                }
            } else if ($config->getType()->getName() === 'entity') {
                $array[$name]['value'] = $child->getData()->__toString();
            }


            //files

            //collection

        }
        //formにview data transformerとしてはめ込んでjsonのデータを取得する

//var_dump(json_encode(array('json' =>$array)));die();
        $this->session->getFlashBag()->set('sessionjson', json_encode(array('json' =>$array)));

        // Check whether the user has chosen to display his email or not.
        // If the data was submitted previously, the additional value that is
        // included in the request variables needs to be removed.
        /*
                if (true === $user['show_email']) {
            $form->add('email', 'email');
        } else {
            unset($user['email']);
            $event->setData($user);
        }
        */
    }

}
