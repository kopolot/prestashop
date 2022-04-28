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
        // ex. 0000-1111-2222-3333
        if (Configuration::get('ORDER_ID_METHOD')==2){
            return true;
        }
        // PL/1999/1/1/1999
        elseif(Configuration::get('ORDER_ID_METHOD')==3){
            return self::dateReference();
        }
        // n++
        return true;
    }

    // return (ISO country/year/number of order in month/month/year) ex. PL/2022/100/04/27
    public function dateReference(){
        $month = date("m");
        // select iso_code from ps_country natural join ps_address where ps_address.id_address = 8; 
        $sql = new DbQuery();
        $sql->select('iso_code');
        $sql->from('ps_country');
        $sql->naturalJoin('ps_address');
        $sql->where("ps_address.id_address = $this->id_address_delivery");
        $country = Db::getInstance()->executeS($sql);
        $date1 = date('/Y/');
        $date2 = date("/m/Y");
        // current month order
        $cmo = $this->monthC();
    }

    // return (int) actual order in current month 
    public function monthC(){

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