<?php

class Order extends OrderCore{

    /**
     * Generate a unique reference for orders generated with the same cart id
     * This references, is useful for check payment.
     *
     * @return string
     */
    public static function generateReference()
    {
        $order = new Order();
        // ex. 0000-1111-2222-3333
        if (Configuration::get('ORDER_REF_METHOD')==2){
            return true;
        }
        // PL/1999/1/1/1999
        elseif(Configuration::get('ORDER_REF_METHOD')==3){
            return self::dateReference();
        }
        // n++
        return true;
    }

    // return (ISO country/year/number of order in month/month/year) ex. PL/2022/100/04/27
    public static function dateReference(){
        // select iso_code from ps_country natural join ps_address where ps_address.id_address = 8; 
        $date1 = date('/Y/');
        $date2 = date("/m/Y");
        // current month order
        $cmo = self::monthC();
        return $date1 . $cmo . $date2;
    }


    // return (int) actual order in current month 
    public static function monthC(){
        // gets last month used for order
        $current_month = Configuration::get("CURRENT_MONTH");

        // gest current order in month 
        $current_month_order = Configuration::get("CURRENT_ORDER_IN_MONTH");

        if($current_month_order===null)
            $current_month_order = 1;

        if($current_month===null)
            $current_month = date("m");

        if($current_month==date("m")){
            Configuration::updateValue("CURRENT_ORDER_IN_MONTH",$current_month_order + 1);
            return Configuration::get("CURRENT_ORDER_IN_MONTH");
        }else{
            Configuration::updateValue("CURRENT_MONTH",date("m"));
            Configuration::updateValue("CURRENT_ORDER_IN_MONTH",1);
            return Configuration::get("CURRENT_ORDER_IN_MONTH");
        }
    }
    /**
     * Return a unique reference like : GWJTHMZUN#2.
     *
     * With multishipping, order reference are the same for all orders made with the same cart
     * in this case this method suffix the order reference by a # and the order number
     *
     * @since 1.5.0.14
     */
    public function getUniqReference()
    {
        $query = new DbQuery();
        $query->select('MIN(id_order) as min, MAX(id_order) as max');
        $query->from('orders');
        $query->where('id_cart = ' . (int) $this->id_cart);

        $order = Db::getInstance()->getRow($query);

        if ($order['min'] == $order['max']) {
            return $this->reference;
        } else {
            return $this->reference . '#' . ($this->id + 1 - $order['min']);
        }
    }

    /**
     * Return a unique reference like : GWJTHMZUN#2.
     *
     * With multishipping, order reference are the same for all orders made with the same cart
     * in this case this method suffix the order reference by a # and the order number
     *
     * @since 1.5.0.14
     */
    public static function getUniqReferenceOf($id_order)
    {
        $order = new Order($id_order);

        return $order->getUniqReference();
    }
}