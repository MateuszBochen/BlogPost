<?php

namespace AppBundle\Controller\Api;

use AppBundle\Helpers\FormException;
use AppBundle\Entity\BlogPost;
use AppBundle\Form\BlogPostType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class BlogPostController.
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
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Publish post to specified target"
     * )
     * @Rest\Route(name="api.blog_post.publish", path="/blog-post/{post}/{target}")
     * @Method("POST")
     * @param BlogPost $post
     * @param $target
     *
     * @return \FOS\RestBundle\View\View
     */
    public function publishPostAction(BlogPost $post, $target)
    {
        // todo: implement this

        return $this->view();
    }
}
