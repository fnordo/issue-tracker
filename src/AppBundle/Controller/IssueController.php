<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Issue;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Issue controller.
 *
 * @Route("issue")
 *
 * @author Wolfgang Gassner <gassnerw@gmail.com>
 */
class IssueController extends Controller
{
    /**
     * @Route("/list/{page}", name="issue_index", requirements={"page" = "\d+"}, defaults={"page" = "1"})
     * @Method("GET")
     *
     * @param integer $page
     * @throws NotFoundHttpException
     * @return Response
     */
    public function indexAction($page)
    {
        $query = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Issue')
            ->createQueryBuilder('i')
            ->orderBy('i.createdAt', 'DESC')
        ;
        $pager = new Pagerfanta(new DoctrineORMAdapter($query));

        try {
            $pager->setCurrentPage($page);
        } catch( NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('issue/index.html.twig', array('issues' => $pager));
    }

    /**
     * @Route("/new", name="issue_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $issue = new Issue();
        $form = $this->createForm('AppBundle\Form\IssueType', $issue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($issue);
            $em->flush($issue);

            return $this->redirectToRoute('issue_show', array('id' => $issue->getId()));
        }

        return $this->render('issue/new.html.twig', array(
            'issue' => $issue,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="issue_show")
     * @Method("GET")
     *
     * @param Issue $issue
     * @return Response
     */
    public function showAction(Issue $issue)
    {
        $deleteForm = $this->createDeleteForm($issue);

        return $this->render('issue/show.html.twig', array(
            'issue' => $issue,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="issue_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Issue $issue
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Issue $issue)
    {
        $this->denyAccessUnlessGranted('EDIT', $issue);

        $deleteForm = $this->createDeleteForm($issue);
        $editForm = $this->createForm('AppBundle\Form\IssueType', $issue);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('issue_show', array('id' => $issue->getId()));
        }

        return $this->render('issue/edit.html.twig', array(
            'issue' => $issue,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="issue_delete")
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Issue $issue
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Issue $issue)
    {
        $this->denyAccessUnlessGranted('DELETE', $issue);

        $form = $this->createDeleteForm($issue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($issue);
            $em->flush($issue);
        }

        return $this->redirectToRoute('issue_index');
    }

    /**
     * @param Issue $issue The issue entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Issue $issue)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issue_delete', array('id' => $issue->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
