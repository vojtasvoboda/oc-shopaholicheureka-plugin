<?php namespace VojtaSvoboda\ShopaholicHeureka;

use Event;
use Lovata\OrdersShopaholic\Classes\Processor\OrderProcessor;
use System\Classes\PluginBase;
use VojtaSvoboda\ShopaholicHeureka\Models\Settings;
use VojtaSvoboda\ShopaholicHeureka\Handlers\OrderCreatedHandler;

/**
 * ShopaholicHeureka Plugin Information File
 */
class Plugin extends PluginBase
{
    /** @var string[] $require Required plugins. */
    public $require = [
        'Lovata.OrdersShopaholic',
    ];

    /**
     * Boot method, called right before the request route.
     */
    public function boot()
    {
        Event::listen(OrderProcessor::EVENT_UPDATE_ORDER_AFTER_CREATE, OrderCreatedHandler::class);
    }

    /**
     * Registers back-end settings for this plugin.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'shopaholicheureka' => [
                'label' => 'Heuérka Ověřeno',
                'description' => 'Heuérka Ověřeno settings.',
                'icon' => 'icon-search-plus',
                'class' => Settings::class,
                'order' => 500,
                'permissions' => ['vojtasvoboda.shopaholic_heureka.manage'],
                'keywords' => 'heureka',
            ]
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'vojtasvoboda.shopaholic_heureka.manage' => [
                'tab' => 'Shopaholic Heuréka',
                'label' => 'Manage Heuréka API keys',
            ],
        ];
    }
}
