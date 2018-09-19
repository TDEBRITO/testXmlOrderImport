<?php
/**
 * Created by PhpStorm.
 * User: tdb
 * Date: 19/09/18
 * Time: 13:30.
 */

namespace App\Controller;

use App\Entity\CustomerOrder;
use App\Repository\CustomerOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CustomerOrderController extends AbstractController
{
    /**
     * @var CustomerOrderRepository
     */
    private $customerOrderRepository;

    public function __construct(CustomerOrderRepository $customerOrderRepository)
    {
        $this->customerOrderRepository = $customerOrderRepository;
    }

    /**
     * @Route("/order/{id}/show", name="customer_order_view", defaults={"currencyFilter" = NULL})
     * @Route("/order/{id}/show/{currencyFilter}", name="customer_order_view_currency")
     */
    public function customerOrderAction(CustomerOrder $order, $currencyFilter)
    {
        return $this->render('customer-orders.html.twig', [
            'order' => $order,
            'currencyFilter' => $currencyFilter ?? $order->getCurrency()->getCurrencyCode(),
        ]);
    }
}
