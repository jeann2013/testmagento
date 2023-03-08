<?php

namespace Training\OrderController\Controller\Order;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * Show constructor.
     * @param Context $context
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        Context $context,
        OrderRepositoryInterface $orderRepository
    ) {
        parent::__construct($context);
        $this->context = $context;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('id');

        $order = $this->orderRepository->get($id);
        $orderItems = [];

        foreach ($order->getItems() as $item) {
            $orderItems[] = [
                'id' => $item->getItemId(),
                'name' => $item->getName(),
                'sku' => $item->getSku()
            ];
        }

        return $this->resultFactory
            ->create(ResultFactory::TYPE_JSON)
            ->setData([
                'data' => [
                    'id' => $id,
                    'total_invoiced' => $order->getTotalInvoiced(),
                    'total_items' => $order->getTotalItemCount(),
                    'status' => $order->getStatus(),
                    'items' => $orderItems
                ]
            ]);
    }
}
