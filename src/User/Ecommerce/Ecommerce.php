<?php

namespace Cxf\User\Ecommerce;

trait Ecommerce {
    use Transactions,
        OrderTemplates,
        ItemCodes,
        PriceLists,
        Prices,
        PaymentMethods,
        Orders;
}