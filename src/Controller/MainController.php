<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\FormHandler;
use App\Service\SortedLinkedList\SortedLinkedList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    public function __construct(private FormHandler $formHandler)
    {
        //
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        return $this->render(
            'index.html.twig',
            [
                'directions' => $this->getDirections(SortedLinkedList::DIRECTION_ASC),
            ]
        );
    }

    /**
     * @Route("/", name="handle", methods={"POST"})
     */
    public function handle(Request $request)
    {
        $postParams = $request->request;
        $submittedToken = $postParams->get('_csrf_token');
        if (!$this->isCsrfTokenValid('main', $submittedToken)) {
            throw new \Exception('Form protection check failed');
        }

        $direction = $postParams->get('direction');
        $map = json_decode($postParams->get('map', ''), true);
        if (!is_array($map)) {
            $map = [];
        }
        $newValue = $postParams->get('newValue');
        $newList = $this->formHandler->handle($map, $newValue, $direction);

        return $this->render(
            'index.html.twig',
            [
                'directions' => $this->getDirections($direction),
                'list'       => $newList,
                'map'        => json_encode($newList),
            ]
        );
    }

    private function getDirections(string $selected = null): array
    {
        $l = array_fill_keys(SortedLinkedList::DIRECTIONS, false);
        if (!is_null($selected && isset($l[$selected]))) {
            $l[$selected] = true;
        }

        return $l;
    }
}
