<?php
namespace RWCandy\Core\Plugin\Pmclain\AuthorizenetCim\Model\Adapter;
use Pmclain\Authnet\CustomerProfile as CP;
use Pmclain\Authnet\TransactionRequest as TR;
use Pmclain\Authnet\TransactionRequest\Order as TRO;
use Pmclain\AuthorizenetCim\Gateway\Request\CustomerDataBuilder as CDB;
use Pmclain\AuthorizenetCim\Gateway\Request\PaymentDataBuilder as PDB;
use Pmclain\AuthorizenetCim\Model\Adapter\AuthorizenetAdapter as Sb;
// 2019-11-19
final class AuthorizenetAdapter {
	/**
	 * 2019-11-19
	 * 1) «Undefined offset: 0 in /vendor/pmclain/magento2-autherizenetcim/Model/Adapter/AuthorizenetAdapter on line 160»:
	 * https://github.com/royalwholesalecandy/core/issues/17
	 * 2) https://developer.authorize.net/api/reference/features/customer_profiles.html#Duplicate_Profile_Verification
	 * 3) https://community.developer.authorize.net/t5/Integration-and-Testing/E00039-A-duplicate-record-already-exists/m-p/60748/highlight/true#M35260
	 * 4) https://developer.authorize.net/api/reference/index.html#customer-profiles-create-customer-profile
	 * @see \Pmclain\AuthorizenetCim\Model\Adapter\AuthorizenetAdapter::saleForNewProfile()
	 * @used-by \Pmclain\AuthorizenetCim\Gateway\Http\Client\TransactionSale::process()
	 * @param Sb $sb
	 * @param array(string => mixed) $d
	 */
	function beforeSaleForNewProfile(Sb $sb, array $d) {
    	$cp = $d[CDB::CUSTOMER_PROFILE]; /** @var CP $cp */
    	$tr = $d[PDB::TRANSACTION_REQUEST]; /** @var TR $tr */
    	$cp->setDescription($tr->toArray()[TR::FIELD_ORDER][TRO::FIELD_INVOICE_NUMBER]);
	}
}