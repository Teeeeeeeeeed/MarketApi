<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class ItemController
 * @route("/api", name="api_")
 */
class ItemController extends AbstractFOSRestController
{
    /**
     * @Route("/get", name="get_items")
     */
    public function getAllItems()
    {
        $encoders = [new XmlEncoder(),new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizer, $encoders);
        $repository = $this->getDoctrine()->getRepository(Item::class);
        $items = $repository->findAll();
        $json = $serializer->serialize($items,'json');
        $response = new Response($json,
        Response::HTTP_OK,
        ['content-type'=>'json']);
        return $response;
    }
    /**
     * @Route("/get/{item}", name="get_item")
     */
    public function getSpecificItem(Request $request, $item)
    {
        $encoders = [new XmlEncoder(),new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizer, $encoders);
        $item = str_replace("-"," ",$item);
        $em = $this->getDoctrine()->getManager();
        $retrievedPost = $em->getRepository(Item::class)->findOneBy(['name'=>$item]);
        $json = $serializer->serialize($retrievedPost, 'json');
        $response = new Response($json,
        Response::HTTP_OK,
        ['content-type'=>'json']);
        return $response;
    }
    /**
     * @Route("/form", name="form")
     */
    public function postItem(Request $request)
    {
        $item = new Item();
        $item->setName('Name');
        $item->setId(123456);
        $item->setDescription('Description');
        $item->setPrice('15');
        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
        }
        return $this->render('form/index.html.twig',[
            'post_form'=>$form->createView()
        ]);
    }
}