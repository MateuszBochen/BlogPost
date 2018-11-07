<?php

namespace AppBundle\Controller\Api;

use AppBundle\Exception\TargetNotExistsException;
use AppBundle\Form\TagType;
use AppBundle\Helpers\FormException;
use AppBundle\Entity\BlogPost;
use AppBundle\Form\BlogPostType;
use AppBundle\Services\BlogPostPublisher;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Class BlogPostController.
 * Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
 */
class BlogPostController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Return complete list of blog posts"
     * )
     *
     * @Rest\Route(name="api.blog_post.list", path="/blog-post")
     * @Method("GET")
     *
     * @return \FOS\RestBundle\View\View
     */
    public function listPostsAction()
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:BlogPost');

        return $this->view($repo->findAll());
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Adding new Blog Post"
     * )
     *
     * @Rest\Route(name="api.blog_post.create", path="/blog-post")
     * @Rest\View(statusCode=201)
     * @Method("POST")
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request)
    {
        $blogPost = new BlogPost();
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->get('manager.blog.post');
            $manager->addNew($blogPost);
            return $this->view($blogPost);
        }

        return (new FormException(406, $form))->response();
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @ApiDoc(
     *     section="Edit Blog Post",
     *     description="Edit Post BLOG"
     * )
     *
     * @Rest\Route(name="api.blog_post.edit", path="/blog-post/{blogPost}")
     * @Rest\View(statusCode=202)
     * @Method("PUT")
     *
     * @param Request $request
     * @param BlogPost $blogPost
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function putAction(Request $request, BlogPost $blogPost)
    {
        $form = $this->createForm(BlogPostType::class, $blogPost, [
            'method' => 'put'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->get('manager.blog.post');
            $manager->edit($blogPost);
            return $this->view($blogPost);
        }

        return (new FormException(406, $form))->response();
    }


    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Publish post to specified target"
     * )
     * @Rest\Route(name="api.blog_post.publish", path="/blog-post/{post}/{target}")
     * @Method("POST")
     * @param BlogPost $post
     * @param string $target
     *
     * @return \FOS\RestBundle\View\View
     * @throws TargetNotExistsException
     * @throws \AppBundle\Exception\BlogPostPublisherException
     * @throws \AppBundle\Exception\TargetIsNotCompatibleException
     */
    public function publishPostAction(BlogPost $post, string $target)
    {
        /** @var BlogPostPublisher $blogPostPublisher */
        $blogPostPublisher = $this->get('publisher');
        $blogPostPublisher->setTarget($target);
        $blogPostPublisher->publish($post);
        return $this->view($post);
    }


    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @ApiDoc(
     *     section="Adding tags for Blog Post",
     *     description="Adding tags for Blog Post, Remove old and add new"
     * )
     *
     * @Rest\Route(name="api.blog_post.tags", path="/blog-post/{blogPost}/tag")
     * @Rest\View(statusCode=202)
     * @Method("PATCH")
     *
     * @param Request $request
     * @param BlogPost $blogPost
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function tagsAction(Request $request, BlogPost $blogPost)
    {
        $form = $this->createForm(BlogPostType::class, $blogPost, [
            'method' => 'patch'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->get('manager.blog.post');
            $manager->edit($blogPost);
            return $this->view($blogPost);
        }

        return (new FormException(406, $form))->response();
    }
}
