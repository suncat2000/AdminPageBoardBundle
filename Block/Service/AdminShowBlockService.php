<?php

namespace Suncat\AdminPageBoardBundle\Block\Service;

use Sonata\AdminBundle\Admin\Pool;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Class AdminShowBlockService
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class AdminShowBlockService extends BaseBlockService
{
    protected $sonataAdminPool;

    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param Pool $sonataAdminPool
     */
    public function __construct($name, EngineInterface $templating, Pool $sonataAdminPool)
    {
        parent::__construct($name, $templating);

        $this->sonataAdminPool = $sonataAdminPool;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'News detail';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'SuncatAdminPageBoardBundle:Block:block_admin_show.html.twig',
            'sonata_admin_code' => null,
            'sonata_admin_object_id_param' => 'id',
            'btn_add' => true,
            'btn_edit' => true,
            'btn_list' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();

        if (null === $settings['sonata_admin_code']) {
            throw new \RuntimeException(sprintf('Sonata Admin code \'%s\' not exist', $settings['sonata_admin_code']));
        }

        $admin = $this->sonataAdminPool->getAdminByAdminCode($settings['sonata_admin_code']);

        if (!$admin) {
            throw new \RuntimeException(sprintf('Unable to find the admin class related to code (%s)', $admin));
        }

        if (null === $settings['route_params']) {
            throw new \RuntimeException('Route params is null');
        }

        if (!isset($settings['sonata_admin_object_id_param']) || null === $settings['sonata_admin_object_id_param']) {
            throw new \RuntimeException('Sonata Admin object ID param not exist');
        }

        if (
            !isset($settings['route_params'][$settings['sonata_admin_object_id_param']]) ||
            null === $settings['route_params'][$settings['sonata_admin_object_id_param']]
        ) {
            throw new \RuntimeException('Object id route param is not exist');
        }

        $id = $settings['route_params'][$settings['sonata_admin_object_id_param']];

        $object = $admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $admin->isGranted('VIEW', $object)) {
            throw new AccessDeniedException();
        }

        $admin->setSubject($object);

        return $this->renderResponse($blockContext->getTemplate(), array(
                'action'   => 'show',
                'admin'   => $admin,
                'object'   => $object,
                'elements' => $admin->getShow(),
                'block'     => $blockContext->getBlock(),
                'settings'  => $settings
            ));
    }
}
