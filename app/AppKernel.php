<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // SYMFONY STANDARD EDITION
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            // KNP HELPER BUNDLES
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),

            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),

            // API
            new FOS\RestBundle\FOSRestBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),

            // SONATA CORE & HELPER BUNDLES
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\CacheBundle\SonataCacheBundle(),
            new Sonata\SeoBundle\SonataSeoBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Sonata\FormatterBundle\SonataFormatterBundle(),
            new Sonata\ClassificationBundle\SonataClassificationBundle(),
            new Application\Sonata\ClassificationBundle\ApplicationSonataClassificationBundle(),
            new Sonata\NotificationBundle\SonataNotificationBundle(),
            new Application\Sonata\NotificationBundle\ApplicationSonataNotificationBundle(),

            // ADMIN
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),

            // USER
            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),

            //OAUTH
            //new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
            new Application\FOS\OAuthServerBundle\ApplicationFOSOAuthServerBundle(),

            //OPEN ID
            //new Fp\OpenIdBundle\FpOpenIdBundle(),

            // CMF Integration
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),

            // PAGE
            new Sonata\PageBundle\SonataPageBundle(),
            new Application\Sonata\PageBundle\ApplicationSonataPageBundle(),

            // MEDIA
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),

            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),

            // PUSH NOTIFICATION
            new Openpp\PushNotificationBundle\OpenppPushNotificationBundle(),
            new Application\Openpp\PushNotificationBundle\ApplicationOpenppPushNotificationBundle(),

            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),

            new Bazinga\Bundle\FakerBundle\BazingaFakerBundle(),

            new Openpp\MapBundle\OpenppMapBundle(),
            new AppBundle\AppBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
