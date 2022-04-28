<?php
class Order extends OrderCore{
    /**
     * Generate a unique reference for orders generated with the same cart id
     * This references, is useful for check payment.
     *
     * @return string
     */
    /*
    * module: customorderref
    * date: 2022-04-28 14:33:55
    * version:  .dev
    */
    public static function generateReference()
    {
        $order = new Order();
        if (Configuration::get('ORDER_REF_METHOD')==2){
            return true;
        }
        elseif(Configuration::get('ORDER_REF_METHOD')==3){
            return self::dateReference();
        }
        return true;
    }
    /*
    * module: customorderref
    * date: 2022-04-28 14:33:55
    * version:  .dev
    */
    public static function dateReference(){
        $date1 = date('/Y/');
        $date2 = date("/m/Y");
        $cmo = self::monthC();
        $random = self::random3String();
        return $random . $date1 . $cmo . $date2;
    }

    public static function random3String(){
        $char = "ABidsfidfjJOIPfoasfDSOVKDSPOPVMPOsopajfsadjuiuwmecruitvcxnvxczczzxWEQPOCVCXKLVBGOWSG";
        $charlen = strlen($char)-1;
        for ($i = 0;$i<=3;$i++){
            $res[$i]=substr($char,rand(0,$charlen),1);
        }
        return $res[0] . $res[1] . $res[2];
    }
    /*
    * module: customorderref
    * date: 2022-04-28 14:33:55
    * version:  .dev
    */
    public static function monthC(){
        $current_month = Configuration::get("CURRENT_MONTH");
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
    /*
    * module: customorderref
    * date: 2022-04-28 14:33:55
    * version:  .dev
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
    /*
    * module: customorderref
    * date: 2022-04-28 14:33:55
    * version:  .dev
    */
    public static function getUniqReferenceOf($id_order)
    {
        $order = new Order($id_order);
        return $order->getUniqReference();
    }
}