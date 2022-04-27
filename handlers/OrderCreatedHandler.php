<?php namespace VojtaSvoboda\ShopaholicHeureka\Handlers;

use Heureka\ShopCertification;
use Heureka\ShopCertification\DuplicateProductItemIdException;
use Lovata\OrdersShopaholic\Models\Order;
use VojtaSvoboda\ShopaholicHeureka\Models\Settings;

class OrderCreatedHandler
{
    const MAX_ORDER_ITEMS = 40;

    /** @var array<string, int> $services */
    private $services = [
        'cz' => ShopCertification::HEUREKA_CZ,
        'sk' => ShopCertification::HEUREKA_SK,
    ];

    /**
     * @throws ShopCertification\InvalidArgumentException
     * @throws ShopCertification\Exception
     */
    public function handle(Order $order)
    {
        // resolve service
        $heureka = $this->getService($order);
        if ($heureka === null) {
            return;
        }

        // prepare conversion
        $heureka->setEmail($order->getProperty('email'));
        $heureka->setOrderId($this->getOrderNumber($order));

        // add order items
        $limit = self::MAX_ORDER_ITEMS;
        foreach ($order->order_position as $item) {
            try {
                $heureka->addProductItemId($item->offer->external_id);
            } catch (DuplicateProductItemIdException $e) {}

            if (--$limit < 1) {
                break;
            }
        }

        // send conversion
        $heureka->logOrder();
    }

    private function getService(Order $order): ?ShopCertification
    {
        // get order country
        $country = strtolower($order->getProperty('billing_country'));
        if (!array_key_exists($country, $this->services)) {
            return null;
        }

        // get secret key
        $key = Settings::get("secret_key_$country");
        if (empty($key)) {
            return null;
        }

        // create service options
        $options = [
            'service' => $this->services[$country],
        ];

        return app(ShopCertification::class, [$key, $options]);
    }

    private function getOrderNumber(Order $order): int
    {
        return (int) str_replace('-', '', $order->order_number);
    }
}
