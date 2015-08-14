<?php
/**
 * Created by PhpStorm.
 * User: taniguchi
 * Date: 8/5/15
 * Time: 15:50
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Sonata\PageBundle\Model\SiteInterface;
use Sonata\PageBundle\Model\PageInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sonata\BlockBundle\Block\Service\MenuBlockService;

class LoadPageData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $site = $this->createSite();
        $this->createGlobalPage($site);
        $this->createHomePage($site);
        $this->createAboutPage($site);
        $this->createTermsPage($site);
        $this->createPrivacyPage($site);
        $this->createHelpPage($site);
        $this->create404ErrorPage($site);
        $this->create500ErrorPage($site);

    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return SiteInterface $site
     */
    public function createSite()
    {
        $site = $this->getSiteManager()->create();
        $site->setHost('localhost');
        $site->setEnabled(true);
        $site->setName('localhost');
        $site->setEnabledFrom(new \DateTime('now'));
        $site->setEnabledTo(new \DateTime('+10 years'));
        $site->setRelativePath("/");
        $site->setIsDefault(true);
        $this->getSiteManager()->save($site);
        return $site;
    }

    /**
     * @param SiteInterface $site
     */
    public function createHomePage(SiteInterface $site)
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();
        $this->addReference('page-homepage', $homepage = $pageManager->create());
        $homepage->setSlug('/');
        $homepage->setUrl('/');
        $homepage->setName('Home');
        $homepage->setTitle('Homepage');
        $homepage->setEnabled(true);
        $homepage->setDecorate(1);
        $homepage->setRequestMethod('GET|POST|HEAD|DELETE|PUT');
        $homepage->setTemplateCode('plain');
        $homepage->setRouteName(PageInterface::PAGE_ROUTE_CMS_NAME);
        $homepage->setSite($site);

        // CREATE A HEADER BLOCK
        $homepage->addBlocks($content = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $homepage,
            'code' => 'content_top',
        )));
        $content->setName('Top content');

        // add company info
        $content->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', <<<CONTENT
<div class="col-md-3 welcome"><h2>Hello World</h2></div>
<div class="col-md-9">
FOS, Sonata 系バンドルを組み合わせて、Push通知が便利に使えるAPIベースのプロジェクトを目指します。
<p>
</p>
<p>
</p>
</div>
CONTENT
        );
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($homepage);

        $pageManager->save($homepage);

    }

    /**
     * @param SiteInterface $site
     */
    public function createAboutPage(SiteInterface $site)
    {
        $this->createTextContentPage($site, 'info-about', 'about', <<<CONTENT
<div class="col-md-3 welcome"><h2>運営会社</h2></div>
<div class="col-md-9">
<p>
運営会社
</p>
<p>
テストデータ
</p>
</div>
CONTENT
        );
    }

    /**
     * @param SiteInterface $site
     */
    public function createTermsPage(SiteInterface $site)
    {
        $this->createTextContentPage($site, 'info-terms', 'terms', <<<CONTENT
<div class="col-md-3 welcome"><h2>利用規約</h2></div>
<div class="col-md-9">
<p>
利用規約
</p>
<p>
テストデータ
</p>
</div>
CONTENT
        );
    }



    /**
     * @param SiteInterface $site
     */
    public function createPrivacyPage(SiteInterface $site)
    {
        $this->createTextContentPage($site, 'info-privacy', 'Privacy', <<<CONTENT
<div class="col-md-3 welcome"><h2>プライバシーポリシー</h2></div>
<div class="col-md-9">
<p>
プライバシーポリシー
</p>
<p>
テストデータ
</p>
</div>
CONTENT
        );
    }

    /**
     * create /info-help page
     *
     * @param SiteInterface $site
     */
    public function createHelpPage(SiteInterface $site)
    {
        $this->createTextContentPage($site, 'info-help', 'Help', <<<CONTENT
<div class="col-md-3 welcome"><h2>ヘルプ</h2></div>
<div class="col-md-9">
<p>
ヘルプ
</p>
<p>
テストデータ
</p>
</div>
CONTENT
        );
    }

    /**
     * Creates simple content pages
     *
     * @param SiteInterface $site    A Site entity instance
     * @param string        $url     A page URL
     * @param string        $title   A page title
     * @param string        $content A text content
     *
     * @return void
     */
    public function createTextContentPage(SiteInterface $site, $url, $title, $content)
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();
        $page = $pageManager->create();
        $page->setSlug(sprintf('/%s', $url));
        $page->setUrl(sprintf('/%s', $url));
        $page->setName($title);
        $page->setTitle($title);
        $page->setEnabled(true);
        $page->setDecorate(1);
        $page->setRequestMethod('GET|POST|HEAD|DELETE|PUT');
        $page->setTemplateCode('plain');
        $page->setRouteName('page_slug');
        $page->setSite($site);
        $page->setParent($this->getReference('page-homepage'));
        $page->addBlocks($block = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $page,
            'code'    => 'content_top',
        )));
        // add the breadcrumb
        $block->addChildren($breadcrumb = $blockManager->create());
        $breadcrumb->setType('sonata.page.block.breadcrumb');
        $breadcrumb->setPosition(0);
        $breadcrumb->setEnabled(true);
        $breadcrumb->setPage($page);
        // Add text content block
        $block->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', sprintf('<h2>%s</h2><div>%s</div>', $title, $content));
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($page);
        $pageManager->save($page);
    }

    public function create404ErrorPage(SiteInterface $site)
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();
        $page = $pageManager->create();
        $page->setName('_page_internal_error_not_found');
        $page->setTitle('Error 404');
        $page->setEnabled(true);
        $page->setDecorate(1);
        $page->setRequestMethod('GET|POST|HEAD|DELETE|PUT');
        $page->setTemplateCode('plain');
        $page->setRouteName('_page_internal_error_not_found');
        $page->setSite($site);
        $page->addBlocks($block = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $page,
            'code' => 'content_top',
        )));
// add the breadcrumb
        $block->addChildren($breadcrumb = $blockManager->create());
        $breadcrumb->setType('sonata.page.block.breadcrumb');
        $breadcrumb->setPosition(0);
        $breadcrumb->setEnabled(true);
        $breadcrumb->setPage($page);
// Add text content block
        $block->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', '<h2>Error 404</h2><div>Page not found.</div>');
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($page);
        $pageManager->save($page);
    }
    public function create500ErrorPage(SiteInterface $site)
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();
        $page = $pageManager->create();
        $page->setName('_page_internal_error_fatal');
        $page->setTitle('Error 500');
        $page->setEnabled(true);
        $page->setDecorate(1);
        $page->setRequestMethod('GET|POST|HEAD|DELETE|PUT');
        $page->setTemplateCode('plain');
        $page->setRouteName('_page_internal_error_fatal');
        $page->setSite($site);
        $page->addBlocks($block = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $page,
            'code' => 'content_top',
        )));
// add the breadcrumb
        $block->addChildren($breadcrumb = $blockManager->create());
        $breadcrumb->setType('sonata.page.block.breadcrumb');
        $breadcrumb->setPosition(0);
        $breadcrumb->setEnabled(true);
        $breadcrumb->setPage($page);
// Add text content block
        $block->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', '<h2>Error 500</h2><div>Internal error.</div>');
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($page);
        $pageManager->save($page);
    }

    public function createGlobalPage(SiteInterface $site)
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();
        $global = $pageManager->create();
        $global->setName('global');
        $global->setRouteName('_page_internal_global');
        $global->setSite($site);
        $pageManager->save($global);
        // CREATE A HEADER BLOCK
        $global->addBlocks($header = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $global,
            'code' => 'header',
        )));
        $header->setName('The header container');
        $header->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', '<h2><a href="/">OpenPP Demo</a></h2>');
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($global);
        $global->addBlocks($headerTop = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $global,
            'code' => 'header-top',
        ), function ($container) {
            $container->setSetting('layout', '<div class="pull-right">{{ CONTENT }}</div>');
        }));
        $headerTop->setPosition(1);
        $header->addChildren($headerTop);
        $headerTop->addChildren($account = $blockManager->create());
        $account->setType('sonata.user.block.account');
        $account->setPosition(1);
        $account->setEnabled(true);
        $account->setPage($global);
/*
        $global->addBlocks($headerMenu = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $global,
            'code' => 'header-menu',
        )));
        $headerMenu->setPosition(2);
        $header->addChildren($headerMenu);
        $headerMenu->setName('The header menu container');
        $headerMenu->setPosition(3);
        $headerMenu->addChildren($menu = $blockManager->create());
        $menu->setType('sonata.block.service.menu');
        $menu->setSetting('menu_name', "AppBundle:Builder:mainMenu");
        $menu->setSetting('safe_labels', true);
        $menu->setPosition(3);
        $menu->setEnabled(true);
        $menu->setPage($global);
*/
        $global->addBlocks($footer = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $global,
            'code'    => 'footer'
        ), function ($container) {
            $container->setSetting('layout', '<div class="row page-footer well">{{ CONTENT }}</div>');
        }));
        $footer->setName('The footer container');
        // Footer : add 3 children block containers (left, center, right)
        $footer->addChildren($footerLeft = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $global,
            'code'    => 'content'
        ), function ($container) {
            $container->setSetting('layout', '<div class="col-sm-3">{{ CONTENT }}</div>');
        }));
        $footer->addChildren($footerLinksLeft = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $global,
            'code'    => 'content',
        ), function ($container) {
            $container->setSetting('layout', '<div class="col-sm-2 col-sm-offset-3">{{ CONTENT }}</div>');
        }));
        $footer->addChildren($footerLinksCenter = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $global,
            'code'    => 'content'
        ), function ($container) {
            $container->setSetting('layout', '<div class="col-sm-2">{{ CONTENT }}</div>');
        }));
        $footer->addChildren($footerLinksRight = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page'    => $global,
            'code'    => 'content'
        ), function ($container) {
            $container->setSetting('layout', '<div class="col-sm-2">{{ CONTENT }}</div>');
        }));
        // Footer left: add a simple text block
        $footerLeft->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', '<h2>OpenPP Demo</h2>');
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($global);
        // Footer left links
        $footerLinksLeft->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', <<<CONTENT
<h4>PRODUCT</h4>
<ul class="links">
    <li><a href="/info-help">FAQ</a></li>
</ul>
CONTENT
        );
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($global);
        // Footer middle links
        $footerLinksCenter->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', <<<CONTENT
<h4>ABOUT</h4>
<ul class="links">
    <li><a href="/info-privacy">Legal notes</a></li>
    <li><a href="/info-terms">Terms</a></li>
</ul>
CONTENT
        );
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($global);
        // Footer right links
        $footerLinksRight->addChildren($text = $blockManager->create());
        $text->setType('sonata.block.service.text');
        $text->setSetting('content', <<<CONTENT
<h4>COMMUNITY</h4>
<ul class="links">
    <li><a href="http://www.github.com/webwarejp/openpp" target="_blank">Github</a></li>
    <li><a href="/contact-us">Contact us</a></li>
</ul>
CONTENT
        );
        $text->setPosition(1);
        $text->setEnabled(true);
        $text->setPage($global);
        $pageManager->save($global);

    }
    /**
     * @return \Sonata\PageBundle\Model\SiteManagerInterface
     */
    public function getSiteManager()
    {
        return $this->container->get('sonata.page.manager.site');
    }
    /**
     * @return \Sonata\PageBundle\Model\PageManagerInterface
     */
    public function getPageManager()
    {
        return $this->container->get('sonata.page.manager.page');
    }

    /**
     * @return \Sonata\BlockBundle\Model\BlockManagerInterface
     */
    public function getBlockManager()
    {
        return $this->container->get('sonata.page.manager.block');
    }

    /**
     * @return \Sonata\PageBundle\Entity\BlockInteractor
     */
    public function getBlockInteractor()
    {
        return $this->container->get('sonata.page.block_interactor');
    }
}
