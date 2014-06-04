<?php
/**
 * Created by PhpStorm.
 * User: epson
 * Date: 14/07/06
 * Time: 22:40
 */

namespace Acme\HelpBundle\Form\DataTransformer;

use  Acme\HelpBundle\Form\ContactType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class ConfirmTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var ContactType
     */
    private $form;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, ContactType $form)
    {
        $this->om = $om;
        $this->form = $form;
    }

    public function transform($value)
    {
        $array = array();
        foreach ($this->form->getIterator() as $name => $child) {
            $config = $child->getConfig();
            $options = $config->getOptions();
            $array[$name]['type'] = $config->getType()->getName();
            //label
            if ($config->getType()->getName() === 'repeated') {
                $array[$name]['label'] = $options['first_options']['label'];
                $array[$name]['value'] = $child->getData();
            } else {
                $array[$name]['label'] = $options["label"];
                $array[$name]['value'] = $child->getData();
            }

            //choices
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
            }
            //files

            //collection

        }
        //formにview data transformerとしてはめ込んでjsonのデータを取得する

        return $array;
        //var_dump($value);
    }
    public function reverseTransform($value)
    {
        return $value;
    }
}
