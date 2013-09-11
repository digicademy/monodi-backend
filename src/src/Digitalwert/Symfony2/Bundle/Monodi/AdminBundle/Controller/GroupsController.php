<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\AdminBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Group;

use Digitalwert\Symfony2\Bundle\Monodi\AdminBundle\Form\GroupType;

/**
 * Group controller.
 *
 * @Route("/groups")
 */
class GroupsController extends Controller
{
    /**
     * Lists all Group entities.
     *
     * @Route("/", name="admin_groups")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $groups = $this->container->get('fos_user.group_manager')->findGroups();

        return array(
            'groups' => $groups,
        );
    }

    /**
     * Creates a new Group entity.
     *
     * @Route("/", name="admin_groups_create")
     * @Method("POST")
     * @Template("DigitalwertMonodiAdminBundle:Groups:new.html.twig")
     */
    public function createAction(Request $request)
    {
        
        $form = $this->container->get('fos_user.group.form');
        $formHandler = $this->container->get('fos_user.group.form.handler');

        $process = $formHandler->process();
        if ($process) {
            $this->setFlash('fos_user_success', 'group.flash.created');
            $parameters = array(
//                'groupname' => $form->getData('group')->getName(),
                'id' => $form->getData('group')->getId(),
            );
            
            $url = $this->container->get('router')->generate('admin_groups_show', $parameters);

            return new RedirectResponse($url);
        }

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Group entity.
     *
     * @Route("/new", name="admin_groups_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        
        $form = $this->container->get('fos_user.group.form');
//        $formHandler = $this->container->get('fos_user.group.form.handler');

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Group entity.
     *
     * @Route("/{id}", name="admin_groups_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $group = $this->findGroupBy('id', $id);

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'group'      => $group,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Group entity.
     *
     * @Route("/{id}/edit", name="admin_groups_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $group = $this->findGroupBy('id', $id);
        
        $form = $this->container->get('fos_user.group.form');
        $formHandler = $this->container->get('fos_user.group.form.handler');
        
        $form->setData($group);
//        $process = $formHandler->process($group);
        
        $editForm = $form; 
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'group'      => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Group entity.
     *
     * @Route("/{id}", name="admin_groups_update")
     * @Method("PUT")
     * @Template("DigitalwertMonodiCommonBundle:Group:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        
        $em = $this->getDoctrine()->getManager();
        
        $group = $this->findGroupBy('id', $id);
        
        $form = $this->container->get('fos_user.group.form');
        
//        $formHandler = $this->container->get('fos_user.group.form.handler');
//        $process = $formHandler->process($group);
        
        $form->setData($group);
        $editForm = $form; //$this->createForm($form, $group);
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm->bind($request);
        if ($editForm->isValid()) {
            
            $em->persist($group);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_groups_edit', array('id' => $id)));
        }

        return array(
            'group'      => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Group entity.
     *
     * @Route("/{id}", name="admin_groups_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            
            $group = $this->findGroupBy('id', $id);

            $em->remove($group);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_groups'));
    }

    /**
     * Creates a form to delete a Group entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Find a group by a specific property
     *
     * @param string $key   property name
     * @param mixed  $value property value
     *
     * @throws NotFoundException                    if user does not exist
     * @return \FOS\UserBundle\Model\GroupInterface
     */
    protected function findGroupBy($key, $value)
    {
        $manager = $this->container->get('fos_user.group_manager');
        if (!empty($value)) {

            $group = $manager->{'findGroupBy'.ucfirst($key)}($value);
        }

        if (empty($group)) {
            throw new NotFoundHttpException(sprintf('The group with "%s" does not exist for value "%s"', $key, $value));
        }

        return $group;
    }
    
    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->setFlash($action, $value);
    }
}
